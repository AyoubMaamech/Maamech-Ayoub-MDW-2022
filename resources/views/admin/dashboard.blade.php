@extends('index')

@section('title')
@lang('Dashboard')
@endsection

@section('breadcubs')
<x-front.breadcubs title="Admin Dashboard" :path="['Admin']" />
@endsection

@section('dashboard-content')
                <div class="row gutters-20">
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="dashboard-summery-one mg-b-20">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <div class="item-icon bg-light-green ">
                                        <i class="flaticon-classmates text-green"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="item-content">
                                        <div class="item-title">@lang('Students')</div>
                                        <div class="item-number"><span class="counter" data-num="{{$total_students}}">{{$total_students}}</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="dashboard-summery-one mg-b-20">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <div class="item-icon bg-light-blue">
                                        <i class="flaticon-multiple-users-silhouette text-blue"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="item-content">
                                        <div class="item-title">@lang('Teachers')</div>
                                        <div class="item-number"><span class="counter" data-num="{{$total_teachers}}">{{$total_teachers}}</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="dashboard-summery-one mg-b-20">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <div class="item-icon bg-light-yellow">
                                        <i class="flaticon-couple text-orange"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="item-content">
                                        <div class="item-title">@lang('Parents')</div>
                                        <div class="item-number"><span class="counter" data-num="{{$total_parents}}">{{$total_parents}}</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-sm-6 col-12">
                        <div class="dashboard-summery-one mg-b-20">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <div class="item-icon bg-light-red">
                                        <i class="flaticon-money text-red"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="item-content">
                                        <div class="item-title">@lang('Earnings')</div>
                                        <div class="item-number"><span>$</span><span class="counter" data-num="{{$total_earnings}}">{{$total_earnings}}</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="dashboard-summery-one mg-b-20 bg-blue">
                            <div class="row align-items-center">
                                <div class="col-2">
                                    <div class="item-icon bg-light-yellow">
                                        <i class="flaticon-user text-yellow"></i>
                                    </div>
                                </div>
                                <div class="col-7">
                                    <div class="item-content text-left">
                                        <div class="item-title text-white">@lang('Pending admissions')</div>
                                        <div class="item-number text-white"><span class="counter" data-num="{{$total_pending}}">{{$total_pending}}</span></div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="item-content">
                                        <a href="{{route('etudiants.index')}}" class="btn fw-btn-fill btn-gradient-yellow">@lang('View') <i class="fas fa-eye"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Dashboard summery End Here -->
                <!-- Dashboard Content Start Here -->
                <div class="row gutters-20">
                    <div class="col-12 col-xl-8 ">
                        <div class="card dashboard-card-one pd-b-20">
                            <div class="card-body">
                                <div class="heading-layout1">
                                    <div class="item-title">
                                        <h3>@lang('Earnings')</h3>
                                    </div>
                                </div>
                                <div class="earning-report">
                                    <div class="item-content">
                                        <div class="single-item pseudo-bg-blue">
                                            <h4>@lang('Fees Collection')</h4>
                                            <span>{{array_sum($earnings['values'])}}</span>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    const earning_chart_labels = {!! json_encode($earnings['labels']) !!};
                                    const earning_chart_values = {!! json_encode($earnings['values']) !!};
                                    let max_value = Math.max(...earning_chart_values);
                                    let digits = Math.floor(Math.log10(max_value));
                                    const earning_chart_step_size = Math.pow(10, digits) * Math.ceil(max_value * 0.3 / Math.pow(10, digits));
                                </script>
                                <div class="earning-chart-wrap">
                                    <canvas id="earning-line-chart" width="660" height="320"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 ">
                        <div class="card dashboard-card-two pd-b-20">
                            <div class="card-body">
                                <div class="heading-layout1">
                                    <div class="item-title">
                                        <h3>@lang('Expenses')</h3>
                                    </div>
                                </div>
                                <div class="expense-report">
                                    <div class="monthly-expense pseudo-bg-Aquamarine">
                                        <div class="expense-date">{{$expenses[2]['key']}}</div>
                                        <div class="expense-amount"><span>$</span> {{$expenses[2]['value']}}</div>
                                    </div>
                                    <div class="monthly-expense pseudo-bg-blue">
                                        <div class="expense-date">{{$expenses[1]['key']}}</div>
                                        <div class="expense-amount"><span>$</span> {{$expenses[1]['value']}}</div>
                                    </div>
                                    <div class="monthly-expense pseudo-bg-yellow">
                                        <div class="expense-date">{{$expenses[0]['key']}}</div>
                                        <div class="expense-amount"><span>$</span> {{$expenses[0]['value']}}</div>
                                    </div>
                                </div>
                                <script>
                                    const expense_chart_labels = [{!! json_encode($expenses[2]['key']) !!}, {!! json_encode($expenses[1]['key']) !!}, {!! json_encode($expenses[0]['key']) !!}];
                                    const expense_chart_values = [{!! json_encode($expenses[2]['value']) !!}, {!! json_encode($expenses[1]['value']) !!}, {!! json_encode($expenses[0]['value']) !!}];
                                    
                                    max_value = Math.max(...expense_chart_values);
                                    digits = Math.floor(Math.log10(max_value));
                                    const expense_chart_step_size = Math.pow(10, digits) * Math.ceil(max_value * 0.3 / Math.pow(10, digits));
                                </script>
                                <div class="expense-chart-wrap">
                                    <canvas id="expense-bar-chart" width="100" height="300"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-6 ">
                        <div class="card dashboard-card-three pd-b-20">
                            <div class="card-body">
                                <div class="heading-layout1">
                                    <div class="item-title">
                                        <h3>@lang('Students')</h3>
                                    </div>
                                </div>
                                <div class="doughnut-chart-wrap">
                                    <canvas id="student-doughnut-chart" width="100" height="300" data-1-label="@lang('Male Students')"  data-title="@lang('Students')" 
                                        data-2-label="@lang('Female Students')" data-1-count="{{$males}}" data-2-count="{{$females}}" ></canvas>
                                </div>
                                <div class="student-report">
                                    <div class="student-count pseudo-bg-blue">
                                        <h4 class="item-title">@lang('Male Students')</h4>
                                        <div class="item-number">{{$males}}</div>
                                    </div>
                                    <div class="student-count pseudo-bg-yellow">
                                        <h4 class="item-title">@lang('Female Students')</h4>
                                        <div class="item-number">{{$females}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-6 ">
                        <div class="card dashboard-card-four pd-b-20">
                            <div class="card-body">
                                <div class="heading-layout1">
                                    <div class="item-title">
                                        <h3>Event Calender</h3>
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