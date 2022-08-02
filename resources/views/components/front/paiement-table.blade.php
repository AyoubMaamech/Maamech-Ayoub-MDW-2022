@props([
    'profile' => 'student',
    'list' => [],
])
<div class="table-responsive">
    <table class="table display data-table text-nowrap">
        <thead>
            <tr>
                <th class="text-center">@lang('ID')</th>
                @if(auth()->user()->profile != 'student')<th class="text-center">@lang('Photo')</th><th>@lang('Name')</th>@endif
                <th>@lang('For')</th>
                <th>@lang('Date')</th>
                <th>@lang('Amount')</th>
                @if(auth()->user()->profile === 'admin')<th colspan="2">@lang('Action')</th>@endif
            </tr>
        </thead>
        <tbody>
        @foreach($list as $data)
            <tr>
                @if($profile === 'student') 
                <td class="text-center">{{ isset($data->etudiant->cne) ? '#'.$data->etudiant->cne : __('[ None ]') }}</td>
                @if(auth()->user()->profile != 'student')
                <td class="text-center"><img src="{{ getImage($data->etudiant) }}" alt="@lang('photo')" width="30" height="30"/></td>
                <td>{{ $data->etudiant->nom() }}</td>
                @endif
                @elseif($profile === 'teacher') 
                <td class="text-center">{{ isset($data->enseignant->cin) ? '#'.$data->enseignant->cin : __('[ None ]') }}</td>
                <td class="text-center"><img src="{{ getImage($data->enseignant) }}" alt="@lang('photo')" width="30" height="30"/></td>
                <td>{{ $data->enseignant->nom() }}</td>
                @else <td class="text-center">{{ __('[ None ]') }}</td><td></td><td></td>@endif
                <td>{{ $data->pour }}</td>
                <td>{{ $data->datePaiement() }}</td>
                <td>{{ $data->montant }} TND</td>
            @if(auth()->user()->profile === 'admin')
                <td class="text-center"><a class="text-warning" href="{{route('paiements.edit', $data->id)}}"><i class="fas fa-pen"></i></a></td>
                <td class="text-center"><a class="text-danger" href="#" onclick="document.getElementById('modal-submit').setAttribute('formaction', '{{route('paiements.destroy', $data->id)}}');" data-toggle="modal" data-target="#delete_dialog"><i class="fas fa-trash"></i></a></td>
            @endif
            </tr>
        @endforeach
        </tbody>
    </table>
</div>