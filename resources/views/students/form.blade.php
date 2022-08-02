@extends('index')

@section('title')
@lang('Student Admission From')
@endsection

@section('breadcubs')
<x-front.breadcubs title="Students" :path="['Student Admission Form']" />
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
                        <x-front.form profile="student" action="{{route('etudiants.update', $student->id)}}" :classes="$classes" :old="$student" method="PATCH" />
                    @else
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>@lang('New Student')</h3>
                            </div>
                        </div>
                        <x-front.form profile="student" action="{{route('etudiants.store')}}" :filieres="$filieres" :classes="$classes"/>
                    @endif
                    </div>
                </div>
@endsection