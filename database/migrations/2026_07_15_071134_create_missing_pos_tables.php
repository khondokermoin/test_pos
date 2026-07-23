<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ১. Brands টেবিল তৈরি করা (যদি না থাকে)
        if (!Schema::hasTable('brands')) {
            Schema::create('brands', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('company_id')->nullable();
                $table->string('name');
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // ২. Units টেবিল তৈরি করা (যদি না থাকে)
        if (!Schema::hasTable('units')) {
            Schema::create('units', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('company_id')->nullable();
                $table->string('name');
                $table->string('short_code')->nullable(); // যেমন: kg, pcs, ltr
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        // ৩. Taxes টেবিল তৈরি করা (যদি না থাকে)
        if (!Schema::hasTable('taxes')) {
            Schema::create('taxes', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('company_id')->nullable();
                $table->string('name');
                $table->decimal('rate', 5, 2)->default(0); // যেমন: 15.00 (15% এর জন্য)
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('taxes');
        Schema::dropIfExists('units');
        Schema::dropIfExists('brands');
    }
};