<?php

namespace App;
use App\Order;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use UserActivities;

    protected $fillable = ['name', 'description', 'price', 'image'];

    public function order()
    {
        return $this->belongsToMany(Order::class, 'order_details')->withPivot('qty');
    }

}
