@extends('layouts.admin')

@section('title', __('pharmacy.Pharmacy_List'))
@section('content-header', __('pharmacy.Pharmacy_List'))
@section('content-actions')
<a href="{{route('pharmacies.create')}}" class="btn btn-primary">{{ __('pharmacy.Create_pharmacy') }}</a>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}">
@endsection
@section('content')
<div class="card pharmacy-list">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('pharmacy.ID') }}</th>
                    <th>{{ __('pharmacy.name') }}</th>
                    <th>{{ __('pharmacy.address') }}</th>
                    <th>{{ __('pharmacy.Created_At') }}</th>
                    <th>{{ __('pharmacy.Updated_At') }}</th>
                    <th>{{ __('pharmacy.Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pharmacies as $pharmacy)
                <tr>
                    <td>{{$pharmacy->id}}</td>
                    <td>{{$pharmacy->name}}</td>
                    <td>{{$pharmacy->address}}</td>
                    <td>{{$pharmacy->created_at}}</td>
                    <td>{{$pharmacy->updated_at}}</td>
                    <td>
                        <a href="{{ route('pharmacies.edit', $pharmacy) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                        @csrf
                        <button class="btn btn-danger btn-delete" data-url="{{route('pharmacies.destroy', $pharmacy)}}"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $pharmacies->render() }}
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
                        url: $this.data('url'), // Assuming data-url attribute contains the delete URL
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
