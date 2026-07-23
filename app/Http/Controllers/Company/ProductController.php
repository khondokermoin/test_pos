<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Unit;
use App\Models\Tax;
use App\Models\Stock;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the products for the authenticated company.
     */
    public function index()
    {
        $companyId = Auth::user()->company_id;

        $products = Product::where('company_id', $companyId)
            ->with(['category', 'brand', 'variants'])
            ->latest()
            ->paginate(15);

        return Inertia::render('Company/Products/Index', [
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $companyId = Auth::user()->company_id;

        return Inertia::render('Company/Products/Create', [
            'categories' => Category::where('company_id', $companyId)->where('is_active', true)->get(['id', 'name']),
            'brands'     => Brand::where('company_id', $companyId)->where('is_active', true)->get(['id', 'name']),
            'units'      => Unit::where('company_id', $companyId)->where('is_active', true)->get(['id', 'name']),
            'taxes'      => Tax::where('company_id', $companyId)->where('is_active', true)->get(['id', 'name', 'rate']),
        ]);
    }

    /**
     * Store a newly created product and its variant(s) in storage.
     *
     * FIX APPLIED:
     *  - Stock::updateOrCreate() no longer uses non-existent 'product_id' column.
     *    The stocks table unique key is (branch_id, variant_id). For company-level
     *    initial stock entry we use (company_id, variant_id) without branch_id.
     *  - StockMovement type changed from invalid 'in' to valid enum 'purchase_in'.
     *  - StockMovement no longer uses non-existent 'product_id' or 'reference' columns.
     *    Instead uses the correct polymorphic pair: reference_type + reference_id (both null
     *    for manual initial stock), plus a 'notes' field if the column exists.
     */
    public function store(Request $request)
    {
        $companyId = Auth::user()->company_id;
        $userId    = Auth::id();

        // Full form validation with company-scoped exists rules for security.
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'category_id'  => 'required|exists:categories,id,company_id,' . $companyId,
            'brand_id'     => 'nullable|exists:brands,id,company_id,' . $companyId,
            'description'  => 'nullable|string',
            'has_variants' => 'nullable|boolean',

            'variants'                   => 'required|array|min:1',
            'variants.*.sku'             => 'required|string|max:255',
            'variants.*.barcode'         => 'nullable|string|max:255',
            'variants.*.unit_id'         => 'required|exists:units,id,company_id,' . $companyId,
            'variants.*.tax_id'          => 'nullable|exists:taxes,id,company_id,' . $companyId,
            'variants.*.cost_price'      => 'required|numeric|min:0',
            'variants.*.selling_price'   => 'required|numeric|min:0',
            'variants.*.initial_stock'   => 'required|integer|min:0',
            'variants.*.reorder_level'   => 'required|integer|min:0',
            'variants.*.attributes'      => 'nullable|array',
        ]);

        DB::beginTransaction();

        try {
            // Step 1: Create the parent Product record.
            $product = Product::create([
                'company_id'   => $companyId,
                'name'         => $validated['name'],
                'category_id'  => $validated['category_id'],
                'brand_id'     => $validated['brand_id'] ?? null,
                'description'  => $validated['description'] ?? null,
                'has_variants' => $request->boolean('has_variants'),
                'is_active'    => true,
            ]);

            // Step 2: Process and create each variant.
            foreach ($validated['variants'] as $variantData) {

                // Clean and encode the attributes JSON.
                $cleanAttributes = [];
                if (! empty($variantData['attributes']) && is_array($variantData['attributes'])) {
                    foreach ($variantData['attributes'] as $attr) {
                        if (! empty($attr['key']) && ! empty($attr['value'])) {
                            $cleanAttributes[] = [
                                'key'   => trim($attr['key']),
                                'value' => trim($attr['value']),
                            ];
                        }
                    }
                }

                // Create the ProductVariant.
                $variant = ProductVariant::create([
                    'product_id'    => $product->id,
                    'sku'           => $variantData['sku'],
                    'barcode'       => $variantData['barcode'] ?? null,
                    'unit_id'       => $variantData['unit_id'],
                    'tax_id'        => $variantData['tax_id'] ?? null,
                    'cost_price'    => $variantData['cost_price'],
                    'selling_price' => $variantData['selling_price'],
                    'reorder_level' => $variantData['reorder_level'],
                    'attributes'    => ! empty($cleanAttributes) ? $cleanAttributes : null,
                    'is_active'     => true,
                ]);

                // Step 3: Create initial Stock entry (company-level, no branch yet).
                // The stocks table unique key is (branch_id, variant_id).
                // For a company-level initial stock (before branch assignment),
                // we create a stock row with branch_id = null.
                // FIX: Removed non-existent 'product_id' from the Stock upsert.
                $initialStock = (int) ($variantData['initial_stock'] ?? 0);

                Stock::updateOrCreate(
                    [
                        // Unique lookup: one stock row per variant per branch (null = warehouse/unassigned)
                        'company_id' => $companyId,
                        'branch_id'  => null,
                        'variant_id' => $variant->id,
                    ],
                    [
                        'quantity'      => $initialStock,
                        'reorder_level' => $variantData['reorder_level'],
                    ]
                );

                // Step 4: Create a StockMovement audit log entry for the initial stock.
                // FIX 1: type changed from invalid 'in' to valid enum value 'purchase_in'.
                // FIX 2: Removed non-existent 'product_id' column.
                // FIX 3: Removed non-existent 'reference' string column.
                //         The migration uses nullableMorphs('reference') which creates
                //         'reference_type' (string) and 'reference_id' (bigint) columns.
                //         For a manual initial stock entry, both are null.
                if ($initialStock > 0) {
                    StockMovement::create([
                        'company_id'     => $companyId,
                        'branch_id'      => null,
                        'variant_id'     => $variant->id,
                        'type'           => 'purchase_in',  // Valid enum value
                        'quantity'       => $initialStock,  // Positive = stock coming in
                        'reference_type' => null,           // No linked document for initial entry
                        'reference_id'   => null,
                        'user_id'        => $userId,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('company.products.index')
                ->with('success', 'Product and its variants have been added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Failed to add product: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $this->authorizeCompany($product);

        $product->load(['category', 'brand', 'variants.unit', 'variants.tax']);

        return Inertia::render('Company/Products/Show', [
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $this->authorizeCompany($product);
        $companyId = Auth::user()->company_id;

        $product->load('variants');

        return Inertia::render('Company/Products/Edit', [
            'product'    => $product,
            'categories' => Category::where('company_id', $companyId)->where('is_active', true)->get(['id', 'name']),
            'brands'     => Brand::where('company_id', $companyId)->where('is_active', true)->get(['id', 'name']),
            'units'      => Unit::where('company_id', $companyId)->where('is_active', true)->get(['id', 'name']),
            'taxes'      => Tax::where('company_id', $companyId)->where('is_active', true)->get(['id', 'name', 'rate']),
        ]);
    }

    /**
     * Update the specified product in storage.
     *
     * Same fixes applied as in store():
     *  - Stock upsert uses (company_id, branch_id, variant_id) — no product_id.
     *  - StockMovement uses valid enum type and correct morphs columns.
     */
    public function update(Request $request, Product $product)
    {
        $this->authorizeCompany($product);
        $companyId = Auth::user()->company_id;
        $userId    = Auth::id();

        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'category_id'  => 'required|exists:categories,id,company_id,' . $companyId,
            'brand_id'     => 'nullable|exists:brands,id,company_id,' . $companyId,
            'description'  => 'nullable|string',
            'has_variants' => 'nullable|boolean',

            'variants'                   => 'required|array|min:1',
            'variants.*.id'              => 'nullable|exists:product_variants,id',
            'variants.*.sku'             => 'required|string|max:255',
            'variants.*.barcode'         => 'nullable|string|max:255',
            'variants.*.unit_id'         => 'required|exists:units,id,company_id,' . $companyId,
            'variants.*.tax_id'          => 'nullable|exists:taxes,id,company_id,' . $companyId,
            'variants.*.cost_price'      => 'required|numeric|min:0',
            'variants.*.selling_price'   => 'required|numeric|min:0',
            'variants.*.initial_stock'   => 'required|integer|min:0',
            'variants.*.reorder_level'   => 'required|integer|min:0',
            'variants.*.attributes'      => 'nullable|array',
        ]);

        DB::beginTransaction();

        try {
            // Step 1: Update the parent Product.
            $product->update([
                'name'         => $validated['name'],
                'category_id'  => $validated['category_id'],
                'brand_id'     => $validated['brand_id'] ?? null,
                'description'  => $validated['description'] ?? null,
                'has_variants' => $request->boolean('has_variants'),
            ]);

            $processedVariantIds = [];

            // Step 2: Update existing variants or create new ones.
            foreach ($validated['variants'] as $variantData) {

                $cleanAttributes = [];
                if (! empty($variantData['attributes']) && is_array($variantData['attributes'])) {
                    foreach ($variantData['attributes'] as $attr) {
                        if (! empty($attr['key']) && ! empty($attr['value'])) {
                            $cleanAttributes[] = [
                                'key'   => trim($attr['key']),
                                'value' => trim($attr['value']),
                            ];
                        }
                    }
                }

                $variantPayload = [
                    'sku'           => $variantData['sku'],
                    'barcode'       => $variantData['barcode'] ?? null,
                    'unit_id'       => $variantData['unit_id'],
                    'tax_id'        => $variantData['tax_id'] ?? null,
                    'cost_price'    => $variantData['cost_price'],
                    'selling_price' => $variantData['selling_price'],
                    'reorder_level' => $variantData['reorder_level'],
                    'attributes'    => ! empty($cleanAttributes) ? $cleanAttributes : null,
                ];

                $variantId = $variantData['id'] ?? null;

                if ($variantId) {
                    // Update existing variant — verify it belongs to this product.
                    $variant = ProductVariant::where('product_id', $product->id)
                        ->findOrFail($variantId);
                    $variant->update($variantPayload);
                    $processedVariantIds[] = $variant->id;
                } else {
                    // Create a brand-new variant for this product.
                    $variantPayload['product_id'] = $product->id;
                    $variantPayload['is_active']   = true;
                    $newVariant = ProductVariant::create($variantPayload);
                    $processedVariantIds[] = $newVariant->id;

                    // Create initial stock for the new variant.
                    // FIX: No product_id in Stock, correct morphs in StockMovement.
                    $initialStock = (int) ($variantData['initial_stock'] ?? 0);

                    Stock::updateOrCreate(
                        [
                            'company_id' => $companyId,
                            'branch_id'  => null,
                            'variant_id' => $newVariant->id,
                        ],
                        [
                            'quantity'      => $initialStock,
                            'reorder_level' => $variantData['reorder_level'],
                        ]
                    );

                    if ($initialStock > 0) {
                        StockMovement::create([
                            'company_id'     => $companyId,
                            'branch_id'      => null,
                            'variant_id'     => $newVariant->id,
                            'type'           => 'purchase_in',
                            'quantity'       => $initialStock,
                            'reference_type' => null,
                            'reference_id'   => null,
                            'user_id'        => $userId,
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()
                ->route('company.products.index')
                ->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Failed to update product: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified product from storage.
     *
     * Products with transaction history are soft-deleted (set is_active = false)
     * rather than hard-deleted to preserve audit trails.
     */
    public function destroy(Product $product)
    {
        $this->authorizeCompany($product);

        // Check if any stock movements exist for this product's variants.
        $variantIds  = $product->variants()->pluck('id');
        $hasHistory  = StockMovement::whereIn('variant_id', $variantIds)->exists();

        if ($hasHistory) {
            // Soft-deactivate instead of hard delete to preserve history.
            $product->update(['is_active' => false]);

            return back()->with('success', 'Product has transaction history and has been deactivated instead of deleted.');
        }

        DB::beginTransaction();
        try {
            // Hard delete: remove stock, movements, variants, then the product.
            $product->variants()->each(function ($variant) {
                Stock::where('variant_id', $variant->id)->delete();
                StockMovement::where('variant_id', $variant->id)->delete();
                $variant->delete();
            });

            $product->delete();
            DB::commit();

            return redirect()
                ->route('company.products.index')
                ->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }

    // ==========================================
    // Private Helpers
    // ==========================================

    /**
     * Abort with 403 if the product does not belong to the authenticated user's company.
     * This is a secondary guard - the EnsureTenantAccess middleware is the primary one.
     */
    private function authorizeCompany(Product $product): void
    {
        if ((int) $product->company_id !== (int) Auth::user()->company_id) {
            abort(403, 'Unauthorized: This product does not belong to your company.');
        }
    }
}
