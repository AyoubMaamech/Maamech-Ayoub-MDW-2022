@props([
    'action' => '#',
    'method' => 'post',
    'profile' => 'student',
    'old' => null,
    'filieres' => [],
    'classes' => [],
])


<form class="mg-b-20" action="{{route('parents.index.filter')}}" method="POST" >
    @csrf
    <div class="row gutters-8">
        <div class="col-3-xxxl col-xl-3 col-lg-3 col-12 form-group">
            <input type="text" name="cnp" placeholder="@lang('Search by ID ...')" class="form-control">
        </div>
        <div class="col-4-xxxl col-xl-4 col-lg-3 col-12 form-group">
            <input type="text" name="nom" placeholder="@lang('Search by Name ...')" class="form-control">
        </div>
        <div class="col-4-xxxl col-xl-3 col-lg-3 col-12 form-group">
            <input type="text" name="etudiant" placeholder="@lang('Search by Kid ...')" class="form-control">
        </div>
        <div class="col-1-xxxl col-xl-2 col-lg-3 col-12 form-group">
            <button type="submit" class="fw-btn-fill btn-gradient-yellow" style="width:auto;">@lang('SEARCH')</button>
        </div>
    </div>
</form>