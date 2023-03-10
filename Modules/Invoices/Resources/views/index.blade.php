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
                            <?php
                            $collected_data = \DB::table('orders')
                                ->where([
                                    'order_type' => 'invoice',
                                    'status' => 'confirm',
                                ])
                                ->get();
                            ?>
                            @forelse ($collected_data as $item)
                                <?php
                                $member_name = \DB::table('customers')
                                    ->where('id', $item->member_id)
                                    ->first();
                                ?>
                                <tr>
                                    <td>{{ date('m-d-Y', $item->time) }}</td>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $member_name->first_name . ' ' . $member_name->last_name }}</td>
                                    <td>{{ $item->bill }}</td>
                                    <td><?php if ($item->paid == 'no') {
                                        echo 'Unpaid';
                                    } else {
                                        echo 'paid';
                                    } ?></td>
                                    <td>
                                        <a href=""><u>Cancel</u></a>
                                        <a href=""><u>Complete</u></a>
                                        <a href="{{ route('backend.invoice.details', $item->id) }}"> <u>Details</u></a>
                                        <a href=""><u>Paid</u></a>
                                    </td>
                                </tr>
                            @empty
                            @endforelse

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
