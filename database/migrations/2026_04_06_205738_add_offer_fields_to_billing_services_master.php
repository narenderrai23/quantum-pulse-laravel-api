<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('billing_services_master', function (Blueprint $table) {
            $table->date('offer_s_date')->nullable()->after('deffered_payment_applicable');
            $table->date('offer_e_date')->nullable()->after('offer_s_date');
            $table->decimal('offer_amount', 10, 2)->nullable()->after('offer_e_date');
        });
    }

    public function down(): void
    {
        Schema::table('billing_services_master', function (Blueprint $table) {
            $table->dropColumn(['offer_s_date', 'offer_e_date', 'offer_amount']);
        });
    }
};
