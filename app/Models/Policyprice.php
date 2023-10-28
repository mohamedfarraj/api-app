<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Products;

class Policyprice extends Model
{
    use HasFactory;


    protected $table = 'policyprice';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'type',
        'price',
    ];


    /**
    * Get the user that owns the phone.
    */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Products::class,'product_id','id');
    }
    
}
