@extends('layouts.app')
@section('menuTitle')
Mon compte
@endsection
@section('contentTitle')
<li class="breadcrumb-item text-dark">
    Logs </li>
@endsection
@section('content')
<div class=" container-xxl " id="kt_content_container">


    @include('compte.header')
    <!--end::Navbar-->
    <div class="card mb-5 mb-lg-10">
        <!--begin::Card header-->
        <div class="card-header">
            <!--begin::Heading-->
            <div class="card-title">
                <h3>Sessions de connexion</h3>
            </div>
            <!--end::Heading-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body p-0">
            <!--begin::Table wrapper-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table class="table align-middle table-row-bordered table-row-solid gy-4 gs-9">
                    <!--begin::Thead-->
                    <thead class="border-gray-200 fs-5 fw-semibold bg-lighten">
                        <tr>
                            <th class="min-w-150px">Localisation</th>
                            <th class="min-w-100px">Status</th>
                            <th class="min-w-150px">Appareil</th>
                            <th class="min-w-150px">Adresse IP</th>
                            <th class="min-w-150px">Durée</th>
                        </tr>
                    </thead>
                    <!--end::Thead-->

                    <!--begin::Tbody-->
                    <tbody class="fw-6 fw-semibold text-gray-600">
                        @foreach ($logs as $index =>$log)
                        <tr>
                            <td>
                                <a href="#" class="text-hover-primary text-gray-600">RDC, Goma</a>
                            </td>

                            <td>
                                <span class="badge badge-light-success fs-7 fw-bold">


                                    @if (($index+1) == $logs->count())
                                    <div class="badge badge-light fw-bold position-relative">
                                        <span
                                            class="z-index-3 bullet bullet-dot bg-success h-6px w-6px position-absolute translate-start top-0 start-100 animation-blink"></span>
                                        Session en cours
                                    </div>
                                    @else
                                    Session fermée
                                    @endif
                                </span>
                            </td>

                            <td>
                                {{ $log->navigator}} - {{ $log->appareil}}
                            </td>

                            <td> {{ $log->ip}}</td>

                            <td>{{(now()->diffForHumans($log->updated_at))}} </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <!--end::Tbody-->
                </table>
                <!--end::Table-->
            </div>
            <!--end::Table wrapper-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Timeline-->
</div>
@endsection
