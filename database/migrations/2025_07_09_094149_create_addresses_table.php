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
            Schema::create('addresses', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('label');
                $table->string('recipient_name');
                $table->string('phone_number');
                $table->text('full_address');
                $table->string('province'); // <-- Pastikan ini 'province', bukan 'province_id'
                $table->string('city');     // <-- Pastikan ini 'city', bukan 'city_id'
                $table->string('postal_code');
                $table->boolean('is_default')->default(false);
                $table->timestamps();
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
