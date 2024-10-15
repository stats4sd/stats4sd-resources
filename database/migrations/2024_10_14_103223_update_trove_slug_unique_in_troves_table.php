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
        Schema::table('troves', function (Blueprint $table) {
            // remove troves_slug_unique index
           $table->dropUnique('troves_slug_unique');
        });

        Schema::table('troves', function (Blueprint $table) {
            // add troves_slug_unique index
            $table->unique(['slug', 'uuid']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('troves', function (Blueprint $table) {
            //
        });
    }
};
