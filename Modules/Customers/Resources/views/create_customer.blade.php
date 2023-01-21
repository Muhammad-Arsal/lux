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
        <x-backend-breadcrumb-item route='' icon='fas fa-sitemap'>
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
                    <form action="{{ route('backend.customer.store') }}" method="post" id="customerForm"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row mbb-3">
                            <div class="col">
                                <div class="form-group">
                                    <h4><u>Add Customers</u></h4>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-group">
                                    <label>First name</label>
                                    <input type="text" class="form-control" value="" name="first_name"
                                        id="first_name" placeholder="First Name">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" value="" name="last_name"
                                        id="last_name" placeholder="Last Name">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" class="form-control" value="" name="email" id="email"
                                        placeholder="Email">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" class="form-control" value="" name="phone" id="phone"
                                        placeholder="Phone">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-group">
                                    <label>Fax</label>
                                    <input type="text" class="form-control" value="" name="fax" id="fax"
                                        placeholder="Fax">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-group">
                                    <label>Company</label>
                                    <input type="text" class="form-control" value="" name="company" id="company"
                                        placeholder="Company">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control" value="" name="address" id="address"
                                        placeholder="Address">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-group">
                                    <label>City</label>
                                    <input type="text" class="form-control" value="" name="city" id="city"
                                        placeholder="City">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-group">
                                    <label>State</label>
                                    <input type="text" class="form-control" value="" name="state" id="state"
                                        placeholder="State">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="form-group">
                                    <label>Zip</label>
                                    <input type="text" class="form-control" value="" name="zip"
                                        id="zip" placeholder="Zip">
                                </div>
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
        var validate = $('#customerForm').validate({
            rules: {
                first_name: {
                    required: true,
                },
                last_name: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true,
                },
                phone: {
                    required: true,
                },
                company: {
                    required: true,
                },
                fax: {
                    required: true,
                },
                address: {
                    required: true,
                },
                city: {
                    required: true,
                },
                state: {
                    required: true,
                },
                zip: {
                    required: true,
                },
            },
            messages: {
                first_name: "The Name field is required",
                last_name: "The Name field is required",
                email: {
                    required: "Valid email is required",
                    email: "Valid email id is required"
                },
                phone: "Phone number is required",
                company: "Company name is required",
                fax: "Fax id is required",
                address: "Address is required",
                city: "City name is required",
                state: "State name is required",
                zip: "Zip code is required",
            },
        })
    </script>
@endpush
