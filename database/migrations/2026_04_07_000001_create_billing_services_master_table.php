<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('billing_services_master', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('category')->nullable();
            $table->string('sub_category')->nullable();
            $table->string('service_name');
            $table->string('hsn')->nullable();
            $table->string('unit')->nullable();
            $table->enum('status', ['Active', 'Not Active'])->default('Active');
            $table->decimal('max_price', 10, 2)->nullable();
            $table->decimal('min_price', 10, 2)->nullable();
            $table->decimal('product_cost', 10, 2)->nullable();
            $table->tinyInteger('tax_applicable_1')->default(1);
            $table->tinyInteger('tax_applicable_2')->default(2);
            $table->enum('finance_applicable', ['yes', 'no'])->default('yes');
            $table->enum('deffered_payment_applicable', ['yes', 'no'])->default('yes');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('billing_services_master');
    }
};
