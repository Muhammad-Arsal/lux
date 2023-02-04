<?php

namespace Modules\Invoices\Http\Controllers;

use Hamcrest\Type\IsNumeric;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Invoices\Entities\Orders;
use Modules\invoices\Entities\OrderDetails;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('invoices::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('invoices::create');
    }

    public function fetch($id)
    {
        $product_id = $id;
        if ($product_id == is_numeric($product_id)) {
            $collected = \DB::table('product_variants')->where('id', $product_id)->first();
            return response()->json(["relativeProducts" => $collected]);
        } else {
            $collected = \DB::table('product_variants')->where('name', $product_id)->first();
            return response()->json(["relativeProducts" => $collected]);
        }
    }

    public function search($current)
    {
        $current_string = $current;
        $collected = \DB::table('product_variants')->select("name")->where('name', 'LIKE', "%{$current_string}%")->get();
        return response()->json($collected);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $billCalculation = 0;
        $j = 0;
        foreach ($request['price'] as $items) {
            $billCalculation += $items * $request['qty'][$j];
            $j++;
        }
        $orders = new Orders();
        $orders->member_id = $request->member;
        $orders->time = time();
        $orders->order_type = 'invoice';
        $orders->bill = $billCalculation;
        $orders->total = $billCalculation;
        $orders->status = 'confirm';
        $orders->paid = 'no';

        $orders->save();

        $i = 0;
        if ($request->price) {
            foreach ($request->price as $items) {
                $order_details = new OrderDetails();

                $order_details->order_id = $orders->id;
                $order_details->variant_id = $request['ids'][$i];
                $order_details->price = $items;

                $dp = \DB::table('product_variants')->where('id', $request['ids'][$i])->first();

                $order_details->discount_price = $dp->discount_price;
                $order_details->qty_sold = $request['qty'][$i];
                $order_details->total = $request['qty'][$i] * $request['price'][$i];
                $order_details->save();

                ++$i;
            }
            return redirect()->route('backend.invoices.view');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function showDetails($id)
    {
        return view('invoices::details')->with(compact('id'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('invoices::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
