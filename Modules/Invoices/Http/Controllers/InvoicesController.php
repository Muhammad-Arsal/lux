<?php

namespace Modules\Invoices\Http\Controllers;

use Hamcrest\Type\IsNumeric;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('invoices::show');
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
