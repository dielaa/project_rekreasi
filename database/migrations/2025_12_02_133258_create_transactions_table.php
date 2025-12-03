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
        Schema::create('transactions', function (Blueprint $table) {
            $table->string('no')->unique(); 
            $table->foreignId('user_id')->constrained('users'); 
            $table->foreignId('promo_id')->nullable()->constrained('promos'); 
            $table->decimal('total', 10, 2);
            $table->decimal('promo', 10, 2);
            $table->decimal('sub_total', 10, 2);
            $table->foreignId('payment_id')->constrained('payments'); 
            $table->string('attachment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};



