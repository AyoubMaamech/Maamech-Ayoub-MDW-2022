@extends('index')

@section('title')
@lang('Acconunt')
@endsection

@section('breadcubs')
<x-front.breadcubs :title="$profile === 'student' ? 'Fees Collection' : 'Teacher Payments'" :path="['All Payments']" />

@endsection
@section('dashboard-content')
                <!-- Student Table Area Start Here -->
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
            @elseif (count($paiements ?? []) == 0)
                <x-alert 
                    type='warning'
                    :title="__('No Payment Found')"
                    icon="exclamation">
                </x-alert>
            @endif

                @if(auth()->user()->profile === 'admin')
                <x-front.paiement-form :profile="$profile" :data="session('paiement') ? session()->get('paiement') : null" :edit="session('paiement') ? true : false" />
                @endif

                <div class="card height-auto">
                    <div class="card-body">
                        <div class="heading-layout1">
                            <div class="item-title">
                                <h3>@lang('All Payments')</h3>
                            </div>
                        </div>
                        <div class="mg-t-20 pd-b-40"></div>
                        
                        <x-front.paiement-table :profile="$profile" :list="$paiements ?? []" />
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
                          @lang('Are you sure you want to delete this Payment ?')
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

                