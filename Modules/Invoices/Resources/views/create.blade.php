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
                <i class="fas fa-sitemap"></i>Create<small class="text-muted"> Invoices</small>

                <x-slot name="subtitle">
                    Customers Management Dashboard
                </x-slot>
                {{-- <x-slot name="toolbar">
                    <x-buttons.create route="{{ route('backend.invoices.add') }}" title="Create Invoices" />
                </x-slot> --}}
            </x-backend.section-header>

            <div class="container mt-1">
                <div class="row border border-1  p-2">
                    <div class="col-6">
                        <p class="text-end m-2">Customers:</p>
                    </div>
                    <div class="col-6 m-0">
                        <select class="form-select form-control" name="" id="">
                            <option selected>Select one</option>
                            @php
                                $all = \DB::table('customers')->get();
                            @endphp
                            @forelse ($all as $item)
                                <option value="{{ $item->id }}">{{ $item->first_name . ' ' . $item->last_name }}
                                </option>
                            @empty
                            @endforelse
                        </select>
                    </div>
                </div>
            </div>
            <div class="container border border-1 mt-1">
                <div class="row  p-2">
                    <div class="col-3">
                        <p class="text-end m-2">Products:</p>
                    </div>
                    <div class="col-7">
                        <input class="form-control rounded-0 product"type="text" name="product" value=""
                            id="autoComplete">
                    </div>
                    <div class="col-2">
                        <button class="btn btn-primary add">Add</button>
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col-3">
                        <p class="text-end m-2">New:</p>
                    </div>
                    <div class="col-3">
                        <input class="rounded-0 form-control name" type="text" name="name" id=""
                            placeholder="Name">
                    </div>
                    <div class="col-3">
                        <input class="form-control rounded-0 price" type="text" name="price" id=""
                            placeholder="Price">
                    </div>
                    <div class="col-3">
                        <button class="btn btn-primary newAddition">Add New</button>
                    </div>
                </div>
            </div>
            <div class="container mt-1 border border-1">
                <div class="table-responsive mt-2">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="table-dark">#</th>
                                <th class="table-dark">Product Name</th>
                                <th class="table-dark">Size</th>
                                <th class="table-dark">Price</th>
                                <th class="table-dark">Quantity</th>
                            </tr>
                        </thead>
                        <tbody class="show">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="container mt-2 border-top partition" style="display: none;">
                <div class="form-check mb-2 mt-1">
                    <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                        Paid
                    </label>
                </div>
                <button class="btn btn-primary">Save Invoice</button>
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

@push('before-styles')
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/css/autoComplete.02.min.css">
@endpush

@push('after-scripts')
    <script src="https://cdn.jsdelivr.net/npm/@tarekraafat/autocomplete.js@10.2.7/dist/autoComplete.min.js"></script>
    <script type="text/javascript">
        var searchedData = [];
        $(document).ready(function() {
            var counting = 1;
            var route;

            //Add button function
            $('.add').on('click', function() {
                var current = $(this);
                var current_value = $(this).parent().parent().find('.product').val();

                var route = "{{ route('backend.invoices.fetch', ['id' => 'replace']) }}";
                route = route.replace('replace', current_value);

                $.ajax({
                    type: "get",
                    url: route,
                    success: function(response) {
                        var all = response.relativeProducts;
                        $(all).each(function(index, element) {
                            var size = '--';
                            if (element.size != null) {
                                size = element.size;
                            }
                            $('.show').append(
                                "<tr><td>" + counting++ +
                                "</td><td>" + element.name + "</td>   <td>" +
                                size +
                                "</td><td>$<input type='text' name='price' value=" +
                                element.price +
                                "></td><td><input type='text' name='qty_v' value='' /></td></tr>"
                            );
                        });
                        $('.partition').css('display', 'block');
                    }
                });
            });


            //Quick form addition
            $(".newAddition").click(function(e) {
                e.preventDefault();
                var name = $(this).parent().parent().find('.name').val();
                var price = $(this).parent().parent().find('.price').val();

                $('.show').append(
                    "<tr><td>" + counting++ +
                    "</td><td>" + name + "</td>   <td>" +
                    "--" +
                    "</td><td>$<input type='text' name='price' value=" +
                    price +
                    "></td><td><input type='text' name='qty_v' value='' /></td></tr>"
                );
                $('.partition').css('display', 'block');
            });

            // //input field entry search
            // $(".product").keyup(function(e) {
            //     e.preventDefault();
            //     console.log(searchedData);
            //     searchedData = [];
            //     var current_value = $(this).val();

            //     var route = "{{ route('backend.invoices.search', ['current' => 'replace']) }}";
            //     route = route.replace('replace', current_value);

            //     $.ajax({
            //         type: "get",
            //         url: route,
            //         success: function(response) {
            //             var collected = response.searchedProducts;
            //             $(collected).each(function(index, element) {
            //                 searchedData.push(element.name);

            //             });
            //         }
            //     });
            // });
            // console.log(searchedData);

        });


        $(".product").keyup(function(e) {
            var current_value = $(this).val();
            route = "{{ route('backend.invoices.search', ['current' => 'replace']) }}";
            route = route.replace('replace', current_value);
        });
        const autoCompleteJS = new autoComplete({
            name: "autoComplete",
            placeHolder: "Search for Product...",
            data: {
                src: async (query) => {
                    try {
                        // Fetch Data from external Source
                        const source = await fetch(route);
                        // Data should be an array of `Objects` or `Strings`
                        const data = await source.json();

                        return data;
                    } catch (error) {
                        return error;
                    }
                },
                // Data source 'Object' key to be searched
                keys: ["name"],
            },
            resultItem: {
                highlight: true,
            },
        });
    </script>
@endpush
