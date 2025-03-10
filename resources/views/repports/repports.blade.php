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
    utilisateurs </li>
@endsection

@section('content')
<div class=" container-xxl " id="kt_content_container" data-select2-id="select2-data-kt_content_container">


    <div class="card" data-select2-id="select2-data-156-v9nn">

        <div class="card-header border-0 pt-6" data-select2-id="select2-data-155-sseq">

            <div class="card-title">

                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span class="path1"></span><span
                            class="path2"></span></i> <input type="text" data-kt-user-table-filter="search"
                        class="form-control form-control-solid w-250px ps-13" placeholder="Rechercher une catégorie">
                </div>

            </div>



            <div class="card-toolbar" data-select2-id="select2-data-154-zqod">

                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">





                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_add_user">
                        <i class="ki-duotone ki-plus fs-2"></i> Ajouter un email Rapport
                    </button>

                </div>



                <div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
                    <div class="fw-bold me-5">
                        <span class="me-2" data-kt-user-table-select="selected_count"></span> Selectionnee(s)
                    </div>

                    <button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">
                        Supprimer la selection
                    </button>
                </div>





                <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">

                    <div class="modal-dialog modal-dialog-centered mw-650px">

                        <div class="modal-content">

                            <div class="modal-header" id="kt_modal_add_user_header">

                                <h2 class="fw-bold">Ajouter un email Repport</h2>



                                <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                   data-bs-dismiss="modal">
                                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                            class="path2"></span></i>
                                </div>

                            </div>



                            <div class="modal-body px-5 my-7">

                                <form id="" method="POST"
                                    class="form fv-plugins-bootstrap5 fv-plugins-framework"
                                    action="{{ route('repports.store')}}">
                                    @csrf
                                    <div class="d-flex flex-column scroll-y px-5 px-lg-10"
                                        id="kt_modal_add_user_scroll" data-kt-scroll="true"
                                        data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                                        data-kt-scroll-dependencies="#kt_modal_add_user_header"
                                        data-kt-scroll-wrappers="#kt_modal_add_user_scroll"
                                        data-kt-scroll-offset="300px" style="max-height: 269px;">
                                        <div class="col">
                                            <div class="fv-row mb-7 fv-plugins-icon-container">

                                                <label class="required fw-semibold fs-6 mb-2">Nom</label>



                                                <input type="text" name="fullname"
                                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Nom complet"
                                                    value="">

                                                <div
                                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                </div>
                                            </div>
                                            <div class="fv-row mb-7 fv-plugins-icon-container">

                                                <label class="required fw-semibold fs-6 mb-2">Email</label>



                                                <input type="text" name="email"
                                                    class="form-control form-control-solid mb-3 mb-lg-0" placeholder="email"
                                                    value="">

                                                <div
                                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                </div>
                                            </div>
                                            <div class="fv-row mb-7 fv-plugins-icon-container">

                                                <label class="required fw-semibold fs-6 mb-2">Categories</label>



                                                <select name="categories" aria-label="Selectionne une categorie"  data-control="select2" data-placeholder="Selectionner une catégorie..." class="form-select form-select-solid form-select-lg fw-bold"  data-dropdown-parent="#kt_modal_add_user"  data-allow-clear="true">
                                                    <option value="">Selectionner une catégorie...</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}" data-kt-flag="{{ $category->avatar }}">
                                                        {{ $category->designation }}</option>
                                                    @endforeach

                                                </select>

                                                <div
                                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
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
                                    aria-label="">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input" type="checkbox" data-kt-check="true"
                                            data-kt-check-target="#kt_table_users .form-check-input" value="1">
                                    </div>
                                </th>
                                <th class="min-w-250px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1"
                                    colspan="1" style=""
                                    aria-label="Utilisateur: activate to sort column ascending">Email user</th>
                                <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1"
                                    colspan="1" style="width: 100px;"
                                    aria-label="Role: activate to sort column ascending">Abbreviation</th>
                                <th class="min-w-100px sorting" tabindex="0" aria-controls="kt_table_users" rowspan="1"
                                    colspan="1" style="width: 185px;"
                                    aria-label="Connexion: activate to sort column ascending">Date de creation</th>

                                <th class="sorting min-w-100px d-none " tabindex="0" aria-controls="kt_table_users"
                                    rowspan="1" colspan="1" style="width: 100px;"
                                    aria-label="Date creat.: activate to sort column ascending">
                                    Telephone</th>
                                <th>

                                </th>
                                <th class="text-end min-w-100px sorting_disabled text-center" rowspan="1" colspan="1"
                                    style="width: 100px;" aria-label="Actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 fw-semibold">
                            @foreach ($repports as $index=>$repport)

                            <tr class="odd">
                                <td>
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1">
                                    </div>
                                </td>
                                <td class="d-flex align-items-center">

                                    <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                                        <div class="symbol-label fs-3 bg-light-danger text-danger">
                                            {{$repport->fullname[0]}} </div>
                                    </div>


                                    <div class="d-flex flex-column">
                                        <a href="/" class="text-gray-800 text-hover-primary mb-1">{{ $repport->fullname}} </a>
                                    </div>

                                </td>
                                <td>
                                    {{
                                        $repport->email}} </td>
                                <td data-order="2023-10-07T02:43:51+02:00">
                                    {{$repport->created_at}}
                                </td>
                                <td></td>

                                <td class="text-end">
                                    <a href="{{ route('repports.edit', $repport->id)}}"
                                        class="btn btn-icon btn-active-light-primary w-30px h-30px me-3">
                                        <i class="ki-duotone ki-pencil fs-3"><span class="path1"></span><span
                                                class="path2"></span><span class="path3"></span><span
                                                class="path4"></span><span class="path5"></span></i>
                                    </a>
                                    <a href="{{ route('repports.destroy', $repport->id)}}" data-confirm-delete="true"
                                        class="btn btn-icon btn-active-light-primary w-30px h-30px">
                                        <i class="ki-duotone ki-trash fs-3"><span class="path1"></span><span
                                                class="path2"></span><span class="path3"></span><span
                                                class="path4"></span><span class="path5"></span></i>
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
