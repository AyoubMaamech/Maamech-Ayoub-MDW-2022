@extends('index')

@section('title')
    @lang('Info')
@endsection

@section('breadcubs')
<x-front.breadcubs title="Teacher Info" :path="['Teacher']" />

@endsection

@section('dashboard-content')
    <x-front.details profile="teacher" :details="$teacher" :edit="$edit ?? (auth()->user()->profile === 'admin')"/>
@endsection