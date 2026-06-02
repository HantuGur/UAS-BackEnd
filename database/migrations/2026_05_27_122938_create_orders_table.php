<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->integer('total_price')->default(0);
            $table->integer('discount_amount')->default(0);
            $table->unsignedBigInteger('promo_id')->nullable();
            $table->string('status')->default('pending');
            $table->string('order_type')->default('dine_in');
            $table->unsignedBigInteger('table_id')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('orders');
    }
};