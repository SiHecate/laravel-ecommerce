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
        /*
            Adres bilgileri
            Telefon numarası

        */
        Schema::create('addressInfo,', function (Blueprint $table) {
            $table->id();
            $table->json('address_name');
            $table->unsignedBigInteger('user_id');
            $table->json('name');
            $table->json('lastname');
            $table->json('telephone');
            $table->json('city');
            $table->json('county');
            $table->json('neighborhood');
            $table->json('full_address');
            $table->timestamps();
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
