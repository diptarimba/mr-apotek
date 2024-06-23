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
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->string("invoice_code");
            $table->timestamp("published_at");
            $table->timestamp("due_at");
            $table->bigInteger("tax");
            $table->bigInteger("total");
            $table->uuid("supplier_id");
            $table->uuid("updated_by_id");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
