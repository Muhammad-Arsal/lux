<?php

namespace Modules\Product\Http\Controllers\Backend;

use App\Authorizable;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Flash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{

    // use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Categories';

        // module name
        // $this->module_name = 'categories';

        // directory path of the module
        // $this->module_path = 'categories';

        // module icon
        $this->module_icon = 'fa fa-shopping-bag';

        // module model name, path
        $this->module_model = "Modules\Product\Entities\Category";
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        $data['module_title'] = $this->module_title;
        $data['module_icon'] = $this->module_icon;
        $module_model = $this->module_model;

        $categories = $module_model::orderBy('name')->get();

        return view('product::category.index', compact('data', 'categories'));
    }

    // /**
    //  * Show the form for creating a new resource.
    //  * @return Renderable
    //  */
    public function create()
    {
        $module_model = $this->module_model;

        $categories = $module_model::where('parent_id', 0)->orderBy('name')->get();

        return view('product::category.create', compact('categories'));
    }

    // /**
    //  * Store a newly created resource in storage.
    //  * @param Request $request
    //  * @return Renderable
    //  */
    public function store(Request $request)
    {
        $module_model = $this->module_model;
        $request->validate([
            'name' => 'required',
        ]);

        $category = $module_model::create([
            'parent_id' => $request->parent_id ? $request->parent_id : 0,
            'name' => $request->name
        ]);

        Flash::success("<i class='fas fa-check'></i> New Category Added")->important();

        return redirect()->route('backend.product.category.index');
    }

    // /**
    //  * Show the specified resource.
    //  * @param int $id
    //  * @return Renderable
    //  */
    // public function show($id)
    // {
    //     return view('product::show');
    // }

    // /**
    //  * Show the form for editing the specified resource.
    //  * @param int $id
    //  * @return Renderable
    //  */
    public function edit($id)
    {
        $module_model = $this->module_model;

        $categories = $module_model::where('parent_id', 0)->where('id', '!=', $id)->orderBy('name')->get();

        $category = $module_model::where('id', $id)->first();
        return view('product::category.edit', compact('categories', 'category'));
    }

    // /**
    //  * Update the specified resource in storage.
    //  * @param Request $request
    //  * @param int $id
    //  * @return Renderable
    //  */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', Rule::unique('product_categories')->ignore($id)],
        ]);

        $module_model = $this->module_model;

        $category = $module_model::where('id', $id)->update([
            'parent_id' => $request->parent_id ? $request->parent_id : 0,
            'name' => $request->name
        ]);

        Flash::success("<i class='fas fa-check'></i> Category Updated")->important();

        return redirect()->route('backend.product.category.index');
    }

    // /**
    //  * Remove the specified resource from storage.
    //  * @param int $id
    //  * @return Renderable
    //  */
    public function destroy($id)
    {
        $module_model = $this->module_model;

        $category = $module_model::where('id', $id)->first();

        $child_cat = $module_model::where('parent_id', $id)->get();
        if (!$child_cat->isEmpty()) {
            Flash::error("<i class='fas fa-times'></i> This category has child categories, Delete them first!")->important();

            return redirect()->route('backend.product.category.index');
        }

        $category->delete();

        Flash::success("<i class='fas fa-check'></i> Category Deleted")->important();

        return redirect()->route('backend.product.category.index');
    }
}
