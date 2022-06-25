<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.order.index', [
            'orders' => Order::with('order_detail')->with('user')->get()->sortByDesc('id'),
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::with('order_detail')->find($id);
        $order_details = OrderDetail::where('order_id', $id)->with('variant')->get();
        return view('admin.order.show', [
            'order' => $order,
            'order_details' => $order_details,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function change_status(Request $request)
    {
        $id = $request->id;
        $order = Order::find($id);
        if(!isset($order) || $order->status !== 'Pending')
        {
            return response()->json([
                'status' => 'error',
                'message'=> 'Invalid Request! Status not Changed!'
            ]);
        } else {
            $order->status = $request->status;
            if($order->save())
            {
                return response()->json([
                    'status' => 'success',
                    'message'=> 'Status Changed Successfully!'
                ]);
            } else {
                return response()->json([
                    'status' => 'success',
                    'message'=> 'Status Changed Successfully!'
                ]);
            }
        }
    }
}
