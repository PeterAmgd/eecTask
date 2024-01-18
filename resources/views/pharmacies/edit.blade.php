@extends('layouts.admin')

@section('title', __('pharmacy.Edit_Pharmacy'))
@section('content-header', __('pharmacy.Edit_Pharmacy'))

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('pharmacies.update', $pharmacy) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">{{ __('pharmacy.name') }}</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name"
                    placeholder="{{ __('pharmacy.name') }}" value="{{ old('name', $pharmacy->name) }}">
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>


            <div class="form-group">
                <label for="address">{{ __('pharmacy.address') }}</label>
                <textarea name="address" class="form-control @error('address') is-invalid @enderror"
                    id="address"
                    placeholder="{{ __('pharmacy.address') }}">{{ old('address', $pharmacy->address) }}</textarea>
                @error('address')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <button class="btn btn-primary" type="submit">{{ __('common.Update') }}</button>
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
