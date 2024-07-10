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
            $table->unsignedInteger('principal_savings'); // simpanan pokok
            $table->unsignedInteger('voluntary_savings'); // simpanan sukarela
            $table->unsignedInteger('mandatory_savings'); // simpanan wajib
            $table->unsignedInteger('installments'); // angsuran
            $table->foreignId('group_id')->constrained()->onDelete('cascade');
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
