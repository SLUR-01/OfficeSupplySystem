<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnRequest extends Model
{
    use HasFactory;
    protected $table = 'returns';

    protected $fillable = [
        'request_id',
        'item_id',
        'user_id',
        'requester_name',
        'item_name',
        'variant_value',
        'quantity',
        'department',
        'return_date',
        'condition',
        'description',
        'return_status',
        'proof_image',
        'replacement_status',
        'quantity_received',
    ];
    protected $casts = [
        'return_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function requestSupply()
    {
        return $this->belongsTo(RequestSupply::class);
    }


    
    public function originalRequest()
    {
        return $this->belongsTo(Request::class, 'request_id');
    }
}