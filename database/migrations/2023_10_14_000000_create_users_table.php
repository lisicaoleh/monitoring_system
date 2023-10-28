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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->unsignedBigInteger('position_id')->nullable();
            $table->unsignedBigInteger('facility_id')->nullable();
            $table->string('email')->unique();
            $table->string('mobile')->unique();
            $table->string('password');
            $table->enum('role', config('app.user_roles'));
            $table->boolean('is_receive_email_notif')->default('false');
            $table->boolean('is_receive_sms_notif')->default('false');
            $table->boolean('is_receive_push_notif')->default('false');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
            $table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
