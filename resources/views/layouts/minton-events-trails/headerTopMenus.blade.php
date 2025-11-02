<ul class="list-unstyled topnav-menu topnav-menu-left m-0">
    <li>
        <button class="button-menu-mobile waves-effect waves-light">
            <i class="fe-menu"></i>
        </button>
    </li>

    @if(View::hasSection('headerMenuManagerLeft'))
        @yield('headerMenuManagerLeft')
    @else

    @endif
    @if(View::hasSection('headerMenuManagerRight'))
        @yield('headerMenuManagerRight')
    @else
       
    @endif
</ul>
