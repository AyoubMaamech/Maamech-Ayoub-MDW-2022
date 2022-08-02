@extends('index')

@section('title')
@lang('All Grades')
@endsection

@section('breadcubs')
@php
 $breadcubs_path = [route('notes.index', 'all') => 'All Grades'];
 if (isset($annee)) $breadcubs_path += [route('notes.index', $annee) => $annee];/*
 if (isset($niveau)) $breadcubs_path += [route('notes.index', [$annee, $niveau]) => $niveau];
 if (isset($filiere)) $breadcubs_path += [route('notes.index', [$annee, $niveau, $filiere->id]) => $filiere->nom];*/
 if (isset($classe)) $breadcubs_path += [route('notes.index', [$annee, /*$niveau, $filiere->id, */$classe->id]) => $classe->nom];

 if (!isset($epreuves)) $epreuves = [];
 if (!isset($notes)) $notes = [];

@endphp
<x-front.breadcubs title="Exam Grades" :path="$breadcubs_path" />
@endsection
@section('dashboard-content')
@if (!isset($classe))
<x-alert 
    type='success'
    :title="__('Grades will be loaded after selecting a class!')">
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
                        <form class="mg-b-20" action="{{route('notes.index.filter')}}" method="POST" >
                            @csrf
                            <div class="row gutters-8">
                                <x-front.form-input  label="Year *" type="select" name="annee" :usekeys="false" :options="$annees ?? [$annee]" :required="true"/>
@isset($annee)  {{--            <x-front.form-input  label="Level *" type="select" name="niveau" :usekeys="false" :options="$niveaux ?? [$niveau]" :required="true"/> @endisset
@isset($niveau)                 <x-front.form-input  label="Course *" type="select" name="filiere" :options="getIDNomArray($filieres ?? [$filiere])" :required="true"/> @endisset
@isset($filiere)--}}            <x-front.form-input  span="half" label="Class *" type="select" name="classe" :options="getIDAffichageArray($classes ?? [$classe])" :required="true"/> @endisset

                                <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group mg-t-30">
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
    <div class="col-lg-12 col-xl-12 col-12 col-12-xxxl">
    @if(session('ok'))
    <x-alert 
        type='success'
        title="{!! session('ok') !!}">
    </x-alert>
    @endif
</div>

            @if (auth()->user()->profile === 'admin' || auth()->user()->profile === 'teacher') 
            <div class="col-lg-12 col-xl-12 col-12-xxxl">
                <div class="card dashboard-card-four">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>@if(session('note')) @lang('Edit Grade') @else @lang('New Grade') @endif</h3>
                            </div>
                        </div>
                                                

                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />

                        <form class="mg-b-20" action="{{ session('note') ? route('notes.update', session('note')->id) : route('notes.store')}}" method="POST" >
                            @csrf
                            @if(session('note')) @method('PATCH') @endif
                            <div class="row">
                                <x-front.form-input class="mg-t-10" span="half" label="Exam *" type="select" name="epreuve" :options="getIDAffichageArray($epreuves)" :old="session('note') ? session('note')->epreuve_id: null" />
                                <x-front.form-input class="mg-t-10" span="half" label="Student *" type="select" name="etudiant" :options="getIDAffichageArray($etudiants)" :old="session('note') ? session('note')->etudiant_id : null" />
                                <x-front.form-input class="mg-t-10" span="full" label="Grade *" name="note" :old="session('note') ? session('note')->note : null" />

                                <div class="col-12 form-group mg-t-30">
                                    <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">@lang('Save')</button>
                                    <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">@lang('Reset')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            <div class="col-12-xxxl col-lg-12 col-12">
            @if (count($notes) == 0)
            <x-alert 
                type='warning'
                :title="__('No Grade Found')"
                icon="exclamation">
            </x-alert>
            @endif
            </div>

            <div class=" col-12">
                <div class="card dashboard-card-ten">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>@lang('All Grades')</h3>
                            </div>
                        </div>

                        <div class="mg-t-20 pd-b-30"></div>

                        <div class="table-responsive">
                            <table class="table display data-table text-nowrap">
                                <thead>
                                    <tr>
                                        <th>@lang('Exam Type')</th>
                                        <th>@lang('Subject')</th>
                                        <th>@lang('Student')</th>
                                        <th>@lang('Grade')</th>
                                        <th>@lang('Date')</th>
                                    @if(auth()->user()->profile === 'admin')
                                        <th class="text-center" colspan="2">@lang('Action')</th>
                                    @endif
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($notes as $note)
                                    <tr>
                                        <td>{{ $note->epreuve->type_epreuve->nom }}</td>
                                        <td>{{ $note->epreuve->matiere->nom }}</td>
                                        <td>{{ $note->etudiant->nom() }}</td>
                                        <td>{{ $note->note }}</td>
                                        <td>{{ $note->epreuve->dateEpreuve() }}</td>
                                    @if(auth()->user()->profile === 'admin')
                                        <td class="text-center"><a class="text-warning" href="{{route('notes.edit', $note->id)}}"><i class="fas fa-pen"></i></a></td>
                                        <td class="text-center"><a class="text-danger" href="javascript:;" onclick="$('#delete_dialog .modal-body').html('@lang('Are you sure you want to delete this Grade ?')'); $('#modal-submit').attr('formaction', '{{route('notes.destroy', $note->id)}}');" data-toggle="modal" data-target="#delete_dialog"><i class="fas fa-trash"></i></a></td>
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
                