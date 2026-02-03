<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestItem extends Model
{
    use HasFactory;

    protected $table = 'request_items';

    protected $fillable = [
        'request_supply_id',  // FK to main request
        'stock_id',           // FK to stock table
        'item_name',          // Copy of the stock item name
        'variant_value',      // Optional variant
        'quantity',           // Quantity requested
    ];

    /**
     * The request this item belongs to
     */
    public function requestSupply()
    {
        return $this->belongsTo(RequestSupply::class);
    }

    /**
     * The stock item this request item references
     */
    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    /**
     * Returns associated return records (if any)
     */
    public function returns()
    {
        return $this->hasMany(ReturnRequest::class, 'request_item_id');
    }
}
