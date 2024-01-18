@extends('layouts.admin')

@section('title', __('product.Product_List'))
@section('content-header', __('product.Product_List'))
@section('content-actions')
    <a href="{{ route('products.create') }}" class="btn btn-primary">{{ __('product.Create_Product') }}</a>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection
@section('content')
    <div class="card product-list">
        <div class="card-body">
            <div class="mb-3">
                <label for="searchProduct" class="form-label">Search Product:</label>
                <input type="text" class="form-control" id="searchProduct" placeholder="Enter product title">
            </div>
            <table class="table" id="products-table">
                <thead>
                    <tr>
                        <th>{{ __('product.ID') }}</th>
                        <th>{{ __('product.title') }}</th>
                        <th>{{ __('product.Image') }}</th>
                        <th>{{ __('product.Description') }}</th>
                        <th>{{ __('product.Price') }}</th>
                        <th>{{ __('product.Quantity') }}</th>
                        <th>{{ __('product.Created_At') }}</th>
                        <th>{{ __('product.Updated_At') }}</th>
                        <th>{{ __('product.Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr class="product-row" data-product-id="{{ $product->id }}" style="cursor: pointer;">
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->title }}</td>
                            <td><img class="product-img" src="{{ Storage::url($product->image) }}" alt=""></td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->quantity }}</td>
                            <td>{{ $product->created_at }}</td>
                            <td>{{ $product->updated_at }}</td>
                            <td>
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-primary btn-action"><i
                                        class="fas fa-edit"></i></a>
                                @csrf
                                <button class="btn btn-danger btn-delete btn-action"
                                    data-url="{{ route('products.destroy', $product) }}"><i
                                        class="fas fa-trash"></i></button>
                                <a href="{{ route('get-pharmacies', $product) }}" class="btn btn-success btn-action"><i
                                        class="fas fa-eye"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <!-- Modal content goes here -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="productModalLabel">Product Details</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Order details content goes here -->
                        </div>
                    </div>
                </div>
            </div>

            <script>
                $(document).ready(function() {

                    // Define productId outside of the scroll event
                    var productId;

                    function showLoadingSpinner() {
                        // Show loading spinner in the product modal body
                        $('#productModal .modal-body').html(`
                            <div class="text-center">
                                <div class="spinner-border" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        `);
                    }

                    function fetchData(productId) {
                        // Make an AJAX request to fetch more data
                        $.ajax({
                            url: `show-product/${productId}`,
                            method: 'GET',
                            dataType: 'json',
                            success: function(data) {
                                // Extract product details
                                const productTitle = data.product.title;
                                const productDescription = data.product.description;

                                // Set the modal title and clear modal body content
                                $('#productModal .modal-title').text('Product Details');
                                $('#productModal .modal-body').html('');

                                // Add product details to modal body
                                $('#productModal .modal-body').html(`
                                    <div>
                                        <h2> Product Title : ${productTitle}</h2>
                                        <p> Product Title : ${productDescription}</p>
                                    </div>
                                `);

                                // Create a table for pharmacies
                                const pharmaciesTable = document.createElement('table');
                                pharmaciesTable.className = 'table table-striped';
                                pharmaciesTable.innerHTML = `
                                    <thead>
                                        <tr>
                                            <th>Pharmacy ID</th>
                                            <th>Pharmacy Name</th>
                                            <th>Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${data.product.pharmacies.map(pharmacy => `
                                            <tr>
                                                <td>${pharmacy.id}</td>
                                                <td>${pharmacy.name}</td>
                                                <td>${pharmacy.pivot.price}</td>
                                            </tr>
                                        `).join('')}
                                    </tbody>
                                `;

                                // Append the pharmacies table to the modal body
                                $('#productModal .modal-body').append(pharmaciesTable);

                                // Show the product modal
                                $('#productModal').modal('show');
                            },
                            error: function(error) {
                                console.error('Error fetching product details:', error);
                            }
                        });
                    }

                    $('#searchProduct').on('input', function() {
                        console.log('Search input changed!');
                        // Make an Ajax request
                        $.ajax({
                            url: 'search', // Replace with the actual endpoint URL
                            method: 'GET', // Choose the appropriate HTTP method (POST, GET, etc.)
                            data: { // Optional data to send to the server
                                search: $(this).val(), // Include the value of the input field
                                _token: '{{ csrf_token() }}' // Include the CSRF token for Laravel
                            },
                            dataType: 'json',
                            success: function(data) {
                                // Handle the success response
                                console.log('done', data.products.data);
                                renderProducts(data.products.data);
                            },
                            error: function(error) {
                                // Handle the error response
                                console.error('Error:', error);
                            }
                        });
                    });

                    function renderProducts(products) {
                        // Clear the existing products table body
                        $('table tbody').empty();

                        // Append the updated products to the table
                        $.each(products, function(index, product) {
                            $('table tbody').append(`
                                <tr class="product-row" data-product-id="${product.id}" style="cursor: pointer;">
                                    <td>${product.id}</td>
                                    <td>${product.title}</td>
                                    <td><img class="product-img" src="/storage/${product.image}" alt=""></td>
                                    <td>${product.description}</td>
                                    <td>${product.price}</td>
                                    <td>${product.quantity}</td>
                                    <td>${product.created_at}</td>
                                    <td>${product.updated_at}</td>
                                    <td>
                                        <a href="/admin/products/${product.id}/edit" class="btn btn-primary btn-action"><i class="fas fa-edit"></i></a>
                                        @csrf
                                        <button class="btn btn-danger btn-delete btn-action" data-url="/admin/products/${product.id}/delete"><i class="fas fa-trash"></i></button>
                                        <a href="/admin/get-pharmacies/${product.id}" class="btn btn-success btn-action"><i class="fas fa-eye"></i></a>
                                    </td>
                                </tr>
                            `);
                        });
                    }


                    $(document).on('click', '.product-row', function() {
                        console.log('Product row clicked!');
                        productId = $(this).attr('data-product-id');
                        showLoadingSpinner();
                        fetchData(productId);
});
                });
            </script>

            {{ $products->render() }}
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', '.btn-delete', function() {
                var $this = $(this);

                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                });

                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: 'You will not be able to recover this product!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.value) {
                        // Make an AJAX request to delete the product
                        $.ajax({
                            url: $this.data(
                                'url'
                            ), // Assuming data-url attribute contains the delete URL
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}', // Include CSRF token for Laravel
                                // You can include other data if required
                            },
                            success: function(response) {
                                // Handle success, e.g., remove the deleted row from the table
                                $this.closest('tr').fadeOut(500, function() {
                                    $(this).remove();
                                });

                                swalWithBootstrapButtons.fire(
                                    'Deleted!',
                                    'The product has been deleted.',
                                    'success'
                                );
                            },
                            error: function(xhr, status, error) {
                                // Handle AJAX request error
                                console.error(xhr.responseText);
                                swalWithBootstrapButtons.fire(
                                    'Error!',
                                    'An error occurred while deleting the product.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>

@endsection
