@extends('backend.layouts.app')

@section('title')
    Create Product
@endsection

@push('after-styles')
    <style>
        label.error,
        label.errorCustom,
        label.errorCustom1,
        label.errorCustom2 {
            color: red;
            font-weight: lighter !important;
            display: block;
        }

        .price {
            margin-right: 5em;
        }

        .d_price {
            margin-right: 0.8em;
        }
    </style>
@endpush

@section('breadcrumbs')
    <x-backend-breadcrumbs>
        <x-backend-breadcrumb-item route='{{ route('backend.product.index') }}' icon='fas fa-sitemap'>
            Products
        </x-backend-breadcrumb-item>
        <x-backend-breadcrumb-item type="active">Create</x-backend-breadcrumb-item>
    </x-backend-breadcrumbs>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">

            <x-backend.section-header>
                <i class="fas fa-sitemap"></i> Product <small class="text-muted">Create</small>

                <x-slot name="subtitle">
                    Products Management Dashboard
                </x-slot>
                <x-slot name="toolbar">
                    <x-backend.buttons.return-back />
                    <a href="{{ route('backend.product.index') }}" class="btn btn-secondary ms-1" data-toggle="tooltip"
                        title="Products List"><i class="fas fa-list-ul"></i> List</a>
                </x-slot>
            </x-backend.section-header>

            <div class="row mt-4">
                <div class="col">
                    <form action="{{ route('backend.product.store') }}" method="post" id="productForm"
                        enctype="multipart/form-data">
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
                                    <input type="text" class="form-control" value="{{ old('product_name') }}"
                                        name="product_name" id="product_name" placeholder="Name">
                                </div>
                                @error('product_name')
                                    <label id="product_name-error" class="error" for="product_name">{{ $message }}</label>
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
                                            @php
                                                $childCat = \DB::table('product_categories')
                                                    ->where('parent_id', $item->id)
                                                    ->get();
                                            @endphp
                                            <optgroup label="{{ $item->name }}">
                                                @foreach ($childCat as $item1)
                                                    <option value="{{ $item1->id }}">{{ $item1->name }}</option>
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
                                    <textarea class="form-control" id="desc" name="desc" rows="3">{{ old('desc') }}</textarea>
                                </div>
                                @error('desc')
                                    <label id="desc-error" class="error" for="desc">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-group">
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
                                        <input class="form-check-input" type="radio" name="featured" id="featured"
                                            value="yes">
                                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="featured" id="featured"
                                            value="no">
                                        <label class="form-check-label" for="inlineRadio2">No</label>
                                    </div>
                                    <span class="errorCustom"></span>
                                    @error('featured')
                                        <label id="featured-error" class="error" for="featured">{{ $message }}</label>
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
                                        <input class="form-check-input offer_availability" type="radio"
                                            name="offer_availability" value="yes">
                                        <label class="form-check-label" for="inlineRadio1">Yes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input offer_availability" type="radio"
                                            name="offer_availability" value="no">
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

                        <div class="row mb-3 offer_availability_yes" style="display: none">
                            <div class="col">
                                <div class="form-group">
                                    <div>
                                        <label>Offer Type</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input offer_type" type="radio" name="offer_type"
                                            value="free">
                                        <label class="form-check-label" for="inlineRadio1">Free</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input offer_type" type="radio" name="offer_type"
                                            value="off">
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

                        <div class="row mb-3 offer_type_off" style="display: none;">
                            <div class="col">
                                <div class="form-group">
                                    <label>On Purchase Of:</label>
                                    <input type="text" name="on_purchase_of" id="on_purchase_of" size="3">(pcs)
                                </div>
                                @error('on_purchase_of')
                                    <label id="on_purchase_of-error" class="error"
                                        for="on_purchase_of">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 offer_type_free" style="display: none">
                            <div class="col">
                                <div class="form-group">
                                    <label>Free Products Qty:</label>
                                    <input type="text" name="free_prod_qty" id="free_prod_qty" size="3">(pcs)
                                </div>
                                @error('free_prod_qty')
                                    <label id="free_prod_qty-error" class="error"
                                        for="free_prod_qty">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3 mt-2">
                            <div class="col">
                                <div class="form-group">
                                    <h4>Add Variant 1</h4>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-group">
                                    <label>Variant Name</label>
                                    <input type="text" class="form-control" value="{{ old('variant_name') }}"
                                        name="variant_name" id="variant_name" placeholder="Name">
                                </div>
                                @error('variant_name')
                                    <label id="variant_name-error" class="error"
                                        for="variant_name">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1" class="form-label">Short Description</label>
                                    <textarea class="form-control" id="variant_description" name="variant_description" rows="3">{{ old('variant_description') }}</textarea>
                                </div>
                                @error('variant_description')
                                    <label id="variant_description-error" class="error"
                                        for="variant_description">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-group">
                                    <label class="price">Price:</label>
                                    <input type="text" name="variant_price" value="{{ old('variant_price') }}"
                                        id="variant_price" size="5">$
                                    <span class="errorCustom3"></span>
                                </div>
                                @error('variant_price')
                                    <label id="variant_price-error" class="error"
                                        for="variant_price">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-group">
                                    <label class="d_price">Discount Price:</label>
                                    <input type="text" name="discount_price" value="{{ old('discount_price') }}"
                                        id="discount_price" size="5">$
                                    <span class="errorCustom4"></span>
                                </div>
                                @error('discount_price')
                                    <label id="discount_price-error" class="error"
                                        for="discount_price">{{ $message }}</label>
                                @enderror

                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-group">
                                    <label>Picture</label>
                                    <input type="file" name="variant_picture" class="form-control" id="name_picture">
                                </div>
                                @error('variant_picture')
                                    <label id="variant_picture-error" class="error"
                                        for="variant_picture">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    {{ html()->button($text = "<i class='fas fa-plus-circle'></i> Create", $type = 'submit')->class('btn btn-success') }}
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="float-end">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-warning" onclick="history.back(-1)"><i
                                                class="fas fa-reply"></i> Cancel</button>
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
                product_picture: {
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
                variant_name: {
                    required: true,
                },
                variant_description: {
                    required: true,
                },
                variant_price: {
                    required: true,
                    number: true,
                },
                discount_price: {
                    required: true,
                    number: true,
                },
                variant_picture: {
                    required: true,
                }
            },
            messages: {
                product_name: "The Name field is required",
                product_cat_id: "The Choose Category is field is required",
                desc: "The Description field is required",
                product_picture: "The Picture field is required",
                featured: "The Featured field is required",
                offer_availability: "The Offer Availability field is required",
                offer_type: "The Offer Type field is required",
                on_purchase_of: "The On Purchase Of field is required",
                free_prod_qty: "The Free Products Qty fiels is required",
                variant_name: "The Variant Name field is required",
                variant_description: "The Variant Description is field is required",
                variant_price: {
                    required: "The Price field is required",
                    number: "The Price field must be in number"
                },
                discount_price: {
                    required: "The Discount Price field is required",
                    number: "The Discount Price must be in number",
                },
                variant_picture: "The Variant Picture field is required",
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "featured") {
                    error.appendTo(".errorCustom");
                } else if (element.attr("name") == "offer_availability") {
                    error.appendTo(".errorCustom1");
                } else if (element.attr('name') == "offer_type") {
                    error.appendTo(".errorCustom2");
                } else if (element.attr('name') == 'variant_price') {
                    error.appendTo(".errorCustom3");
                } else if (element.attr('name') == 'discount_price') {
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
            if (value == 'yes') {
                $(".offer_availability_yes").show();
            } else {
                $(".offer_availability_yes").hide();
            }
        })

        $(".offer_type").on('change', function() {

            var input1 = $(".offer_type_free").find('input').val(" ");

            var value = $(this).val();
            if (value == 'off') {
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
