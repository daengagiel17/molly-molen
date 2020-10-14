<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Customer;
use App\Menu;

class Order extends Model
{
    protected $fillable = ['customer_id', 'total', 'status'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function menu()
    {
        return $this->belongsToMany(Menu::class, 'order_details')->withPivot('qty');
    }    

}
