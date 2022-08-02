@extends('index')

@section('title')
    @lang('Info')
@endsection

@section('breadcubs')
<x-front.breadcubs title="Student Info" :path="['Student']" />

@endsection

@section('dashboard-content')
    <x-front.details profile="student" :details="$student" :edit="$edit ?? (auth()->user()->profile === 'admin')"/>
@endsection