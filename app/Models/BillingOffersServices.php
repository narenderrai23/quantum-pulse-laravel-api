<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingOffersServices extends Model
{
    use HasFactory;

    protected $table = 'billing_offers_services';

    protected $fillable = [
        'offer_id',
        'service_id',
        'service_name',
        'qty',
        'record_date',
    ];

    protected $casts = [
        'record_date' => 'datetime',
        'qty'         => 'integer',
    ];

    /**
     * The master service this offer line belongs to.
     */
    public function service()
    {
        return $this->belongsTo(BillingServicesMaster::class, 'service_id');
    }
}
