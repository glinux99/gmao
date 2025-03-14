@extends('layouts.app')
@section('menuTitle')
Gestion d'utilisateurs
@endsection
@section('contentTitle')
<li class="breadcrumb-item text-dark">
    Détails du technicien </li>
@endsection

@section('content')
<!--begin::Content-->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-xxl">
            <!--begin::Layout-->
            <div class="d-flex flex-column flex-lg-row">
                <!--begin::Content-->
                <div class="flex-lg-row-fluid me-lg-15 order-2 order-lg-1 mb-10 mb-lg-0">
                    <!--begin::Card-->
                    <div class="card card-flush pt-3 mb-5 mb-xl-10">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2 class="fw-bolder">Product Details</h2>
                            </div>
                            <!--begin::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <a href="../../demo8/dist/apps/subscriptions/add.html" class="btn btn-light-primary">Update Product</a>
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-3">
                            <!--begin::Section-->
                            <div class="mb-10">
                                <!--begin::Title-->
                                <h5 class="mb-4">Billing Address:</h5>
                                <!--end::Title-->
                                <!--begin::Details-->
                                <div class="d-flex flex-wrap py-5">
                                    <!--begin::Row-->
                                    <div class="flex-equal me-5">
                                        <!--begin::Details-->
                                        <table class="table fs-6 fw-bold gs-0 gy-2 gx-2 m-0">
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400 min-w-175px w-175px">Bill to:</td>
                                                <td class="text-gray-800 min-w-200px">
                                                    <a href="../../demo8/dist/pages/apps/customers/view.html" class="text-gray-800 text-hover-primary">e.smith@kpmg.com.au</a>
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Customer Name:</td>
                                                <td class="text-gray-800">Emma Smith</td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Address:</td>
                                                <td class="text-gray-800">Floor 10, 101 Avenue of the Light Square, New York, NY, 10050.</td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Phone:</td>
                                                <td class="text-gray-800">(555) 555-1234</td>
                                            </tr>
                                            <!--end::Row-->
                                        </table>
                                        <!--end::Details-->
                                    </div>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <div class="flex-equal">
                                        <!--begin::Details-->
                                        <table class="table fs-6 fw-bold gs-0 gy-2 gx-2 m-0">
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400 min-w-175px w-175px">Subscribed Product:</td>
                                                <td class="text-gray-800 min-w-200px">
                                                    <a href="#" class="text-gray-800 text-hover-primary">Basic Bundle</a>
                                                </td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Subscription Fees:</td>
                                                <td class="text-gray-800">$149.99 / Year</td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Billing method:</td>
                                                <td class="text-gray-800">Annually</td>
                                            </tr>
                                            <!--end::Row-->
                                            <!--begin::Row-->
                                            <tr>
                                                <td class="text-gray-400">Currency:</td>
                                                <td class="text-gray-800">USD - US Dollar</td>
                                            </tr>
                                            <!--end::Row-->
                                        </table>
                                        <!--end::Details-->
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Section-->
                            <!--begin::Section-->
                            <div class="mb-0">
                                <!--begin::Title-->
                                <h5 class="mb-4">Subscribed Products:</h5>
                                <!--end::Title-->
                                <!--begin::Product table-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-dashed fs-6 gy-4 mb-0">
                                        <!--begin::Table head-->
                                        <thead>
                                            <!--begin::Table row-->
                                            <tr class="border-bottom border-gray-200 text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-150px">Product</th>
                                                <th class="min-w-125px">Subscription ID</th>
                                                <th class="min-w-125px">Qty</th>
                                                <th class="min-w-125px">Total</th>
                                                <th class="text-end min-w-70px">Actions</th>
                                            </tr>
                                            <!--end::Table row-->
                                        </thead>
                                        <!--end::Table head-->
                                        <!--begin::Table body-->
                                        <tbody class="fw-bold text-gray-800">
                                            <tr>
                                                <td>
                                                    <label class="w-150px">Basic Bundle</label>
                                                    <div class="fw-normal text-gray-600">Basic yearly bundle</div>
                                                </td>
                                                <td>
                                                    <span class="badge badge-light-danger">sub_4567_8765</span>
                                                </td>
                                                <td>1</td>
                                                <td>$149.99 / Year</td>
                                                <td class="text-end">
                                                    <!--begin::Action-->
                                                    <a href="#" class="btn btn-icon btn-active-light-primary w-30px h-30px" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                                        <span class="svg-icon svg-icon-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path d="M17.5 11H6.5C4 11 2 9 2 6.5C2 4 4 2 6.5 2H17.5C20 2 22 4 22 6.5C22 9 20 11 17.5 11ZM15 6.5C15 7.9 16.1 9 17.5 9C18.9 9 20 7.9 20 6.5C20 5.1 18.9 4 17.5 4C16.1 4 15 5.1 15 6.5Z" fill="black" />
                                                                <path opacity="0.3" d="M17.5 22H6.5C4 22 2 20 2 17.5C2 15 4 13 6.5 13H17.5C20 13 22 15 22 17.5C22 20 20 22 17.5 22ZM4 17.5C4 18.9 5.1 20 6.5 20C7.9 20 9 18.9 9 17.5C9 16.1 7.9 15 6.5 15C5.1 15 4 16.1 4 17.5Z" fill="black" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </a>
                                                    <!--begin::Menu-->
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-6 w-200px py-4" data-kt-menu="true">
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3">Pause Subscription</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3" data-kt-subscriptions-view-action="delete">Edit Subscription</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link text-danger px-3" data-kt-subscriptions-view-action="edit">Cancel Subscription</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>
                                                    <!--end::Menu-->
                                                    <!--end::Action-->
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label class="w-150px">Pro Bundle</label>
                                                    <div class="fw-normal text-gray-400">Basic yearly bundle</div>
                                                </td>
                                                <td>
                                                    <span class="badge badge-light-danger">sub_4567_3433</span>
                                                </td>
                                                <td>5</td>
                                                <td>$949.99 / Year</td>
                                                <td class="text-end">
                                                    <!--begin::Action-->
                                                    <a href="#" class="btn btn-icon btn-active-light-primary w-30px h-30px" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                        <!--begin::Svg Icon | path: icons/duotune/general/gen019.svg-->
                                                        <span class="svg-icon svg-icon-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path d="M17.5 11H6.5C4 11 2 9 2 6.5C2 4 4 2 6.5 2H17.5C20 2 22 4 22 6.5C22 9 20 11 17.5 11ZM15 6.5C15 7.9 16.1 9 17.5 9C18.9 9 20 7.9 20 6.5C20 5.1 18.9 4 17.5 4C16.1 4 15 5.1 15 6.5Z" fill="black" />
                                                                <path opacity="0.3" d="M17.5 22H6.5C4 22 2 20 2 17.5C2 15 4 13 6.5 13H17.5C20 13 22 15 22 17.5C22 20 20 22 17.5 22ZM4 17.5C4 18.9 5.1 20 6.5 20C7.9 20 9 18.9 9 17.5C9 16.1 7.9 15 6.5 15C5.1 15 4 16.1 4 17.5Z" fill="black" />
                                                            </svg>
                                                        </span>
                                                        <!--end::Svg Icon-->
                                                    </a>
                                                    <!--begin::Menu-->
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-6 w-200px py-4" data-kt-menu="true">
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3">Pause Subscription</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3" data-kt-subscriptions-view-action="delete">Edit Subscription</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link text-danger px-3" data-kt-subscriptions-view-action="edit">Cancel Subscription</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>
                                                    <!--end::Menu-->
                                                    <!--end::Action-->
                                                </td>
                                            </tr>
                                        </tbody>
                                        <!--end::Table body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Product table-->
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                    <!--begin::Card-->
                    <div class="card card-flush pt-3 mb-5 mb-xl-10">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>Recent Events</h2>
                            </div>
                            <!--end::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <a href="#" class="btn btn-light-primary">View All Events</a>
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0">
                            <!--begin::Table wrapper-->
                            <div class="table-responsive">
                                <!--begin::Table-->
                                <table class="table align-middle table-row-dashed fs-6 text-gray-600 fw-bold gy-5" id="kt_table_customers_events">
                                    <!--begin::Table body-->
                                    <tbody>
                                        <!--begin::Table row-->
                                        <tr>
                                            <!--begin::Event=-->
                                            <td class="min-w-400px">
                                            <a href="#" class="fw-bolder text-gray-800 text-hover-primary me-1">Melody Macy</a>has made payment to
                                            <a href="#" class="fw-bolder text-gray-800 text-hover-primary">2626-7150</a></td>
                                            <!--end::Event=-->
                                            <!--begin::Timestamp=-->
                                            <td class="pe-0 text-gray-600 text-end min-w-200px">15 Apr 2021, 6:43 am</td>
                                            <!--end::Timestamp=-->
                                        </tr>
                                        <!--end::Table row-->
                                        <!--begin::Table row-->
                                        <tr>
                                            <!--begin::Event=-->
                                            <td class="min-w-400px">
                                            <a href="#" class="fw-bolder text-gray-800 text-hover-primary me-1">Melody Macy</a>has made payment to
                                            <a href="#" class="fw-bolder text-gray-800 text-hover-primary">2626-7150</a></td>
                                            <!--end::Event=-->
                                            <!--begin::Timestamp=-->
                                            <td class="pe-0 text-gray-600 text-end min-w-200px">19 Aug 2021, 6:05 pm</td>
                                            <!--end::Timestamp=-->
                                        </tr>
                                        <!--end::Table row-->
                                        <!--begin::Table row-->
                                        <tr>
                                            <!--begin::Event=-->
                                            <td class="min-w-400px">Invoice
                                            <a href="#" class="fw-bolder text-gray-800 text-hover-primary me-1">7486-4409</a>status has changed from
                                            <span class="badge badge-light-primary me-1">In Transit</span>to
                                            <span class="badge badge-light-success">Approved</span></td>
                                            <!--end::Event=-->
                                            <!--begin::Timestamp=-->
                                            <td class="pe-0 text-gray-600 text-end min-w-200px">05 May 2021, 10:30 am</td>
                                            <!--end::Timestamp=-->
                                        </tr>
                                        <!--end::Table row-->
                                        <!--begin::Table row-->
                                        <tr>
                                            <!--begin::Event=-->
                                            <td class="min-w-400px">Invoice
                                            <a href="#" class="fw-bolder text-gray-800 text-hover-primary me-1">7486-4409</a>status has changed from
                                            <span class="badge badge-light-primary me-1">In Transit</span>to
                                            <span class="badge badge-light-success">Approved</span></td>
                                            <!--end::Event=-->
                                            <!--begin::Timestamp=-->
                                            <td class="pe-0 text-gray-600 text-end min-w-200px">10 Nov 2021, 11:05 am</td>
                                            <!--end::Timestamp=-->
                                        </tr>
                                        <!--end::Table row-->
                                        <!--begin::Table row-->
                                        <tr>
                                            <!--begin::Event=-->
                                            <td class="min-w-400px">Invoice
                                            <a href="#" class="fw-bolder text-gray-800 text-hover-primary me-1">8132-4943</a>is
                                            <span class="badge badge-light-info">In Progress</span></td>
                                            <!--end::Event=-->
                                            <!--begin::Timestamp=-->
                                            <td class="pe-0 text-gray-600 text-end min-w-200px">20 Jun 2021, 6:43 am</td>
                                            <!--end::Timestamp=-->
                                        </tr>
                                        <!--end::Table row-->
                                    </tbody>
                                    <!--end::Table body-->
                                </table>
                                <!--end::Table-->
                            </div>
                            <!--end::Table wrapper-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                    <!--begin::Card-->
                    <div class="card card-flush pt-3 mb-5 mb-xl-10">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>Invoices</h2>
                            </div>
                            <!--end::Card title-->
                            <!--begin::Toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Tab nav-->
                                <ul class="nav nav-stretch fs-5 fw-bold nav-line-tabs nav-line-tabs-2x border-transparent" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a id="kt_referrals_year_tab" class="nav-link text-active-primary active" data-bs-toggle="tab" role="tab" href="#kt_customer_details_invoices_1">This Year</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a id="kt_referrals_2019_tab" class="nav-link text-active-primary ms-3" data-bs-toggle="tab" role="tab" href="#kt_customer_details_invoices_2">2020</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a id="kt_referrals_2018_tab" class="nav-link text-active-primary ms-3" data-bs-toggle="tab" role="tab" href="#kt_customer_details_invoices_3">2019</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a id="kt_referrals_2017_tab" class="nav-link text-active-primary ms-3" data-bs-toggle="tab" role="tab" href="#kt_customer_details_invoices_4">2018</a>
                                    </li>
                                </ul>
                                <!--end::Tab nav-->
                            </div>
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-2">
                            <!--begin::Tab Content-->
                            <div id="kt_referred_users_tab_content" class="tab-content">
                                <!--begin::Tab panel-->
                                <div id="kt_customer_details_invoices_1" class="tab-pane fade show active" role="tabpanel">
                                    <!--begin::Table wrapper-->
                                    <div class="table-responsive">
                                        <!--begin::Table-->
                                        <table id="kt_customer_details_invoices_table_1" class="table align-middle table-row-dashed fs-6 fw-bolder gs-0 gy-4 p-0 m-0">
                                            <!--begin::Thead-->
                                            <thead class="border-bottom border-gray-200 fs-7 text-uppercase fw-bolder">
                                                <tr class="text-start text-gray-400">
                                                    <th class="min-w-100px">Order ID</th>
                                                    <th class="min-w-100px">Amount</th>
                                                    <th class="min-w-100px">Status</th>
                                                    <th class="min-w-125px">Date</th>
                                                    <th class="w-100px">Invoice</th>
                                                </tr>
                                            </thead>
                                            <!--end::Thead-->
                                            <!--begin::Tbody-->
                                            <tbody class="fs-6 fw-bold text-gray-600">
                                                <tr>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">102445788</a>
                                                    </td>
                                                    <td class="text-success">$38.00</td>
                                                    <td>
                                                        <span class="badge badge-light-success">Approved</span>
                                                    </td>
                                                    <td>Nov 01, 2020</td>
                                                    <td class="">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">423445721</a>
                                                    </td>
                                                    <td class="text-danger">$-2.60</td>
                                                    <td>
                                                        <span class="badge badge-light-info">In progress</span>
                                                    </td>
                                                    <td>Oct 24, 2020</td>
                                                    <td class="">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">312445984</a>
                                                    </td>
                                                    <td class="text-success">$76.00</td>
                                                    <td>
                                                        <span class="badge badge-light-info">In progress</span>
                                                    </td>
                                                    <td>Oct 08, 2020</td>
                                                    <td class="">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">312445984</a>
                                                    </td>
                                                    <td class="text-success">$5.00</td>
                                                    <td>
                                                        <span class="badge badge-light-warning">Pending</span>
                                                    </td>
                                                    <td>Sep 15, 2020</td>
                                                    <td class="">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">523445943</a>
                                                    </td>
                                                    <td class="text-danger">$-1.30</td>
                                                    <td>
                                                        <span class="badge badge-light-info">In progress</span>
                                                    </td>
                                                    <td>May 30, 2020</td>
                                                    <td class="">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <!--end::Tbody-->
                                        </table>
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Table wrapper-->
                                </div>
                                <!--end::Tab panel-->
                                <!--begin::Tab panel-->
                                <div id="kt_customer_details_invoices_2" class="tab-pane fade" role="tabpanel">
                                    <!--begin::Table wrapper-->
                                    <div class="table-responsive">
                                        <!--begin::Table-->
                                        <table id="kt_customer_details_invoices_table_2" class="table align-middle table-row-dashed fs-6 fw-bolder gs-0 gy-4 p-0 m-0">
                                            <!--begin::Thead-->
                                            <thead class="border-bottom border-gray-200 fs-7 text-uppercase fw-bolder">
                                                <tr class="text-start text-gray-400">
                                                    <th class="min-w-100px">Order ID</th>
                                                    <th class="min-w-100px">Amount</th>
                                                    <th class="min-w-100px">Status</th>
                                                    <th class="min-w-125px">Date</th>
                                                    <th class="w-100px">Invoice</th>
                                                </tr>
                                            </thead>
                                            <!--end::Thead-->
                                            <!--begin::Tbody-->
                                            <tbody class="fs-6 fw-bold text-gray-600">
                                                <tr>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">523445943</a>
                                                    </td>
                                                    <td class="text-danger">$-1.30</td>
                                                    <td>
                                                        <span class="badge badge-light-warning">Pending</span>
                                                    </td>
                                                    <td>May 30, 2020</td>
                                                    <td class="">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">231445943</a>
                                                    </td>
                                                    <td class="text-success">$204.00</td>
                                                    <td>
                                                        <span class="badge badge-light-danger">Rejected</span>
                                                    </td>
                                                    <td>Apr 22, 2020</td>
                                                    <td class="">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">426445943</a>
                                                    </td>
                                                    <td class="text-success">$31.00</td>
                                                    <td>
                                                        <span class="badge badge-light-success">Approved</span>
                                                    </td>
                                                    <td>Feb 09, 2020</td>
                                                    <td class="">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">984445943</a>
                                                    </td>
                                                    <td class="text-success">$52.00</td>
                                                    <td>
                                                        <span class="badge badge-light-success">Approved</span>
                                                    </td>
                                                    <td>Nov 01, 2020</td>
                                                    <td class="">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">324442313</a>
                                                    </td>
                                                    <td class="text-danger">$-0.80</td>
                                                    <td>
                                                        <span class="badge badge-light-warning">Pending</span>
                                                    </td>
                                                    <td>Jan 04, 2020</td>
                                                    <td class="">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <!--end::Tbody-->
                                        </table>
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Table wrapper-->
                                </div>
                                <!--end::Tab panel-->
                                <!--begin::Tab panel-->
                                <div id="kt_customer_details_invoices_3" class="tab-pane fade" role="tabpanel">
                                    <!--begin::Table wrapper-->
                                    <div class="table-responsive">
                                        <!--begin::Table-->
                                        <table id="kt_customer_details_invoices_table_3" class="table align-middle table-row-dashed fs-6 fw-bolder gs-0 gy-4 p-0 m-0">
                                            <!--begin::Thead-->
                                            <thead class="border-bottom border-gray-200 fs-7 text-uppercase fw-bolder">
                                                <tr class="text-start text-gray-400">
                                                    <th class="min-w-100px">Order ID</th>
                                                    <th class="min-w-100px">Amount</th>
                                                    <th class="min-w-100px">Status</th>
                                                    <th class="min-w-125px">Date</th>
                                                    <th class="w-100px">Invoice</th>
                                                </tr>
                                            </thead>
                                            <!--end::Thead-->
                                            <!--begin::Tbody-->
                                            <tbody class="fs-6 fw-bold text-gray-600">
                                                <tr>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">426445943</a>
                                                    </td>
                                                    <td class="text-success">$31.00</td>
                                                    <td>
                                                        <span class="badge badge-light-danger">Rejected</span>
                                                    </td>
                                                    <td>Feb 09, 2020</td>
                                                    <td class="">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">984445943</a>
                                                    </td>
                                                    <td class="text-success">$52.00</td>
                                                    <td>
                                                        <span class="badge badge-light-success">Approved</span>
                                                    </td>
                                                    <td>Nov 01, 2020</td>
                                                    <td class="">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">324442313</a>
                                                    </td>
                                                    <td class="text-danger">$-0.80</td>
                                                    <td>
                                                        <span class="badge badge-light-danger">Rejected</span>
                                                    </td>
                                                    <td>Jan 04, 2020</td>
                                                    <td class="">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">312445984</a>
                                                    </td>
                                                    <td class="text-success">$5.00</td>
                                                    <td>
                                                        <span class="badge badge-light-info">In progress</span>
                                                    </td>
                                                    <td>Sep 15, 2020</td>
                                                    <td class="">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">102445788</a>
                                                    </td>
                                                    <td class="text-success">$38.00</td>
                                                    <td>
                                                        <span class="badge badge-light-info">In progress</span>
                                                    </td>
                                                    <td>Nov 01, 2020</td>
                                                    <td class="">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <!--end::Tbody-->
                                        </table>
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Table wrapper-->
                                </div>
                                <!--end::Tab panel-->
                                <!--begin::Tab panel-->
                                <div id="kt_customer_details_invoices_4" class="tab-pane fade" role="tabpanel">
                                    <!--begin::Table wrapper-->
                                    <div class="table-responsive">
                                        <!--begin::Table-->
                                        <table id="kt_customer_details_invoices_table_4" class="table align-middle table-row-dashed fs-6 fw-bolder gs-0 gy-4 p-0 m-0">
                                            <!--begin::Thead-->
                                            <thead class="border-bottom border-gray-200 fs-7 text-uppercase fw-bolder">
                                                <tr class="text-start text-gray-400">
                                                    <th class="min-w-100px">Order ID</th>
                                                    <th class="min-w-100px">Amount</th>
                                                    <th class="min-w-100px">Status</th>
                                                    <th class="min-w-125px">Date</th>
                                                    <th class="w-100px">Invoice</th>
                                                </tr>
                                            </thead>
                                            <!--end::Thead-->
                                            <!--begin::Tbody-->
                                            <tbody class="fs-6 fw-bold text-gray-600">
                                                <tr>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">102445788</a>
                                                    </td>
                                                    <td class="text-success">$38.00</td>
                                                    <td>
                                                        <span class="badge badge-light-info">In progress</span>
                                                    </td>
                                                    <td>Nov 01, 2020</td>
                                                    <td class="">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">423445721</a>
                                                    </td>
                                                    <td class="text-danger">$-2.60</td>
                                                    <td>
                                                        <span class="badge badge-light-danger">Rejected</span>
                                                    </td>
                                                    <td>Oct 24, 2020</td>
                                                    <td class="">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">102445788</a>
                                                    </td>
                                                    <td class="text-success">$38.00</td>
                                                    <td>
                                                        <span class="badge badge-light-danger">Rejected</span>
                                                    </td>
                                                    <td>Nov 01, 2020</td>
                                                    <td class="">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">423445721</a>
                                                    </td>
                                                    <td class="text-danger">$-2.60</td>
                                                    <td>
                                                        <span class="badge badge-light-success">Approved</span>
                                                    </td>
                                                    <td>Oct 24, 2020</td>
                                                    <td class="">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="#" class="text-gray-600 text-hover-primary">426445943</a>
                                                    </td>
                                                    <td class="text-success">$31.00</td>
                                                    <td>
                                                        <span class="badge badge-light-info">In progress</span>
                                                    </td>
                                                    <td>Feb 09, 2020</td>
                                                    <td class="">
                                                        <button class="btn btn-sm btn-light btn-active-light-primary">Download</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <!--end::Tbody-->
                                        </table>
                                        <!--end::Table-->
                                    </div>
                                    <!--end::Table wrapper-->
                                </div>
                                <!--end::Tab panel-->
                            </div>
                            <!--end::Tab Content-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Content-->
                <!--begin::Sidebar-->
                <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-300px mb-10 order-1 order-lg-2">
                    <!--begin::Card-->
                    <div class="card card-flush mb-0" data-kt-sticky="true" data-kt-sticky-name="subscription-summary" data-kt-sticky-offset="{default: false, lg: '200px'}" data-kt-sticky-width="{lg: '250px', xl: '300px'}" data-kt-sticky-left="auto" data-kt-sticky-top="150px" data-kt-sticky-animation="false" data-kt-sticky-zindex="95">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>Summary</h2>
                            </div>
                            <!--end::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">
                                <!--begin::More options-->
                                <a href="#" class="btn btn-sm btn-light btn-icon" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    <!--begin::Svg Icon | path: icons/duotune/general/gen052.svg-->
                                    <span class="svg-icon svg-icon-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                            <rect x="10" y="10" width="4" height="4" rx="2" fill="black" />
                                            <rect x="17" y="10" width="4" height="4" rx="2" fill="black" />
                                            <rect x="3" y="10" width="4" height="4" rx="2" fill="black" />
                                        </svg>
                                    </span>
                                    <!--end::Svg Icon-->
                                </a>
                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-6 w-200px py-4" data-kt-menu="true">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3">Pause Subscription</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-kt-subscriptions-view-action="delete">Edit Subscription</a>
                                    </div>
                                    <!--end::Menu item-->
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link text-danger px-3" data-kt-subscriptions-view-action="edit">Cancel Subscription</a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu-->
                                <!--end::More options-->
                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0 fs-6">
                            <!--begin::Section-->
                            <div class="mb-7">
                                <!--begin::Details-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-60px symbol-circle me-3">
                                        <img alt="Pic" src="assets/media/avatars/150-4.jpg" />
                                    </div>
                                    <!--end::Avatar-->
                                    <!--begin::Info-->
                                    <div class="d-flex flex-column">
                                        <!--begin::Name-->
                                        <a href="#" class="fs-4 fw-bolder text-gray-900 text-hover-primary me-2">Sean Bean</a>
                                        <!--end::Name-->
                                        <!--begin::Email-->
                                        <a href="#" class="fw-bold text-gray-600 text-hover-primary">sean@dellito.com</a>
                                        <!--end::Email-->
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Details-->
                            </div>
                            <!--end::Section-->
                            <!--begin::Seperator-->
                            <div class="separator separator-dashed mb-7"></div>
                            <!--end::Seperator-->
                            <!--begin::Section-->
                            <div class="mb-7">
                                <!--begin::Title-->
                                <h5 class="mb-4">Product details</h5>
                                <!--end::Title-->
                                <!--begin::Details-->
                                <div class="mb-0">
                                    <!--begin::Plan-->
                                    <span class="badge badge-light-info me-2">Basic Bundle</span>
                                    <!--end::Plan-->
                                    <!--begin::Price-->
                                    <span class="fw-bold text-gray-600">$149.99 / Year</span>
                                    <!--end::Price-->
                                </div>
                                <!--end::Details-->
                            </div>
                            <!--end::Section-->
                            <!--begin::Seperator-->
                            <div class="separator separator-dashed mb-7"></div>
                            <!--end::Seperator-->
                            <!--begin::Section-->
                            <div class="mb-10">
                                <!--begin::Title-->
                                <h5 class="mb-4">Payment Details</h5>
                                <!--end::Title-->
                                <!--begin::Details-->
                                <div class="mb-0">
                                    <!--begin::Card info-->
                                    <div class="fw-bold text-gray-600 d-flex align-items-center">Mastercard
                                    <img src="assets/media/svg/card-logos/mastercard.svg" class="w-35px ms-2" alt="" /></div>
                                    <!--end::Card info-->
                                    <!--begin::Card expiry-->
                                    <div class="fw-bold text-gray-600">Expires Dec 2024</div>
                                    <!--end::Card expiry-->
                                </div>
                                <!--end::Details-->
                            </div>
                            <!--end::Section-->
                            <!--begin::Seperator-->
                            <div class="separator separator-dashed mb-7"></div>
                            <!--end::Seperator-->
                            <!--begin::Section-->
                            <div class="mb-10">
                                <!--begin::Title-->
                                <h5 class="mb-4">Subscription Details</h5>
                                <!--end::Title-->
                                <!--begin::Details-->
                                <table class="table fs-6 fw-bold gs-0 gy-2 gx-2">
                                    <!--begin::Row-->
                                    <tr class="">
                                        <td class="text-gray-400">Subscription ID:</td>
                                        <td class="text-gray-800">sub_4567_8765</td>
                                    </tr>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <tr class="">
                                        <td class="text-gray-400">Started:</td>
                                        <td class="text-gray-800">15 Apr 2021</td>
                                    </tr>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <tr class="">
                                        <td class="text-gray-400">Status:</td>
                                        <td>
                                            <span class="badge badge-light-success">Active</span>
                                        </td>
                                    </tr>
                                    <!--end::Row-->
                                    <!--begin::Row-->
                                    <tr class="">
                                        <td class="text-gray-400">Next Invoice:</td>
                                        <td class="text-gray-800">15 Apr 2022</td>
                                    </tr>
                                    <!--end::Row-->
                                </table>
                                <!--end::Details-->
                            </div>
                            <!--end::Section-->
                            <!--begin::Actions-->
                            <div class="mb-0">
                                <a href="../../demo8/dist/apps/subscriptions/add.html" class="btn btn-primary" id="kt_subscriptions_create_button">Edit Subscription</a>
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Sidebar-->
            </div>
            <!--end::Layout-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Post-->
</div>
<!--end::Content-->
@endsection
