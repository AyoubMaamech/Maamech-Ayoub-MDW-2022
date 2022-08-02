@extends('index')

@section('title')
@lang('Attendence')
@endsection

@section('breadcubs')
@php
 $breadcubs_path = [route('presences.index', 'all') => 'Attendence', 'javascript:;' => $etudiant->nom()];

 if (!isset($presences)) $presences = [];

@endphp
<x-front.breadcubs title="Attendence" :path="$breadcubs_path" />
@endsection
@section('dashboard-content')

<div class="row gutters-20">
    <div class="col-lg-12 col-xl-12 col-12 col-12-xxxl">
    @if(session('ok'))
    <x-alert 
        type='success'
        title="{!! session('ok') !!}">
    </x-alert>
    @endif
</div>

            <div class="col-12-xxxl col-lg-12 col-12">
            @if (count($presences) == 0)
            <x-alert 
                type='warning'
                :title="__('No Attendence Found')"
                icon="exclamation">
            </x-alert>
            @endif
            </div>

            <div class="col-lg-4">
                <div class="dashboard-summery-one">
                    <div class="row">
                        <div class="col-6">
                            <div class="item-icon bg-light-yellow">
                                <i class="flaticon-percentage-discount text-orange"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="item-content">
                                <div class="item-title">@lang('Attendence')</div>
                                <div class="item-number"><span class="counter" data-num="{{ getPercent($presence['present'], $presence['present'] + $presence['absent'], false) }}">0</span><span>%</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
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
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($presences as $presence)
                                    <tr>
                                        <td>{{ $presence->seance->matiere->nom }}</td>
                                        <td>{{ $presence->dateSeance() }}</td>
                                        <td class="text-center">{!! $presence->present ? '<i class="fas fa-check text-success">' : '<i class="fas fa-times text-danger"></i>' !!}</td>
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
                