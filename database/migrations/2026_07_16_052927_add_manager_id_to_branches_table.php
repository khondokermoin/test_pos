<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('branches', function (Blueprint $table) {
            // Check if column doesn't exist before adding it
            if (!Schema::hasColumn('branches', 'manager_id')) {
                $table->foreignId('manager_id')
                      ->nullable() // Important: Your request body shows manager_id can be null
                      ->after('email')
                      ->constrained('users')
                      ->nullOnDelete(); // Sets to null if the user is deleted
            }
        });
    }

    public function down()
    {
        Schema::table('branches', function (Blueprint $table) {
            if (Schema::hasColumn('branches', 'manager_id')) {
                $table->dropForeign(['manager_id']);
                $table->dropColumn('manager_id');
            }
        });
    }
};