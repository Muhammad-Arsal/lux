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

            <?php
            $collectedData = \DB::table('orders')
                ->where('id', $id)
                ->first();
            $member_name = \DB::table('customers')
                ->where('id', $collectedData->member_id)
                ->first();
            $variants = \DB::table('order_details')
                ->where('order_id', $id)
                ->get();
            ?>
            <div class="row" style="margin-top: 1em;">
                <div class="mb-3 border border-2 p-2 mb-2">
                    <div class="row">
                        <div class="col-6">
                            <span class="fs-3">Invoice No.</span>
                            <span style="border-bottom: 1px solid black;" class="ms-2 fs-4">{{ $collectedData->id }}</span>
                        </div>
                        <div class="col-6">
                            <span class="fs-3">Name:</span>
                            <span style="border-bottom: 1px solid black;"
                                class="ms-2 fs-4">{{ $member_name->first_name . ' ' . $member_name->last_name }}</span>
                        </div>
                    </div>
                </div>
                <div class="table-responsive border border-2 p-2">
                    <table class="table table-bordered">
                        <thead class="bg-secondary">
                            <tr>
                                <th>Sr No.</th>
                                <th>Product</th>
                                <th>Size</th>
                                <th>Total Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @forelse ($variants as $item)
                                <?php
                                $variant_name = \DB::table('product_variants')
                                    ->where('id', $item->variant_id)
                                    ->first();
                                ?>
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $variant_name->name }}</td>
                                    <td><?php if ($variant_name->size) {
                                        echo $variant_name->size;
                                    } else {
                                        echo '--';
                                    } ?></td>
                                    <td>{{ $item->qty_sold }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->total }}</td>
                                </tr>
                            @empty
                            @endforelse
                            <tr>
                                <td colspan="4" class="text-end">Bill Amount</td>
                                <td class="text-center bg-secondary" colspan="2">
                                    <b>{{ $collectedData->total . "$" }}</b>
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
