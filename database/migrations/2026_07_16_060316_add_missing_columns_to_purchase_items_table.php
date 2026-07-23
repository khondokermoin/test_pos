<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('purchase_items', function (Blueprint $table) {
            if (!Schema::hasColumn('purchase_items', 'purchase_id')) {
                $table->foreignId('purchase_id')->after('id')->constrained()->cascadeOnDelete();
            }
            if (!Schema::hasColumn('purchase_items', 'variant_id')) {
                $table->foreignId('variant_id')->after('purchase_id')->constrained('product_variants')->cascadeOnDelete();
            }
            if (!Schema::hasColumn('purchase_items', 'quantity')) {
                $table->integer('quantity')->default(1)->after('variant_id');
            }
            if (!Schema::hasColumn('purchase_items', 'unit_price')) {
                $table->decimal('unit_price', 15, 2)->default(0)->after('quantity');
            }
            if (!Schema::hasColumn('purchase_items', 'subtotal')) {
                $table->decimal('subtotal', 15, 2)->default(0)->after('unit_price');
            }
        });
    }

    public function down(): void
    {
        Schema::table('purchase_items', function (Blueprint $table) {
            $table->dropForeign(['purchase_id']);
            $table->dropForeign(['variant_id']);
            $table->dropColumn(['purchase_id', 'variant_id', 'quantity', 'unit_price', 'subtotal']);
        });
    }
};