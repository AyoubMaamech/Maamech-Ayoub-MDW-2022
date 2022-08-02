@props([
    'profile' => 'student',
    'details' => null,
    'edit' => false
])


@if ($profile === 'student' && $details->cne == null)
<x-alert 
    type='warning'
    :title="__('Admission Pending, waiting for admin approval')">
</x-alert>
@endif

<div class="card height-auto">

    <div class="card-body">
        <div class="heading-layout1">
            <div class="item-title">
                <h3>@lang('About Me')</h3>
            </div>
        </div>
        <!---  ******************************************  -->
        <div class="single-info-details">
            <div class="item-img">
                <img src="{{ getImage($details) }}" alt="image">
                {{--<img src="{{ getImage($post) }}" alt="photo">--}}
            </div>
            <div class="item-content">
                <div class="header-inline item-header">
                    <h3 class="text-dark-medium font-medium">{{ $details->user->name }}</h3>
                    @if($edit)
                    <div class="header-elements">
                        <ul>
                            <li>
                            @if($profile === 'student')
                                <a href="{{ route('etudiants.edit', $details->id) }}">
                            @elseif ($profile === 'parent')
                                <a href="{{ route('parents.edit', $details->id) }}">
                            @else
                                <a href="{{ route('enseignants.edit', $details->id) }}">
                            @endif
                                <i class="far fa-edit"></i></a>
                            </li>
                            @if($profile === 'student' && auth()->user()->profile === 'parent')
                                @if($details->parent_id === auth()->user()->parent->id)
                                <li><a class="text-danger" href="javascript:;" data-toggle="modal" data-target="#unlink_dialog"><i class="fas fa-unlink"></i></a></li>
                                @endif
                            @endif
                        </ul>
                    </div>
                    @elseif($profile === 'student' && auth()->user()->profile === 'parent')
                    <div class="header-elements">
                        <ul>
                            @if($details->parent_id === auth()->user()->parent->id)
                            <li><a class="text-danger" href="javascript:;" data-toggle="modal" data-target="#unlink_dialog"><i class="fas fa-unlink"></i></a></li>
                            @endif
                        </ul>
                    </div>
                    @endif
                </div>
                <p>{{ $details->bio }}</p>
                <div class="table-responsive info-table">
                    <table class="table text-nowrap">
                        <tbody>
                            <tr>
                                <td>@lang('Name:')</td>
                                <td class="font-medium text-dark-medium">{{ $details->nom() }}</td>
                            </tr>
                            <tr>
                                <td>@lang('Gender:')</td>
                                <td class="font-medium text-dark-medium">{{ $details->sexe == 'F' ? __('Female') : __('Male') }}</td>
                            </tr>
                            @if($profile === 'parent')
                            <tr>
                                <td>@lang('Occupation:')</td>
                                <td class="font-medium text-dark-medium">{{ __($details->occupation) }}</td>
                            </tr>
                            <tr>
                                <td>@lang('ID:')</td>
                                <td class="font-medium text-dark-medium">{{ $details->cnp ?? __('[ None ]') }}</td>
                            </tr>
                            @endif
                            @if($profile === 'teacher')
                            
                            <tr>
                                <td>@lang('National Identity Card:')</td>
                                <td class="font-medium text-dark-medium">{{ $details->cin }}</td>
                            </tr>
                            <tr>
                                <td>@lang('Title:')</td>
                                <td class="font-medium text-dark-medium">{{ __($details->titre) }}</td>
                            </tr>
                            <tr>
                                <td>@lang('CV:')</td>
                                <td class="font-medium text-dark-medium"><a href="{{ getCV($details) }}" target="blank" class="__cf_email__" >@lang('Show CV')</a></td>
                            </tr>
                            <tr>
                                <td>@lang('Joining Date:')</td>
                                <td class="font-medium text-dark-medium">{{ $details->dateRejoin() }}</td>
                            </tr> 
                            <tr>
                                <td>@lang('Salary:')</td>
                                <td class="font-medium text-dark-medium">{{ $details->salaire }} TND</td>
                            </tr> 
                            @endif
                            @if($profile === 'student')
                            <tr>
                                <td>@lang('Parent Name:')</td>
                                <td class="font-medium text-dark-medium">{!! isset($details->parent) ? '<a  class="__cf_email__" href="'.route('parents.show', $details->parent_id).'" >'.$details->parent->nom().'</a>' : __("[ None ]") !!}</td>
                            </tr>
                            <tr>
                                <td>@lang('Parent ID:')</td>
                                <td class="font-medium text-dark-medium">{{ isset($details->parent) ? $details->parent->cnp : __("[ None ]") }}</td>
                            </tr>
                            <tr>
                                <td>@lang('Date Of Birth:')</td>
                                <td class="font-medium text-dark-medium">{{ $details->dateDeNaissance() }}</td>
                            </tr>
                            <tr>
                                <td>@lang('Admission Date:')</td>
                                <td class="font-medium text-dark-medium">{{ $details->dateAdmission() }}</td>
                            </tr> 
                            <tr>
                                <td>@lang('ID:')</td>
                                <td class="font-medium text-dark-medium">{{ $details->cne ?? __('[ None ]') }}</td>
                            </tr>
                            <tr>
                                @isset($details->classe) 
                                    @if($details->classe->annee == null && $details->classe->niveau == null && $details->classe->nom == null)
                                    
                                        <td>@lang('Course:')</td>
                                        <td class="font-medium text-dark-medium">{{isset($details->classe->filiere) ? $details->classe->filiere->nom : __('[ None ]')}}</td>
                                    @else
                                        <td>@lang('Class:')</td>
                                        <td class="font-medium text-dark-medium">{{ $details->classe->affichage() }} </td>
                                    @endif 
                                @else 
                                    <td>@lang('Class:')</td>
                                    <td class="font-medium text-dark-medium"> @lang('[ None ]') </td>
                                @endisset 
                            </tr>
                            @endif
                            <tr>
                                <td>@lang('Phone:')</td>
                                <td class="font-medium text-dark-medium">{{ $details->tel }}</td>
                            </tr>
                            <tr>
                                <td>@lang('E-Mail:')</td>
                                <td class="font-medium text-dark-medium">{{ $details->email }}</td>
                            </tr>
                            @if($profile != 'teacher')
                            <tr>
                                <td>@lang('Address:')</td>
                                <td class="font-medium text-dark-medium">{{ $details->adresse }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


@if($profile === 'student' && auth()->user()->profile === 'parent')
    @if($details->parent_id === auth()->user()->parent->id)
        <!-- Modal -->
        <div class="modal fade" id="unlink_dialog" tabindex="-1" role="dialog" aria-labelledby="unlinkDialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('Unlink')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                @lang('Are you sure you want to unlink this Student ?')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-fill-lg bg-blue-dark btn-hover-yellow"  data-dismiss="modal">@lang('Cancel')</button>
                    <form method="POST" action="{{route('etudiants.parent')}}" >
                        @csrf
                        <input type="hidden" name="cne" value="{{$details->cne}}" />
                        <button type="submit" id="modal-submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">@lang('Unlink')</button>
                    </form>
                </div>
            </div>
            </div>
        </div>
    @endif
@endif