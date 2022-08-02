@props([
    'action' => '#',
    'method' => 'post',
    'profile' => 'student',
    'old' => null,
    'filieres' => [],
    'classes' => [],
])


<form class="new-added-form" method="POST" action="{{$action}}" enctype="multipart/form-data">

    @csrf

    @if ($method === 'PATCH' || $method === 'patch' )
        @method('PATCH')
    @elseif ($method === 'PUT' || $method === 'put' )
        @method('PUT')
    @endif

    <div class="row">
@if($profile === 'student' && auth()->user()->profile === 'admin')
<x-front.form-input span="half" label="Admission ID *" name="cne" :required="true" :old="isset($old) ? $old->cne : null"/>
<x-front.form-input span="half" label="Class *" type="select" name="classe" :options="$classes" :required="true" :old="isset($old) ? (isset($old->classe) ? $old->classe->id : null) : null"/>
@endif
        <x-front.form-input  label="First Name *" name="prenom" :required="true" :old="isset($old) ? $old->prenom : null" />
        <x-front.form-input  label="Last Name *" name="nom" :required="true" :old="isset($old) ? $old->nom : null" />
        <x-front.form-input  label="Gender *" type="select" name="sexe" :options="['M' => 'Male', 'F' => 'Female']" :required="true" :old="isset($old) ? $old->sexe : null"/>
@if($profile === 'student')
        <x-front.form-input  label="Date Of Birth *" type="date" name="ddn" :placeholder="__('dd/mm/yyyy')" :required="true" :old="isset($old) ? inputFormatDate($old->dateDeNaissance()) : null"/>
@elseif($profile === 'parent')
        <x-front.form-input  label="Occupation *" name="occupation" :required="true" :old="isset($old) ? $old->occupation : null" />
@elseif($profile === 'teacher')
        <x-front.form-input  label="Title *" name="titre" :required="true" :old="isset($old) ? $old->titre : null" />
@endif
        <x-front.form-input  label="Phone *" type="phone" name="tel" :required="true" :old="isset($old) ? $old->tel : null" />
        <x-front.form-input  label="E-Mail *" type="email" name="email" :required="true" :old="isset($old) ? $old->email : auth()->user()->email" />
        <x-front.form-input  label="Address *" name="adresse" :required="true" :old="isset($old) ? $old->adresse : null" />
@if($profile === 'parent' && auth()->user()->profile === 'admin')
<x-front.form-input label="Parent ID *" name="cnp" :required="true" :old="isset($old) ? $old->cnp : null"/>
@endif
@if($profile === 'teacher')
<x-front.form-input label="National Identity Card *" name="cin" :required="true" :old="isset($old) ? $old->cin : null"/>
@endif
        <div class="col-lg-6 col-12 form-group">
            <label for="bio">@lang('Short BIO')</label>
            <textarea class="textarea form-control" name="bio" id="bio" cols="10"
                rows="9">{{ isset($old) ? $old->bio : '' }}</textarea>
        </div>
        <div class="col-lg-6 col-12 form-group mg-t-30">
            <label for="photo" class="text-dark-medium">@lang('Upload Your Photo (150px X 150px)')</label>
            <input type="file" class="form-control-file" name="photo" id="photo" accept="image/png, image/gif, image/jpeg">
@if($profile === 'teacher')
            <label for="cv" class="text-dark-medium mg-t-30">@lang('Upload Your CV')</label>
            <input type="file" class="form-control-file" name="cv" id="cv">
@endif
@if($profile === 'student')
            <label for="docs" class="text-dark-medium mg-t-30">@lang('Upload Your Documents')</label>
            <input type="file" class="form-control-file" name="docs[]" id="docs" multiple>
@endif
        </div>
        <input type="hidden" name="user" value="{{isset($old) ? $old->user->id : (auth()->user()->profile === $profile ? auth()->user()->id : null)}}" />
        <div class="col-12 form-group mg-t-8">
            <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Save</button>
            <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Reset</button>
        </div>
    </div>
</form>