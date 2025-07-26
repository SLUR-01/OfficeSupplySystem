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
        'stock_quantity',
        'reorderpoint',

    ];
public $incrementing = false;
protected $primaryKey = 'id';

    public function requests()
{
    return $this->hasMany(RequestSupply::class, 'item_name', 'item_name');
}
    
}
