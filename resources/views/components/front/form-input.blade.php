@props([
    'label' => '',
    'type' => 'text',
    'placeholder' => '',
    'name' => '',
    'id' => '',
    'required' => false,
    'disabled' => false,
    'old' => '',
    'options' => [],
    'usekeys' => true,
    'icon' => null,
    'span' => null,
    'class' => ''
])

@if($span === 'full')
<div class="col-xl-12 col-lg-12 col-12 form-group {{$class}}">
@elseif($span === 'half')
    <div class="col-xl-6 col-lg-6 col-12 form-group {{$class}}">
@else
<div class="col-xl-3 col-lg-6 col-12 form-group {{$class}}">
@endif
    <label @isset($id) for="{{$id}}" @endisset>@lang($label)</label>
@if ($type == 'select')
    <select class="form-control" name="{{$name}}" @isset($id) id="{{$id}}" @endisset @if($disabled) disabled @endif>
        @foreach ($options as $val => $option)
            <option value="{{$usekeys ? $val : $option}}" @if(isset($old) && $old == $val) selected @endif >@lang($option)</option>
        @endforeach
    </select>
@else
    <input type="{{$type}}" placeholder="@lang($placeholder)" name="{{$name}}" @isset($id) id="{{$id}}" @endisset @isset($old) value="{{$old}}" @endisset class="form-control" @if($required) required @endif @if($disabled) disabled @endif>
@endif

    @isset($icon)<i class="{{$icon}}"></i>@endisset
   <!--hhh ??-->
</div>