@extends('backend.layouts.app')

@section('title') Edit Product Variant @endsection

@push('after-styles')
    <style>
        label.error, label.errorCustom, label.errorCustom1, label.errorCustom2 {
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

        .size {
            margin-right: 5.4em;
        }
    </style>
@endpush

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item route='{{route("backend.product.index")}}' icon='fas fa-sitemap'>
        Products Variant
    </x-backend-breadcrumb-item>
    <x-backend-breadcrumb-item type="active">Edit</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-body">

        <x-backend.section-header>
            <i class="fas fa-sitemap"></i> Product Variant <small class="text-muted">Edit</small>

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
                <form action="{{ route('backend.product.updateVariant', ['product_id' => $product_id, 'id' => $product->id]) }}" method="post" id="productForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row mbb-3">
                        <div class="col">
                            <div class="form-group">
                                <h4>Product</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3 mt-2">
                        <div class="col">
                            <div class="form-group">
                                <h4>Edit Variant</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-group">
                                <label>Variant Name</label>
                                <input type="text" class="form-control" value="{{ old('variant_name') ? old('variant_name') : $product->name }}" name="variant_name" id="variant_name" placeholder="Name">
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
                                <textarea class="form-control" id="variant_description" name="variant_description" rows="3">{{ old('variant_description') ? old('variant_description') : $product->description }}</textarea>
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
                                <input type="text" name="variant_price" value="{{ old('variant_price') ? old('variant_price') : $product->price }}" id="variant_price" size="5">$
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
                                <input type="text" name="discount_price" value="{{ old('discount_price') ? old('discount_price') : $product->discount_price }}" id="discount_price"  size="5">$
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
                                <label class="size">Size:</label>
                                <input type="text" name="size" value="{{ old('size') }}" id="size"  size="5">
                            </div>

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

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-group">
                                <div class="picture">
                                    <img src="{{ asset('uploads/product/'.$product->picture) }}" style="width: 150px;">
                                </div>
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
                featured: {
                    required: true,
                },
            },         
            messages: {
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
                featured: "The Featured field is required",
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