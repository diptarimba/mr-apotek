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
            $table->bigInteger("quantity_received")->default(0);
            $table->bigInteger("quantity_sold")->default(0);
            $table->bigInteger("quantity_returned")->default(0);
            $table->bigInteger("quantity_expired")->default(0);
            $table->bigInteger("buy_price")->default(0);
            $table->bigInteger("buy_amount")->default(0);
            $table->string('buy_notes')->nullable();
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
