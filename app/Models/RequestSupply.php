<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class RequestSupply extends Model
{
    use HasFactory;

    protected $table = 'request_supplies';  // Define the table name (optional if it follows Laravel convention)

    protected $fillable = [
        'requester_name',
        'user_id',
        'department',
        'datetime',
        'description',
        'signature',
        'admin_status',
        'withdrawal_status',
        'date_needed',
        'completed_at' => 'datetime',
        'withdrawn_by',
    ];

    public function items()
    {
        return $this->hasMany(RequestItem::class);
    }

    // public function return(): HasOne
    // {
    //     return $this->hasOne(ReturnRequest::class, 'request_id');
    // }
    public function returnRequests()
    {
        return $this->hasMany(ReturnRequest::class, 'request_id');
    }
    public function returns()
    {
        return $this->hasMany(ReturnRequest::class, 'request_id'); // adjust foreign key if needed
    }
}
