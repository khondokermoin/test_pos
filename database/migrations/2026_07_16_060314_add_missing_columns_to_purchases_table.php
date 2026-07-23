<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            if (!Schema::hasColumn('purchases', 'company_id')) {
                $table->foreignId('company_id')->after('id')->constrained()->cascadeOnDelete();
            }
            if (!Schema::hasColumn('purchases', 'branch_id')) {
                $table->foreignId('branch_id')->nullable()->after('company_id')->constrained()->nullOnDelete();
            }
            if (!Schema::hasColumn('purchases', 'supplier_id')) {
                $table->foreignId('supplier_id')->nullable()->after('branch_id')->constrained()->nullOnDelete();
            }
            if (!Schema::hasColumn('purchases', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('supplier_id')->constrained()->nullOnDelete();
            }
            if (!Schema::hasColumn('purchases', 'purchase_date')) {
                $table->date('purchase_date')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('purchases', 'total_amount')) {
                $table->decimal('total_amount', 15, 2)->default(0)->after('purchase_date');
            }
            if (!Schema::hasColumn('purchases', 'status')) {
                $table->string('status')->default('pending')->after('total_amount');
            }
        });
    }

    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropForeign(['branch_id']);
            $table->dropForeign(['supplier_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn(['company_id', 'branch_id', 'supplier_id', 'user_id', 'purchase_date', 'total_amount', 'status']);
        });
    }
};