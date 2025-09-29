<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('order_id'); // initial order
            $table->date('start_date');
            $table->string('period')->default('monthly'); // monthly, yearly
            $table->integer('duration_months')->default(12);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indexes and foreign keys (optional)
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
