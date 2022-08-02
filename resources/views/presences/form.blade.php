@extends('index')

@section('title')
@lang('Attendence')
@endsection

@section('breadcubs')
@php
$breadcubs_path = [
    route('presences.index', 'all') => 'Attendence', 
    route('presences.index', $classe->annee) => $classe->annee,
    route('presences.index', [$classe->annee, $classe->niveau]) => $classe->niveau,
    route('presences.index', [$classe->annee, $classe->niveau, $classe->filiere->id]) => $classe->filiere->nom,
    route('presences.index', [$classe->annee, $classe->niveau, $classe->filiere->id, $classe->id]) => $classe->nom
];

@endphp
<x-front.breadcubs title="Attendance" :path="$breadcubs_path" />
@endsection
@section('dashboard-content')

@if (!isset($matiere))
<x-alert 
    type='success'
    :title="__('Attendence will be loaded after selecting a subject!')">
</x-alert>
@endif

<div class="row gutters-20">
@if(session('ok'))
    <div class="col-lg-12 col-xl-12 col-12 col-12-xxxl">
        <x-alert 
            type='success'
            title="{!! session('ok') !!}">
        </x-alert>
    </div>
@endif

    <div class=" col-12">
        <div class="card dashboard-card-ten">
            <div class="card-body">
                <div class="heading-layout1">
                    <div class="item-title">
                        @if(isset($matiere))
                        <h3>@if(isset($presences)) @lang('Edit Attendence') @else @lang('New Attendence') @endif</h3>
                        @else
                        <h3>@lang('Select Subject')</h3>
                        @endif
                    </div>
                </div>
                        <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form class="mg-b-20" action="{{ !isset($matiere) ? route('presences.create.filter', $classe->id) : (isset($presences) ? route('presences.update', implode(', ', $presences->pluck('id')->toArray())) : route('presences.store'))}}" method="POST" >
                    @csrf

                    @if(isset($presences)) @method('PATCH') @endif

                    <input type="hidden" name="classe" value="{{$classe->id}}" />

                    <div class="row gutters-8">
@isset($matiere)                
                        <x-front.form-input  label="Session *" type="select" name="seance" :options="getIDAffichageArray($matiere->seances ?? [])" :required="true" :old="isset($presences) ? $presences[0]->seance->id : null"/> 
                        <x-front.form-input  label="Date *" type="date" name="date" placeholder="dd/mm/yyyy" :required="true" :old="isset($presences) ? inputFormatDate(formatDate($presences[0]->date_seance)) : null"/>
            
                        <div class=" col-xl-3 col-lg-3 col-12 form-group mg-t-30">
                            <button type="submit" class="fw-btn-fill btn-gradient-yellow" style="width:auto;">@isset($presences) @lang('UPDATE') @else @lang('ADD') @endisset</button>
                        </div>

                        <div class="col-12-xxxl col-lg-12 col-12">
                            @if (count($etudiants ?? []) == 0 && count($presences ?? []) == 0)
                            <x-alert 
                                type='warning'
                                :title="__('No Student Found')"
                                icon="exclamation">
                            </x-alert>
                            @endif
                        </div>

                        <div class="table-responsive">
                            <table class="table display data-table text-nowrap">
                                <thead>
                                    <tr>
                                        <th>@lang('Students')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if (isset($presences))
                                    @foreach($presences as $presence)
                                        <tr>
                                            <td><input class="mg-r-10" type="checkbox" name="ids[]" value="{{$presence->id }}" @if ($presence->present) checked @endif /> {{ $presence->etudiant->nom() }}</td>
                                        </tr>
                                    @endforeach                                   
                                @else 
                                    @foreach($etudiants as $etudiant)
                                        <tr>
                                            <td><input class="mg-r-10" type="checkbox" name="etudiants[]" value="{{$etudiant->id }}" /> {{ $etudiant->nom() }}</td>
                                        </tr>
                                    @endforeach                                   
                                @endif

                                </tbody>
                            </table>
                        </div>
@else
                        <x-front.form-input  label="Subject *" type="select" name="matiere" :options="getIDNomArray($matieres ?? [])" :required="true"/>                        

                        <div class=" col-xl-3 col-lg-3 col-12 form-group mg-t-30">
                            <button type="submit" class="fw-btn-fill btn-gradient-yellow" style="width:auto;">@lang('SEARCH')</button>
                        </div>
@endisset
                    </div>
                </form>
            </div>
        </div>
        <!-- Student Table Area End Here -->
    </div>
</div>
@endsection
                