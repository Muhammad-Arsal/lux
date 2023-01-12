@extends('backend.layouts.app')

@section('title') List Categories @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item type="active" icon='fas fa-sitemap'>Categories</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-body">

        <x-backend.section-header>
            <i class="fas fa-sitemap"></i> Categories <small class="text-muted">List</small>

            <x-slot name="subtitle">
                Categories Management Dashboard
            </x-slot>
            <x-slot name="toolbar">
                <x-buttons.create route="{{ route('backend.product.category.create') }}" title="Create Category" />
            </x-slot>
        </x-backend.section-header>

        <div class="table-responsive" style="margin-top: 1em;">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th>Parent Category</th>
                  <th>Created on</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @php $i = 1; @endphp
                @foreach ($categories as $item)
                    @php $parent_category =  \DB::table('product_categories')->where('id', $item->parent_id)->first(); @endphp
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $parent_category ? $parent_category->name : "--" }}</td>
                        <td>{{ date('d-m-Y h:i:a', strtotime($item->created_at)) }}</td>
                        <td class="text-center">
                            <a href='{{ route('backend.product.category.edit', $item->id) }}' class='btn btn-sm btn-primary mt-1' data-toggle="tooltip" title="Edit Category"><i class="fas fa-wrench"></i></a>
                            <button class='btn btn-sm btn-danger mt-1 modalButton' data-bs-toggle="modal" data-action="{{ route('backend.product.category.delete', $item->id) }}" data-bs-target="#deleteEventModal" data-toggle="tooltip" title="Delete Category"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    @php $i++; @endphp
                @endforeach
              </tbody>
            </table>
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