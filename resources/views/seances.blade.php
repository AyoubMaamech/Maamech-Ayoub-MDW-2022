@extends('index')

@section('title')
@lang('All Sessions')
@endsection

@section('breadcubs')
@php
 $breadcubs_path = [route('seances.index', ['all']) => 'All Sessions'];
 if (isset($annee)) $breadcubs_path += [route('seances.index', $annee) => $annee];
 /*
 if (isset($niveau)) $breadcubs_path += [route('seances.index', [$annee, $niveau]) => $niveau];
 if (isset($filiere)) $breadcubs_path += [route('seances.index', [$annee, $niveau, $filiere->id]) => $filiere->nom];
 */
if (isset($classe)) $breadcubs_path += [route('seances.index', [$annee, /*$niveau, $filiere->id, */$classe->id]) => $classe->nom];

 if (!isset($matieres)) $matieres = [];
 if (!isset($seances)) $seances = [];

@endphp
<x-front.breadcubs title="Class Routine" :path="$breadcubs_path" />
@endsection
@section('dashboard-content')
@if (!isset($classe))
<x-alert 
    type='success'
    :title="__('Sessions will be loaded after selecting a class!')">
</x-alert>
        <div class="row gutters-20">

            <div class="col-12">
                <div class="card dashboard-card-ten">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>@lang('Select Class')</h3>
                            </div>
                        </div>
                        <form class="mg-b-20" action="{{route('seances.index.filter')}}" method="POST" >
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

            @if (auth()->user()->profile === 'admin')
            <div class="col-lg-12 col-xl-12 col-12-xxxl">
                <div class="card dashboard-card-four">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>@if(session('seance')) @lang('Edit Session') @else @lang('New Session') @endif</h3>
                            </div>
                        </div>
                                                

                        <!-- Validation Errors -->
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />

                        <form class="mg-b-20" action="{{ session('seance') ? route('seances.update', session('seance')->id) : route('seances.store')}}" method="POST" >
                            @csrf
                            @if(session('seance')) @method('PATCH') @endif
                            <div class="row">
                                <x-front.form-input class="mg-t-10" span="half" label="Subject *" type="select" name="matiere" :options="getIDNomArray($matieres)" :old="session('seance') ? session('seance')->matiere->id : null" />
                                <x-front.form-input class="mg-t-10" span="half" label="Day *" type="select" name="jour" :required="true" :options="getDays()" :old="session('seance') ? session('seance')->jour : null" />
                                <x-front.form-input class="mg-t-10" span="half" label="From *" type="time" name="de" :required="true" :old="session('seance') ? session('seance')->de : null" />
                                <x-front.form-input class="mg-t-10" span="half" label="To *" type="time" name="a" :required="true" :old="session('seance') ? session('seance')->a : null" />
                                <x-front.form-input class="mg-t-10" span="full" label="ClassRoom" name="salle" :old="session('seance') ? session('seance')->salle : null" />

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

            <div class="col-12">
                <div class="card dashboard-card-twelve pd-b-20">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>@lang('Class Routine')</h3>
                            </div>
                        </div>
                        <div class="calender-wrap">
                            <div id="cr-calender" class="fc-calender"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12-xxxl col-lg-12 col-12">
            @if (count($seances) == 0)
            <x-alert 
                type='warning'
                :title="__('No Session Found')"
                icon="exclamation">
            </x-alert>
            @endif
            </div>

            <div class="col-12">
                <div class="card dashboard-card-ten">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>@lang('All Sessions')</h3>
                            </div>
                        </div>

                        <div class="mg-t-20 pd-b-30"></div>

                        <div class="table-responsive">
                            <table class="table display data-table text-nowrap">
                                <thead>
                                    <tr>
                                        <th>@lang('Day')</th>
                                        <th>@lang('From')</th>
                                        <th>@lang('To')</th>
                                        <th>@lang('Subject')</th>
                                        <th>@lang('ClassRoom')</th>
                                    @if(auth()->user()->profile === 'admin')
                                        <th class="text-center" colspan="2">@lang('Action')</th>
                                    @endif
                                    </tr>
                                </thead>
                                <tbody>
                                @php
                                    $calendar_json_data = [];
                                @endphp
                                @foreach($seances as $seance)
                                    <tr>
                                        <td>{{ getDays()[$seance->jour] }}</td>
                                        <td>{{ $seance->de }}</td>
                                        <td>{{ $seance->a }}</td>
                                        <td>{{ $seance->matiere->nom }}</td>
                                        <td>{{ $seance->salle }}</td>
                                    @if(auth()->user()->profile === 'admin')
                                        <td class="text-center"><a class="text-warning" href="{{route('seances.edit', $seance->id)}}"><i class="fas fa-pen"></i></a></td>
                                        <td class="text-center"><a class="text-danger" href="javascript:;" onclick="$('#delete_dialog .modal-body').html('@lang('Are you sure you want to delete this Session ?')'); $('#modal-submit').attr('formaction', '{{route('seances.destroy', $seance->id)}}');" data-toggle="modal" data-target="#delete_dialog"><i class="fas fa-trash"></i></a></td>
                                    @endif
                                    </tr>
                                    @php
                                    array_push($calendar_json_data, ["jour" => $seance->jour, "de" => $seance->de, "a" => $seance->a, "salle" => $seance->salle, "matiere" => $seance->matiere->nom]);
                                @endphp
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


@section('scripts')
<script>
    const cr_calender_data = {!! json_encode($calendar_json_data ?? []) !!};
    const date = new Date();
    const firstDay = new Date(date.setDate(date.getDate() - date.getDay()));
    const cr_calendar_date_format = (date, time) => date.toISOString().replace(/T.+/, '') + "T" + time + ":00";
    const cr_calendar_date_calcul = (day) => new Date(new Date(firstDay).setDate(firstDay.getDate() + day));
    const cr_calendar_events = cr_calender_data.map((data) => {
        return {
            title: data.matiere + "\n" + data.salle,
            start: cr_calendar_date_format(cr_calendar_date_calcul(parseInt(data.jour)), data.de),
            end  : cr_calendar_date_format(cr_calendar_date_calcul(parseInt(data.jour)), data.a ),
            allDay: false
        };
    });
    /*-------------------------------------
          Calender initiate 
      -------------------------------------*/
      if ($.fn.fullCalendar !== undefined) {
      $('#cr-calender').fullCalendar({
        header: {
          center: null,
          left: null,
          right: null,
        },
        allDaySlot:false,
        minTime: "08:00:00",
        maxTime: "18:00:00",
        columnHeaderFormat: "ddd",
        defaultView: 'agendaWeek',
        hiddenDays: [0],
        eventTextColor: 'white',
        displayEventEnd: true,
        timeFormat: 'HH:mm',
        fixedWeekCount: true,
        navLinks: false, // can click day/week names to navigate views
        editable: false,
        eventLimit: false, // allow "more" link when too many events
        aspectRatio: 1.6,
        events: cr_calendar_events
      });
    }
</script>
@endsection
                