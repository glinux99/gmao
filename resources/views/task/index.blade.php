@extends('layouts.app')
@section('contentSubTitle')

        Gestion des tâches

@endsection
@section('contentTitle')
        Tâches
@endsection
@section('content')
{{-- sss --}}

{{--  <form action="{{ route('task.imports')}}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" id="">
    <button type="submit">Envoyer</button>
</form>  --}}
<div id="contentVue">
    <task-list />
</div>
@endsection
