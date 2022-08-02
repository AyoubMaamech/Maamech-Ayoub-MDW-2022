@extends('index')

@section('title')
@lang('All Teachers')
@endsection

@section('breadcubs')
<x-front.breadcubs title="Teachers" :path="['All Teachers']" />

@endsection
@section('dashboard-content')
                <!-- Student Table Area Start Here -->
            @if(session('ok'))
                <x-alert 
                    type='success'
                    title="{!! session('ok') !!}">
                </x-alert>
            @elseif ($teachers->count() == 0)
                <x-alert 
                    type='warning'
                    :title="__('No Teacher Found')"
                    icon="exclamation">
                </x-alert>
            @endif
                <div class="card height-auto">
                    <div class="card-body">
                        <div class="header-inline item-header">
                            <h3 class="text-dark-medium font-medium">@lang('All Teachers')</h3>
                            <div class="header-elements">
                                <ul>
                                    @if(auth()->user()->profile === 'admin')
                                    <li><a href="{{route('enseignants.create')}}" class="fw-btn-fill btn-success">@lang('ADD') <i class="fas fa-plus"></i> </a> </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <form class="mg-b-20" action="{{route('enseignants.index.filter')}}" method="POST" >
                            @csrf
                            <div class="row gutters-8">
                                <div class="col-xl-3 col-lg-3 col-12 form-group">
                                    <input type="text" name="cin" placeholder="@lang('Search by ID ...')" class="form-control">
                                </div>
                                <div class="col-xl-4 col-lg-3 col-12 form-group">
                                    <input type="text" name="nom" placeholder="@lang('Search by Name ...')" class="form-control">
                                </div>
                                <div class="col-xl-3 col-lg-3 col-12 form-group">
                                    <input type="text" name="titre" placeholder="@lang('Search by Title ...')" class="form-control">
                                </div>
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
                                        <th>@lang('Title')</th>
                                        <th>@lang('Subjects')</th>
                                        <th>@lang('E-mail')</th>
                                    @if(auth()->user()->profile === 'admin' || auth()->user()->profile === 'teacher')
                                        <th>@lang('Phone')</th>
                                        <th>@lang('Address')</th>
                                        <th></th>
                                        <th @if(auth()->user()->profile === 'admin') colspan="3" @endif>@lang('Action')</th>
                                    @endif
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($teachers as $teacher)
                                    <tr>
                                        <td class="text-center">{{ isset($teacher->cin) ? '#'.$teacher->cin : __('[ None ]') }}</td>
                                        <td class="text-center"><img src="{{ getImage($teacher) }}" alt="@lang('photo')" width="30" height="30"/></td>
                                        <td>{{ $teacher->nom() }}</td>
                                        <td class="text-center">{!! $teacher->sexe === 'F' ? '<i class="fas fa-venus" style="color:crimson"></i>' : '<i class="fas fa-mars" style="color: darkcyan"></i>' !!}</td>
                                        <td>{{ $teacher->titre }}</td>
                                        <td>{{ $teacher->matieres->count() }}</td>
                                        <td>{{ $teacher->email }}</td>
                                    @if(auth()->user()->profile === 'admin' || auth()->user()->profile === 'teacher')
                                        <td>{{ $teacher->tel }}</td>
                                        <td>{{ $teacher->adresse }}</td>
                                        <td></td>
                                        <td class="text-center"><a class="text-primary" href="{{route('enseignants.show', $teacher->id)}}"><i class="fas fa-eye"></i></a></td>
                                    @endif
                                    @if(auth()->user()->profile === 'admin')
                                        <td class="text-center"><a class="text-warning" href="{{route('enseignants.edit', $teacher->id)}}"><i class="fas fa-pen"></i></a></td>
                                        <td class="text-center"><a class="text-danger" href="#" onclick="document.getElementById('modal-submit').setAttribute('formaction', '{{route('enseignants.destroy', $teacher->id)}}');" data-toggle="modal" data-target="#delete_dialog"><i class="fas fa-trash"></i></a></td>
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
                          @lang('Are you sure you want to delete this Teacher ?')
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

                