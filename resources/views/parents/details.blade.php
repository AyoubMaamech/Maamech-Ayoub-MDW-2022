@extends('index')

@section('title')
    @lang('Info')
@endsection

@section('breadcubs')
<x-front.breadcubs title="Parent Info" :path="['Parent']" />
@endsection

@section('dashboard-content')
    <x-front.details profile="parent" :details="$parent" :edit="$edit ?? (auth()->user()->profile === 'admin')"/>
@endsection