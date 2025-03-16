@extends('layouts.app')

@section('subtitle', 'Dashboard')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Welcome to PWL_POS Dashboard')

@section('content_body')
<div class="row">
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>150</h3>
                <p>New Orders</p>
            </div>
            <div class="icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>53%</h3>
                <p>Bounce Rate</p>
            </div>
            <div class="icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-12">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>44</h3>
                <p>User Registrations</p>
            </div>
            <div class="icon">
                <i class="fas fa-user-plus"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    .small-box .icon {
        top: 10px;
    }
</style>
@endpush

@push('js')
<script>
    console.log("Welcome to the Laravel-AdminLTE Dashboard!");
</script>
@endpush
