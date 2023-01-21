<?php

namespace Modules\Customers\Http\Controllers;

use Illuminate\Auth\Events\Failed;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Customers\Entities\Customers;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function __construct()
    {
        // module model name, path
        $this->module_model = "Modules\Customers\Entities\Customers";
    }
    public function index()
    {

        return view('customers::view_all');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */

    public function createPage()
    {
        return view('customers::create_customer');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'fax' => 'required',
            'phone' => 'required',
            'company' => 'required',
            'address' => 'required',
            'state' => 'required',
            'zip' => 'required',
            'city' => 'required',
        ]);

        Customers::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'fax' => $request->fax,
            'phone' => $request->phone,
            'company' => $request->company,
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'city' => $request->city,
        ]);

        return redirect()->route('backend.customer.view');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('customers::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $collected_data = \DB::table('customers')->where("id", $id)->first();

        $data = compact('collected_data');

        return view('customers::update_customer')->with($data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        Customers::where('id', $id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'fax' => $request->fax,
            'phone' => $request->phone,
            'company' => $request->company,
            'address' => $request->address,
            'state' => $request->state,
            'zip' => $request->zip,
            'city' => $request->city,
        ]);

        return redirect()->route('backend.customer.view');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $customer = Customers::find($id);

        $customer->delete();

        return redirect()->route('backend.customer.view');
    }
}
