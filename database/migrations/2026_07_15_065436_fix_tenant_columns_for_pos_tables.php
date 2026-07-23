<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ১. Categories টেবিল ফিক্স করা
        if (Schema::hasTable('categories')) {
            Schema::table('categories', function (Blueprint $table) {
                if (!Schema::hasColumn('categories', 'company_id')) {
                    $table->unsignedBigInteger('company_id')->nullable();
                }
                if (!Schema::hasColumn('categories', 'name')) {
                    $table->string('name')->nullable();
                }
                if (!Schema::hasColumn('categories', 'is_active')) {
                    $table->boolean('is_active')->default(true);
                }
            });
        }

        // ২. Brands টেবিল ফিক্স করা (যদি থাকে)
        if (Schema::hasTable('brands')) {
            Schema::table('brands', function (Blueprint $table) {
                if (!Schema::hasColumn('brands', 'company_id')) {
                    $table->unsignedBigInteger('company_id')->nullable();
                }
                if (!Schema::hasColumn('brands', 'name')) {
                    $table->string('name')->nullable();
                }
                if (!Schema::hasColumn('brands', 'is_active')) {
                    $table->boolean('is_active')->default(true);
                }
            });
        }

        // ৩. Units টেবিল ফিক্স করা (যদি থাকে)
        if (Schema::hasTable('units')) {
            Schema::table('units', function (Blueprint $table) {
                if (!Schema::hasColumn('units', 'company_id')) {
                    $table->unsignedBigInteger('company_id')->nullable();
                }
                if (!Schema::hasColumn('units', 'name')) {
                    $table->string('name')->nullable();
                }
            });
        }

        // ৪. Taxes টেবিল ফিক্স করা (যদি থাকে)
        if (Schema::hasTable('taxes')) {
            Schema::table('taxes', function (Blueprint $table) {
                if (!Schema::hasColumn('taxes', 'company_id')) {
                    $table->unsignedBigInteger('company_id')->nullable();
                }
                if (!Schema::hasColumn('taxes', 'name')) {
                    $table->string('name')->nullable();
                }
                if (!Schema::hasColumn('taxes', 'is_active')) {
                    $table->boolean('is_active')->default(true);
                }
            });
        }

        // ৫. Products টেবিল ফিক্স করা (Foreign Key ছাড়া, সম্পূর্ণ নিরাপদ)
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                if (!Schema::hasColumn('products', 'company_id')) {
                    $table->unsignedBigInteger('company_id')->nullable();
                }
                if (!Schema::hasColumn('products', 'category_id')) {
                    $table->unsignedBigInteger('category_id')->nullable();
                }
                if (!Schema::hasColumn('products', 'brand_id')) {
                    $table->unsignedBigInteger('brand_id')->nullable();
                }
                if (!Schema::hasColumn('products', 'name')) {
                    $table->string('name')->nullable();
                }
                if (!Schema::hasColumn('products', 'description')) {
                    $table->text('description')->nullable();
                }
                if (!Schema::hasColumn('products', 'has_variants')) {
                    $table->boolean('has_variants')->default(false);
                }
                if (!Schema::hasColumn('products', 'is_active')) {
                    $table->boolean('is_active')->default(true);
                }
            });
        }

        // ৬. Product Variants টেবিল তৈরি করা (যদি না থাকে)
        if (!Schema::hasTable('product_variants')) {
            Schema::create('product_variants', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('product_id');
                $table->string('sku')->unique();
                $table->string('barcode')->nullable()->unique();
                $table->unsignedBigInteger('unit_id')->nullable();
                $table->unsignedBigInteger('tax_id')->nullable();
                $table->decimal('cost_price', 10, 2)->default(0);
                $table->decimal('selling_price', 10, 2)->default(0);
                $table->integer('stock_quantity')->default(0);
                $table->integer('reorder_level')->default(5);
                $table->json('attributes')->nullable(); 
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
        
        $tables = ['products', 'categories', 'brands', 'units', 'taxes'];
        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    $columnsToDrop = [];
                    $possibleColumns = ['company_id', 'category_id', 'brand_id', 'name', 'description', 'has_variants', 'is_active'];
                    
                    foreach ($possibleColumns as $col) {
                        if (Schema::hasColumn($tableName, $col)) {
                            $columnsToDrop[] = $col;
                        }
                    }
                    
                    // MySQL-এ কলাম ড্রপ করলে অটোমেটিক্যালি তার ফরেন কি কনস্ট্রেইন্টও ড্রপ হয়ে যায়
                    if (!empty($columnsToDrop)) {
                        $table->dropColumn($columnsToDrop);
                    }
                });
            }
        }
    }
};