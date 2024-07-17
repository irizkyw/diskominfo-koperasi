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
        Schema::create('tabungan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedInteger('simp_pokok'); // simpanan pokok
            $table->unsignedInteger('simp_sukarela'); // simpanan sukarela
            $table->unsignedInteger('simp_wajib'); // simpanan wajib
            $table->decimal('angsuran', 15, 2)->default(0);
            $table->foreignId('golongan_id')->constrained()->onDelete('cascade');
            $table->timestamp('lastUpdate_principal')->nullable(); // last update simpanan wajib
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tabungan');
    }
};
