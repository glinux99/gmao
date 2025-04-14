@extends('layouts.app')
@section('contentSubTitle')

        Gestion de la maintenance

@endsection
@section('contentTitle')
        Maintenances
@endsection
@section('content')
{{-- sss --}}
{{--  <form action="{{ route('maintenances.imports')}}" enctype="multipart/form-data" method="POST">
    @csrf
    <input type="file" name="file" id="">
    <button type="submit">Envoyer</button>
</form>  --}}

<div id="contentVue">
    <maintenance-list />
</div>
@endsection
