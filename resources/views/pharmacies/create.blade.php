@extends('layouts.admin')

@section('title', __('pharmacy.Create_Pharmacy'))
@section('content-header', __('pharmacy.Create_Pharmacy'))

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('pharmacies.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">{{ __('pharmacy.name') }}</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name"
                    placeholder="{{ __('pharmacy.name') }}" value="{{ old('name') }}">
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>


            <div class="form-group">
                <label for="address">{{ __('pharmacy.address') }}</label>
                <textarea name="address" class="form-control @error('address') is-invalid @enderror"
                    id="address" placeholder="{{ __('pharmacy.address') }}">{{ old('address') }}</textarea>
                @error('address')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <button class="btn btn-primary" type="submit">{{ __('common.Create') }}</button>
        </form>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>
    $(document).ready(function () {
        bsCustomFileInput.init();
    });
</script>
@endsection
