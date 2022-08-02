@extends('index')

@section('title')
@lang('Dashboard')
@endsection

@section('breadcubs')
<x-front.breadcubs title="Dashboard" :path="['Student']" />
@endsection

@section('dashboard-content')
                <div class="row">
                    <!-- Student Info Area Start Here -->
                    <div class=" col-12">
                        <div class="card dashboard-card-ten">
                            <div class="card-body">
                                <div class="heading-layout1">
                                    <div class="item-title">
                                        <h3>@lang('About Me')</h3>
                                    </div>
                                </div>
                                <div class="student-info">
                                    <div class="media media-none--xs">
                                        <div class="item-img">
                                            <img src="{{ getImage($student) }}" class="media-img-auto" alt="student">
                                        </div>
                                        <div class="media-body">
                                            <h3 class="item-title">{{ $student->user->name }}</h3>
                                            <p>{{ $student->description }}</p>
                                        </div>
                                    </div>
                                    <div class="table-responsive info-table">
                                        <table class="table text-nowrap">
                                            <tbody>
                                                <tr>
                                                    <td>@lang('Name:')</td>
                                                    <td class="font-medium text-dark-medium">{{ $student->nom() }}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('Gender:')</td>
                                                    <td class="font-medium text-dark-medium">{{ $student->sexe == 'F' ? __('Female') : __('Male') }}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('Parent Name:')</td>
                                                    <td class="font-medium text-dark-medium">{!! isset($student->parent) ? '<a  class="__cf_email__" href="'.route('parents.show', $student->parent_id).'" >'.$student->parent->nom().'</a>' : __("[ None ]") !!}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('Parent ID:')</td>
                                                    <td class="font-medium text-dark-medium">{{ isset($student->parent) ? $student->parent->cnp : __("[ None ]") }}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('Date Of Birth:')</td>
                                                    <td class="font-medium text-dark-medium">{{ $student->dateDeNaissance() }}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('E-Mail:')</td>
                                                    <td class="font-medium text-dark-medium">{{ $student->email }}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('Admission Date:')</td>
                                                    <td class="font-medium text-dark-medium">{{ $student->dateAdmission() }}</td>
                                                </tr> 
                                                <tr>
                                                    @isset($student->classe) 
                                                        @if($student->classe->annee == null && $student->classe->niveau == null && $student->classe->nom == null)
                                                        
                                                            <td>@lang('Course:')</td>
                                                            <td class="font-medium text-dark-medium">{{isset($student->classe->filiere) ? $student->classe->filiere->nom : __('[ None ]')}}</td>
                                                        @else
                                                            <td>@lang('Class:')</td>
                                                            <td class="font-medium text-dark-medium">{{ $student->classe->affichage() }} </td>
                                                        @endif 
                                                    @else 
                                                        <td>@lang('Class:')</td>
                                                        <td class="font-medium text-dark-medium"> @lang('[ None ]') </td>
                                                    @endisset 
                                                </tr>
                                                <tr>
                                                    <td>@lang('Roll:')</td>
                                                    <td class="font-medium text-dark-medium">{{ $student->cne ?? __('[ None ]') }}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('Address:')</td>
                                                    <td class="font-medium text-dark-medium">{{ $student->adresse }}</td>
                                                </tr>
                                                <tr>
                                                    <td>@lang('Phone:')</td>
                                                    <td class="font-medium text-dark-medium">{{ $student->tel }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Student Info Area End Here -->
                    <div class=" col-12">
                        <div class="row">
                            <!-- Exam Result Area Start Here -->
                            <div class="col-lg-12">
                                <div class="card dashboard-card-eleven">
                                    <div class="card-body">
                                        <div class="heading-layout1">
                                            <div class="item-title">
                                                <h3>@lang('Exam Grades')</h3>
                                            </div>
                                        </div>
                                        <div class="table-box-wrap">
                                            <div class="table-responsive result-table-box">
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
                            <!-- Exam Result Area End Here -->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class=" col-xl-6 col-12">
                        <div class="card dashboard-card-three">
                            <div class="card-body">
                                <div class="heading-layout1">
                                    <div class="item-title">
                                        <h3>@lang('Attendence')</h3>
                                    </div>
                                </div>
                                <div class="doughnut-chart-wrap">
                                    <canvas id="student-doughnut-chart" width="100" height="270" data-1-label="@lang('Absent')"  data-title="@lang('Attendence')" 
                                        data-2-label="@lang('Present')" data-1-count="{{$presence['absent']}}" data-2-count="{{$presence['present']}}" ></canvas>
                                </div>
                                <div class="student-report">
                                    <div class="student-count pseudo-bg-blue">
                                        <h4 class="item-title">@lang('Absent')</h4>
                                        <div class="item-number">{{ getPercent($presence['absent'], $presence['present'] + $presence['absent'])}}</div>
                                    </div>
                                    <div class="student-count pseudo-bg-yellow">
                                        <h4 class="item-title">@lang('Present')</h4>
                                        <div class="item-number">{{ getPercent($presence['present'], $presence['present'] + $presence['absent'])}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" col-xl-6 col-12">
                        <div class="card dashboard-card-thirteen">
                            <div class="card-body">
                                <div class="heading-layout1">
                                    <div class="item-title">
                                        <h3>@lang('Calender')</h3>
                                    </div>
                                </div>
                                <div class="calender-wrap">
                                    <div id="fc-calender" class="fc-calender"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
@endsection