<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Stock;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PosController extends Controller
{
    // ১. POS পেজ লোড করা
    public function index()
    {
        return Inertia::render('Branch/POS');
    }

    // ২. AJAX: বারকোড বা নাম দিয়ে প্রোডাক্ট সার্চ করা
    public function search(Request $request)
    {
        $query = $request->input('q');
        $user = auth()->user();
        $branchId = $user->branch_id;

        // চেক ১: ইউজারের ব্রাঞ্চ আইডি আছে কিনা
        if (!$branchId) {
            return response()->json(['error' => 'Debug: আপনার ইউজার অ্যাকাউন্টে কোনো branch_id অ্যাসাইন করা নেই!'], 400);
        }

        // চেক ২: প্রোডাক্ট ভ্যারিয়েন্ট খুঁজে বের করা
        $variant = ProductVariant::where('barcode', $query)
            ->orWhere('sku', $query)
            ->orWhereHas('product', function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->first();

        if (!$variant) {
            return response()->json(['error' => 'Debug: ক্যাটালগে এই বারকোড/নামের কোনো প্রোডাক্ট নেই। Query: ' . $query], 404);
        }

        // চেক ৩: ওই নির্দিষ্ট ব্রাঞ্চে স্টক আছে কিনা
        $stock = Stock::where('variant_id', $variant->id)
            ->where('branch_id', $branchId)
            ->first();

        if (!$stock) {
            return response()->json(['error' => 'Debug: Variant ID: ' . $variant->id . ' এর জন্য Branch ID: ' . $branchId . ' তে কোনো Stock row নেই!'], 400);
        }

        if ($stock->quantity <= 0) {
            return response()->json(['error' => 'Debug: স্টক আছে কিন্তু Quantity 0!'], 400);
        }

        // সব ঠিক থাকলে ডাটা রিটার্ন করা
        return response()->json([
            'variant_id' => $variant->id,
            'name' => $variant->product->name . ($variant->name ? ' - ' . $variant->name : ''),
            'sku' => $variant->sku,
            'price' => $variant->selling_price,
            'available_stock' => $stock->quantity
        ]);
    }

    // ৩. চেকআউট প্রসেস (স্টক কাটা, সেল সেভ করা)
    public function checkout(Request $request)
    {
        $request->validate([
            'cart_data' => 'required|json',
            'customer_id' => 'nullable|exists:customers,id',
            'payment_method' => 'required|in:cash,card,mobile_banking',
            'received_amount' => 'required|numeric|min:0',
        ]);

        $cart = json_decode($request->cart_data, true);
        if (empty($cart)) return back()->with('error', 'Cart is empty!');

        $branchId = auth()->user()->branch_id;
        $companyId = auth()->user()->company_id;
        $userId = auth()->id();

        DB::beginTransaction();
        try {
            $subtotal = 0;
            $saleItemsData = [];

            // স্টক ভ্যালিডেশন এবং টোটাল হিসাব
            foreach ($cart as $item) {
                $stock = Stock::where('variant_id', $item['variant_id'])
                    ->where('branch_id', $branchId)
                    ->lockForUpdate() // Race condition এড়াতে
                    ->first();

                if (!$stock || $stock->quantity < $item['qty']) {
                    throw new \Exception("Insufficient stock for: " . $item['name']);
                }

                $lineTotal = $item['price'] * $item['qty'];
                $subtotal += $lineTotal;

                $saleItemsData[] = [
                    'variant_id' => $item['variant_id'],
                    'product_name' => $item['name'],
                    'quantity' => $item['qty'],
                    'unit_price' => $item['price'],
                    'subtotal' => $lineTotal,
                ];
            }

            // সেল রেকর্ড তৈরি
            $sale = Sale::create([
                'company_id' => $companyId,
                'branch_id' => $branchId,
                'customer_id' => $request->customer_id,
                'user_id' => $userId,
                'invoice_no' => 'INV-' . strtoupper(uniqid()),
                'subtotal' => $subtotal,
                'discount' => 0,
                'total_amount' => $subtotal,
                'received_amount' => $request->received_amount,
                'payment_method' => $request->payment_method,
                'status' => 'completed',
            ]);

            // সেল আইটেম সেভ এবং স্টক ডিক্রিমেন্ট
            foreach ($saleItemsData as $itemData) {
                $sale->items()->create($itemData);

                // স্টক কমানো
                $stock = Stock::where('variant_id', $itemData['variant_id'])
                    ->where('branch_id', $branchId)->first();
                $stock->decrement('quantity', $itemData['quantity']);

                // অডিট লগ (Stock Movement)
                StockMovement::create([
                    'company_id' => $companyId,
                    'branch_id' => $branchId,
                    'variant_id' => $itemData['variant_id'],
                    'type' => 'sale_out',
                    'quantity' => -$itemData['quantity'],
                    'reference_type' => Sale::class,
                    'reference_id' => $sale->id,
                    'user_id' => $userId,
                ]);
            }

            DB::commit();
            // ইনভয়েস পেজে রিডাইরেক্ট
            return redirect()->route('branch.pos.invoice-print', $sale->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Checkout failed: ' . $e->getMessage());
        }
    }

    // ৪. ইনভয়েস প্রিন্ট ভিউ
    public function printInvoice(Sale $sale)
    {
        if ($sale->branch_id !== auth()->user()->branch_id) abort(403);
        $sale->load('items.variant.product');
        return view('branch.pos.invoice_print', compact('sale'));
    }
}
