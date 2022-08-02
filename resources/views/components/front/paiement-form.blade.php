@props([
    'profile' => 'student',
    'data' => null,
    'edit' => false,
])

<!-- Add Expense Area Start Here -->
<div class="card  dashboard-card-twelve">
    <div class="card-body">
        <div class="heading-layout1">
            <div class="item-title">
                <h3>@if($edit) @lang('Edit Payment') @else @lang('Add Payment') @endif </h3>
            </div>
        </div>
        <form class="new-added-form" method="POST" action="{{$edit ? route('paiements.update', $data->id) : route('paiements.store')}}">

            @csrf

            @if($edit) @method('PATCH') @endif

            <div class="row">
            @if($profile === 'student')
                <x-front.form-input label="Student" placeholder="cne" name="cne" :required="true" :old="isset($data) ? $data->etudiant->cne : old('cne') ?? null"/>
            @elseif($profile === 'teacher')
                <x-front.form-input label="Teacher" placeholder="cin" name="cin" :required="true" :old="isset($data) ? $data->enseignant->cin : old('cin') ?? null"/>
            @endif
                <x-front.form-input label="For" placeholder="month(s)" name="pour" :required="true" :old="isset($data) ? $data->pour : old('pour') ?? null"/>
                <x-front.form-input label="Amount" placeholder="500.000" name="montant" :required="true" :old="isset($data) ? $data->montant : old('montant') ?? null"/>
                <x-front.form-input label="Date" type="date" placeholder="dd/mm/yyyy" name="date_paiement" :required="true" :old="isset($data) ? inputFormatDate($data->datePaiement()) : old('date_paiement') ?? null"/>
                
                <div class="col-12 form-group mg-t-8">
                    <button type="submit" class="btn-fill-lg btn-gradient-yellow btn-hover-bluedark">Save</button>
                    <button type="reset" class="btn-fill-lg bg-blue-dark btn-hover-yellow">Reset</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- Add Expense Area End Here -->