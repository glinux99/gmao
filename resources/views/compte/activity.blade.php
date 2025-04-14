@extends('layouts.app')
@section('menuTitle')
Mon compte
@endsection
@section('contentTitle')
<li class="breadcrumb-item text-dark">
    Activites </li>
@endsection
@section('content')
<div class=" container-xxl " id="kt_content_container">

    @include('compte.header')



    <div class="card">

        <div class="card-header card-header-stretch">

            <div class="card-title d-flex align-items-center">
                <i class="ki-duotone ki-calendar-8 fs-1 text-primary me-3 lh-0"><span class="path1"></span><span
                        class="path2"></span><span class="path3"></span><span class="path4"></span><span
                        class="path5"></span><span class="path6"></span></i>

                <h3 class="fw-bold m-0 text-gray-800">{{ Carbon\Carbon::now()->locale('fr')->format('d M Y') }}
                </h3>
            </div>



            <div class="card-toolbar m-0">

                <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0 fw-bold" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a id="kt_activity_today_tab"
                            class="nav-link justify-content-center text-active-gray-800 active" data-bs-toggle="tab"
                            role="tab" href="#kt_activity_today" aria-selected="true">
                            Aujourd'hui
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a id="kt_activity_week_tab" class="nav-link justify-content-center text-active-gray-800"
                            data-bs-toggle="tab" role="tab" href="#kt_activity_week" aria-selected="false"
                            tabindex="-1">
                            Semaine
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a id="kt_activity_month_tab" class="nav-link justify-content-center text-active-gray-800"
                            data-bs-toggle="tab" role="tab" href="#kt_activity_month" aria-selected="false"
                            tabindex="-1">
                            Mois
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a id="kt_activity_year_tab"
                            class="nav-link justify-content-center text-active-gray-800 text-hover-gray-800"
                            data-bs-toggle="tab" role="tab" href="#kt_activity_year" aria-selected="false"
                            tabindex="-1">
                            2023 </a>
                    </li>
                </ul>

            </div>

        </div>



        <div class="card-body">

            <div class="tab-content">

                <div id="kt_activity_today" class="card-body p-0 tab-pane fade show active" role="tabpanel"
                    aria-labelledby="kt_activity_today_tab">

                    <div class="timeline timeline-border-dashed">
                        @foreach ($activities as $activity)

                        <div class="timeline-item">

                            <div class="timeline-line"></div>



                            <div class="timeline-icon">
                                <i class="ki-duotone ki-user-edit fs-2 text-gray-500"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span></i>
                            </div>




                            <div class="timeline-content mb-10 mt-n1">

                                <div class="pe-3 mb-5">

                                    <div class="fs-5 fw-semibold mb-2">{{$activity->title}} {{$activity->id}}
                                    </div>



                                    <div class="d-flex align-items-center mt-1 fs-6">

                                        <div class="text-muted me-2 fs-7">Ajoute le {{
                                            Carbon\Carbon::parse($activity->created_at)->locale('fr')->format('d M Y')
                                            }}
                                            par</div>



                                        <div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip"
                                            data-bs-boundary="window" data-bs-placement="top"
                                            aria-label="{{$activity->user->post_name}}"
                                            data-bs-original-title="{{$activity->user->post_name}}"
                                            data-kt-initialized="1">
                                            <img src="{{ asset($activity->user->avatar)}}" alt="img">
                                        </div>

                                    </div>

                                </div>



                                <div class="overflow-auto pb-5">
                                    @if (isset(json_decode($activity->actions, true)['marque']) &&
                                    json_decode($activity->actions, true)['model'])
                                    <div
                                        class="d-flex align-items-center justify-content-between border border-dashed border-gray-300 rounded w-100 px-7 py-3 mb-5">


                                        <a href="/" class="fs-5 text-dark text-hover-primary fw-semibold">
                                            {{ $activity->actions!=null?json_decode($activity->actions,
                                            true)['model']??json_decode($activity->actions, true)['marque']?? '': ''}}
                                        </a>

                                        <div class="pe-2 ">
                                            <span class="row">
                                                <span>
                                                    Proprietaire:
                                                </span>
                                                <span class="d-flex flex-column ms-5">
                                                    <span class="badge badge-light text-muted">
                                                        {{ $activity->actions!=null?json_decode($activity->actions,
                                                        true)['name']??''.' '.json_decode($activity->actions,
                                                        true)['post_name']??'':''}}</span>
                                                    <span class="fs-8 badge badge-light text-muted mt-1">
                                                        {{$activity->actions!=null?json_decode($activity->actions,
                                                        true)['phone']??"":''}}
                                                    </span>
                                                </span>
                                            </span>

                                        </div>

                                        <div class="pe-2">
                                            <span class="badge badge-light text-muted">Plaque:
                                                {{$activity->actions!=null?json_decode($activity->actions,
                                                true)['plaque']:''}}
                                            </span>
                                        </div>



                                        <div class="pe-2">
                                            <span class="badge badge-light-success">Tache finalisee</span>
                                        </div>



                                    </div>
                                    @else
                                    <div
                                        class="d-flex align-items-center justify-content-between border border-dashed border-gray-300 rounded w-100 px-7 py-3 mb-5">


                                        <a href="/" class="fs-5 text-dark text-hover-primary fw-semibold">
                                            {{ $activity->actions!=null?json_decode($activity->actions,
                                            true)['title']??'': ''}}
                                        </a>

                                        <div class="pe-2 ">
                                            <span class="row">
                                                <span>
                                                    Description:
                                                </span>
                                                <span class="fs-8 badge badge-light text-muted mt-1">
                                                    {{$activity->actions!=null?json_decode($activity->actions,
                                                    true)['description']??"":''}}
                                                </span>
                                            </span>

                                        </div>





                                        <div class="pe-2">
                                            <span class="badge badge-light-success">Tache finalisee</span>
                                        </div>



                                    </div>
                                    @endif

                                </div>


                            </div>

                        </div>
                        @endforeach
                    </div>

                </div>



                <div id="kt_activity_week" class="card-body p-0 tab-pane fade show" role="tabpanel"
                    aria-labelledby="kt_activity_week_tab">

                    <div class="timeline timeline-border-dashed">
                        @foreach ($activitiesWeek as $activity)
                        <div class="timeline-item">

                            <div class="timeline-line"></div>



                            <div class="timeline-icon">
                                <i class="ki-duotone ki-user-edit fs-2 text-gray-500"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span></i>
                            </div>




                            <div class="timeline-content mb-10 mt-n1">

                                <div class="pe-3 mb-5">

                                    <div class="fs-5 fw-semibold mb-2">{{$activity->title}} {{$activity->id}}
                                    </div>



                                    <div class="d-flex align-items-center mt-1 fs-6">

                                        <div class="text-muted me-2 fs-7">Ajoute le {{
                                            Carbon\Carbon::parse($activity->created_at)->locale('fr')->format('d M Y')
                                            }}
                                            par</div>



                                        <div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip"
                                            data-bs-boundary="window" data-bs-placement="top"
                                            aria-label="{{$activity->user->post_name}}"
                                            data-bs-original-title="{{$activity->user->post_name}}"
                                            data-kt-initialized="1">
                                            <img src="{{ asset($activity->user->avatar)}}" alt="img">
                                        </div>

                                    </div>

                                </div>



                                <div class="overflow-auto pb-5">
                                    @if (isset(json_decode($activity->actions, true)['marque']) &&
                                    json_decode($activity->actions, true)['model'])
                                    <div
                                        class="d-flex align-items-center justify-content-between border border-dashed border-gray-300 rounded w-100 px-7 py-3 mb-5">


                                        <a href="/" class="fs-5 text-dark text-hover-primary fw-semibold">
                                            {{ $activity->actions!=null?json_decode($activity->actions,
                                            true)['model']??json_decode($activity->actions, true)['marque']?? '': ''}}
                                        </a>

                                        <div class="pe-2 ">
                                            <span class="row">
                                                <span>
                                                    Proprietaire:
                                                </span>
                                                <span class="d-flex flex-column ms-5">
                                                    <span class="badge badge-light text-muted">
                                                        {{ $activity->actions!=null?json_decode($activity->actions,
                                                        true)['name']??''.' '.json_decode($activity->actions,
                                                        true)['post_name']??'':''}}</span>
                                                    <span class="fs-8 badge badge-light text-muted mt-1">
                                                        {{$activity->actions!=null?json_decode($activity->actions,
                                                        true)['phone']??"":''}}
                                                    </span>
                                                </span>
                                            </span>

                                        </div>

                                        <div class="pe-2">
                                            <span class="badge badge-light text-muted">Plaque:
                                                {{$activity->actions!=null?json_decode($activity->actions,
                                                true)['plaque']:''}}
                                            </span>
                                        </div>



                                        <div class="pe-2">
                                            <span class="badge badge-light-success">Tache finalisee</span>
                                        </div>



                                    </div>
                                    @else
                                    <div
                                        class="d-flex align-items-center justify-content-between border border-dashed border-gray-300 rounded w-100 px-7 py-3 mb-5">


                                        <a href="/" class="fs-5 text-dark text-hover-primary fw-semibold">
                                            {{ $activity->actions!=null?json_decode($activity->actions,
                                            true)['title']??'': ''}}
                                        </a>

                                        <div class="pe-2 ">
                                            <span class="row">
                                                <span>
                                                    Description:
                                                </span>
                                                <span class="fs-8 badge badge-light text-muted mt-1">
                                                    {{$activity->actions!=null?json_decode($activity->actions,
                                                    true)['description']??"":''}}
                                                </span>
                                            </span>

                                        </div>





                                        <div class="pe-2">
                                            <span class="badge badge-light-success">Tache finalisee</span>
                                        </div>



                                    </div>
                                    @endif

                                </div>


                            </div>

                        </div>
                        @endforeach
                    </div>

                </div>



                <div id="kt_activity_month" class="card-body p-0 tab-pane fade show" role="tabpanel"
                    aria-labelledby="kt_activity_month_tab">

                    <div class="timeline timeline-border-dashed">
                        @foreach ($activitiesMonth as $activity)
                        <div class="timeline-item">

                            <div class="timeline-line"></div>



                            <div class="timeline-icon">
                                <i class="ki-duotone ki-user-edit fs-2 text-gray-500"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span></i>
                            </div>




                            <div class="timeline-content mb-10 mt-n1">

                                <div class="pe-3 mb-5">

                                    <div class="fs-5 fw-semibold mb-2">{{$activity->title}} {{$activity->id}}
                                    </div>



                                    <div class="d-flex align-items-center mt-1 fs-6">

                                        <div class="text-muted me-2 fs-7">Ajoute le {{
                                            Carbon\Carbon::parse($activity->created_at)->locale('fr')->format('d M Y')
                                            }}
                                            par</div>



                                        <div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip"
                                            data-bs-boundary="window" data-bs-placement="top"
                                            aria-label="{{$activity->user->post_name}}"
                                            data-bs-original-title="{{$activity->user->post_name}}"
                                            data-kt-initialized="1">
                                            <img src="{{ asset($activity->user->avatar)}}" alt="img">
                                        </div>

                                    </div>

                                </div>



                                <div class="overflow-auto pb-5">
                                    @if (isset(json_decode($activity->actions, true)['marque']) &&
                                    json_decode($activity->actions, true)['model'])
                                    <div
                                        class="d-flex align-items-center justify-content-between border border-dashed border-gray-300 rounded w-100 px-7 py-3 mb-5">


                                        <a href="/" class="fs-5 text-dark text-hover-primary fw-semibold">
                                            {{ $activity->actions!=null?json_decode($activity->actions,
                                            true)['model']??json_decode($activity->actions, true)['marque']?? '': ''}}
                                        </a>

                                        <div class="pe-2 ">
                                            <span class="row">
                                                <span>
                                                    Proprietaire:
                                                </span>
                                                <span class="d-flex flex-column ms-5">
                                                    <span class="badge badge-light text-muted">
                                                        {{ $activity->actions!=null?json_decode($activity->actions,
                                                        true)['name']??''.' '.json_decode($activity->actions,
                                                        true)['post_name']??'':''}}</span>
                                                    <span class="fs-8 badge badge-light text-muted mt-1">
                                                        {{$activity->actions!=null?json_decode($activity->actions,
                                                        true)['phone']??"":''}}
                                                    </span>
                                                </span>
                                            </span>

                                        </div>

                                        <div class="pe-2">
                                            <span class="badge badge-light text-muted">Plaque:
                                                {{$activity->actions!=null?json_decode($activity->actions,
                                                true)['plaque']:''}}
                                            </span>
                                        </div>



                                        <div class="pe-2">
                                            <span class="badge badge-light-success">Tache finalisee</span>
                                        </div>



                                    </div>
                                    @else
                                    <div
                                        class="d-flex align-items-center justify-content-between border border-dashed border-gray-300 rounded w-100 px-7 py-3 mb-5">


                                        <a href="/" class="fs-5 text-dark text-hover-primary fw-semibold">
                                            {{ $activity->actions!=null?json_decode($activity->actions,
                                            true)['title']??'': ''}}
                                        </a>

                                        <div class="pe-2 ">
                                            <span class="row">
                                                <span>
                                                    Description:
                                                </span>
                                                <span class="fs-8 badge badge-light text-muted mt-1">
                                                    {{$activity->actions!=null?json_decode($activity->actions,
                                                    true)['description']??"":''}}
                                                </span>
                                            </span>

                                        </div>





                                        <div class="pe-2">
                                            <span class="badge badge-light-success">Tache finalisee</span>
                                        </div>



                                    </div>
                                    @endif

                                </div>


                            </div>

                        </div>
                        @endforeach
                    </div>

                </div>



                <div id="kt_activity_year" class="card-body p-0 tab-pane fade show" role="tabpanel"
                    aria-labelledby="kt_activity_year_tab">

                    <div class="timeline timeline-border-dashed">
                        @foreach ($activitiesYear as $activity)

                        <div class="timeline-item">

                            <div class="timeline-line"></div>



                            <div class="timeline-icon">
                                <i class="ki-duotone ki-user-edit fs-2 text-gray-500"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span></i>
                            </div>




                            <div class="timeline-content mb-10 mt-n1">

                                <div class="pe-3 mb-5">

                                    <div class="fs-5 fw-semibold mb-2">{{$activity->title}} {{$activity->id}}
                                    </div>



                                    <div class="d-flex align-items-center mt-1 fs-6">

                                        <div class="text-muted me-2 fs-7">Ajoute le {{
                                            Carbon\Carbon::parse($activity->created_at)->locale('fr')->format('d M Y')
                                            }}
                                            par</div>



                                        <div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip"
                                            data-bs-boundary="window" data-bs-placement="top"
                                            aria-label="{{$activity->user->post_name}}"
                                            data-bs-original-title="{{$activity->user->post_name}}"
                                            data-kt-initialized="1">
                                            <img src="{{ asset($activity->user->avatar)}}" alt="img">
                                        </div>

                                    </div>

                                </div>



                                <div class="overflow-auto pb-5">

                                    @if (isset(json_decode($activity->actions, true)['marque']) &&
                                    json_decode($activity->actions, true)['model'])
                                    <div
                                        class="d-flex align-items-center justify-content-between border border-dashed border-gray-300 rounded w-100 px-7 py-3 mb-5">


                                        <a href="/" class="fs-5 text-dark text-hover-primary fw-semibold">
                                            {{ $activity->actions!=null?json_decode($activity->actions,
                                            true)['model']??json_decode($activity->actions, true)['marque']?? '': ''}}
                                        </a>

                                        <div class="pe-2 ">
                                            <span class="row">
                                                <span>
                                                    Proprietaire:
                                                </span>
                                                <span class="d-flex flex-column ms-5">
                                                    <span class="badge badge-light text-muted">
                                                        {{ $activity->actions!=null?json_decode($activity->actions,
                                                        true)['name']??''.' '.json_decode($activity->actions,
                                                        true)['post_name']??'':''}}</span>
                                                    <span class="fs-8 badge badge-light text-muted mt-1">
                                                        {{$activity->actions!=null?json_decode($activity->actions,
                                                        true)['phone']??"":''}}
                                                    </span>
                                                </span>
                                            </span>

                                        </div>

                                        <div class="pe-2">
                                            <span class="badge badge-light text-muted">Plaque:
                                                {{$activity->actions!=null?json_decode($activity->actions,
                                                true)['plaque']:''}}
                                            </span>
                                        </div>



                                        <div class="pe-2">
                                            <span class="badge badge-light-success">Tache finalisee</span>
                                        </div>



                                    </div>
                                    @else
                                    <div
                                        class="d-flex align-items-center justify-content-between border border-dashed border-gray-300 rounded w-100 px-7 py-3 mb-5">


                                        <a href="/" class="fs-5 text-dark text-hover-primary fw-semibold">
                                            {{ $activity->actions!=null?json_decode($activity->actions,
                                            true)['title']??'': ''}}
                                        </a>

                                        <div class="pe-2 ">
                                            <span class="row">
                                                <span>
                                                    Description:
                                                </span>
                                                <span class="fs-8 badge badge-light text-muted mt-1">
                                                    {{$activity->actions!=null?json_decode($activity->actions,
                                                    true)['description']??"":''}}
                                                </span>
                                            </span>

                                        </div>





                                        <div class="pe-2">
                                            <span class="badge badge-light-success">Tache finalisee</span>
                                        </div>



                                    </div>
                                    @endif

                                </div>


                            </div>

                        </div>
                        @endforeach
                    </div>

                </div>

            </div>

        </div>


    </div>
    @endsection
