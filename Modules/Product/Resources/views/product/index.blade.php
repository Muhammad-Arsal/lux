@extends('backend.layouts.app')

@section('title') List Products @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item type="active" icon='fas fa-sitemap'>Categories</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-body">

        <x-backend.section-header>
            <i class="fas fa-sitemap"></i> Products <small class="text-muted">List</small>

            <x-slot name="subtitle">
                Products Management Dashboard
            </x-slot>
            <x-slot name="toolbar">
                <a href="{{ route('backend.product.preview') }}" class="btn btn-warning" >Print Preview</a>
                <x-buttons.create route="{{ route('backend.product.create') }}" title="Create Product" />
            </x-slot>
        </x-backend.section-header>

        <div class="row" style="margin-top: 1em;">
            @foreach ($products as $item)
            @php
                $parent_category = ""; 
                $category = \DB::table('product_categories')->where('id', $item->cat_id)->first();
                if($category->parent_id != 0) {
                    $parent_category = \DB::table('product_categories')->where('id', $category->parent_id)->pluck('name');
                }
            @endphp
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-9">
                                    <div class="row">
                                        <div class="col-5 col-md-5 col-lg-3">
                                            <img src="{{ asset('uploads/product/'.$item->picture) }}" class="img-fluid w-100" alt="">
                                        </div>
                                        <div class="col-7 col-md-7 col-lg-9 ps-0">
                                            <div class="fw-bold" >{{ $item->name }}</div>
                                            <div class="text-primary">{{ $parent_category ? $parent_category[0] ." > ". $category->name : $category->name }}</div>
                                            <div>{{ $item->description }}</div>
                                            <div>Offer: <span style="color: {{ $item->offer == 'yes' ? 'green' : 'gray' }};">{{ $item->offer == 'yes' ? "Offer Available" : "No Offer Available" }}</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3 border-start d-flex align-items-center">
                                    <div class="col-6 mx-auto">
                                    <div class="">
            
                                        <a href="{{ route('backend.product.addVariant', $item->id) }}" class="">
                                            <span class="fa fa-add" ></span>
                                            <span>Add Variant</span>
                                        </a>
                                    </div>
                                    <div class="">
            
                                        <a href="{{ route('backend.product.edit', $item->id) }}" class="text-success">
                                            <span class="fa fa-pen" ></span>
                                            <span>Edit Product</span>
                                        </a>
                                    </div>
                                    <div class="">
                                        <a href="" class="text-danger">
                                            <span class="fa fa-trash" ></span>
                                            <span>Delete</span>
                                        </a>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php $variant = \DB::table("product_variants")->where('parent_id', $item->id)->get(); @endphp
                        @foreach ($variant as $item1)
                            <div class="col-10 col-lg-8 mx-auto mt-4">
                                <div class="row">
                                    <div class="col-10">
                                        <div class="row">
                                            <div class="col-3">
                                                <img src="{{ asset('uploads/product/'.$item1->picture) }}" class="img-fluid w-100" alt="">
                                            </div>
                                            <div class="col-9 p-0" style="font-size: 12px; line-height: 1.2;">
                                                <div class="fw-bold" >{{ $item1->name }}</div>
                                                <div>{{ $item1->description }}</div>
                                                <div>Size: </div>
                                                <div>Price: ${{ $item1->price }}</div>
                                                <div>Discount Price: ${{ $item1->discount_price }}</div>
                                                <div>Offer: <span style="color: {{ $item->offer == 'yes' ? 'green' : 'gray' }};">@php if($item->offer == 'no') { echo "No Offer Available"; } else { if($item->offer_type == 'free') { echo "Buy ". $item->on_purchase. " Get " .$item->free_qty. " Free"; } else { echo "Buy " .$item->on_purchase. " Get " .$item1->discount_percentage. "% OFF"; } } @endphp</span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2 border-start d-flex align-items-center">
                                        <div class="col-10 mx-auto" >
                                        <div>
                                            <a href="{{ route('backend.product.editVariant', ['product_id' => $item->id, 'id' => $item1->id]) }}" >
                                                <span class="fa fa-pen-alt"></span>
                                                <span>Edit</span>
                                            </a>
                                        </div>
                                        <div>
                                            <a href="" class="text-danger">
                                                <span class="fa fa-trash-alt"></span>
                                                <span>Delete</span>
                                            </a>
                                        </div>
                                    </div>
                                        
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

    </div>
    <div class="card-footer">
        
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="deleteEventModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form name="deleteForm" action="" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure? You want to delete this category
                </div>
                <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" value="Submit">
                </div>
            </div>
        </form>
    </div>
</div>
@endsection