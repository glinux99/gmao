@extends('layouts.app')
@section('contentTitle')
        Dashboard
@endsection
@section('content')
<div id="contentVue">
    <dashboard
        :maintenance-buget="{{ $maintenanceBuget }}"
        :techniciens="{{ $techniciens }}"
        :mouvements="{{ $mouvements }}"
        :months="{{ json_encode($months) }}"
        :weeks="{{ json_encode($weeks) }}"
        :days="{{ json_encode($days) }}"
        :is-technician="{{ json_encode(auth()->user()->hasRole('technicien')) }}"
        :can-view-tasks-graph="{{ json_encode(auth()->user()->can('tasksGraph')) }}"
    ></dashboard>
</div>
@endsection
