<?php

namespace App;

use App\Order;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'alamat', 'no_phone'];

    public function order()
    {
        return $this->hasMany(Order::class);
    }

}
