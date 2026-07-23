<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('branches', function (Blueprint $table) {
            // status কলাম না থাকলে যুক্ত করবে
            if (!Schema::hasColumn('branches', 'status')) {
                $table->string('status')->default('active')->after('company_id');
            }
        });
    }

    public function down()
    {
        Schema::table('branches', function (Blueprint $table) {
            if (Schema::hasColumn('branches', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};