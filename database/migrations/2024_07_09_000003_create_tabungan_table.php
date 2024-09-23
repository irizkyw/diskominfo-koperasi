<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("tabungan", function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->onDelete("cascade");
            $table->unsignedInteger("simp_pokok");
            $table->unsignedInteger("simp_sukarela")->default(0);
            $table->unsignedInteger("simp_wajib")->default(0);
            $table->unsignedInteger("tabungan_tahun")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("tabungan");
    }
};
