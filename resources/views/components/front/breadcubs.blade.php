@props([
    'title' => 'Home',
    'path' => []
])

<div class="breadcrumbs-area">
    <h3>@lang($title)</h3>
    <ul>
        <li>
            <a href="{{route('home')}}">@lang('Home')</a>
        </li>
        @foreach ($path as $key => $item)
            <li> @if (isAssociative($path)) <a href="{{$key}}">@lang($item)</a> @else @lang($item) @endif </li>
        @endforeach
    </ul>
</div>  