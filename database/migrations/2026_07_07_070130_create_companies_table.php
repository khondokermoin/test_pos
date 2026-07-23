<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();

            // --- Basic Information ---
            $table->string('name');
            $table->string('slug')->unique()->nullable();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('website')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->default('Bangladesh');
            $table->string('zip_code')->nullable();
            $table->string('logo')->nullable();

            // --- SaaS & Multi-tenancy ---
            $table->string('subdomain')->unique()->nullable();
            $table->string('custom_domain')->nullable();

            // --- POS & Inventory Core Settings ---
            $table->string('currency', 10)->default('BDT');
            $table->string('timezone', 50)->default('Asia/Dhaka');
            $table->json('settings')->nullable();

            // --- Subscription & Status ---
            $table->enum('status', ['active', 'inactive', 'suspended', 'trial'])->default('trial');
            $table->timestamp('trial_ends_at')->nullable();
            $table->foreignId('plan_id')->nullable()->constrained('plans')->nullOnDelete();

            // --- Admin Owner & Business Type ---
            $table->foreignId('business_type_id')->nullable()->constrained('business_types')->nullOnDelete(); // <-- এই লাইনটি এমন হতে হবে
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
