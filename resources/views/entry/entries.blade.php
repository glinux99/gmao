@extends('layouts.app')
@section('menuTitle')
    Gestion d'utilisateurs
@endsection
@section('contentTitle')
    <li class="breadcrumb-item text-dark">
        entrées de materiels </li>
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
                            <i class="ki-duotone ki-plus fs-2"></i> Ajouter une categorie
                        </button>

                    </div>








                    <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">

                        <div class="modal-dialog modal-dialog-centered mw-650px">

                            <div class="modal-content">

                                <div class="modal-header" id="kt_modal_add_user_header">

                                    <h2 class="fw-bold">Ajouter une categorie</h2>



                                     <div class="btn btn-icon btn-sm btn-active-icon-primary"
                                   data-bs-dismiss="modal">
                                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                                class="path2"></span></i>
                                    </div>

                                </div>



                                <div class="modal-body px-5 my-7">

                                    <form id="" method="POST"
                                        class="form fv-plugins-bootstrap5 fv-plugins-framework"
                                        action="{{ route('entries.store') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="d-flex flex-column scroll-y px-5 px-lg-10"
                                            id="kt_modal_add_user_scroll" data-kt-scroll="true"
                                            data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                                            data-kt-scroll-dependencies="#kt_modal_add_user_header"
                                            data-kt-scroll-wrappers="#kt_modal_add_user_scroll"
                                            data-kt-scroll-offset="300px" style="max-height: 269px;">
                                            <div class="row">
                                                <div class="fv-row mb-7 fv-plugins-icon-container col-md-6 col-md-6">

                                                    <label class="required fw-semibold fs-6 mb-2">Designation</label>



                                                    <div class="fv-row">
                                                        <select name="category_id" aria-label="Selectionne une unite"  data-control="select2" data-placeholder="Selectionner une unite..." class="form-select form-select-solid form-select-lg fw-bold"  data-dropdown-parent="#kt_modal_add_user"  data-allow-clear="true">
                                                            <option value="">Selectionner une categorie...</option>
                                                            @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}" data-kt-flag="{{ $category->avatar }}">
                                                                {{ $category->designation }}
                                                                @if ($category->caracteristique!="")
                                                                <span >
                                                                    ({{ $category->caracteristique }})
                                                                </span>
                                                                @endif

                                                            </option>
                                                            @endforeach

                                                        </select>
                                                    </div>

                                                    <div
                                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                    </div>
                                                </div>
                                                <div class="fv-row mb-7 fv-plugins-icon-container col-md-6">

                                                    <label class="required fw-semibold fs-6 mb-2">Quantite</label>



                                                    <input type="number" name="quantity"
                                                        class="form-control form-control-solid mb-3 mb-lg-0"
                                                        placeholder="0" value="">

                                                    <div
                                                        class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                    </div>
                                                </div>
                                                <div class="row mb-6">
                                                    <!--begin::Label-->
                                                    <label class="col-lg-6 col-form-label fw-bold fs-6">
                                                        <span class="required">Etat</span>
                                                        <i class="fas fa-exclamation-circle ms-1 fs-7"
                                                            data-bs-toggle="tooltip" title="Etat du materiel"></i>
                                                    </label>
                                                    <!--end::Label-->
                                                    <!--begin::Col-->
                                                    <div class="col-lg-6 fv-row">
                                                        <select name="etat" aria-label="Selectionne l'etat du materiel"
                                                            data-control="select2"
                                                            data-placeholder="Selectionner l'etat du materiel..."
                                                            class="form-select form-select-solid form-select-lg fw-bold"
                                                            data-dropdown-parent="#kt_modal_add_user"
                                                            data-allow-clear="true">
                                                            <option value="">Selectionner un etat...</option>
                                                            <option value="Neuf">Neuf</option>
                                                            <option value="bon">Bon</option>
                                                            <option value="Endommage">Endommage</option>

                                                        </select>
                                                    </div>

                                                    <!--end::Col-->
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


<!--begin::Card body-->
<div class="card-body pt-0">
    <div class="card-toolbar d-none">

        <!--begin::Group actions-->
        <div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
            <div class="fw-bolder me-5">
            <span class="me-2" data-kt-user-table-select="selected_count"></span>Selected</div>
            <button type="button" class="btn btn-danger" data-kt-user-table-select="delete_selected">Delete Selected</button>
        </div>
        <!--end::Group actions-->
    </div>
    <!--begin::Table-->
    @php
    $bg = ['bg-light-success','bg-light-warning', 'bg-light-success','bg-light-danger', 'bg-light-info'];
    @endphp
    <table class="table g-0 fs-6" id="kt_table_users">
        <!--begin::Table body-->
        <tbody class="text-gray-600s fw-bold row g-xl-8">
            <!--begin::Table row-->
            @foreach ($entries as $entry)
            <tr class="col-md-6 card">
                <!--begin::Checkbox-->
                <td class="">
                    <div class="">
                        <div class="d-flex align-items-center {{ $bg[rand(0,count($bg)-1)] }} rounded p-5 mb-7">
                            <!--begin::Icon-->
                            <span class="svg-icon svg-icon-warning me-5">
                                <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                <span class="svg-icon svg-icon-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                        <path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="black" />
                                        <path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="black" />
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->
                            </span>
                            <!--end::Icon-->
                            <!--begin::Title-->
                            <div class="flex-grow-1 me-2">
                                <a href="{{ route('entries.edit', $entry) }}" class="fw-bolder text-gray-800 text-hover-primary fs-6">
                                    {{ $entry->category->designation }}
                                </a>
                                <span class="text-muted fw-bold d-block">
                                    {{ $entry->category->caracteristique }}
                                </span>
                            </div>
                            <!--end::Title-->
                            <!--begin::Lable-->
                           <div class="d-flex flex-column align-items-center">
                            <span class="fw-bolder text-warning py-1">+
                                {{ $entry->quantity }} {{ $entry->category->unity->abbreviation }}
                            </span>
                            <span class="fw-bolder text-success py-1">
                                {{ $entry->etat }}
                            </span>
                           </div>
                            <!--end::Lable-->
                              <!--begin::Lable-->
                           <div class="d-flex flex-column align-items-center">
                            <a href="{{ route('entries.destroy', $entry) }}" data-confirm-delete="true">
                                <i class="ki-duotone ki-trash fs-1 ms-5 text-danger"><span class="path1"></span><span
                                    class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                            </a>
                           </div>
                            <!--end::Lable-->
                        </div>
                    </div>
                </td>
                <!--end::Checkbox-->
                <!--begin::User=-->
                <td class="d-flex align-items-center d-none" >
                </td>
                <!--end::User=-->
                <!--begin::Role=-->
                <td class="d-none"></td>
                <!--end::Role=-->
                <!--begin::Last login=-->
                <td class="d-none">
                </td>
                <!--end::Last login=-->
                <!--begin::Two step=-->
                <td class="d-none"></td>
                <!--end::Two step=-->
                <!--begin::Joined-->
                <td class="d-none"></td>
                <!--begin::Joined-->
                <!--begin::Action=-->
                <td class="d-none">
                </td>
                <!--end::Action=-->
            </tr>
            <!--end::Table row-->
            @endforeach
        </tbody>
        <!--end::Table body-->
    </table>
    <!--end::Table-->
</div>
<!--end::Card body-->


        </div>

    </div>
@endsection
