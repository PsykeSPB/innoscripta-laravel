<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'phone', 'address', 'comment'];

    /**
     * Get the user that made this order.
     * May return null, if user hasn't been loged in.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all products required in this order
     */
    public function products()
    {
        return $this->morphedByMany(Product::class, 'positionable')
            ->using(Positionable::class)
            ->withPivot([
                'quantity',
                'price_mult',
                'price_add',
            ]);
    }

    /**
     * Get all services required in this order
     */
    public function services()
    {
        return $this->morphedByMany(Service::class, 'positionable')
            ->using(Positionable::class)
            ->withPivot([
                'quantity',
                'price_mult',
                'price_add',
            ]);
    }

    /**
     * Get sum of all included products and services modified prices
     *
     * @return Number
     */
    public function getTotalCostAttribute()
    {
        return $this->products->concat($this->services)
            ->map(function ($position) {
                return $position->pivot->quantity * ( $position->pivot->price_mult * $position->price + $position->pivot->price_add );
            })
            ->reduce(function ($sum, $item) {
                return $sum + $item;
            });
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['total_cost'];
}
