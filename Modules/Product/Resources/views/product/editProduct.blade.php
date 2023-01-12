@extends('backend.layouts.app')

@section('title') Edit Product @endsection

@push('after-styles')
    <style>
        label.error, label.errorCustom, label.errorCustom1, label.errorCustom2 {
            color: red;
            font-weight: lighter !important;
            display: block;
        }
    </style>
@endpush

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item route='{{route("backend.product.index")}}' icon='fas fa-sitemap'>
        Products
    </x-backend-breadcrumb-item>
    <x-backend-breadcrumb-item type="active">Edit</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-body">

        <x-backend.section-header>
            <i class="fas fa-sitemap"></i> Product <small class="text-muted">Edit</small>

            <x-slot name="subtitle">
                Products Management Dashboard
            </x-slot>
            <x-slot name="toolbar">
                <x-backend.buttons.return-back />
                <a href="{{ route("backend.product.index") }}" class="btn btn-secondary ms-1" data-toggle="tooltip" title="Products List"><i class="fas fa-list-ul"></i> List</a>
            </x-slot>
        </x-backend.section-header>

        <div class="row mt-4">
            <div class="col">
                <form action="{{ route('backend.product.update', $product->id) }}" method="post" id="productForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row mbb-3">
                        <div class="col">
                            <div class="form-group">
                                <h4>Product</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" value="{{ old('product_name') ? old('product_name') : $product->name }}" name="product_name" id="product_name" placeholder="Name">
                            </div>
                            @error('product_name')
                                <label id="product_name-error" class="error"
                                for="product_name">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-group">
                                <label>Choose Category</label>
                                <select name="product_cat_id" id="product_cat_id" class="form-control">
                                    <option value="">Choose Category</option>
                                    @foreach ($categories as $item)
                                        @php $childCat = \DB::table('product_categories')->where('parent_id', $item->id)->get(); @endphp
                                        <optgroup label="{{ $item->name }}">
                                            @foreach ($childCat as $item1)
                                                <option {{ $product->cat_id == $item1->id ? 'selected' : '' }} value="{{ $item1->id }}">{{ $item1->name }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                            @error('product_cat_id')
                                <label id="product_cat_id-error" class="error"
                                for="product_cat_id">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                                <textarea class="form-control" id="desc" name="desc" rows="3">{{ old('desc') ? old('desc') : $product->description }}</textarea>
                            </div>
                            @error('desc')
                                <label id="desc-error" class="error"
                                for="desc">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-group">
                                <div class="picture">
                                    <img src="{{ asset('uploads/product/'.$product->picture) }}" style="width: 150px;">
                                </div>
                                <label>Picture</label>
                                <input type="file" name="product_picture" class="form-control" id="product_picture">
                            </div>
                            @error('product_picture')
                                <label id="product_picture-error" class="error"
                                for="product_picture">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-group">
                                <div>
                                    <label>Featured</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" {{ $product->featured == 'yes' ? 'checked' : '' }} name="featured" id="featured" value="yes">
                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" {{ $product->featured == 'no' ? 'checked' : '' }} name="featured" id="featured" value="no">
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                                <span class="errorCustom"></span>
                                @error('featured')
                                    <label id="featured-error" class="error"
                                    for="featured">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                    </div>
                    

                    <div class="row mbb-3">
                        <div class="col">
                            <div class="form-group">
                                <h4>Offer</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-group">
                                <div>
                                    <label>Offer Availability</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input offer_availability" {{ $product->offer == 'yes' ? 'checked' : '' }} type="radio" name="offer_availability" value="yes">
                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input offer_availability" {{ $product->offer == 'no' ? 'checked' : '' }} type="radio" name="offer_availability" value="no">
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                                <span class="errorCustom1"></span>
                                @error('offer_availability')
                                    <label id="offer_availability-error" class="error"
                                    for="offer_availability">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 offer_availability_yes" style="display: {{ $product->offer == 'yes' ? 'block' : 'none' }};">
                        <div class="col">
                            <div class="form-group">
                                <div>
                                    <label>Offer Type</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input offer_type" {{ $product->offer_type == 'free' ? 'checked' : '' }} type="radio" name="offer_type" value="free">
                                    <label class="form-check-label" for="inlineRadio1">Free</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input offer_type" {{ $product->offer_type == 'off' ? 'checked' : '' }} type="radio" name="offer_type" value="off">
                                    <label class="form-check-label" for="inlineRadio2">Off</label>
                                </div>
                                <span class="errorCustom2"></span>
                                @error('offer_type')
                                    <label id="offer_type-error" class="error"
                                    for="offer_type">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 offer_type_off" style="display: {{ $product->offer == 'yes' ? 'block' : 'none' }};">
                        <div class="col">
                            <div class="form-group">
                                <label>On Purchase Of:</label>
                                <input type="text" name="on_purchase_of" id="on_purchase_of" value="{{ $product->on_purchase }}" size="3">(pcs)
                            </div>
                            @error('on_purchase_of')
                                <label id="on_purchase_of-error" class="error"
                                for="on_purchase_of">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3 offer_type_free" style="display: {{ $product->offer_type == 'free' ? 'block' : 'none' }};">
                        <div class="col">
                            <div class="form-group">
                                <label>Free Products Qty:</label>
                                <input type="text" name="free_prod_qty" id="free_prod_qty" value="{{ $product->free_qty }}" size="3">(pcs)
                            </div>
                            @error('free_prod_qty')
                                <label id="free_prod_qty-error" class="error"
                                for="free_prod_qty">{{ $message }}</label>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                {{ html()->button($text = "<i class='fas fa-plus-circle'></i> Update", $type = 'submit')->class('btn btn-success') }}
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="float-end">
                                <div class="form-group">
                                    <button type="button" class="btn btn-warning" onclick="history.back(-1)"><i class="fas fa-reply"></i> Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    </div>
    <div class="card-footer">
        
    </div>
</div>
@endsection

@push('after-scripts')
    <script>
        var validate = $('#productForm').validate({
            // ignore: "",
            rules: {
                product_name: {
                    required: true,
                },
                product_cat_id: {
                    required: true,
                },
                desc: {
                    required: true,
                },
                featured: {
                    required: true,
                },
                offer_availability: {
                    required: true,
                },
                offer_type: {
                    required: true,
                },
                on_purchase_of: {
                    required: true,
                },
                free_prod_qty: {
                    required: true,
                },
            },         
            messages: {
                product_name: "The Name field is required",
                product_cat_id: "The Choose Category is field is required",
                desc: "The Description field is required",
                featured: "The Featured field is required",
                offer_availability: "The Offer Availability field is required",
                offer_type: "The Offer Type field is required",
                on_purchase_of: "The On Purchase Of field is required",
                free_prod_qty: "The Free Products Qty fiels is required",
            },
            errorPlacement: function(error, element) 
            {
                if (element.attr("name") == "featured") 
                {
                    error.appendTo(".errorCustom");
                } else if(element.attr("name") == "offer_availability"){
                    error.appendTo(".errorCustom1");
                } else if(element.attr('name') == "offer_type") {
                    error.appendTo(".errorCustom2");
                } else if(element.attr('name') == 'variant_price') {
                    error.appendTo(".errorCustom3");
                } else if(element.attr('name') == 'discount_price') {
                    error.appendTo(".errorCustom4");
                } else {
                    error.insertAfter(element);
                }
            }

        });
        $(".offer_availability").on('change', function() {
            var radio = $(".offer_availability_yes").find('input');
            $(radio).prop('checked', false);
            $(".offer_type_free").hide();
            $(".offer_type_off").hide();
            var input1 = $(".offer_type_off").find('input').val(" ");
            var input2 = $(".offer_type_free").find('input').val(" ");

            var value = $(this).val();
            if(value == 'yes') {
                $(".offer_availability_yes").show();
            } else {
                $(".offer_availability_yes").hide();
            }
        })

        $(".offer_type").on('change', function() {

            var input1 = $(".offer_type_free").find('input').val(" ");

            var value = $(this).val();
            if(value == 'off') {
                $(".offer_type_free").hide();
                $(".offer_type_off").show();
            } else {
                $(".offer_type_off").show();
                $(".offer_type_free").show();
            }
        })

        $("#variant_price").on('focusout', function() {
            var val = $(this).val();

            $("#discount_price").val(val);
        })
    </script>
@endpush