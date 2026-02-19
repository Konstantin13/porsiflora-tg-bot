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
        Schema::create('telegram_send_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_id');
            $table->text('message');
            $table->enum('status', ['SENT', 'FAILED']);
            $table->text('error')->nullable();
            $table->timestamp('sent_at');

            $table->unique(['shop_id', 'order_id']);
            $table->foreign(['shop_id', 'order_id'])
                ->references(['shop_id', 'id'])
                ->on('orders')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegram_send_log');
    }
};
