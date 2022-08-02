@extends('index')

@section('title')
@lang('Teacher Application Form')
@endsection

@section('breadcubs')
<x-front.breadcubs title="Teachers" :path="['Teacher Application Form']" />
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
                        <x-front.form profile="teacher" action="{{route('enseignants.update', $teacher->id)}}" :old="$teacher" method="PATCH" />
                    @else
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>@lang('New Teacher')</h3>
                            </div>
                        </div>
                        <x-front.form profile="teacher" action="{{route('enseignants.store')}}"/>
                    @endif
                    </div>
                </div>
@endsection