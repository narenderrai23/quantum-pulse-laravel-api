<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingServicesMaster extends Model
{
    use HasFactory;

    protected $table = 'billing_services_master';

    protected $fillable = [
        'code',
        'category',
        'sub_category',
        'service_name',
        'hsn',
        'unit',
        'status',
        'max_price',
        'min_price',
        'product_cost',
        'tax_applicable_1',
        'tax_applicable_2',
        'finance_applicable',
        'deffered_payment_applicable',
        'offer_s_date',
        'offer_e_date',
        'offer_amount',
    ];

    protected $casts = [
        'max_price'    => 'decimal:2',
        'min_price'    => 'decimal:2',
        'product_cost' => 'decimal:2',
        'offer_amount' => 'decimal:2',
        'offer_s_date' => 'date',
        'offer_e_date' => 'date',
    ];

    /**
     * A service can appear in many offer lines.
     */
    public function offerServices()
    {
        return $this->hasMany(BillingOffersServices::class, 'service_id');
    }
}
