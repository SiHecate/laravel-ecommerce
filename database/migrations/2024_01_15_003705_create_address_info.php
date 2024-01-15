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
            Girilen adresin adı örn:
                - Bilgenin evi
                - Umutun evi
            Kullanıcı bilgileri
                - İsim
                - Soyisim
                - Telefon numarası
            Adres bilgileri
                - Şehir
                - İlçe
                - Mahalle
            Tam adres.

        */
        Schema::create('address_infos', function (Blueprint $table) {
            $table->id();
            $table->string('address_name'); // JSON olmak yerine string kullanımı
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('lastname');
            $table->string('telephone');
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
