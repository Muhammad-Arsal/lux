<?php

namespace Modules\Product\Http\Controllers\Backend;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Product\Entities\Category;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Flash;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductVariants;

class ProductController extends Controller
{
    // use Authorizable;

    public function __construct()
    {
        // module model name, path
        $this->module_model = "Modules\Product\Entities\Product";
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $module_model = $this->module_model;

        $products = $module_model::orderBy('created_at', 'desc')->get();

        return view('product::product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $module_model = $this->module_model;

        $categories = Category::where('parent_id', 0)->orderBy('name')->get();

        return view('product::product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'product_cat_id' => 'required',
            'desc' => 'required',
            'featured' => 'required',
            'offer_availability' => 'required',
            'product_picture' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            'variant_name' => 'required',
            'variant_description' => 'required',
            'variant_price' => 'required',
            'discount_price' => 'required',
            'variant_picture' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
        ], [
            'product_name.required' => "The Product Name field is required",
            'product_cat_id.required' => "The Choose Category field is required",
            'desc.required' => "The Description field is required",
            'variant_price.required' => "The Price field is required",
            'variant_picture.required' => 'The Picture field is required',
            'product_picture.required' => "The Picture field is required",
        ]);

        $validator->sometimes('offer_type', 'required', function ($request) {
            return ($request->offer_availability == 'yes' ? true : false);
        });

        $validator->sometimes('on_purchase_of', 'required', function ($request) {
            return ($request->offer_availability == 'yes' ? true : false);
        });

        $validator->sometimes('free_prod_qty', 'required', function ($request) {
            return ($request->offer_availability == 'yes' && $request->offer_type == 'free' ? true : false);
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $module_model = $this->module_model;


        $product_image_name = "";
        if ($request->hasFile('product_picture')) {
            $product_image = $request->file('product_picture');
            if (!empty($product_image)) {
                $ext =  strtolower($product_image->getClientOriginalExtension());
                $directory = public_path('uploads/product/');
                if (!$directory) mkdir($directory, 0777);

                //  if(isset($admin->profile) && !empty($admin->profile->profile_image)){   
                //     $existingProfileImage = $directory.$admin->profile->profile_image;
                //     if(file_exists($existingProfileImage)) unlink($existingProfileImage);
                // }
                $product_image_name =  base64_encode('product-' . time()) . '.' . $ext;
                $product_image->move($directory, $product_image_name);
            }
        }

        $product = $module_model::create([
            'name' => $request->product_name,
            'cat_id' => $request->product_cat_id,
            'description' => $request->desc,
            'picture' => $product_image_name,
            'featured' => $request->featured,
            'offer' => $request->offer_availability,
            'offer_type' => $request->offer_type,
            'on_purchase' => $request->on_purchase_of,
            'free_qty' => $request->free_prod_qty,
        ]);

        if ($product) {
            $variant_image_name = "";
            if ($request->hasFile('variant_picture')) {
                $variant_image = $request->file('variant_picture');
                if (!empty($variant_image)) {
                    $ext =  strtolower($variant_image->getClientOriginalExtension());
                    $directory = public_path('uploads/product/');
                    if (!$directory) mkdir($directory, 0777);

                    //  if(isset($admin->profile) && !empty($admin->profile->profile_image)){   
                    //     $existingProfileImage = $directory.$admin->profile->profile_image;
                    //     if(file_exists($existingProfileImage)) unlink($existingProfileImage);
                    // }
                    $variant_image_name =  base64_encode('product-' . time()) . '.' . $ext;
                    $variant_image->move($directory, $variant_image_name);
                }
            }

            $discount_percentage = 0;
            if ($request->discount_price != 0) {
                $discount_percentage = (int)(($request->variant_price - $request->discount_price) / $request->variant_price) * 100;
            }

            $productVariant = ProductVariants::create([
                'name' => $request->variant_name,
                'parent_id' => $product->id,
                'description' => $request->variant_description,
                'price' => $request->variant_price,
                'discount_percentage' => $discount_percentage,
                'discount_price' => $request->discount_price,
                'picture' => $variant_image_name,
            ]);

            Flash::success("<i class='fas fa-check'></i> New Product Added")->important();

            return redirect()->route('backend.product.index');
        } else {
            Flash::error("<i class='fas fa-times'></i> Ooops! Something went wrong")->important();

            return redirect()->route('backend.product.index');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('product::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function editProduct($id)
    {
        $module_model = $this->module_model;

        $categories = Category::where('parent_id', 0)->orderBy('name')->get();

        $product = $module_model::where('id', $id)->first();

        return view('product::product.editProduct', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function updateProduct(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required',
            'product_cat_id' => 'required',
            'desc' => 'required',
            'featured' => 'required',
            'offer_availability' => 'required',
            'product_picture' => 'image|mimes:jpg,png,jpeg,gif,svg',
        ], [
            'product_name.required' => "The Product Name field is required",
            'product_cat_id.required' => "The Choose Category field is required",
            'desc.required' => "The Description field is required",
        ]);

        $validator->sometimes('offer_type', 'required', function ($request) {
            return ($request->offer_availability == 'yes' ? true : false);
        });

        $validator->sometimes('on_purchase_of', 'required', function ($request) {
            return ($request->offer_availability == 'yes' ? true : false);
        });

        $validator->sometimes('free_prod_qty', 'required', function ($request) {
            return ($request->offer_availability == 'yes' && $request->offer_type == 'free' ? true : false);
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $module_model = $this->module_model;

        $getProduct = $module_model::where('id', $id)->first();


        $product_image_name = "";
        if ($request->hasFile('product_picture')) {
            $product_image = $request->file('product_picture');
            if (!empty($product_image)) {
                $ext =  strtolower($product_image->getClientOriginalExtension());
                $directory = public_path('uploads/product/');
                if (!$directory) mkdir($directory, 0777);

                if (isset($getProduct->picture)) {
                    $existingProfileImage = $directory . $getProduct->picture;
                    if (file_exists($existingProfileImage)) unlink($existingProfileImage);
                }
                $product_image_name =  base64_encode('product-' . time()) . '.' . $ext;
                $product_image->move($directory, $product_image_name);
            }

            $product = $module_model::where('id', $id)->update([
                'name' => $request->product_name,
                'cat_id' => $request->product_cat_id,
                'description' => $request->desc,
                'picture' => $product_image_name,
                'featured' => $request->featured,
                'offer' => $request->offer_availability,
                'offer_type' => $request->offer_type,
                'on_purchase' => $request->on_purchase_of,
                'free_qty' => $request->free_prod_qty,
            ]);
        } else {
            $product = $module_model::where('id', $id)->update([
                'name' => $request->product_name,
                'cat_id' => $request->product_cat_id,
                'description' => $request->desc,
                'featured' => $request->featured,
                'offer' => $request->offer_availability,
                'offer_type' => $request->offer_type,
                'on_purchase' => $request->on_purchase_of,
                'free_qty' => $request->free_prod_qty,
            ]);
        }

        if ($product) {

            Flash::success("<i class='fas fa-check'></i> Product Updated")->important();

            return redirect()->route('backend.product.index');
        } else {
            Flash::error("<i class='fas fa-times'></i> Ooops! Something went wrong")->important();

            return redirect()->route('backend.product.index');
        }
    }

    public function addVariant($id)
    {
        $module_model = $this->module_model;

        $product_id = $id;

        return view('product::product.addVariant', compact('product_id'));
    }

    public function storeVariant($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'variant_name' => 'required',
            'variant_description' => 'required',
            'variant_price' => 'required',
            'discount_price' => 'required',
            'variant_picture' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            'featured' => 'required',
        ], [
            'variant_price.required' => "The Price field is required",
            'variant_picture.required' => 'The Picture field is required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $module_model = $this->module_model;
        $variant_image_name = "";
        if ($request->hasFile('variant_picture')) {
            $variant_image = $request->file('variant_picture');
            if (!empty($variant_image)) {
                $ext =  strtolower($variant_image->getClientOriginalExtension());
                $directory = public_path('uploads/product/');
                if (!$directory) mkdir($directory, 0777);

                //  if(isset($admin->profile) && !empty($admin->profile->profile_image)){   
                //     $existingProfileImage = $directory.$admin->profile->profile_image;
                //     if(file_exists($existingProfileImage)) unlink($existingProfileImage);
                // }
                $variant_image_name =  base64_encode('product-' . time()) . '.' . $ext;
                $variant_image->move($directory, $variant_image_name);
            }
        }

        $discount_percentage = 0;
        if ($request->discount_price != 0) {
            $discount_percentage = (int)(($request->variant_price - $request->discount_price) / $request->variant_price) * 100;
        }

        $productVariant = ProductVariants::create([
            'name' => $request->variant_name,
            'parent_id' => $id,
            'description' => $request->variant_description,
            'price' => $request->variant_price,
            'discount_percentage' => $discount_percentage,
            'featured' => $request->featured,
            'discount_price' => $request->discount_price,
            'picture' => $variant_image_name,
            'size' => $request->size,
        ]);

        if ($productVariant) {
            Flash::success("<i class='fas fa-check'></i> New Product Variant Added")->important();

            return redirect()->route('backend.product.index');
        } else {
            Flash::error("<i class='fas fa-times'></i> Ooops! Something went wrong")->important();

            return redirect()->route('backend.product.index');
        }
    }

    public function editVariant($product_id, $id)
    {
        $module_model = $this->module_model;

        $product = ProductVariants::where('id', $id)->first();

        return view('product::product.editVariant', compact('product_id', 'product'));
    }

    public function updateVariant($product_id, $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'variant_name' => 'required',
            'variant_description' => 'required',
            'variant_price' => 'required',
            'discount_price' => 'required',
            'variant_picture' => 'image|mimes:jpg,png,jpeg,gif,svg',
            'featured' => 'required',
        ], [
            'variant_price.required' => "The Price field is required",
            'variant_picture.required' => 'The Picture field is required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $module_model = $this->module_model;

        $getProduct = ProductVariants::where('id', $id)->first();

        $variant_image_name = "";
        if ($request->hasFile('variant_picture')) {
            $variant_image = $request->file('variant_picture');
            if (!empty($variant_image)) {
                $ext =  strtolower($variant_image->getClientOriginalExtension());
                $directory = public_path('uploads/product/');
                if (!$directory) mkdir($directory, 0777);

                if (isset($getProduct->picture)) {
                    $existingProfileImage = $directory . $getProduct->picture;
                    if (file_exists($existingProfileImage)) unlink($existingProfileImage);
                }
                $variant_image_name =  base64_encode('product-' . time()) . '.' . $ext;
                $variant_image->move($directory, $variant_image_name);
            }

            $discount_percentage = 0;
            if ($request->discount_price != 0) {
                $discount_percentage = (int)(($request->variant_price - $request->discount_price) / $request->variant_price) * 100;
            }

            $productVariant = ProductVariants::where('id', $id)->update([
                'name' => $request->variant_name,
                'description' => $request->variant_description,
                'price' => $request->variant_price,
                'discount_percentage' => $discount_percentage,
                'featured' => $request->featured,
                'discount_price' => $request->discount_price,
                'picture' => $variant_image_name,
                'featured' => $request->featured,
                'size' => $request->size,
            ]);
        } else {
            $discount_percentage = 0;
            if ($request->discount_price != 0) {
                $discount_percentage = (int)(($request->variant_price - $request->discount_price) / $request->variant_price) * 100;
            }

            $productVariant = ProductVariants::where('id', $id)->update([
                'name' => $request->variant_name,
                'description' => $request->variant_description,
                'price' => $request->variant_price,
                'discount_percentage' => $discount_percentage,
                'featured' => $request->featured,
                'discount_price' => $request->discount_price,
                'featured' => $request->featured
            ]);
        }

        if ($productVariant) {
            Flash::success("<i class='fas fa-check'></i> Product Variant Updated")->important();

            return redirect()->route('backend.product.index');
        } else {
            Flash::error("<i class='fas fa-times'></i> Ooops! Something went wrong")->important();

            return redirect()->route('backend.product.index');
        }
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

    public function productPreview()
    {
        $products = ProductVariants::orderBy('id', 'asc')->get();

        return view('product::product.preview', compact('products'));
    }
}
