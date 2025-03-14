@extends('layouts.auth')
@section('content')
    <form class="form w-100" method="POST" action="{{ route('login') }}">
        @csrf

        <div class="text-center mb-10">

            <h1 class="text-dark fw-bold fs-2 mb-3">
                Connection</h1>



        </div>




        <div class="fv-row mb-3">

            <label class="form-label fs-6 fw-bold text-dark">Email</label>



            <input class="form-control form-control-lg form-control-solid" type="text" name="email"
                placeholder="Saissez votre addresse email" />

        </div>



        <div class="fv-row mb-10">

            <div class="d-flex flex-stack mb-2">

                <label class="form-label fw-bold text-dark fs-6 mb-0">Mot de passe</label>



            </div>


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

            <div class="row mb-8 d-flex align-items-stretch justify-content-between">
                <div class="col-6">
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" v-model="form.remember" value="1" />
                        <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">
                            Se souvenir de moi
                        </span>
                    </label>
                </div>
                <div class="col-6 d-flex align-items-stretch justify-content-end">

                    <a href="/" class="link-info fs-6 fw-bold">
                        Mot de passe oublie
                    </a>

                </div>
            </div>
        </div>



        <div class="text-center">

            <button type="submit" class="btn btn-lg w-100 mb-5" style="background: #e15f14">
                <span class="indicator-label text-white">
                    Continuer
                </span>
            </button>



        </div>


    </form>
@endsection
