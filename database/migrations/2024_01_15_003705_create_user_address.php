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
        Schema::create('users_address', function (Blueprint $table) {
            $table->id();
            $table->string('address_name');
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('lastname');
            $table->string('telephone');
            $table->string('email');
            $table->string('city');
            $table->string('county');
            $table->string('neighborhood');
            $table->string('full_address');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
