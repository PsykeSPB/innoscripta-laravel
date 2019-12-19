<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\MorphPivot;

class Positionable extends MorphPivot
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['order_id', 'positionable_type', 'positionable_id', 'quantity', 'price_mult', 'price_add'];
}
