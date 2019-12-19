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
}
