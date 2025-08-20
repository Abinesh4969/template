<!DOCTYPE html>
<html lang="en" class="light scroll-smooth group" data-layout="vertical" data-sidebar="light" data-sidebar-size="lg" data-mode="light" data-topbar="light" data-skin="default" data-navbar="sticky" data-content="fluid" dir="ltr">

<head>

    <meta charset="utf-8">
    <title>
         @yield('title', 'Aetheinfi')
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta content="Minimal Admin & Dashboard Template" name="description">
    <meta content="Themesdesign" name="author">
    <!-- App favicon -->
     
     
    <link rel="shortcut icon" href="{{asset('app-assets/images/logo/darklogo.png')}}">
    <!-- Layout config Js -->
    <script src="{{asset('app-assets/js/layout.js')}}"></script>
    <!-- Icons CSS -->
    
    <!-- Tailwind CSS -->
    

  <link rel="stylesheet" href="{{asset('app-assets/css/tailwind2.css')}}">
</head>

<body class="text-base bg-body-bg text-body font-public dark:text-zink-100 dark:bg-zink-800 group-data-[skin=bordered]:bg-body-bordered group-data-[skin=bordered]:dark:bg-zink-700">
<div class="group-data-[sidebar-size=sm]:min-h-sm group-data-[sidebar-size=sm]:relative">
  
     @include('partials.header')


    <div class="relative min-h-screen group-data-[sidebar-size=sm]:min-h-sm">

        <div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
            <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
               @yield('content')
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
       @include('partials.footer')
     
    </div>

</div>
<!-- end main content -->

@include('partials.customebuttons')
 
 
<script src="{{asset('/app-assets/libs/choices.js/public/assets/scripts/choices.min.js')}}"></script>
<script src="{{asset('/app-assets/libs/@popperjs/core/umd/popper.min.js')}}"></script>
<script src="{{asset('/app-assets/libs/tippy.js/tippy-bundle.umd.min.js')}}"></script>
<script src="{{asset('/app-assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('/app-assets/libs/prismjs/prism.js')}}"></script>
<script src="{{asset('/app-assets/libs/lucide/umd/lucide.js')}}"></script>
<script src="{{asset('/app-assets/js/tailwick.bundle.js')}}"></script>
<!--apexchart js-->
<script src="{{asset('/app-assets/libs/apexcharts/apexcharts.min.js')}}"></script>

<!--dashboard ecommerce init js-->
<script src="{{asset('/app-assets/js/pages/dashboards-ecommerce.init.js')}}"></script>

<!-- Newly added  -->  

<!--buttons dataTables start-->
<script src="{{asset('/app-assets/js/datatables/jquery-3.7.0.js')}}"></script>
<script src="{{asset('/app-assets/js/datatables/data-tables.min.js')}}"></script>
<script src="{{asset('/app-assets/js/datatables/data-tables.tailwindcss.min.js')}}"></script>
<!--buttons dataTables end -->
<!-- first initials start -->
<!-- <script src="{{asset('/app-assets/js/datatables/datatables.init.js')}}"></script> -->
<!-- first initials end -->
<!-- second initials start -->
<script src="{{asset('/app-assets/js/datatables/datatables.buttons.min.js')}}"></script>
<script src="{{asset('/app-assets/js/datatables/jszip.min.js')}}"></script>
<script src="{{asset('/app-assets/js/datatables/pdfmake.min.js')}}"></script>
<script src="{{asset('/app-assets/js/datatables/buttons.html5.min.js')}}"></script>
<script src="{{asset('/app-assets/js/datatables/buttons.print.min.js')}}"></script>
 <!-- second initials end -->


 <!-- Sweet Alerts js -->
<script src="{{asset('/app-assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>

<!--sweet alert init js-->
<script src="{{asset('/app-assets/js/pages/sweetalert.init.js')}}"></script>

<!-- Newly added  End-->  


<!-- App js -->
<script src="{{asset('/app-assets/js/app.js')}}"></script>

@stack('script')

</body>

</html>