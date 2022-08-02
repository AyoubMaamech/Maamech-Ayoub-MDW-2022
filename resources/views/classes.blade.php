@extends('index')

@section('title')
@lang('Classes')
@endsection

@section('breadcubs')
                <!-- Breadcubs Area Start Here -->
                <div class="breadcrumbs-area">
                    <h3>@lang('Classes')</h3>
                    <ul>
                        <li>
                            <a href="{{route('home')}}">@lang('Home')</a>
                        </li>
                        <li>@lang('Classes')</li>
                    </ul>
                </div>
@endsection
@section('dashboard-content')
@if(session('ok'))
<x-alert 
    type='success'
    title="{!! session('ok') !!}">
</x-alert>

@elseif ($filieres->count() == 0)
<x-alert 
    type='warning'
    :title="__('No Course Found')"
    icon="exclamation">
</x-alert>

@endif
        <div class="row gutters-20">

            @if(auth()->user()->profile == 'admin')
            <div class="col-lg-6 col-xl-6 ">
            @else
            <div class="col-lg-12 col-xl-12 col-12-xxxl">
            @endif
                <div class="card dashboard-card-six">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>@lang('All Courses')</h3>
                            </div>
                        </div>

                        
                        @if(auth()->user()->profile == 'admin')
                        <form class="mg-b-20 mg-t-20" action="{{ isset($filiere) ? route('filieres.update', $filiere->id) : route('filieres.store')}}" method="POST" >
                            @csrf
                            @isset($filiere) @method('PATCH') @endisset
                            <div class="row gutters-8">
                                <div class=" col-xl-9 col-lg-9 col-12 form-group">
                                    <input type="text" name="filiere" @isset($filiere) placeholder="@lang('Edit Course ...')" value="{{$filiere->nom}}" @else placeholder="@lang('New Course ...')" @endisset class="form-control">
                                </div>
                                <div class=" col-xl-3 col-lg-3 col-12 form-group">
                                    <button type="submit" class="fw-btn-fill btn-gradient-yellow">@isset($filiere) @lang('UPDATE') @else @lang('ADD') @endisset</button>
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
                                    @if(auth()->user()->profile === 'admin')
                                        <th  colspan="2">@lang('Action')</th>
                                    @endif
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($filieres as $filiere)
                                    <tr>
                                        <td class="text-center">#{{ $filiere->id }}</td>
                                        <td>{{ $filiere->nom }}</td>

                                    @if(auth()->user()->profile === 'admin')
                                        <td class="text-center"><a class="text-warning" href="{{route('filieres.edit', $filiere->id)}}"><i class="fas fa-pen"></i></a></td>
                                        <td class="text-center"><a class="text-danger" href="javascript:;" onclick="$('#delete_dialog .modal-body').html('@lang('Are you sure you want to delete this Course ?')'); $('#modal-submit').attr('formaction', '{{route('filieres.destroy', $filiere->id)}}');" data-toggle="modal" data-target="#delete_dialog"><i class="fas fa-trash"></i></a></td>
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
                                <h3>@isset($classe) @lang('Edit Class') @else @lang('New Class') @endisset</h3>
                            </div>
                        </div>
                                                

                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />

                        <form class="mg-b-20" action="{{ isset($classe) ? route('classes.update', $classe->id) : route('classes.store')}}" method="POST" >
                            @csrf
                            @isset($classe) @method('PATCH') @endisset
                            <div class="row">
                                <x-front.form-input class="mg-t-20" span="full" label="School Year *" name="annee" :required="true" :old="isset($classe) ? $classe->annee : '2021-2022'" />
                                <x-front.form-input class="mg-t-10" span="full" label="Level *" type="select" name="niveau" :usekeys="false" :options="['1ére année', '2eme année', '3eme année', '4eme année', '5eme année', '6eme année']" :old="isset($classe) ? $classe->niveau : null" />
                                <x-front.form-input class="mg-t-10" span="full" label="Course *" type="select" name="filiere" :options="getIDNomArray($filieres)" :old="isset($classe) ? $classe->filiere->id : null" />
                                <x-front.form-input class="mg-t-10" span="full" label="Class Name *" name="nom" :required="true" :old="isset($classe) ? $classe->nom : null" />

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
            @if ($classes->count() == 0)
            <x-alert 
                type='warning'
                :title="__('No Class Found')"
                icon="exclamation">
            </x-alert>
            @endif
            </div>

            @if (auth()->user()->profile === 'teacher')
            <div class=" col-12">
                <div class="card dashboard-card-ten">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>@lang('My Classes')</h3>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table display data-table text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">@lang('ID')</th>
                                        <th class="text-center">@lang('Year')</th>
                                  <th>@lang('Class')</th>
                                        <th>@lang('Students')</th>
                                    @if(auth()->user()->profile === 'admin')
                                        <th class="text-center" colspan="2">@lang('Action')</th>
                                    @endif
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($classes as $classe)
                                @if (classeEnseignant($classe, auth()->user()->enseignant->id))
                                    <tr>
                                        <td class="text-center">#{{ $classe->id }}</td>
                                        <td class="text-center">{{ $classe->annee }}</td>
                                  <td>{{ $classe->affichage() }}</td>
                                        <td>{{ $classe->etudiants->count() }}</td>
                                    @if(auth()->user()->profile === 'admin')
                                        <td class="text-center"><a class="text-warning" href="{{route('classes.edit', $classe->id)}}"><i class="fas fa-pen"></i></a></td>
                                        <td class="text-center"><a class="text-danger" href="javascript:;" onclick="$('#delete_dialog .modal-body').html('@lang('Are you sure you want to delete this Class ?')'); $('#modal-submit').attr('formaction', '{{route('classes.destroy', $classe->id)}}');" data-toggle="modal" data-target="#delete_dialog"><i class="fas fa-trash"></i></a></td>
                                    @endif
                                    </tr>
                                @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Student Table Area End Here -->
            </div>
            @endif


        <div class=" col-12">
                <div class="card dashboard-card-ten">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>@lang('All Classes')</h3>
                            </div>
                        </div>
                        <form class="mg-b-20" action="{{route('classes.index.filter')}}" method="POST" >
                            @csrf
                            <div class="row gutters-8">
                                <div class=" col-xl-3 col-lg-3 col-12 form-group">
                                    <input type="text" name="id" placeholder="@lang('Search by ID ...')" class="form-control">
                                </div>
                                <div class=" col-xl-3 col-lg-3 col-12 form-group">
                                    <input type="text" name="annee" placeholder="@lang('Search by Year ...')" class="form-control">
                                </div>
                                <div class=" col-xl-3 col-lg-3 col-12 form-group">
                                    <input type="text" name="nom" placeholder="@lang('Search by Name ...')" class="form-control">
                                </div>
                                <div class=" col-xl-3 col-lg-3 col-12 form-group">
                                    <button type="submit" class="fw-btn-fill btn-gradient-yellow">@lang('SEARCH')</button>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table display data-table text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">@lang('ID')</th>
                                        <th class="text-center">@lang('Year')</th>
{{--                                    <th>@lang('Level')</th>
                                        <th>@lang('Course')</th>
--}}                                    <th>@lang('Class')</th>
                                        <th>@lang('Students')</th>
                                    @if(auth()->user()->profile === 'admin')
                                        <th class="text-center" colspan="2">@lang('Action')</th>
                                    @endif
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($classes as $classe)
                                    <tr>
                                        <td class="text-center">#{{ $classe->id }}</td>
                                        <td class="text-center">{{ $classe->annee }}</td>
{{--                                    <td>{{ $classe->niveau }}</td>
                                        <td>{{ $classe->filiere->nom }}</td>
--}}                                    <td>{{ $classe->affichage() }}</td>
                                        <td>{{ $classe->etudiants->count() }}</td>
                                    @if(auth()->user()->profile === 'admin')
                                        <td class="text-center"><a class="text-warning" href="{{route('classes.edit', $classe->id)}}"><i class="fas fa-pen"></i></a></td>
                                        <td class="text-center"><a class="text-danger" href="javascript:;" onclick="$('#delete_dialog .modal-body').html('@lang('Are you sure you want to delete this Class ?')'); $('#modal-submit').attr('formaction', '{{route('classes.destroy', $classe->id)}}');" data-toggle="modal" data-target="#delete_dialog"><i class="fas fa-trash"></i></a></td>
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
                