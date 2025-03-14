@extends('layouts.app')
@section('menuTitle')
Gestion d'utilisateurs
@endsection
@section('contentTitle')
<li class="breadcrumb-item text-dark">
    Techniciens </li>
@endsection

@section('content')
<div class=" container-xxl " id="kt_content_container" data-select2-id="select2-data-kt_content_container">


    <div class="card" data-select2-id="select2-data-156-v9nn">

        <div class="card-header border-0 pt-6" data-select2-id="select2-data-155-sseq">

            <div class="card-title">

                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span class="path1"></span><span
                            class="path2"></span></i> <input type="text" data-kt-user-table-filter="search"
                        class="form-control form-control-solid w-250px ps-13" placeholder="Rechercher un technicien">
                </div>

            </div>



            <div class="card-toolbar" data-select2-id="select2-data-154-zqod">

                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">





                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_add_user">
                        <i class="ki-duotone ki-plus fs-2"></i> Ajouter un technicien
                    </button>

                </div>



                {{-- <div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
                    <div class="fw-bold me-5">
                        <span class="me-2" data-kt-user-table-select="selected_count"></span> Selectionnee(s)
                    </div>

                    <button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">
                        Supprimer la selection
                    </button>
                </div> --}}





                <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">

                    <div class="modal-dialog modal-dialog-centered mw-850px">

                        <div class="modal-content">

                            <div class="modal-header" id="kt_modal_add_user_header">

                                <h2 class="fw-bold">Ajouter un technicien</h2>



                                <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                   data-bs-dismiss="modal">
                                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                            class="path2"></span></i>
                                </div>

                            </div>



                            <div class="modal-body px-5 my-7">

                                <form id="" method="POST"
                                    class="form fv-plugins-bootstrap5 fv-plugins-framework"
                                    action="{{ route('technicians.store')}}">
                                    @csrf
                                    <div class="d-flex flex-column scroll-y px-5 px-lg-10"
                                        id="kt_modal_add_user_scroll" data-kt-scroll="true"
                                        data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                                        data-kt-scroll-dependencies="#kt_modal_add_user_header"
                                        data-kt-scroll-wrappers="#kt_modal_add_user_scroll"
                                        data-kt-scroll-offset="300px" style="max-height: 269px;">

                                        <div class="fv-row mb-7">

                                            <label class="d-block fw-semibold fs-6 mb-5">Photo</label>




                                            <style>
                                                .image-input-placeholder {
                                                    background-image: url('../../../assets/media/svg/files/blank-image.svg');
                                                }

                                                [data-bs-theme="dark"] .image-input-placeholder {
                                                    background-image: url('../../../assets/media/svg/files/blank-image-dark.svg');
                                                }
                                            </style>


                                            <div class="image-input image-input-outline image-input-placeholder"
                                                data-kt-image-input="true">

                                                <div class="image-input-wrapper w-125px h-125px"
                                                    style="background-image: url({{asset(Auth::user()->avatar)}});">
                                                </div>



                                                <label
                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                    aria-label="Change avatar" data-bs-original-title="Change avatar"
                                                    data-kt-initialized="1">
                                                    <i class="ki-duotone ki-pencil fs-7"><span
                                                            class="path1"></span><span class="path2"></span></i>

                                                    <input type="file" name="avatar" accept=".png, .jpg, .jpeg">
                                                    <input type="hidden" name="avatar_remove">
                                                    <input type="text" name="type" value="technician" hidden>

                                                </label>



                                                <span
                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                    aria-label="Cancel avatar" data-bs-original-title="Cancel avatar"
                                                    data-kt-initialized="1">
                                                    <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span
                                                            class="path2"></span></i> </span>



                                                <span
                                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                                    aria-label="Remove avatar" data-bs-original-title="Remove avatar"
                                                    data-kt-initialized="1">
                                                    <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span
                                                            class="path2"></span></i> </span>

                                            </div>



                                            <div class="form-text">Allowed file types: png, jpg, jpeg.</div>

                                        </div>
                                        <div class="row">
                                            <div class="fv-row mb-7 fv-plugins-icon-container col-md-6 col-md-6">

                                                <label class="required fw-semibold fs-6 mb-2">Nom</label>



                                                <input type="text" name="name"
                                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="name"
                                                    value="">

                                                <div
                                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                </div>
                                            </div>
                                            <div class="fv-row mb-7 fv-plugins-icon-container col-md-6">

                                                <label class="required fw-semibold fs-6 mb-2">Prenom</label>



                                                <input type="text" name="post_name"
                                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="name"
                                                    value="">

                                                <div
                                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                </div>
                                            </div>

                                            <div class="fv-row mb-7 fv-plugins-icon-container col-md-6">

                                                <label class="required fw-semibold fs-6 mb-2">Telephone</label>



                                                <input type="tel" name="number"
                                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="+243970912428"
                                                    value="">

                                                <div
                                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                </div>
                                            </div>

                                            <div class="fv-row mb-7 fv-plugins-icon-container col-md-6">

                                                <label class="required fw-semibold fs-6 mb-2">Email</label>



                                                <input type="email" name="email"
                                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                                    placeholder="example@domain.com" value="">

                                                <div
                                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                </div>
                                            </div>
                                            <div class="fv-row mb-7 fv-plugins-icon-container col-md-6">

                                                <label class="required fw-semibold fs-6 mb-2">Mot de passe</label>



                                                <div class="fv-row mb-3" data-kt-password-meter="true">
                                                    <div class="position-relative">
                                                        <input type="password" placeholder="Password" name="password" autocomplete="off"
                                                            class="form-control bg-transparent" />

                                                        <span class="btn btn-sm btn-icon text-white position-absolute translate-middle top-50 end-0 me-n2"
                                                            data-kt-password-meter-control="visibility">
                                                            <i class="ki-duotone ki-eye-slash fs-1"><span class="path1"></span><span
                                                                    class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                                            <i class="ki-duotone ki-eye d-none fs-1"><span class="path1"></span><span
                                                                    class="path2"></span><span class="path3"></span></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="fv-row mb-7 fv-plugins-icon-container col-md-6">

                                                <label class="required fw-semibold fs-6 mb-2">Departement</label>



                                                <input type="tel" name="departement"
                                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Ex" value="Exploitation" readonly
                                                    value="">

                                                <div
                                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                </div>
                                            </div>
                                            <div class="fv-row mb-7 fv-plugins-icon-container col-md-6">

                                                <label class="required fw-semibold fs-6 mb-2">Size</label>



                                                <input type="text" name="size"
                                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="XL"
                                                    value="">

                                                <div
                                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                </div>
                                            </div>
                                            <div class="fv-row mb-7 fv-plugins-icon-container col-md-6">

                                                <label class="required fw-semibold fs-6 mb-2">Pointure</label>



                                                <input type="number" name="pointure"
                                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="41"
                                                    value="">

                                                <div
                                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="d-flex flex-row gap-1 ">
                                            <div class="mb-5 col-md-6 me-1">

                                                <label class="required fw-semibold fs-6 mb-5">Categorie</label>

                                                <div class="d-flex fv-row">

                                                    <div class="form-check form-check-custom form-check-solid">

                                                        <input class="form-check-input me-3" name="category" type="radio"
                                                            value="Raccordement" checked="checked">

                                                        <label class="form-check-label"
                                                            for="kt_modal_update_role_option_0">
                                                            <div class="fw-bold text-gray-800">Raccordement</div>
                                                            <div class="text-gray-600">
                                                            </div>
                                                        </label>

                                                    </div>

                                                </div>


                                                <div class="separator separator-dashed my-5"></div>
                                                <div class="d-flex fv-row">

                                                    <div class="form-check form-check-custom form-check-solid">

                                                        <input class="form-check-input me-3" name="category" type="radio"
                                                            value="Raccordement" checked="checked">

                                                        <label class="form-check-label"
                                                            for="kt_modal_update_role_option_0">
                                                            <div class="fw-bold text-gray-800">Maintenance</div>
                                                            <div class="text-gray-600">
                                                            </div>
                                                        </label>

                                                    </div>

                                                </div>
                                                <div class="separator separator-dashed my-5"></div>
                                                <div class="d-flex fv-row">

                                                    <div class="form-check form-check-custom form-check-solid">

                                                        <input class="form-check-input me-3" name="category" type="radio"
                                                            value="Raccordement" checked="checked">

                                                        <label class="form-check-label"
                                                            for="kt_modal_update_role_option_0">
                                                            <div class="fw-bold text-gray-800">Intervention</div>
                                                            <div class="text-gray-600">
                                                            </div>
                                                        </label>

                                                    </div>

                                                </div>
                                            </div>
                                            <div class="mb-5 col-md-5">

                                                <label class="required fw-semibold fs-6 mb-5">Niveau d'habilitation</label>

                                                <div class="d-flex fv-row">

                                                    <div class="form-check form-check-custom form-check-solid">

                                                        <input class="form-check-input me-3" name="level" type="radio"
                                                            value="Chef d'equipe" checked="checked">

                                                        <label class="form-check-label"
                                                            for="kt_modal_update_role_option_0">
                                                            <div class="fw-bold text-gray-800">Chef d'equipe</div>
                                                            <div class="text-gray-600">
                                                            </div>
                                                        </label>

                                                    </div>

                                                </div>


                                                <div class="separator separator-dashed my-5"></div>
                                                <div class="d-flex fv-row">
                                                    <div class="form-check form-check-custom form-check-solid">
                                                        <input class="form-check-input me-3" name="level" type="radio"
                                                            value="Simple technicien" checked="checked">
                                                        <label class="form-check-label"
                                                            for="kt_modal_update_role_option_0">
                                                            <div class="fw-bold text-gray-800">Simple technicien</div>
                                                            <div class="text-gray-600">
                                                            </div>
                                                        </label>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>



                                    <div class="text-center pt-10">
                                        <button type="reset" class="btn btn-light me-3"
                                            data-bs-dismiss="modal">
                                            Annuler
                                        </button>

                                        <button type="submit" class="btn btn-primary"
                                            data-kt-users-modal-action="submit">
                                            <span class="indicator-label">
                                                Envoyer
                                            </span>
                                            <span class="indicator-progress">
                                                Veuillez patienter... <span
                                                    class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                            </span>
                                        </button>
                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        <div class="card-body py-4">

            <div class="card-toolbar d-none">

                <!--begin::Group actions-->
                <div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
                    <div class="fw-bolder me-5">
                    <span class="me-2" data-kt-user-table-select="selected_count"></span>Selected</div>
                    <button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">Delete Selected</button>
                </div>
                <!--end::Group actions-->
            </div>
            <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer"
                        id="kt_table_users">
                        <thead>
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th class="w-10px pe-2 sorting_disabled" rowspan="1" colspan="1" style="width: 29.9px;"
                                    aria-label="

            ">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input" type="checkbox" data-kt-check="true"
                                            data-kt-check-target="#kt_table_users .form-check-input" value="1">
                                    </div>
                                </th>
                                <th class="min-w-125px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1"
                                    colspan="1" style="width: 200px;"
                                    aria-label="Utilisateur: activate to sort column ascending">Utilisateur</th>
                                <th class="min-w-75px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1"
                                    colspan="1" style="width: 100px;"
                                    aria-label="Role: activate to sort column ascending">Role</th>
                                <th class="min-w-85px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1"
                                    colspan="1" style="width: 85px;"
                                    aria-label="Connexion: activate to sort column ascending">Pointure / Size</th>

                                <th class="sorting min-w-100px " tabindex="0" aria-controls="kt_table_users"
                                    rowspan="1" colspan="1" style="width: 100px;"
                                    aria-label="Date creat.: activate to sort column ascending">
                                    Telephone</th>
                                <th>

                                </th>
                                <th class="text-end min-w-75px sorting_disabled" rowspan="1" colspan="1"
                                    style="width: 100px;" aria-label="Actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-semibold">
                            @foreach ($users as $index=>$user)

                            <tr class="odd">
                                <td>
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1">
                                    </div>
                                </td>
                                <td class="d-flex align-items-center">

                                    <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                        <a href="/">
                                            @if($user->avatar)
                                            <div class="symbol-label">

                                                <img src="{{ asset($user->avatar)}}" alt="{{$user->name}}"
                                                    class="w-100">
                                            </div>
                                            @else
                                            <div class="symbol-label fs-3 bg-light-danger text-danger">
                                                {{$user->name[0]}} </div>
                                            @endif
                                        </a>
                                    </div>


                                    <div class="d-flex flex-column">
                                        <a href="/" class="text-gray-800 text-hover-primary mb-1">{{ $user->name}} {{
                                            $user->post_name}}</a>
                                        <span>{{ $user->email}}</span>
                                    </div>

                                </td>
                                <td>
                                    @foreach ( $user->getRoleNames() as $userR )

                                            <label class="badge badge-success">
                                                {{ $userR }} - {{  $user->category }}
                                            </label>
                                    @endforeach
                                    <label for="" class="badge badge-primary">
                                        {{ $user->level }}
                                    </label>
                                </td>
                                 </td>
                                <td data-order="2023-10-07T02:43:51+02:00">
                                    {{ $user->size }} / {{ $user->pointure }}
                                </td>

                                <td data-order="{{$user->created_at}}">
                                    {{
                                    $user->number
                                    }} </td>
                                <td>

                                </td>
                                <td class="text-end d-flex">
                                    <a href="{{ route('technicians.edit', $user->id)}}"
                                        class="btn btn-icon btn-active-light-primary w-30px h-30px me-3">
                                        <i class="ki-duotone ki-pencil fs-3"><span class="path1"></span><span
                                                class="path2"></span><span class="path3"></span><span
                                                class="path4"></span><span class="path5"></span></i>
                                    </a>
                                    @if ($user->id == Auth::id())
                                    <a href="{{ route('settings')}}"
                                        class="btn btn-icon btn-active-light-primary w-30px h-30px">
                                        <i class="ki-duotone ki-setting-2 fs-3"><span class="path1"></span><span
                                                class="path2"></span><span class="path3"></span><span
                                                class="path4"></span><span class="path5"></span></i>
                                    </a>
                                    @else
                                    <form action="{{ route('users.destroy', $user->id)}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button
                                            class="btn btn-icon btn-active-light-primary w-30px h-30px">
                                            <i class="ki-duotone ki-trash fs-3"><span class="path1"></span><span
                                                    class="path2"></span><span class="path3"></span><span
                                                    class="path4"></span><span class="path5"></span></i>
                                            </button>
                                    </form>
                                    @endif
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
@endsection
