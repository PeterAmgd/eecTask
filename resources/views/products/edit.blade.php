@extends('layouts.admin')

@section('title', __('product.Edit_Product'))
@section('content-header', __('product.Edit_Product'))

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">{{ __('product.title') }}</label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title"
                    placeholder="{{ __('product.title') }}" value="{{ old('title', $product->title) }}">
                @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>


            <div class="form-group">
                <label for="description">{{ __('product.Description') }}</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                    id="description"
                    placeholder="{{ __('product.Description') }}">{{ old('description', $product->description) }}</textarea>
                @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="image">{{ __('product.Image') }}</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="image" id="image">
                    <label class="custom-file-label" for="image">{{ __('product.Choose_file') }}</label>
                </div>
                @error('image')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>


            <div class="form-group">
                <label for="price">{{ __('product.Price') }}</label>
                <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" id="price"
                    placeholder="{{ __('product.Price') }}" value="{{ old('price', $product->price) }}">
                @error('price')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="quantity">{{ __('product.Quantity') }}</label>
                <input type="text" name="quantity" class="form-control @error('quantity') is-invalid @enderror"
                    id="quantity" placeholder="{{ __('product.Quantity') }}" value="{{ old('quantity', $product->quantity) }}">
                @error('quantity')
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
