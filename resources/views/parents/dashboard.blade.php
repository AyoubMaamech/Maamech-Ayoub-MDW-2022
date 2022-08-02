@extends('index')

@section('title')
@lang('Dashboard')
@endsection

@section('breadcubs')
<x-front.breadcubs title="Dashboard" :path="['Parent']" />
@endsection

@section('dashboard-content')
<!-- Dashboard summery Start Here -->
    <div class="row">
        <div class=" col-sm-6 col-12">
            <div class="dashboard-summery-one">
                <div class="row">
                    <div class="col-6">
                        <div class="item-icon bg-light-yellow">
                            <i class="flaticon-mortarboard text-orange"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="item-content">
                            <div class="item-title">@lang('Grades')</div>
                            <div class="item-number"><span class="counter" data-num="{{count($notes ?? [])}}">0</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class=" col-sm-6 col-12">
            <div class="dashboard-summery-one">
                <div class="row">
                    <div class="col-6">
                        <div class="item-icon bg-light-blue">
                            <i class="flaticon-money text-blue"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="item-content">
                            <div class="item-title">@lang('Expenses')</div>
                            <div class="item-number"><span class="counter" data-num="{{$depenses}}">0</span> <span>TND</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Dashboard summery End Here -->
            @if(session('ok'))
                <x-alert 
                    type='success'
                    title="{!! session('ok') !!}">
                </x-alert>
            @elseif(session('error'))
                <x-alert 
                    type='danger'
                    title="{!! session('error') !!}"
                    icon="exclamation-triangle">
                </x-alert>
            @elseif (count($students ?? []) == 0)
                <x-alert 
                    type='warning'
                    :title="__('No Student Found')"
                    icon="exclamation">
                </x-alert>
            @endif
    <!-- Dashboard Content Start Here -->
    <div class="row">
        <div class="col-12-xxxl col-12">
            <div class="card dashboard-card-twelve">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>@lang('My Kids')</h3>
                        </div>
                    </div>
                    
                    <form class="mg-b-20" action="{{route('etudiants.parent')}}" method="POST" >
                        @csrf

                        <input type="hidden" name="parent" value="{{auth()->user()->parent->id}}" />

                        <div class="row gutters-8">
                            <div class=" col-xl-8 col-lg-9 col-12 form-group">
                                <input type="text" name="cne" placeholder="@lang('Admission ID')" class="form-control">
                            </div>
                            <div class=" col-xl-4 col-lg-3 col-12 form-group">
                                <button type="submit" class="fw-btn-fill btn-gradient-yellow" style="width:auto;">@lang('ADD')</button>
                            </div>
                        </div>
                    </form>

                    <div class="kids-details-wrap">
                        <div class="row">
                        @foreach($students as $student)
                            <a class="col-12-xxxl col-xl-6 col-12" href="{{route('etudiants.show', $student->id)}}">
                               <div class="kids-details-box mb-5">
                                    <div class="item-img">
                                        <img src="{{ getImage($student) }}" alt="@lang('photo')">
                                    </div>
                                    <div class="item-content table-responsive">
                                        <table class="table text-nowrap">
                                            <tbody>
                                                <tr>
                                                    <td>@lang('Name:')</td>
                                                    <td>{{ $student->nom() }}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('Gender:')</td>
                                                    <td>{!! $student->sexe === 'F' ? '<i class="fas fa-venus" style="color:crimson"></i> '.__('Female') : '<i class="fas fa-mars" style="color: darkcyan"></i> '.__('Male') !!}</td>

                                                </tr>
                                                <tr>
                                                    <td>@lang('Class:')</td>
                                                    <td>{{ isset($student->classe) ? $student->classe->affichage() : __('[ None ]') }}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('Admission ID:')</td>
                                                    <td>{{ isset($student->cne) ? '#'.$student->cne : __('[ None ]') }}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('Admission Date:')</td>
                                                    <td>{{ $student->dateAdmission()}}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12-xxxl col-12">
            <div class="card dashboard-card-eleven">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>@lang('Expenses')</h3>
                        </div>
                    </div>
                    <x-front.paiement-table profile="student" :list="$paiements ?? []" />
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-12">
            <div class="card dashboard-card-twelve">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>@lang('Exam Grades')</h3>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table display data-table text-nowrap">
                            <thead>
                                <tr>
                                    <th>@lang('Exam Type')</th>
                                    <th>@lang('Subject')</th>
                                    <th>@lang('Student')</th>
                                    <th>@lang('Grade')</th>
                                    <th>@lang('Date')</th>
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
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection