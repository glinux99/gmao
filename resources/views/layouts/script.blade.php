<script>
    var hostUrl = "assets/";
</script>
<script type="text/ecmascript-6">
    window.Laravel = 1234;
</script>

<!--begin::Javascript-->
<!--begin::Global Javascript Bundle(used by all pages)-->
{{-- <script src="{{ asset('js/app.js')}}"></script> --}}
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Page Vendors Javascript(used by this page)-->
<script src="{{asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>
<!--end::Page Vendors Javascript-->
<!--begin::Page Custom Javascript(used by this page)-->
<script src="{{asset('assets/js/widgets.bundle.js')}}"></script>
<script src="{{asset('assets/js/custom/utilities/modals/create-app.js')}}"></script>
<script src="{{asset('assets/js/custom/utilities/modals/upgrade-plan.js')}}"></script>
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<script src="{{asset('assets/js/custom/apps/projects/list/list.js')}}"></script>
<script src="{{asset('assets/js/widgets.bundle.js')}}"></script>
<script src="{{asset('assets/js/custom/utilities/modals/upgrade-plan.js')}}"></script>
<script src="{{asset('assets/js/custom/utilities/modals/create-account.js')}}"></script>
<script src="{{asset('assets/js/custom/utilities/modals/create-campaign.js')}}"></script>
<script src="{{asset('assets/js/custom/utilities/modals/users-search.js')}}"></script>
<script src="{{asset('assets/js/custom/apps/user-management/users/list/table.js')}}"></script>
<script src="{{asset('assets/js/custom/account/settings/signin-methods.js')}}"></script>
<script src="{{asset('assets/js/custom/account/settings/profile-details.js')}}"></script>
<script src="{{asset('assets/js/custom/account/settings/deactivate-account.js')}}"></script>
<script src="{{asset('assets/js/custom/pages/user-profile/general.js')}}"></script>

<script>
    function updateFunction(self){
                    // alert(self);
                    document.getElementById('id').value
                    document.getElementById("title").value=self.title;
                    document.getElementById("description").value=self.description;
                    // alert(123);
                }

                function updateFunctionAuthor(self){
                    // alert(self.id);
                    document.getElementById('id').value=self.id;
                    // document.getElementById("title").value=self.title;
                    document.getElementById("name").value=self.user.name;
                    document.getElementById("description").value=self.user.description ;
                    // alert(123);
                }

</script>
