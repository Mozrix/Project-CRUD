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
            $table->string('jam_mulai'); // Format: 00, 01, 02, ..., 23
            $table->string('jam_akhir');  // Format: 00, 01, 02, ..., 23
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};