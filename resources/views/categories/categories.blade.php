@extends('layouts.app')
@section('menuTitle')
    Gestion d'utilisateurs
@endsection
@section('contentIndex')

    <li class="breadcrumb-item text-muted">
        <a href="/" class="text-muted">
            Acceuil </a>
    </li>
    <li class="breadcrumb-item text-dark">
        categories </li>
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

                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">





                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_add_user">
                            <i class="ki-duotone ki-plus fs-2"></i> Ajouter une catégorie
                        </button>

                    </div>


                    <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">

                        <div class="modal-dialog modal-dialog-centered mw-850px">

                            <div class="modal-content">

                                <div class="modal-header" id="kt_modal_add_user_header">

                                    <h2 class="fw-bold">Ajouter une catégorie</h2>



                                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                                class="path2"></span></i>
                                    </div>

                                </div>



                                <div class="modal-body px-5 my-7">

                                    <form id="" method="POST" class="form fv-plugins-bootstrap5 fv-plugins-framework"
                                        action="{{ route('categories.store')}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll"
                                            data-kt-scroll="true" data-kt-scroll-activate="true"
                                            data-kt-scroll-max-height="auto"
                                            data-kt-scroll-dependencies="#kt_modal_add_user_header"
                                            data-kt-scroll-wrappers="#kt_modal_add_user_scroll"
                                            data-kt-scroll-offset="300px" style="max-height: 269px;">

                                            <div class="fv-row mb-7">

                                                <label class="d-block fw-semibold fs-6 mb-5">Avatar</label>




                                                <style>
                                                    .image-input-placeholder {
                                                        background-image: url('../../../assets/media/svg/files/blank-image.svg');
                                                    }

                                                    [data-bs-theme="dark"] .image-input-placeholder {
                                                        background-image: url('../../../assets/media/svg/files/blank-image-dark.svg');
                                                    }
                                                </style>


                                                <!--begin::Image input-->
                                                <div class="image-input image-input-outline" data-kt-image-input="true"
                                                    style="background-image: url(assets/media/avatars/blank.png)">
                                                    <!--begin::Preview existing avatar-->
                                                    <div class="image-input-wrapper w-125px h-125px"
                                                        style="background-image: url(assets/media/avatars/connectors.jpeg)">
                                                    </div>
                                                    <!--end::Preview existing avatar-->
                                                    <!--begin::Label-->
                                                    <label
                                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                        data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                        title="Change avatar">
                                                        <i class="bi bi-pencil-fill fs-7"></i>
                                                        <!--begin::Inputs-->
                                                        <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                                                        <input type="hidden" name="avatar_remove" />
                                                        <!--end::Inputs-->
                                                    </label>
                                                    <!--end::Label-->
                                                    <!--begin::Cancel-->
                                                    <span
                                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                                        title="Cancel avatar">
                                                        <i class="bi bi-x fs-2"></i>
                                                    </span>
                                                    <!--end::Cancel-->
                                                    <!--begin::Remove-->
                                                    <span
                                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                        data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                                        title="Remove avatar">
                                                        <i class="bi bi-x fs-2"></i>
                                                    </span>
                                                    <!--end::Remove-->
                                                </div>
                                                <!--end::Image input-->



                                                <div class="form-text">Allowed file types: png, jpg, jpeg.</div>

                                            </div>
                                            <div class="row">
                                                <div class="fv-row mb-7 fv-plugins-icon-container col-md-6 col-md-6">

                                                    <label class="required fw-semibold fs-6 mb-2">Designation</label>



                                                    <input type="text" name="designation"
                                                        class="form-control form-control-solid mb-3 mb-lg-0"
                                                        placeholder="Designation de la catégorie" value="" required>

                                                    <div
                                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                    </div>
                                                </div>
                                                <div class="fv-row mb-7 fv-plugins-icon-container col-md-6">

                                                    <label class="required fw-semibold fs-6 mb-2">Caractéristiques</label>



                                                    <input type="text" name="caracteristique"
                                                        class="form-control form-control-solid mb-3 mb-lg-0"
                                                        placeholder="Caracteristique de la catégorie" value="">

                                                    <div
                                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                    </div>
                                                </div>
                                                <div class="row mb-6">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-4 col-form-label fw-bold fs-6">
                                                        <span class="required">Unité</span>
                                                        <i class="fas fa-exclamation-circle ms-1 fs-7"
                                                            data-bs-toggle="tooltip" title="Unité"></i>
                                                    </label>
                                                    <!--end::Label-->
                                                    <!--begin::Col-->
                                                    <div class="col-lg-8 fv-row">
                                                        <select name="unity_id" required aria-label="Selectionne une unité"
                                                            data-control="select2"
                                                            data-placeholder="Selectionner une unité..."
                                                            class="form-select form-select-solid form-select-lg fw-bold"
                                                            data-dropdown-parent="#kt_modal_add_user"
                                                            data-allow-clear="true">
                                                            <option value="">Selectionner une unité...</option>
                                                            @foreach ($unities as $unity)
                                                                <option value="{{ $unity->id}}">
                                                                    {{ $unity->designation }}
                                                                </option>
                                                            @endforeach

                                                        </select>
                                                    </div>

                                                    <!--end::Col-->
                                                </div>
                                            </div>

                                            <div class="d-flex flex-row gap-1 ">
                                                <div class="d-flex fv-row">

                                                    <div class="form-check form-check-custom form-check-solid">

                                                        <input class="form-check-input me-3" name="is_remise"
                                                            type="checkbox" value="1">

                                                        <label class="form-check-label" >
                                                            <div class="fw-bold text-gray-800">A remettre?</div>
                                                            <div class="text-gray-600">
                                                            </div>
                                                        </label>

                                                    </div>

                                                </div>
                                            </div>

                                        </div>



                                        <div class="text-center pt-10">
                                            <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">
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
                                        colspan="1" style="width: 300px;"
                                        aria-label="Utilisateur: activate to sort column ascending">Catégorie</th>
                                    <th class="min-w-75px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1"
                                        colspan="1" style="width: 100px;"
                                        aria-label="Role: activate to sort column ascending">unité</th>
                                    <th class="min-w-85px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1"
                                        colspan="1" style="width: 85px;"
                                        aria-label="Connexion: activate to sort column ascending">Caractéristique</th>

                                    <th class="sorting min-w-50px " tabindex="0" aria-controls="kt_table_users" rowspan="1"
                                        colspan="1" aria-label="Date creat.: activate to sort column ascending">
                                        A remettre</th>
                                    <th>

                                    </th>
                                    <th class="text-center min-w-100px sorting_disabled" rowspan="1" colspan="1"
                                        style="width: 100px;" aria-label="Actions">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @foreach ($categories as $index => $category)

                                                        <tr class="odd">
                                                            <td>
                                                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                                    <input class="form-check-input" type="checkbox" value="1">
                                                                </div>
                                                            </td>
                                                            <td class="d-flex align-items-center">

                                                                <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                                                    <a href="/">
                                                                        @if($category->avatar)
                                                                            <div class="symbol-label">

                                                                                <img src="{{ asset($category->avatar)}}" alt="{{$category->name}}"
                                                                                    class="w-100">
                                                                            </div>
                                                                        @else
                                                                            <div class="symbol-label fs-3 bg-light-danger text-danger">
                                                                                {{$category->designation[0]}}
                                                                            </div>
                                                                        @endif
                                                                    </a>
                                                                </div>


                                                                <div class="d-flex flex-column">
                                                                    <a href="/" class="text-gray-800 text-hover-primary mb-1">{{ $category->name}}
                                                                        {{
                                    $category->designation}}</a>
                                                                </div>

                                                            </td>
                                                            <td>
                                                                {{ $category->unity->designation}}
                                                            </td>
                                                            <td data-order="2023-10-07T02:43:51+02:00" class="text-center">
                                                                {{ $category->caracteristique}}
                                                            </td>

                                                            <td data-order="{{$category->created_at}}" class="text-center">
                                                                {{
                                    $category->is_remise ? "Oui" : "Non"
                                                                }} </td>
                                                            <td>

                                                            </td>
                                                            <td class="text-center">
                                                                <a href="{{ route('categories.edit', $category->id)}}"
                                                                    class="btn btn-icon btn-active-light-primary text-center d-none">
                                                                    <i class="ki-duotone ki-pencil fs-3"><span class="path1"></span><span
                                                                            class="path2"></span><span class="path3"></span><span
                                                                            class="path4"></span><span class="path5"></span></i>
                                                                </a>
                                                                <a class="text-center" href="{{ route('categories.destroy', $category) }}"
                                                                    data-confirm-delete="true">
                                                                    <i class="ki-duotone ki-trash fs-1 text-danger "><span
                                                                            class="path1"></span><span class="path2"></span><span
                                                                            class="path3"></span><span class="path4"></span></i>
                                                                </a>
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
