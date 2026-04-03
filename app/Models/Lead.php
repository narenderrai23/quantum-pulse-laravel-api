<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id',
        'name',
        'email',
        'phone',
        'city',
        'project',
        'status',
    ];

    /**
     * Format the lead to match the frontend's expected shape.
     */
    public function toApiArray(): array
    {
        return [
            'id'        => $this->lead_id,
            'name'      => $this->name,
            'email'     => $this->email,
            'phone'     => $this->phone,
            'city'      => $this->city,
            'project'   => $this->project,
            'status'    => $this->status,
            'timestamp' => $this->created_at->toISOString(),
        ];
    }
}
