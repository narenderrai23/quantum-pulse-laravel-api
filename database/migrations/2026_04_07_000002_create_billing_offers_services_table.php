<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('billing_offers_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('offer_id');
            $table->unsignedBigInteger('service_id');
            $table->string('service_name');
            $table->integer('qty')->default(1);
            $table->timestamp('record_date')->nullable();
            $table->timestamps();

            $table->foreign('service_id')
                  ->references('id')
                  ->on('billing_services_master')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('billing_offers_services');
    }
};
