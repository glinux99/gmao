@extends('layouts.app')
@section('menuTitle')
    Gestion d'utilisateurs
@endsection
@section('contentTitle')
    <li class="breadcrumb-item text-dark">
        Sortie stock </li>
@endsection

@section('content')
        <div class="row g-1">
            <div class="col-md-6 card">
                <!--begin::Sidebar-->
                <div class="m-0">
                    <!--begin::Invoice 2 sidebar-->
                    <div class="d-print-none border border-dashed border-gray-300 card-rounded h-lg-100 min-w-md-350px p-9">
                        <div class="row">
                            <div class="col-md-6">
                                <!--begin::Labels-->
                                @if ($entry->category->is_remise)
                                <div class="mb-8 ">
                                    <span class="me-2">Etat</span>
                                    <span class="badge badge-light-warning">
                                        {{ $entry->is_remise ? "Remis" : "Non remis" }}
                                    </span>
                                </div>
                                @endif
                                <!--end::Labels-->
                            </div>
                            <div class="col-md-6 d-flex align-items-end justify-content-end">
                                <span class="fw-bolder text-success py-1 fs-1">
                                    {{ $entry->quantity }} {{ $entry->category->unity->abbreviation }}
                                </span>
                            </div>
                        </div>
                        <!--begin::Title-->
                        <h6 class="mb-8 fw-boldest text-gray-600 text-hover-primary">
                            Details
                        </h6>
                        <!--end::Title-->
                        <!--begin::Item-->
                        <div class="mb-6">
                            <div class="fw-bold text-gray-600 fs-7">Designation:</div>
                            <div class="fw-bolder text-gray-800 fs-6">
                                {{ $entry->category->designation }}
                            </div>
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="mb-6">
                            <div class="fw-bold text-gray-600 fs-7">Caracteristiques:</div>
                            <div class="fw-bolder text-gray-800 fs-6">
                                {{ $entry->category->caracteristique }}
                            </div>
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="mb-15">
                            <div class="fw-bold text-gray-600 fs-7">Date:</div>
                            <div class="fw-bolder fs-6 text-gray-800 d-flex align-items-center">
                                {{ $entry->created_at }}
                            <span class="fs-7 text-danger d-flex align-items-center">
                            <span class="bullet bullet-dot bg-danger mx-2"></span>Due in 7 days</span></div>
                        </div>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <div class="mb-15">
                            <div class="fw-bold text-gray-600 fs-7">Fait par:</div>
                            <div class="fw-bolder fs-6 text-gray-800 d-flex align-items-center">
                                {{ $entry->demandeur->name }} {{ $entry->demandeur->post_name }}</div>
                        </div>
                        <!--end::Item-->
                    </div>
                    <!--end::Invoice 2 sidebar-->
                </div>
                <!--end::Sidebar-->
            </div>
            <div class="col-md-6 card p-9">
                Editer
                <form method="POST"
                class="form fv-plugins-bootstrap5 fv-plugins-framework"
                action="{{ route('stock-histories.update', $entry) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="col">
                    <div class="fv-row mb-7 fv-plugins-icon-container">
                        <label class="required fw-semibold fs-6 mb-2">Designation</label>
                        <div class="fv-row">
                            <input type="text" name=""
                            class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="0" value="{{ $entry->category->designation }}" readonly>
                        </div>

                        <div
                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                    <div class="fv-row mb-7 fv-plugins-icon-container">

                        <label class="required fw-semibold fs-6 mb-2">Quantite</label>
                        <div class="d-flex">
                            <input type="number" name="quantity"
                            class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="0" value="{{ $entry->quantity }}">
                            <input type="number" name="category"
                            class="form-control form-control-solid mb-3 mb-lg-0"
                            placeholder="0" value="{{ $entry->category->id }}"  hidden>
                            <span class="mx-5 fs-3 fw-bolder">
                                {{ $entry->category->unity->abbreviation }}
                            </span>
                        </div>

                        <div
                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                        </div>
                    </div>
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-bold fs-6">
                            <span class="required">Etat</span>
                            <i class="fas fa-exclamation-circle ms-1 fs-7"
                                data-bs-toggle="tooltip" title="Etat du materiel"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <select name="etat" aria-label="Selectionne l'etat du materiel"
                                data-control="select2"
                                data-placeholder="Selectionner l'etat du materiel..."
                                class="form-select form-select-solid form-select-lg fw-bold"

                                data-allow-clear="true">
                                <option value="{{ $entry->etat }}">
                                    {{ $entry->etat }}
                                </option>
                                <option value="Neuf">Neuf</option>
                                <option value="bon">Bon</option>
                                <option value="Endommage">Endommage</option>

                            </select>
                        </div>

                        <!--end::Col-->
                    </div>
                    <div class="row mb-6">
                        <!--begin::Label-->
                        <label class="col-lg-4 col-form-label fw-bold fs-6">
                            <span class="required">Status</span>
                            <i class="fas fa-exclamation-circle ms-1 fs-7"
                                data-bs-toggle="tooltip" title="Etat du materiel"></i>
                        </label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8 fv-row">
                            <select name="is_remise" aria-label="Selectionne l'etat du materiel"
                                data-control="select2"
                                data-placeholder="Selectionner le status du materiel..."
                                class="form-select form-select-solid form-select-lg fw-bold"

                                data-allow-clear="true">
                                <option value="{{ $entry->is_remise }}">
                                    {{ $entry->is_remise? "Oui remis" : "Non remis" }}
                                </option>
                                <option value="1">Oui remis</option>
                                <option value="0">Non remis</option>

                            </select>
                        </div>

                        <!--end::Col-->
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary"
                                                data-kt-users-modal-action="submit">
                                                <span class="indicator-label">
                                                    Mis a jour
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
@endsection
