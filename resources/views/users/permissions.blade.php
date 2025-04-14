@extends('layouts.app')
@section('content')

<div class="app-main flex-column flex-row-fluid" id="kt_app_main">

    <div class="d-flex flex-column flex-column-fluid">


        <div id="kt_app_toolbar" class="app-toolbar pb-3 pb-lg-6">


            <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">




                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3 ">

                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        @lang("Liste des permissions")
                    </h1>

                </div>

            </div>

        </div>



        <div id="kt_app_content" class="app-content  flex-column-fluid ">



            <div id="kt_app_content_container" class="app-container  container-xxl ">


                <div class="card card-flush ">

                    <div class="card-header mt-6">

                        <div class="card-title">

                            <div class="d-flex align-items-center position-relative my-1 me-5">
                                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span
                                        class="path1"></span><span class="path2"></span></i> <input type="text"
                                    data-kt-permissions-table-filter="search"
                                    class="form-control form-control-solid w-250px ps-13"
                                    placeholder="@lang('Rechercher une permission')" />
                            </div>

                        </div>


                    </div>



                    <div class="card-body pt-0">

                        <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0" id="kt_permissions_table">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">@lang("Nom")</th>
                                    <th class="min-w-250px">@lang("Assigne a")</th>
                                    <th class="min-w-125px">@lang("Date de creation")</th>
                                    <th class="text-end min-w-100px">@lang("Actions")</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">

                                @foreach ($permissions as $permission)
                                <tr>
                                    <td>{{ $permission->name}}</td>
                                    <td>

                                        @for($i = 0; $i < Count($permission->roles); $i++)
                                            <?php $colors =['primary', 'danger', 'success', 'info', 'warning']; $index = rand(0,
                                        Count($colors)-1);?>
                                            <a href="#" class="{{ " badge badge-light-".$colors[$index]." fs-7 m-1"
                                                }}">{{
                                                $permission->roles[$i]->name}}</a>
                                            @endfor

                                    </td>
                                    <td>
                                        {{ date('d/m/y, H:i', strtotime($permission->created_at))}} </td>
                                    <td class="text-end">
                                        <button class="btn btn-icon btn-active-light-primary w-30px h-30px me-3"
                                            data-bs-toggle="modal" data-bs-target="#kt_modal_update_permission">
                                            <i class="ki-duotone ki-setting-3 fs-3"><span class="path1"></span><span
                                                    class="path2"></span><span class="path3"></span><span
                                                    class="path4"></span><span class="path5"></span></i> </button>
                                        <button class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                            data-kt-permissions-table-filter="delete_row">
                                            <i class="ki-duotone ki-trash fs-3"><span class="path1"></span><span
                                                    class="path2"></span><span class="path3"></span><span
                                                    class="path4"></span><span class="path5"></span></i> </button>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>

                    </div>

                </div>


            </div>

        </div>

    </div>

</div>

@endsection
