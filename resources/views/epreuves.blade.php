@extends('index')

@section('title')
@lang('All Exams')
@endsection

@section('breadcubs')
@php
 $breadcubs_path = [route('epreuves.index', 'all') => 'All Exams'];
 if (isset($annee)) $breadcubs_path += [route('epreuves.index', $annee) => $annee];/*
 if (isset($niveau)) $breadcubs_path += [route('epreuves.index', [$annee, $niveau]) => $niveau];
 if (isset($filiere)) $breadcubs_path += [route('epreuves.index', [$annee, $niveau, $filiere->id]) => $filiere->nom];*/
 if (isset($classe)) $breadcubs_path += [route('epreuves.index', [$annee, /*$niveau, $filiere->id, */$classe->id]) => $classe->nom];

 if (!isset($types)) $types = [];
 if (!isset($epreuves)) $epreuves = [];

@endphp
<x-front.breadcubs title="Exams" :path="$breadcubs_path" />
@endsection
@section('dashboard-content')
@if (!isset($classe))
<x-alert 
    type='success'
    :title="__('Exams will be loaded after selecting a class!')">
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
                        <form class="mg-b-20" action="{{route('epreuves.index.filter')}}" method="POST" >
                            @csrf
                            <div class="row gutters-8">
                                <x-front.form-input  label="Year *" type="select" name="annee" :usekeys="false" :options="$annees ?? [$annee]" :required="true"/>
@isset($annee)  {{--            <x-front.form-input  label="Level *" type="select" name="niveau" :usekeys="false" :options="$niveaux ?? [$niveau]" :required="true"/> @endisset
@isset($niveau)                 <x-front.form-input  label="Course *" type="select" name="filiere" :options="getIDNomArray($filieres ?? [$filiere])" :required="true"/> @endisset
@isset($filiere) --}}           <x-front.form-input  span="half" label="Class *" type="select" name="classe" :options="getIDAffichageArray($classes ?? [$classe])" :required="true"/> @endisset

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
    <div class="col-lg-12 col-xl-12 col-12 col-12-xxxl">
    @if(session('ok'))
    <x-alert 
        type='success'
        title="{!! session('ok') !!}">
    </x-alert>
    @elseif (count($types) == 0)
    <x-alert 
        type='warning'
        :title="__('No Exam Type Found')"
        icon="exclamation">
    </x-alert>
    @endif
    </div>
            @if(auth()->user()->profile == 'admin')
            <div class="col-lg-6 col-xl-6 ">
            @else
            <div class="col-lg-12 col-xl-12 col-12-xxxl">
            @endif
                <div class="card dashboard-card-six">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>@lang('All Exam Types')</h3>
                            </div>
                        </div>

                        
                        @if(auth()->user()->profile == 'admin')
                        <form class="mg-b-20 mg-t-20" action="{{ session('type') ? route('type_epreuves.update', session('type')->id) : route('type_epreuves.store')}}" method="POST" >
                            @csrf

                            @if(session('type')) @method('PATCH') @endif
                            <div class="row gutters-8">
                                <div class=" col-xl-5 col-lg-5 col-12 form-group">
                                    <input type="text" name="type" @if(session('type')) placeholder="@lang('Edit Exam Type ...')" value="{{session('type')->nom}}" @else placeholder="@lang('New Exam Type ...')" @endif class="form-control">
                                </div>
                                <div class=" col-xl-4 col-lg-4 col-12 form-group">
                                    <input type="text" name="coeff" @if(session('type')) placeholder="@lang('Exam Coeff ...')" value="{{session('type')->coeff}}" @else placeholder="@lang('Exam Coeff ...')" @endif class="form-control">
                                </div>
                                <div class=" col-xl-3 col-lg-3 col-12 form-group">
                                    <button type="submit" class="fw-btn-fill btn-gradient-yellow">@if(session('type')) @lang('UPDATE') @else @lang('ADD') @endif</button>
                                </div>
                            </div>
                        </form>
                        @else
                        <div class="mg-b-20 mg-t-20"></div>
                        @endif
                        <div class="table-responsive">
                            <table class="table display data-table text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">@lang('ID')</th>
                                        <th>@lang('Name')</th>
                                        <th>@lang('Coeff')</th>
                                    @if(auth()->user()->profile === 'admin')
                                        <th class="text-center" colspan="2">@lang('Action')</th>
                                    @endif
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($types as $type)
                                    <tr>
                                        <td class="text-center">#{{ $type->id }}</td>
                                        <td>{{ $type->nom }}</td>
                                        <td>{{ $type->coeff }}</td>

                                    @if(auth()->user()->profile === 'admin')
                                        <td class="text-center"><a class="text-warning" href="{{route('type_epreuves.edit', $type->id)}}"><i class="fas fa-pen"></i></a></td>
                                        <td class="text-center"><a class="text-danger" href="javascript:;" onclick="$('#delete_dialog .modal-body').html('@lang('Are you sure you want to delete this Exam Type ?')'); $('#modal-submit').attr('formaction', '{{ route('type_epreuves.destroy', $type->id) }}');" data-toggle="modal" data-target="#delete_dialog"><i class="fas fa-trash"></i></a></td>
                                    @endif
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @if (auth()->user()->profile === 'admin')
            <div class="col-lg-6 col-xl-6 ">
                <div class="card dashboard-card-four">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>@if(session('epreuve')) @lang('Edit Exam') @else @lang('New Exam') @endif</h3>
                            </div>
                        </div>
                                                

                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />

                        <form class="mg-b-20" action="{{ session('epreuve') ? route('epreuves.update', session('epreuve')->id) : route('epreuves.store')}}" method="POST" >
                            @csrf
                            @if(session('epreuve')) @method('PATCH') @endif
                            <div class="row">
                                <x-front.form-input class="mg-t-10" span="full" label="Type *" type="select" name="type" :options="getIDNomArray($types)" :old="session('epreuve') ? session('epreuve')->type_id : null" />
                                <x-front.form-input class="mg-t-10" span="full" label="Subject *" type="select" name="matiere" :options="getIDNomArray($matieres)" :old="session('epreuve') ? session('epreuve')->matiere_id : null" />
                                <x-front.form-input class="mg-t-20" span="full" label="Date *" type="date" name="date" :required="true" :old="session('epreuve') ? inputFormatDate(session('epreuve')->dateEpreuve()) : null" />
                                <x-front.form-input class="mg-t-10" span="full" label="ClassRoom" name="salle" :old="session('epreuve') ? session('epreuve')->salle : null" />

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
            @if (count($epreuves) == 0)
            <x-alert 
                type='warning'
                :title="__('No Exam Found')"
                icon="exclamation">
            </x-alert>
            @endif
            </div>

            <div class=" col-12">
                <div class="card dashboard-card-ten">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>@lang('All Exams')</h3>
                            </div>
                        </div>
                        <div class="mg-b-20 pd-b-40"></div>
                        <div class="table-responsive">
                            <table class="table display data-table text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">@lang('ID')</th>
                                        <th>@lang('Type')</th>
                                        <th>@lang('Subject')</th>
                                        <th>@lang('Date')</th>
                                        <th>@lang('ClassRoom')</th>
                                    @if(auth()->user()->profile === 'admin')
                                        <th class="text-center" colspan="2">@lang('Action')</th>
                                    @endif
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($epreuves as $epreuve)
                                    <tr>
                                        <td class="text-center">#{{ $epreuve->id }}</td>
                                        <td>{{ $epreuve->type_epreuve->nom }}</td>
                                        <td>{{ $epreuve->matiere->nom }}</td>
                                        <td>{{ $epreuve->dateEpreuve() }}</td>
                                        <td>{{ $epreuve->salle }}</td>
                                    @if(auth()->user()->profile === 'admin')
                                        <td class="text-center"><a class="text-warning" href="{{route('epreuves.edit', $epreuve->id)}}"><i class="fas fa-pen"></i></a></td>
                                        <td class="text-center"><a class="text-danger" href="javascript:;" onclick="$('#delete_dialog .modal-body').html('@lang('Are you sure you want to delete this Exam ?')'); $('#modal-submit').attr('formaction', '{{route('epreuves.destroy', $epreuve->id)}}');" data-toggle="modal" data-target="#delete_dialog"><i class="fas fa-trash"></i></a></td>
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
                