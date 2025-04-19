@extends('layouts.app')
@section('contentSubTitle')

        Gestion des tâches

@endsection
@section('contentTitle')
        Tâches
@endsection
@section('content')

{{--
 <form action="{{ route('tasks.imports')}}" method="post" enctype="multipart/form-data">
    @csrf
    dddd
    <input type="file" name="file" id="">
    <button type="submit">Envoyer</button>
</form>  --}}
<div id="contentVue">
    <task-list />
</div>
@endsection
