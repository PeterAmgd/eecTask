@extends('layouts.admin')

@section('content-header', __('dashboard.title'))

@section('content')
    <div class="container-fluid">
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                  <h3>Products</h3>

              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="{{route('products.index')}}" class="small-box-footer">{{ __('common.More_info') }} <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                  <h3>Pharmacies</h3>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="{{route('pharmacies.index')}}" class="small-box-footer">{{ __('common.More_info') }} <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

    </div>
</div>
@endsection
