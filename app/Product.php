<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
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
    protected $fillable = ['name', 'description', 'img_url', 'price'];

    /**
     * Get all orders where current product occurs
     */
    public function orders()
    {
        return $this->morphToMany(Order::class, 'positionable')
            ->using(Positionable::class)
            ->withPivot([
                'quantity',
                'price_mult',
                'price_add',
            ]);
    }
}
