@extends('backend.layouts.app')

@section('title') Edit Category @endsection

@section('breadcrumbs')
<x-backend-breadcrumbs>
    <x-backend-breadcrumb-item route='{{route("backend.product.category.index")}}' icon='fas fa-sitemap'>
        Categories
    </x-backend-breadcrumb-item>
    <x-backend-breadcrumb-item type="active">Edit</x-backend-breadcrumb-item>
</x-backend-breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-body">

        <x-backend.section-header>
            <i class="fas fa-sitemap"></i> Category <small class="text-muted">Edit</small>

            <x-slot name="subtitle">
                Categories Management Dashboard
            </x-slot>
            <x-slot name="toolbar">
                <x-backend.buttons.return-back />
                <a href="{{ route("backend.product.category.index") }}" class="btn btn-secondary ms-1" data-toggle="tooltip" title="Category List"><i class="fas fa-list-ul"></i> List</a>
            </x-slot>
        </x-backend.section-header>

        <div class="row mt-4">
            <div class="col">
                <form action="{{ route('backend.product.category.update', $category->id) }}" method="post">
                    @csrf
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-group">
                                <label>Choose Parent</label>
                                <select name="parent_id" class="form-control">
                                    <option value="">None</option>
                                    @foreach ($categories as $item)
                                        <option {{ $category->parent_id == $item->id ? 'selected' : '' }} value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name" value="{{ $category->name }}" placeholder="Name">
                            </div>
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