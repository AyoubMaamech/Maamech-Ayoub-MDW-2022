@extends('index')

@section('title')
@if(auth()->user()->profile === 'student')
@lang('Classmates')
@else
@lang('All Students')
@endif
@endsection

@section('breadcubs')
<x-front.breadcubs :title="auth()->user()->profile === 'student' ? 'Classmates' : 'Students'" :path="['All Students']" />

@endsection
@section('dashboard-content')
                <!-- Student Table Area Start Here -->
            @if(session('ok'))
                <x-alert 
                    type='success'
                    title="{!! session('ok') !!}">
                </x-alert>
            @else
                @if (auth()->user()->profile === 'admin' && count($pending_students ?? []) == 0)
                <x-alert 
                    type='success'
                    :title="__('No Pending Student Found')"
                    icon="exclamation">
                </x-alert>
                @endif
                @if (count($students ?? []) == 0)
                <x-alert 
                    type='warning'
                    :title="__('No Student Found')"
                    icon="exclamation">
                </x-alert>
                @endif
            @endif
            @if(auth()->user()->profile === 'admin')
                <div class="card height-auto">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>@lang('Pending Students')</h3>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table display data-table text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">@lang('Photo')</th>
                                        <th>@lang('Name')</th>
                                        <th class="text-center">@lang('Gender')</th>
                                        <th>@lang('E-mail')</th>
                                        <th>@lang('Phone')</th>
                                        <th>@lang('Address')</th>
                                        <th>@lang('Date Of Birth')</th>
                                        <th></th>
                                        <th colspan="3">@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($pending_students as $student)
                                    <tr>
                                        <td class="text-center"><img src="{{ getImage($student) }}" alt="@lang('photo')" width="30" height="30"/></td>
                                        <td>{{ $student->nom() }}</td>
                                        <td class="text-center">{!! $student->sexe === 'F' ? '<i class="fas fa-venus" style="color:crimson"></i>' : '<i class="fas fa-mars" style="color: darkcyan"></i>' !!}</td>
                                        <td>{{ $student->email }}</td>
                                        <td>{{ $student->tel }}</td>
                                        <td>{{ $student->adresse }}</td>
                                        <td>{{ $student->dateDeNaissance() }}</td>
                                        <td></td>
                                        <td class="text-center"><a class="text-primary" href="{{route('etudiants.show', $student->id)}}"><i class="fas fa-eye"></i></a></td>
                                        <td class="text-center"><a class="text-warning" href="{{route('etudiants.edit', $student->id)}}"><i class="fas fa-pen"></i></a></td>
                                        <td class="text-center"><a class="text-danger" href="#" onclick="document.getElementById('modal-submit').setAttribute('formaction', '{{route('etudiants.destroy', $student->id)}}');" data-toggle="modal" data-target="#delete_dialog"><i class="fas fa-trash"></i></a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
                <div class="card height-auto">
                    <div class="card-body">
                        <div class="header-inline item-header">
                            <h3 class="text-dark-medium font-medium">@lang('All Students')</h3>
                            <div class="header-elements">
                                <ul>
                                    @if(auth()->user()->profile === 'admin')
                                    <li><a href="{{route('etudiants.create')}}" class="fw-btn-fill btn-success">@lang('ADD') <i class="fas fa-plus"></i> </a> </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <form class="mg-b-20" action="{{route('etudiants.index.filter')}}" method="POST" >
                            @csrf
                            <div class="row gutters-8">
                                <div class="col-xl-3 col-lg-3 col-12 form-group">
                                    <input type="text" name="cne" placeholder="@lang('Search by ID ...')" class="form-control">
                                </div>
                                <div class="col-xl-4 col-lg-3 col-12 form-group">
                                    <input type="text" name="nom" placeholder="@lang('Search by Name ...')" class="form-control">
                                </div>
                                @if(auth()->user()->profile != 'student')
                                <div class="col-xl-3 col-lg-3 col-12 form-group">
                                    <input type="text" name="classe" placeholder="@lang('Search by Class ...')" class="form-control">
                                </div>
                                @endif
                                <div class="col-xl-2 col-lg-3 col-12 form-group">
                                    <button type="submit" class="fw-btn-fill btn-gradient-yellow">@lang('SEARCH')</button>
                                </div>
                            </div>
                        </form>
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
                                @foreach($students as $student)
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
                <!-- Student Table Area End Here -->
                  
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
                          @lang('Are you sure you want to delete this Student ?')
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

                