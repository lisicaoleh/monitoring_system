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
        Schema::create('accidents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('facility_id')->unsigned();
            $table->unsignedBigInteger('construction_id')->unsigned();
            $table->longText('notified_users')->nullable();
            $table->string('date');
            $table->timestamps();

            $table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade');
            $table->foreign('construction_id')->references('id')->on('constructions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accidents');
    }
};
