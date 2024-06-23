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
        Schema::create('product_trackers', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->uuid("product_id");
            $table->uuid("invoice_id");
            $table->bigInteger("quantity_received");
            $table->bigInteger("quantity_sold");
            $table->bigInteger("quantity_returned");
            $table->bigInteger("quantity_expired");
            $table->bigInteger("buy_price");
            $table->bigInteger("buy_amount");
            $table->string('buy_notes');
            $table->timestamp("expired_at");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_trackers');
    }
};
