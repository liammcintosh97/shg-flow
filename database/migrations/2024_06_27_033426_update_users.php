<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('asana_id');
            $table->integer('number');
            $table->boolean('disaster_support');
            $table->json('brands');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('asana_id');
            $table->dropColumn('number');
            $table->dropColumn('disaster_support');
            $table->dropColumn('brands');
        });
    }
};
