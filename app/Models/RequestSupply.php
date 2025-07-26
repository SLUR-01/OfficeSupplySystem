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
        'item_name',
        'quantity',
        'datetime',
        'description',
        'signature',
        'variant_value',
        'chairman_status',
        'dean_status',
        'admin_status',
        'withdrawal_status',
        'date_needed',
        'completed_at' => 'datetime',
        'withdrawn_by',
    ];
    public function stockItem()
    {
        return $this->belongsTo(Stock::class, 'item_name', 'item_name');
    }
    public function return(): HasOne
    {
        return $this->hasOne(ReturnRequest::class, 'request_id');
    }
    public function returnRequests()
    {
        return $this->hasMany(ReturnRequest::class, 'request_id');
    }
        public function returns()
    {
        return $this->hasMany(ReturnRequest::class, 'request_id'); // adjust foreign key if needed
    }




}
