<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable =
    [

        'item_name',
        'variant_type',
        'variant_value',
        'current_stock',
        'remaining_stocks',
        'reorderpoint',

    ];
    public $incrementing = false;
    protected $primaryKey = 'id';

    public function requestItems()
    {
        return $this->hasMany(RequestItem::class);
    }

    public function requests()
    {
        // All requests that contain this stock
        return $this->hasManyThrough(
            RequestSupply::class,
            RequestItem::class,
            'stock_id',       // Foreign key on RequestItem table
            'id',             // Foreign key on RequestSupply table
            'id',             // Local key on Stock
            'request_supply_id' // Local key on RequestItem
        );
    }
}
