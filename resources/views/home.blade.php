@extends('layouts.app')
@section('contentTitle')
        Dashboard
@endsection
@section('content')
<!--begin::Row-->
<div class=" container-xxl " id="kt_content_container" data-select2-id="select2-data-kt_content_container">
<div class="row g-5 g-xl-8">
    @hasrole('technicien')
            @else
    <div class="col-xl-4">
        <!--begin::Statistics Widget 5-->
        <a href="#" class="card bg-body-white hoverable card-xl-stretch mb-xl-8">
            <!--begin::Body-->

            <div class="card-body">
                <i class="ki-duotone ki-chart text-muted display-3"><span class="path1"></span><span
                    class="path2"></span></i>
                <div class="text-gray-900 fw-bolder fs-2 mb-2 mt-5">Prévision bugétaire</div>
                <div class="d-flex justify-content-between align-items-center">
                   <div class="col-6">
                    <span class="fw-bold text-danger fs-2"> {{$maintenanceBuget}} USD</span>
                   </div>
                   <div class="col-6">
                    {{--  @if($maintenanceRealise)
                    <span class="badge badge-light-success" v-if="false">
                        {{ number_format(($maintenanceRealise*100/$maintenanceBuget), 2)}} % réalisé
                    </span>
                    @endif
                    @if($maintenanceCancel)
                    <span class="badge badge-light-dark" v-if="false">
                        {{ number_format(($maintenanceCancel*100/$maintenanceBuget), 2)}} % annulé
                    </span>
                    @endif  --}}

                   </div>
                </div>
            </div>

            <!--end::Body-->
        </a>
        <!--end::Statistics Widget 5-->
    </div>
    @endrole
    <div class="col-xl-4">
        <!--begin::Statistics Widget 5-->
        <a href="#" class="card bg-primary hoverable card-xl-stretch mb-xl-8">
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
                <div class="text-white fw-bolder fs-2 mb-2 mt-5">
                    <span class="fs-1">
                        {{$techniciens}}
                    </span>
                    Techniciens</div>
                <div class="fw-bold text-white">Techniciens enregistrés</div>
            </div>
            <!--end::Body-->
        </a>
        <!--end::Statistics Widget 5-->
    </div>
    <div class="col-xl-4">
        <!--begin::Statistics Widget 5-->
        <a href="#" class="card bg-dark hoverable card-xl-stretch mb-5 mb-xl-8">
            <!--begin::Body-->
            <div class="card-body">
                <!--begin::Svg Icon | path: icons/duotune/arrows/arr070.svg-->
                <span class="svg-icon svg-icon-gray-100 svg-icon-3x ms-n1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect x="8" y="9" width="3" height="10" rx="1.5" fill="black" />
                        <rect opacity="0.5" x="13" y="5" width="3" height="14" rx="1.5" fill="black" />
                        <rect x="18" y="11" width="3" height="8" rx="1.5" fill="black" />
                        <rect x="3" y="13" width="3" height="6" rx="1.5" fill="black" />
                    </svg>
                </span>
                <!--end::Svg Icon-->
                <div class="text-gray-100 fw-bolder fs-2 mb-2 mt-5">
                    {{ $mouvements}} Mouvements</div>
                <div class="fw-bold text-gray-100">
                    Statistiques
                </div>
            </div>
            <!--end::Body-->
        </a>
        <!--end::Statistics Widget 5-->
    </div>
</div>
<!--end::Row-->
@can('tasksGraph')
<div class="card mb-3">
    <div class="card-header border-0 pt-5">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bolder fs-3 mb-1">Taches</span>
            <span class="text-muted mt-1 fw-bold fs-7">Informations sur les taches en cours</span>
        </h3>
        {{-- <div class="card-toolbar">
            <ul class="nav">
                <li class="nav-item">
                    <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-dark active fw-bolder px-4 me-1" data-bs-toggle="tab" href="#kt_table_widget_5_tab_1">Mensuel</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-dark fw-bolder px-4 me-1" data-bs-toggle="tab" href="#kt_table_widget_5_tab_2">Semaine</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-dark fw-bolder px-4" data-bs-toggle="tab" href="#kt_table_widget_5_tab_3">Journaliere</a>
                </li>
            </ul>
        </div> --}}
    </div>

    <div id="contentVue">
        <task-chart/>
    </div>
</div>
@endcan
<!--begin::Row-->
<div class="row g-5 g-xl-8">
    <!--begin::Col-->
    <div class="col-xl-12">
        <!--begin::Tables Widget 5-->
        <div class="card card-xl-stretch mb-5 mb-xl-8">
            <!--begin::Header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder fs-3 mb-1">Derniers
                        mouvements</span>
                    <span class="text-muted mt-1 fw-bold fs-7">Materiels</span>
                </h3>
                <div class="card-toolbar">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-dark active fw-bolder px-4 me-1" data-bs-toggle="tab" href="#kt_table_widget_5_tab_1">Mensuel</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-dark fw-bolder px-4 me-1" data-bs-toggle="tab" href="#kt_table_widget_5_tab_2">Semaine</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn btn-sm btn-color-muted btn-active btn-active-dark fw-bolder px-4" data-bs-toggle="tab" href="#kt_table_widget_5_tab_3">Journaliere</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body py-3">
                <div class="tab-content">
                    <!--begin::Tap pane-->
                    <div class="tab-pane fade show active" id="kt_table_widget_5_tab_1">
                        <!--begin::Table container-->
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table table-row-dashed table-row-gray-200 align-middle gs-0 gy-4">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="border-0">
                                        <th class="p-0 w-50px"></th>
                                        <th class="p-0 min-w-150px"></th>
                                        <th class="p-0 min-w-140px"></th>
                                        <th class="p-0 min-w-110px"></th>
                                        <th class="p-0 min-w-50px"></th>
                                    </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody>
                                    @foreach ($months as $month)
                                    <tr>
                                        <td>
                                            <div class="symbol symbol-45px me-2">
                                                <span class="symbol-label">
                                                    <img src="{{ asset($month->category->avatar ?? "/assets/media/svg/brand-logos/plurk.svg")}}" class="h-50 align-self-center" alt="" />
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="#" class="text-dark fw-bolder text-hover-primary mb-1 fs-6">
                                                {{ $month->category->designation }}
                                            </a>
                                            <span class="text-muted fw-bold d-block">
                                                {{ $month->demandeur->name }}
                                            </span>
                                        </td>
                                        <td class="text-end text-muted fw-bold">
                                            {{ $month->quantity }} {{ $month->category->unity->designation ?? "" }}
                                        </td>
                                        <td class="text-end">
                                            <span class="badge badge-light-success">
                                                {{ $month->etat }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary">
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                                <span class="svg-icon svg-icon-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="black" />
                                                        <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="black" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <!--end::Table body-->
                            </table>
                        </div>
                        <!--end::Table-->
                    </div>
                    <!--end::Tap pane-->
                    <!--begin::Tap pane-->
                    <div class="tab-pane fade" id="kt_table_widget_5_tab_2">
                        <!--begin::Table container-->
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table table-row-dashed table-row-gray-200 align-middle gs-0 gy-4">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="border-0">
                                        <th class="p-0 w-50px"></th>
                                        <th class="p-0 min-w-150px"></th>
                                        <th class="p-0 min-w-140px"></th>
                                        <th class="p-0 min-w-110px"></th>
                                        <th class="p-0 min-w-50px"></th>
                                    </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody>
                                    @foreach ($weeks as $month)
                                    <tr>
                                        <td>
                                            <div class="symbol symbol-45px me-2">
                                                <span class="symbol-label">
                                                    <img src="{{ asset($month->category->avatar ?? "/assets/media/svg/brand-logos/plurk.svg")}}" class="h-50 align-self-center" alt="" />
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="#" class="text-dark fw-bolder text-hover-primary mb-1 fs-6">
                                                {{ $month->category->designation }}
                                            </a>
                                            <span class="text-muted fw-bold d-block">
                                                {{ $month->demandeur->name }}
                                            </span>
                                        </td>
                                        <td class="text-end text-muted fw-bold">
                                            {{ $month->quantity }} {{ $month->category->unity->designation ?? "" }}
                                        </td>
                                        <td class="text-end">
                                            <span class="badge badge-light-success">
                                                {{ $month->etat }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary">
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                                <span class="svg-icon svg-icon-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="black" />
                                                        <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="black" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <!--end::Table body-->
                            </table>
                        </div>
                        <!--end::Table-->
                    </div>
                    <!--end::Tap pane-->
                    <!--begin::Tap pane-->
                    <div class="tab-pane fade" id="kt_table_widget_5_tab_3">
                        <!--begin::Table container-->
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table table-row-dashed table-row-gray-200 align-middle gs-0 gy-4">
                                <!--begin::Table head-->
                                <thead>
                                    <tr class="border-0">
                                        <th class="p-0 w-50px"></th>
                                        <th class="p-0 min-w-150px"></th>
                                        <th class="p-0 min-w-140px"></th>
                                        <th class="p-0 min-w-110px"></th>
                                        <th class="p-0 min-w-50px"></th>
                                    </tr>
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody>
                                    @foreach ($days as $month)
                                    <tr>
                                        <td>
                                            <div class="symbol symbol-45px me-2">
                                                <span class="symbol-label">
                                                    <img src="{{ asset($month->category->avatar ?? "/assets/media/svg/brand-logos/plurk.svg")}}" class="h-50 align-self-center" alt="" />
                                                </span>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="#" class="text-dark fw-bolder text-hover-primary mb-1 fs-6">
                                                {{ $month->category->designation }}
                                            </a>
                                            <span class="text-muted fw-bold d-block">
                                                {{ $month->demandeur->name }}
                                            </span>
                                        </td>
                                        <td class="text-end text-muted fw-bold">
                                            {{ $month->quantity }} {{ $month->category->unity->designation ?? "" }}
                                        </td>
                                        <td class="text-end">
                                            <span class="badge badge-light-success">
                                                {{ $month->etat }}
                                            </span>
                                        </td>
                                        <td class="text-end">
                                            <a href="#" class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary">
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                                                <span class="svg-icon svg-icon-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="black" />
                                                        <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="black" />
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <!--end::Table body-->
                            </table>
                        </div>
                        <!--end::Table-->
                    </div>
                    <!--end::Tap pane-->
                </div>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Tables Widget 5-->
    </div>
    <!--end::Col-->
</div>
<!--end::Row-->
</div>
@endsection
