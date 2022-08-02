@extends('index')

@section('title')
@lang('Attendence')
@endsection

@section('breadcubs')
@php
 $breadcubs_path = [route('presences.index', 'all') => 'Attendence'];
 if (isset($annee)) $breadcubs_path += [route('presences.index', $annee) => $annee];/*
 if (isset($niveau)) $breadcubs_path += [route('presences.index', [$annee, $niveau]) => $niveau];
 if (isset($filiere)) $breadcubs_path += [route('presences.index', [$annee, $niveau, $filiere->id]) => $filiere->nom];*/
 if (isset($classe)) $breadcubs_path += [route('presences.index', [$annee, /*$niveau, $filiere->id, */$classe->id]) => $classe->nom];

 if (!isset($presences)) $presences = [];

@endphp
<x-front.breadcubs title="Attendence" :path="$breadcubs_path" />
@endsection
@section('dashboard-content')
@if (!isset($classe))
<x-alert 
    type='success'
    :title="__('Attendence will be loaded after selecting a class!')">
</x-alert>
        <div class="row gutters-20">
            <div class=" col-12">
                <div class="card dashboard-card-ten">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>@lang('Select Class')</h3>
                            </div>
                        </div>
                        <form class="mg-b-20" action="{{route('presences.index.filter')}}" method="POST" >
                            @csrf
                            <div class="row gutters-8">
                                <x-front.form-input  label="Year *" type="select" name="annee" :usekeys="false" :options="$annees ?? [$annee]" :required="true"/>
@isset($annee)  {{--            <x-front.form-input  label="Level *" type="select" name="niveau" :usekeys="false" :options="$niveaux ?? [$niveau]" :required="true"/> @endisset
@isset($niveau)                 <x-front.form-input  label="Course *" type="select" name="filiere" :options="getIDNomArray($filieres ?? [$filiere])" :required="true"/> @endisset
@isset($filiere)--}}            <x-front.form-input  span="half" label="Class *" type="select" name="classe" :options="getIDAffichageArray($classes ?? [$classe])" :required="true"/> @endisset

                                <div class=" col-xl-3 col-lg-3 col-12 form-group mg-t-30">
                                    <button type="submit" class="fw-btn-fill btn-gradient-yellow">@lang('SEARCH')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- Student Table Area End Here -->
            </div>
@else 
<div class="row gutters-20">
    @if(session('ok'))
    <div class="col-lg-12 col-xl-12 col-12 col-12-xxxl">
        <x-alert 
            type='success'
            title="{!! session('ok') !!}">
        </x-alert>
    </div>
    @endif


@if (auth()->user()->profile === 'admin' || auth()->user()->profile === 'teacher')
<div class="col-lg-4">
<a href="{{route('presences.create', $classe->id)}}">
    <div class="dashboard-summery-one btn-gradient-yellow">
        <div class="row">
            <div class="col-6">
                <div class="item-icon bg-light-yellow">
                    <i class="flaticon-shopping-list text-orange"></i>
                </div>
            </div>
            <div class="col-6">
                <div class="item-content">
                    <div class="item-number text-white">@lang('Mark Attendence')</div>
                </div>
            </div>
        </div>
    </div>
</a>
</div>
@endif

            

            <div class="col-12-xxxl col-lg-12 col-12">
            @if (count($presences) == 0)
            <x-alert 
                type='warning'
                :title="__('No Attendence Found')"
                icon="exclamation">
            </x-alert>
            @endif
            </div>

            <div class=" col-12">
                <div class="card dashboard-card-ten">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>@lang('Attendence')</h3>
                            </div>
                        </div>

                        <div class="mg-t-20 pd-b-30"></div>

                        <div class="table-responsive">
                            <table class="table display data-table text-nowrap">
                                <thead>
                                    <tr>
                                        <th>@lang('Subject')</th>
                                        <th>@lang('Date')</th>
                                        <th>@lang('Present')</th>
                                        <th>@lang('Absent')</th>
                                    @if(auth()->user()->profile === 'admin' || auth()->user()->profile === 'teacher')
                                        <th class="text-center" colspan="2">@lang('Action')</th>
                                    @endif
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($presences as $presence)
                                    <tr>
                                        <td>{{ $presence['matiere'] }}</td>
                                        <td>{{ $presence['date'] }}</td>
                                        <td>{{ $presence['present'] }}</td>
                                        <td>{{ $presence['absent'] }}</td>
                                    @if(auth()->user()->profile === 'admin' || auth()->user()->profile === 'teacher')
                                        <td class="text-center"><a class="text-warning" href="{{route('presences.edit', $presence['ids'])}}"><i class="fas fa-pen"></i></a></td>
                                        <td class="text-center"><a class="text-danger" href="javascript:;" onclick="$('#delete_dialog .modal-body').html('@lang('Are you sure you want to delete this Attendence ?')'); $('#modal-submit').attr('formaction', '{{route('presences.destroy', $presence['ids'])}}');" data-toggle="modal" data-target="#delete_dialog"><i class="fas fa-trash"></i></a></td>
                                    @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Student Table Area End Here -->
            </div>
        </div>
@endif
<!-- Modal -->
<div class="modal fade" id="delete_dialog" tabindex="-1" role="dialog" aria-labelledby="deleteDialog" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">@lang('Delete')</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn-fill-lg bg-blue-dark btn-hover-yellow"  data-dismiss="modal">@lang('Cancel')</button>
        <form method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" id="modal-submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">@lang('Delete')</button>
        </form>
    </div>
    </div>
</div>
</div>
@endsection
                