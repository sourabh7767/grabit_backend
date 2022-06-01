<?php

namespace App\Http\Controllers\clerk;

use App\Http\Controllers\Controller;
use App\Models\clerk\Orders;
use App\Models\user\User;
use App\Models\user\Items;
use Illuminate\Http\Request;


class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['orders'] = Orders::get();
        if($data['orders']){
            foreach ($data['orders'] as $key => $order) {
                $user = User::find($order->user_id);
                $items = json_decode($order->items);
                $itemNames = [];
                //echo"<pre>";print_r($items);die;
                foreach ($items as $key1 => $itm) {
                    $item = Items::find($itm->item_id);
                    if($item){
                        $itemNames[$key1] = $item->en_item_name;    
                    }
                }
                $data['orders'][$key]['item_names'] = implode(', ', $itemNames);
                $data['orders'][$key]['user_name'] = $user->username;
            }
        }
        $data['section'] = "Orders";
        return view('clerk/orders/list', $data);
    }

    public function accept($id){
        $order = Orders::find($id);
        $order->status = 2;
        $order->save();
        return redirect('clerk/orders')->with('success', 'Order Accepted');        
    }

    public function cancel($id){
        $order = Orders::find($id);
        $order->status = 0;
        $order->save();
        return redirect('clerk/orders')->with('success', 'Order Cancelled');        
    }

    public function readyToDeliver($id){
        $order = Orders::find($id);
        $order->status = 3;
        $order->save();
        return redirect('clerk/orders')->with('success', 'Order Ready To Deliver');        
    }

    public function deliver($id){
        $order = Orders::find($id);
        $order->status = 4;
        $order->save();
        return redirect('clerk/orders')->with('success', 'Order Delivered');        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $store_id=$request->session()->get('store_id');
        $data['title'] = 'Orders';
        $data['orders'] = Orders::where('store_id',$store_id)->get();
        $data['section'] = "Orders";

        return view('clerk/orders/list', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\clerk\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function show(Orders $orders)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\clerk\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function edit(Orders $orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\clerk\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Orders $orders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\clerk\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function destroy(Orders $orders)
    {
        //
    }
}
