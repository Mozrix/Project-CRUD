<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nomer_hp');
            $table->date('tanggal_booking');
            $table->string('jam_mulai');
            $table->string('jam_akhir'); 
            $table->string('lapangan');
            $table->timestamps();
        });


    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};