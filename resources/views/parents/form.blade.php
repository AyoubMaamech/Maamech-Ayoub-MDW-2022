@extends('index')

@section('title')
@lang('Parent Registration From')
@endsection

@section('breadcubs')
<x-front.breadcubs title="Parents" :path="['Parent Registration Form']" />
@endsection

@section('dashboard-content')
                <div class="card height-auto">
                    <div class="card-body">
                    @if($edit ?? false)
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>@lang('Edit Info')</h3>
                            </div>
                        </div>
                        <x-front.form profile="parent" action="{{route('parents.update', $parent->id)}}" :old="$parent" method="PATCH" />
                    @else
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>@lang('New Parent')</h3>
                            </div>
                        </div>
                        <x-front.form profile="parent" action="{{route('parents.store')}}"/>
                    @endif
                    </div>
                </div>
@endsection