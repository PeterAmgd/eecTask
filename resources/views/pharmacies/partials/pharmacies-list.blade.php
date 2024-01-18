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
                    <th>{{ __('#') }}</th>
                    <th>{{ __('pharmacy.ID') }}</th>
                    <th>{{ __('pharmacy.name') }}</th>
                    <th>{{ __('pharmacy.address') }}</th>
                    <th>{{ __('pharmacy.price') }}</th>
                    <th>{{ __('pharmacy.Created_At') }}</th>
                    <th>{{ __('pharmacy.Updated_At') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pharmacies as $pharmacy)
                <tr>
                    <td>
                        <input type="checkbox" class="pharmacy-checkbox" data-pharmacy-id="{{ $pharmacy->id }}">
                    </td>
                    <td>{{$pharmacy->id}}</td>
                    <td>{{$pharmacy->name}}</td>
                    <td>{{$pharmacy->address}}</td>
                    <td>
                        <input type="number" class="form-control pharmacy-price" data-pharmacy-id="{{ $pharmacy->id }}">
                    </td>
                    <td>{{$pharmacy->created_at}}</td>
                    <td>{{$pharmacy->updated_at}}</td>

                </tr>
                @endforeach
            </tbody>
        </table>
        <button id="attachPharmaciesBtn" class="btn btn-success">{{ __('Attach Selected Pharmacies') }}</button>
        {{ $pharmacies->render() }}
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function() {
        // Handle the click event on the "Attach Selected Pharmacies" button
        $('#attachPharmaciesBtn').on('click', function() {
            // Array to store selected pharmacy IDs
            var selectedPharmacies = [];
            // Loop through all checkboxes and collect selected pharmacy IDs
            $('.pharmacy-checkbox:checked').each(function () {
                var pharmacyId = $(this).data('pharmacy-id');
                var price = $('.pharmacy-price[data-pharmacy-id="' + pharmacyId + '"]').val();
                selectedPharmacies.push({ id: pharmacyId, price: price });
            });

            var productId = {{ $product->id }};

            $.ajax({
                url: `attach-product/${productId}`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    pharmaciesWithPrices: selectedPharmacies
                },
                success: function(response) {
                    // Handle success, e.g., show a success message
                    alert("Done!");
                },
                error: function(xhr, status, error) {
                    // Handle AJAX request error
                    alert('sorry the product already exists.');
                }
            });
        });
    });
</script>


@endsection
