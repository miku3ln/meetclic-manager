<!-- BUSINESS-MANAGER-TEMPLATE-SIDEBAR -->

<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

    <div class="slimscroll-menu">

        @if(isset($menuStringHtml))
            <!--- Sidemenu -->
            <div id="sidebar-menu">

                <ul class="metismenu" id="side-menu">

                    @if(View::hasSection('menuCurrent'))
                        @yield('menuCurrent')
                    @else
                        {{$menuStringHtml}}

                    @endif
                </ul>

            </div>
        @endif
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->
