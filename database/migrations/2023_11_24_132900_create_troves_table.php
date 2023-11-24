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
        Schema::disableForeignKeyConstraints();

        Schema::create('troves', function (Blueprint $table) {
            $table->id();
            $table->string('title', 400);
            $table->string('slug', 400);
            $table->longText('description');
            $table->foreignId('uploader_id')->constrained('users');
            $table->date('creation_date');
            $table->foreignId('type_id')->constrained();
            $table->string('cover_image', 400);
            $table->boolean('public');
            $table->string('youtube', 400);
            $table->boolean('source');
            $table->integer('download_count')->default(null);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('troves');
    }
};
