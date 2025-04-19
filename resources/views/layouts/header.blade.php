
<head>
    <title>@yield('title', 'VE Controller | Acceuil')</title>
    <meta charset="utf-8"/>
    <meta name="description" content="
        Ve
    "/>
    <meta name="keywords" content="
       Ve
    "/>
    @auth
        <meta name="user_auth" content="{{ Auth::user()}}">
    @endauth
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="" />
    <meta property="og:url" content=""/>
    <meta property="og:site_name" content="" />
    <link rel="canonical" href=""/>
    <link rel="shortcut icon" href="../../../assets/media/logos/fa.png"/>

    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>        <!--end::Fonts-->

                <!--begin::Vendor Stylesheets(used for this page only)-->
                        <link href="{{asset('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css"/>
                    <!--end::Vendor Stylesheets-->


                <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
                        <link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css"/>
                        <link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css"/>
                    <!--end::Global Stylesheets Bundle-->
<style>
    .bg-primary{
        background: #e15f14!important;
    }
    .text-primary{
        color:#e15f14!important;
    }
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999; /* Ensure it's on top */
      }

      .loading-spinner {
        /* Add any styling for the spinner container if needed */
      }
</style>
                <!-- Google tag (gtag.js) -->
                 {{-- @vite(['resources/js/app.js']) --}}
    @vite(['resources/js/app.js'])
<script async src="https://www.googletagmanager.com/gtag/js?id=G-52YZ3XGZJ6"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());

gtag('config', 'G-52YZ3XGZJ6');
</script>
    <script>
        // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking)
        if (window.top != window.self) {
            window.top.location.replace(window.self.location.href);
        }
    </script>
</head>

