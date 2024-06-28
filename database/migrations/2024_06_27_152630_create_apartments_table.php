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
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->string('name',200);
            $table->string('cover_image',255);
            $table->string('address',255);
            $table->text('description')->nullable();
            $table->smallInteger('square_meters')->unsigned();
            $table->tinyInteger('num_bathrooms')->unsigned();
            $table->tinyInteger('num_beds')->unsigned();
            $table->tinyInteger('num_rooms')->unsigned();
            $table->string('slug',255)->unique();
            $table->decimal('latitude', 11,8)->nullable();
            $table->decimal('longitude', 11,8)->nullable();
            $table->boolean('visible')->nullable()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};
