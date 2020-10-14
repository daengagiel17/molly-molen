<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Customer;
use App\Order;
use App\Menu;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function menu()
    {
        $menu = Menu::all();

        return response()->json($menu);
    }   
    
    public function order(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'alamat' => 'required',
            'no_phone' => 'required',
        ]);

        // Create customer
        $customer = new Customer;
        $customer->name = $request->name;
        $customer->alamat = $request->alamat;
        $customer->no_phone = $request->no_phone;
        $customer->save();

        // Create order
        $order = new Order;
        $order->customer_id = $customer->id;
        $order->total = 0;
        $order->status = "wait";
        $order->save();

        // Menghitung harga total order
        $menus = Menu::whereIn('id', $request->menu)->get();

        foreach ($menus as $key => $menu) {
            $order->total = $order->total + ($menu->price * $request->qty[$key]);
            $order->menu()->attach($menu->id, ['qty' => $request->qty[$key]]);
        }
        $order->save();

        return response()->json('success');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'alamat' => 'required',
            'no_phone' => 'required',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->name = $request->name;
        $customer->alamat = $request->alamat;
        $customer->no_phone = $request->no_phone;
        $customer->save();

        return response()->json('success');
    }


}
