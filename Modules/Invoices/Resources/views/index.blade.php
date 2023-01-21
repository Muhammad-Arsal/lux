@extends('backend.layouts.app')

@section('title')
    Invoices List
@endsection

@section('breadcrumbs')
    <x-backend-breadcrumbs>
        <x-backend-breadcrumb-item type="active" icon='fas fa-sitemap'>Categories</x-backend-breadcrumb-item>
    </x-backend-breadcrumbs>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">

            <x-backend.section-header>
                <i class="fas fa-sitemap"></i>Invoices<small class="text-muted">List</small>

                <x-slot name="subtitle">
                    Customers Management Dashboard
                </x-slot>
                <x-slot name="toolbar">
                    <x-buttons.create route="{{ route('backend.invoices.add') }}" title="Create Invoices" />
                </x-slot>
            </x-backend.section-header>

            <div class="row" style="margin-top: 1em;">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Invoice No.</th>
                                <th>Name</th>
                                <th>Bill No.</th>
                                <th>Status</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>
                                    <a href="" class="text-success">
                                        <span class="fa fa-trash-alt"></span>
                                        <span>Edit</span>
                                    </a>
                                    <a href="#" class="text-danger modalButton" data-bs-toggle="modal" data-action=""
                                        data-bs-target="#deleteEventModal" data-toggle="tooltip" title="Delete Category">
                                        <span class="fa fa-trash-alt"></span>
                                        <span>Delete</span>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
