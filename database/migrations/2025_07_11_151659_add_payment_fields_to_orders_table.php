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
            Schema::table('orders', function (Blueprint $table) {
                // Kolom untuk menyimpan path gambar bukti transfer
                $table->string('payment_proof')->nullable()->after('status');
                // Kolom untuk status pembayaran, terpisah dari status pengiriman
                $table->enum('payment_status', ['unpaid', 'paid', 'verified'])->default('unpaid')->after('payment_proof');
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
