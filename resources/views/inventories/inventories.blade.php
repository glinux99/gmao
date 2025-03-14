@extends('layouts.app')
@section('menuTitle')
    Gestion d'utilisateurs
@endsection
@section('contentTitle')
    <li class="breadcrumb-item text-dark">
        inventaires
    </li>
@endsection

@section('content')
    <div class=" container-xxl " id="kt_content_container" data-select2-id="select2-data-kt_content_container">


        <div class="card" data-select2-id="select2-data-156-v9nn">

            <div class="card-header border-0 pt-6" data-select2-id="select2-data-155-sseq">

                <div class="card-title">

                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span class="path1"></span><span
                                class="path2"></span></i> <input type="text" data-kt-user-table-filter="search"
                            class="form-control form-control-solid w-250px ps-13" placeholder="Rechercher une  categorie">
                    </div>

                </div>



                <div class="card-toolbar" data-select2-id="select2-data-154-zqod">

                    {{-- <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">





                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_add_user">
                            <i class="ki-duotone ki-plus fs-2"></i> Nouvelle sortie de materiel
                        </button>

                    </div> --}}



                </div>

            </div>



            <div class="card-body py-4">
                <div class="row g-5 g-xl-8">
                    @php
                        $colors =['primary', 'dark', 'success', 'warning', 'danger']
                    @endphp
                    @foreach ($sorties as $i=>$sortie)
                    <div class="col-xl-4">
                        <a href="#" class="card bg-{{ $colors[rand(0,count($colors)-1)] }} hoverable card-xl-stretch mb-xl-8">
                            <!--begin::Body-->
                            <div class="card-body">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen008.svg-->
                                <span class="svg-icon svg-icon-white svg-icon-3x ms-n1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path d="M3 2H10C10.6 2 11 2.4 11 3V10C11 10.6 10.6 11 10 11H3C2.4 11 2 10.6 2 10V3C2 2.4 2.4 2 3 2Z" fill="black" />
                                        <path opacity="0.3" d="M14 2H21C21.6 2 22 2.4 22 3V10C22 10.6 21.6 11 21 11H14C13.4 11 13 10.6 13 10V3C13 2.4 13.4 2 14 2Z" fill="black" />
                                        <path opacity="0.3" d="M3 13H10C10.6 13 11 13.4 11 14V21C11 21.6 10.6 22 10 22H3C2.4 22 2 21.6 2 21V14C2 13.4 2.4 13 3 13Z" fill="black" />
                                        <path opacity="0.3" d="M14 13H21C21.6 13 22 13.4 22 14V21C22 21.6 21.6 22 21 22H14C13.4 22 13 21.6 13 21V14C13 13.4 13.4 13 14 13Z" fill="black" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                                <div class="text-light fw-bolder fs-2 mb-2 mt-5">
                                {{ $sortie->category->designation }}/  {{ $sortie->etat }}
                                </div>
                                <div class="fw-bold text-light">
                               Restant: <span class="fw-bolder">{{ $sortie->quantity_restante }}</span> {{ $sortie->category->unity->abbreviation }}
                                </div>
                            </div>
                            <!--end::Body-->
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>

    </div>
@endsection
