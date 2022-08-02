@extends('index')

@section('title')
@lang('Dashboard')
@endsection

@section('breadcubs')
<x-front.breadcubs title="Dashboard" :path="['Teacher']" />
@endsection

@section('dashboard-content')
    <div class="row">

        <!-- Students Chart End Here -->
        <div class="col-lg-6  col-xl-6">
            <div class="card dashboard-card-three">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>@lang('Students')</h3>
                        </div>
                    </div>
                    <div class="doughnut-chart-wrap">
                        <canvas id="student-doughnut-chart" width="100" height="300" data-1-label="@lang('Male Students')"  data-title="@lang('Students')" 
                            data-2-label="@lang('Female Students')" data-1-count="{{$info['males']}}" data-2-count="{{$info['females']}}" ></canvas>
                    </div>
                    <div class="student-report">
                        <div class="student-count pseudo-bg-blue">
                            <h4 class="item-title">@lang('Male Students')</h4>
                            <div class="item-number">{{$info['males']}}</div>
                        </div>
                        <div class="student-count pseudo-bg-yellow">
                            <h4 class="item-title">@lang('Female Students')</h4>
                            <div class="item-number">{{$info['females']}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Students Chart End Here -->
                <!-- Dashboard summery Start Here -->
                <div class="col-12 col-lg-6 ">
                    <div class="row">
                        <div class=" col-lg-6 col-sm-6 col-12">
                            <div class="dashboard-summery-two">
                                <div class="item-icon bg-light-yellow">
                                    <i class="flaticon-mortarboard text-orange"></i>
                                </div>
                                <div class="item-content">
                                    <div class="item-number"><span class="counter" data-num="{{$info['matieres']}}">0</span></div>
                                    <div class="item-title">@lang('Total Subjects')</div>
                                </div>
                            </div>
                        </div>
                        <div class=" col-lg-6 col-sm-6 col-12">
                            <div class="dashboard-summery-two">
                                <div class="item-icon bg-light-blue">
                                    <i class="flaticon-shopping-list text-blue"></i>
                                </div>
                                <div class="item-content">
                                    <div class="item-number"><span class="counter" data-num="{{$info['epreuves']}}">0</span></div>
                                    <div class="item-title">@lang('Total Exams')</div>
                                </div>
                            </div>
                        </div>
                        <div class=" col-lg-6 col-sm-6 col-12">
                            <div class="dashboard-summery-two">
                                <div class="item-icon bg-light-magenta">
                                    <i class="flaticon-classmates text-magenta"></i>
                                </div>
                                <div class="item-content">
                                    <div class="item-number"><span class="counter" data-num="{{count($students ?? [])}}">0</span></div>
                                    <div class="item-title">@lang('Total Students')</div>
                                </div>
                            </div>
                        </div>
                        <div class=" col-lg-6 col-sm-6 col-12">
                            <div class="dashboard-summery-two">
                                <div class="item-icon bg-light-red">
                                    <i class="flaticon-money text-red"></i>
                                </div>
                                <div class="item-content">
                                    <div class="item-number"><span>$</span><span class="counter" data-num="{{$info['gains']}}">0</span></div>
                                    <div class="item-title">@lang('Total Income')</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Dashboard summery End Here -->
    </div>
    <!-- Student Table Area Start Here -->
    {{--
    <div class="row">
        <div class="col-lg-12">
            <div class="card dashboard-card-eleven">
                <div class="card-body">
                    <div class="heading-layout1">
                        <div class="item-title">
                            <h3>@lang('All Students')</h3>
                        </div>
                    </div>
                    <div class="mg-t-20 pd-b-40"></div>
                    <div class="table-responsive">
                        <table class="table display data-table text-nowrap">
                            <thead>
                                <tr>
                                    <th class="text-center">@lang('ID')</th>
                                    <th class="text-center">@lang('Photo')</th>
                                    <th>@lang('Name')</th>
                                    <th class="text-center">@lang('Gender')</th>
                                    <th>@lang('Class')</th>
                                    <th>@lang('E-mail')</th>
                                @if(auth()->user()->profile === 'admin' || auth()->user()->profile === 'teacher')
                                    <th>@lang('Phone')</th>
                                    <th>@lang('Address')</th>
                                    <th>@lang('Date Of Birth')</th>
                                    <th>@lang('Parents')</th>
                                    <th></th>
                                    <th @if(auth()->user()->profile === 'admin') colspan="3" @endif>@lang('Action')</th>
                                @endif
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($students ?? [] as $student)
                                <tr>
                                    <td class="text-center">{{ isset($student->cne) ? '#'.$student->cne : __('[ None ]') }}</td>
                                    <td class="text-center"><img src="{{ getImage($student) }}" alt="@lang('photo')" width="30" height="30"/></td>
                                    <td>{{ $student->nom() }}</td>
                                    <td class="text-center">{!! $student->sexe === 'F' ? '<i class="fas fa-venus" style="color:crimson"></i>' : '<i class="fas fa-mars" style="color: darkcyan"></i>' !!}</td>
                                    <td>{{ isset($student->classe) ? $student->classe->affichage() : __('[ None ]') }}</td>
                                    <td>{{ $student->email }}</td>
                                @if(auth()->user()->profile === 'admin' || auth()->user()->profile === 'teacher')
                                    <td>{{ $student->tel }}</td>
                                    <td>{{ $student->adresse }}</td>
                                    <td>{{ $student->dateDeNaissance() }}</td>
                                    <td>{{ $student->parent == null ? __('[ None ]') : $student->parent->nom() }}</td>
                                    <td></td>
                                    <td class="text-center"><a class="text-primary" href="{{route('etudiants.show', $student->id)}}"><i class="fas fa-eye"></i></a></td>
                                @endif
                                @if(auth()->user()->profile === 'admin')
                                    <td class="text-center"><a class="text-warning" href="{{route('etudiants.edit', $student->id)}}"><i class="fas fa-pen"></i></a></td>
                                    <td class="text-center"><a class="text-danger" href="#" onclick="document.getElementById('modal-submit').setAttribute('formaction', '{{route('etudiants.destroy', $student->id)}}');" data-toggle="modal" data-target="#delete_dialog"><i class="fas fa-trash"></i></a></td>
                                @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>--}}
    <!-- Student Table Area End Here -->
@endsection