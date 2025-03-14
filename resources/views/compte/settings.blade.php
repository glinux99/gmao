@extends('layouts.app')
@section('menuTitle')
Mon compte
@endsection
@section('contentTitle')
<li class="breadcrumb-item text-dark">
    Paramètre </li>
@endsection

@section('content')
<div class=" container-xxl " id="kt_content_container">

    @include('compte.header')

    <div class="card mb-5 mb-xl-10">

        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
            data-bs-target="#kt_account_profile_details" aria-expanded="true"
            aria-controls="kt_account_profile_details">

            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Details du profil</h3>
            </div>

        </div>



        <div id="kt_account_settings_profile_details" >


            <form class="form" method="POST" action="{{ route('users.update', Auth::user()->id) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf


                <div class="card-body border-top p-9">

                    <div class="row mb-6">

                        <label class="col-lg-4 col-form-label fw-semibold fs-6">Photo</label>



                        <div class="col-lg-8">

                            <div class="image-input image-input-outline" data-kt-image-input="true"
                                style="background-image: url('../assets/media/svg/avatars/blank.svg')">

                                <div class="image-input-wrapper w-125px h-125px"
                                    style="background-image: url({{asset(Auth::user()->avatar)}})"></div>



                                <label
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                    title="Changer l'image">
                                    <i class="ki-duotone ki-pencil fs-7"><span class="path1"></span><span
                                            class="path2"></span></i>

                                    <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="avatar_remove" />

                                </label>



                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                    title="Annuler l'image">
                                    <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span
                                            class="path2"></span></i> </span>



                                <span
                                    class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                    data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                    title="Supprimer la photo">
                                    <i class="ki-duotone ki-cross fs-2"><span class="path1"></span><span
                                            class="path2"></span></i> </span>

                            </div>



                        </div>

                    </div>



                    <div class="row mb-6">

                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Nom complet</label>



                        <div class="col-lg-8">

                            <div class="row">

                                <div class="col-lg-6 fv-row">
                                    <input type="text" name="name"
                                        class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                        placeholder="nom" value="{{Auth::user()->name}}" />
                                </div>



                                <div class="col-lg-6 fv-row">
                                    <input type="text" name="post_name"
                                        class="form-control form-control-lg form-control-solid" placeholder="prenom"
                                        value="{{Auth::user()->post_name}}" />
                                </div>

                            </div>

                        </div>

                    </div>



                    <div class="row mb-6">

                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Agence</label>



                        <div class="col-lg-8 fv-row">
                            <input type="text" class="form-control form-control-lg form-control-solid"
                                placeholder="nom de l'agence" value="Magasin Sous Station Ve" disabled />
                        </div>

                    </div>



                    <div class="row mb-6">

                        <label class="col-lg-4 col-form-label fw-semibold fs-6">
                            <span class="required">Telephone</span>


                            <span class="ms-1" data-bs-toggle="tooltip" title="Phone number must be active">
                                <i class="ki-duotone ki-information-5 text-gray-500 fs-6"><span
                                        class="path1"></span><span class="path2"></span><span
                                        class="path3"></span></i></span> </label>



                        <div class="col-lg-8 fv-row">
                            <input type="tel" name="number" class="form-control form-control-lg form-control-solid"
                                placeholder="Phone number" value="{{Auth::user()->number}}" />
                        </div>

                    </div>
                    <div class="row mb-6">

                        <label class="col-lg-4 col-form-label required fw-semibold fs-6">Type d'agent</label>



                        <div class="col-lg-8 fv-row">

                            <div class="d-flex align-items-center mt-3">

                                <label class="form-check form-check-custom form-check-inline form-check-solid me-5">
                                    <input class="form-check-input" name="type" type="radio"
                                        value="Agent de bureau" @if (Auth::user()->type=="Agent de bureau")
                                            checked
                                        @endif />
                                    <span class="fw-semibold ps-2 fs-6">
                                        Agent de bureau
                                    </span>
                                </label>
                                <label class="form-check form-check-custom form-check-inline form-check-solid">
                                    <input class="form-check-input" name="type" type="radio"
                                        value="Agent de terrain" @if (Auth::user()->type=="Agent de terrain")
                                        checked
                                    @endif />
                                    <span class="fw-semibold ps-2 fs-6">
                                        Agent de terrain
                                    </span>
                                </label>

                            </div>

                        </div>

                    </div>

                </div>



                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="reset" class="btn btn-light btn-active-light-primary me-2">Annuler</button>
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>

            </form>

        </div>

    </div>


    <div class="card  mb-5 mb-xl-10">

        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
            data-bs-target="#kt_account_signin_method">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Methode d'authentification</h3>
            </div>
        </div>



        <div id="kt_account_settings_signin_method" >

            <div class="card-body border-top p-9">

                <div class="d-flex flex-wrap align-items-center">

                    <div id="kt_signin_email">
                        <div class="fs-6 fw-bold mb-1">Adresse Email</div>
                        <div class="fw-semibold text-gray-600">{{ Auth::user()->email}}</div>
                    </div>



                    <div id="kt_signin_email_edit" class="flex-row-fluid d-none">

                        <form id="kt_signin_change_email" class="form" novalidate="novalidate" method="POST"
                            action="{{ route('users.update', Auth::user()->id) }}">
                            @csrf
                            @method('put')
                            <div class="row mb-6">
                                <div class="col-lg-6 mb-4 mb-lg-0">
                                    <div class="fv-row mb-0">
                                        <label for="emailaddress" class="form-label fs-6 fw-bold mb-3">Entrez une
                                            nouvelle
                                            adresse</label>
                                        <input type="email" class="form-control form-control-lg form-control-solid"
                                            id="emailaddress" placeholder="Adresse Email" name="email"
                                            value="{{ Auth::user()->email}}" />
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="fv-row mb-0">
                                        <label for="confirmemailpassword" class="form-label fs-6 fw-bold mb-3">Confirmez
                                            le
                                            mot de passe</label>
                                        <input type="password" class="form-control form-control-lg form-control-solid"
                                            name="confirmemailpassword" id="confirmemailpassword" />
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex">
                                <button type="submit" id="submitEmailChange" hidden></button>
                                <button id="kt_signin_submit" type="button" class="btn btn-primary  me-2 px-6">Mis a
                                    jour de l'Email</button>
                                <button id="kt_signin_cancel" type="button"
                                    class="btn btn-color-gray-400 btn-active-light-primary px-6">Annuler</button>
                            </div>
                        </form>

                    </div>



                    <div id="kt_signin_email_button" class="ms-auto">
                        <button class="btn btn-light btn-active-light-primary">Changer l'Email</button>
                    </div>

                </div>



                <div class="separator separator-dashed my-6"></div>



                <div class="d-flex flex-wrap align-items-center mb-10">

                    <div id="kt_signin_password">
                        <div class="fs-6 fw-bold mb-1">Mot de passe</div>
                        <div class="fw-semibold text-gray-600">************</div>
                    </div>



                    <div id="kt_signin_password_edit" class="flex-row-fluid d-none">

                        <form id="kt_signin_change_password" class="form" novalidate="novalidate" method="POST"
                        action="{{ route('users.update', Auth::user()->id) }}">
                        @csrf
                        @method('put')
                            <div class="row mb-1">
                                <div class="col-lg-4">
                                    <div class="fv-row mb-0">
                                        <label for="currentpassword" class="form-label fs-6 fw-bold mb-3">Mot de passe
                                            courrant</label>
                                        <input type="password" class="form-control form-control-lg form-control-solid "
                                            name="password" id="currentpassword" />
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="fv-row mb-0">
                                        <label for="newpassword" class="form-label fs-6 fw-bold mb-3">Nouveau mot de
                                            passe</label>
                                        <input type="password" class="form-control form-control-lg form-control-solid "
                                            name="newpassword" id="newpassword" />
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="fv-row mb-0">
                                        <label for="confirmpassword" class="form-label fs-6 fw-bold mb-3">Confirmez le
                                            nouvel mot de passe</label>
                                        <input type="password" class="form-control form-control-lg form-control-solid "
                                            name="" id="confirmpassword" />
                                    </div>
                                </div>
                            </div>

                            <div class="form-text mb-5">Le mot de passe doit comporter au moins 8 caractères et contenir
                                des symboles</div>

                            <div class="d-flex">
                                <button type="submit" hidden id="passwordSubmit"></button>
                                <button id="kt_password_submit" type="button" class="btn btn-primary me-2 px-6">Mis a
                                    jour du mot de passe</button>
                                <button id="kt_password_cancel" type="button"
                                    class="btn btn-color-gray-400 btn-active-light-primary px-6">Annuler</button>
                            </div>
                        </form>

                    </div>



                    <div id="kt_signin_password_button" class="ms-auto">
                        <button class="btn btn-light btn-active-light-primary">réinitialiser le mot de passe</button>
                    </div>

                </div>




                <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed  p-6">

                    <i class="ki-duotone ki-shield-tick fs-2tx text-primary me-4"><span class="path1"></span><span
                            class="path2"></span></i>



                    <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">

                        <div class="mb-3 mb-md-0 fw-semibold">
                            <h4 class="text-gray-900 fw-bold">Sécurise ton compte</h4>

                            <div class="fs-6 text-gray-700 pe-7">Nous vous encourageons à mettre régulièrement à jour
                                vos informations d'authentification afin de protéger votre compte contre les
                                cyberattaques
                            </div>
                        </div>



                    </div>

                </div>

            </div>

        </div>

    </div>



    <div class="card  ">


        <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
            data-bs-target="#kt_account_deactivate" aria-expanded="true" aria-controls="kt_account_deactivate">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Désactiver le compte</h3>
            </div>
        </div>



        <div id="kt_account_settings_deactivate" >

            <form id="kt_account_deactivate_form" class="form">


                <div class="card-body border-top p-9">


                    <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-9 p-6">

                        <i class="ki-duotone ki-information fs-2tx text-warning me-4"><span class="path1"></span><span
                                class="path2"></span><span class="path3"></span></i>



                        <div class="d-flex flex-stack flex-grow-1 ">

                            <div class=" fw-semibold">
                                <h4 class="text-gray-900 fw-bold">Vous désactivez votre compte</h4>

                                <div class="fs-6 text-gray-700 ">Pour plus de sécurité, cela nécessite que vous
                                    confirmiez votre
                                    e-mail ou numéro de téléphone lorsque vous réinitialisez votre mot de passe de
                                    connexion. <br /><a class="fw-bold" href="#">Lire plus</a></div>
                            </div>


                        </div>

                    </div>



                    <div class="form-check form-check-solid fv-row">
                        <input name="deactivate" class="form-check-input" type="checkbox" value="" />
                        <label class="form-check-label fw-semibold ps-2 fs-6" for="deactivate">Je confirme mon compte
                            désactivation</label>
                    </div>

                </div>



                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button id="kt_account_deactivate_account_submit" type="submit"
                        class="btn btn-danger fw-semibold">Desactiver le compte</button>
                </div>


            </form>

        </div>

    </div>

</div>

@endsection
