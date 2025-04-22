@extends('layouts.app')
@section('contentSubTitle')
        Systeme configuration
@endsection
@section('contentTitle')
        Maps
@endsection
@section('content')
{{-- sss --}}
{{--  <form action="{{route('googlemaps.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file">
    <button type="submit">Envoyer</button>
</form>  --}}
<div id="contentVue">
    <google-maps />
</div>
@endsection
