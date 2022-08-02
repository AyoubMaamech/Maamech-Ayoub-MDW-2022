@extends('index')

@section('title')
@lang('Map')
@endsection

@section('breadcubs')
                <div class="breadcrumbs-area">
                    <h3>@lang('School Position')</h3>
                    <ul>
                        <li>
                            <a href="{{ route('home') }}">@lang('Home')</a>
                        </li>
                        <li>@lang('Map')</li>
                    </ul>
                </div>
@endsection


@section('dashboard-content')
                <!-- Google Map Area Start Here -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card google-map-area">
                            <div class="card-body">
                                <div class="heading-layout1">
                                    <div class="item-title">
                                        <h3>@lang('Map')</h3>
                                    </div>
                                </div>
                                <div class="default-map">
                                    <div id="markergoogleMap" style="width:100%; height:660px; border-radius: 4px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Google Map Area End Here -->
@endsection

@section('scripts')
    <!-- Google Map js -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtmXSwv4YmAKtcZyyad9W7D4AC08z0Rb4"></script>
    <!-- Map Init js -->
    <script src="js/google-marker-map.js"></script>
@endsection