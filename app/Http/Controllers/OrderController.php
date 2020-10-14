<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = Order::with('customer')->get();

        return view('order.index', compact(['orders']))->with('no',1);
    }

    public function show($id)
    {
        $order = Order::with('menu','customer')->find($id);

        return view('order.show', compact(['order']))->with('no',1);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $status = $order->status;

        if($status == "wait"){
            $order->status = "send";
        }elseif($status == "send"){
            $order->status = "done";
        }

        $order->save();

        return redirect()->route('order.index');
    }

}
