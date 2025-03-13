@php
    $param_router = '?router=' . request()->query('router');
@endphp

<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">
        <div class="navbar-nav theme-brand flex-row  text-center">
            <div class="nav-logo">
                <div class="nav-item theme-logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ $company->logo_light }}" class="navbar-logo" alt="logo">
                    </a>
                </div>
                <div class="nav-item theme-text">
                    <a href="{{ route('home') }}" class="nav-link"> {{ $company->name }} </a>
                </div>
            </div>
            <div class="nav-item sidebar-toggle">
                <div class="btn-toggle sidebarCollapse">
                    <i data-feather="chevrons-left"></i>
                </div>
            </div>
        </div>
        <div class="profile-info">
            <div class="user-info">
                <div class="profile-img">
                    <img src="{{ $user->avatar }}" alt="avatar">
                </div>
                <div class="profile-content">
                    <h6 class="">{{ $user->name }}</h6>
                    <p class="">{{ $user->role }}</p>
                </div>
            </div>
        </div>

        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">

            <li class="menu {{ $title == 'Data Router' ? 'active' : '' }}">
                <a href="{{ route('routers.index') }}" aria-expanded="{{ $title == 'Data Router' ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <i data-feather="cloud"></i>
                        <span>List Router</span>
                    </div>
                </a>
            </li>

            <li class="menu menu-heading">
                <div class="heading">
                    <i data-feather="minus"></i>
                    <span>BILLING</span>
                </div>
            </li>
            <li
                class="menu {{ $title == 'Data Odp' || $title == 'Data Customer' || $title == 'Data Package' ? 'active' : '' }}">
                <a href="#billing_nav" data-bs-toggle="collapse"
                    aria-expanded="{{ $title == 'Data Odp' || $title == 'Data Customer' || $title == 'Data Package' ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <i data-feather="database"></i>
                        <span>Master Data</span>
                    </div>
                    <div>
                        <i data-feather="chevron-right"></i>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ $title == 'Data Odp' || $title == 'Data Customer' || $title == 'Data Package' ? 'show' : '' }}"
                    id="billing_nav" data-bs-parent="#accordionExample">
                    <li class="{{ $title == 'Data Package' ? 'active' : '' }}">
                        <a href="{{ route('packages.index') }}{{ $param_router }}"> Package </a>
                    </li>
                    <li class="{{ $title == 'Data Odp' ? 'active' : '' }}">
                        <a href="{{ route('odps.index') }}{{ $param_router }}"> Odp </a>
                    </li>
                    <li class="{{ $title == 'Data Customer' ? 'active' : '' }}">
                        <a href="{{ route('customers.index') }}{{ $param_router }}"> Customer </a>
                    </li>
                </ul>
            </li>

            <li class="menu menu-heading">
                <div class="heading">
                    <i data-feather="minus"></i>
                    <span>SERVICE</span>
                </div>
            </li>

            <li class="menu {{ $title == 'Dashboard' ? 'active' : '' }}">
                <a href="{{ route('mikapi.dashboard') }}{{ $param_router }}"
                    aria-expanded="{{ $title == 'Dashboard' ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="home"></i>
                        <span>Dashboard</span>
                    </div>
                </a>
            </li>

            <li
                class="menu {{ $title == 'Hotspot Profile' || $title == 'Hotspot User' || $title == 'Hotspot Active' || $title == 'Hotspot Host' || $title == 'Hotspot Binding' || $title == 'Hotspot Cookie' ? 'active' : '' }}">
                <a href="#hotspot_nav" data-bs-toggle="collapse"
                    aria-expanded="{{ $title == 'Hotspot Profile' || $title == 'Hotspot User' || $title == 'Hotspot Active' || $title == 'Hotspot Host' || $title == 'Hotspot Binding' || $title == 'Hotspot Cookie' ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <i data-feather="wifi"></i>
                        <span> Hotspot </span>
                    </div>
                    <div>
                        <i data-feather="chevron-right"></i>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ $title == 'Hotspot Profile' || $title == 'Hotspot User' || $title == 'Hotspot Active' || $title == 'Hotspot Host' || $title == 'Hotspot Binding' || $title == 'Hotspot Cookie' ? 'show' : '' }}"
                    id="hotspot_nav" data-bs-parent="#accordionExample">
                    <li class="{{ $title == 'Hotspot Profile' ? 'active' : '' }}">
                        <a href="{{ route('mikapi.hotspot.profile') }}{{ $param_router }}"> Profile </a>
                    </li>
                    <li class="{{ $title == 'Hotspot User' ? 'active' : '' }}">
                        <a href="{{ route('mikapi.hotspot.user') }}{{ $param_router }}"> User </a>
                    </li>
                    <li class="{{ $title == 'Hotspot Active' ? 'active' : '' }}">
                        <a href="{{ route('mikapi.hotspot.active') }}{{ $param_router }}"> Active </a>
                    </li>
                    <li class="{{ $title == 'Hotspot Host' ? 'active' : '' }}">
                        <a href="{{ route('mikapi.hotspot.host') }}{{ $param_router }}"> Host </a>
                    </li>
                    <li class="{{ $title == 'Hotspot Binding' ? 'active' : '' }}">
                        <a href="{{ route('mikapi.hotspot.binding') }}{{ $param_router }}"> Binding </a>
                    </li>
                    <li class="{{ $title == 'Hotspot Cookie' ? 'active' : '' }}">
                        <a href="{{ route('mikapi.hotspot.cookie') }}{{ $param_router }}"> Cookie </a>
                    </li>
                </ul>
            </li>

            <li class="menu {{ $title == 'All Voucher' || $title == 'Generate Hotspot User' ? 'active' : '' }}">
                <a href="#voucher_nav" data-bs-toggle="collapse"
                    aria-expanded="{{ $title == 'All Voucher' || $title == 'Generate Hotspot User' ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <i data-feather="printer"></i>
                        <span> Voucher </span>
                    </div>
                    <div>
                        <i data-feather="chevron-right"></i>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ $title == 'All Voucher' || $title == 'Generate Hotspot User' ? 'show' : '' }}"
                    id="voucher_nav" data-bs-parent="#accordionExample">
                    <li class="{{ $title == 'All Voucher' ? 'active' : '' }}">
                        <a href="{{ route('mikapi.voucher.index') }}{{ $param_router }}"> All Voucher </a>
                    </li>
                    <li class="{{ $title == 'Generate Hotspot User' ? 'active' : '' }}">
                        <a href="{{ route('mikapi.hotspot.user.generate') }}{{ $param_router }}"> Generate User </a>
                    </li>
                </ul>
            </li>

            <li
                class="menu {{ $title == 'PPP Profile' || $title == 'PPP Secret' || $title == 'PPP Active' || $title == 'PPP L2tp Secret' ? 'active' : '' }}">
                <a href="#ppp_nav" data-bs-toggle="collapse"
                    aria-expanded="{{ $title == 'PPP Profile' || $title == 'PPP Secret' || $title == 'PPP Active' || $title == 'PPP L2tp Secret' ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <i data-feather="share-2"></i>
                        <span> PPP </span>
                    </div>
                    <div>
                        <i data-feather="chevron-right"></i>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ $title == 'PPP Profile' || $title == 'PPP Secret' || $title == 'PPP Active' || $title == 'PPP L2tp Secret' ? 'show' : '' }}"
                    id="ppp_nav" data-bs-parent="#accordionExample">
                    <li class="{{ $title == 'PPP Profile' ? 'active' : '' }}">
                        <a href="{{ route('mikapi.ppp.profile') }}{{ $param_router }}"> Profile </a>
                    </li>
                    <li class="{{ $title == 'PPP Secret' ? 'active' : '' }}">
                        <a href="{{ route('mikapi.ppp.secret') }}{{ $param_router }}"> Secret </a>
                    </li>
                    <li class="{{ $title == 'PPP Active' ? 'active' : '' }}">
                        <a href="{{ route('mikapi.ppp.active') }}{{ $param_router }}"> Active </a>
                    </li>
                    <li class="{{ $title == 'PPP L2tp Secret' ? 'active' : '' }}">
                        <a href="{{ route('mikapi.ppp.l2tp_secret') }}{{ $param_router }}"> L2tp Secret </a>
                    </li>
                </ul>
            </li>

            <li
                class="menu {{ $title == 'Hotspot Log' || $title == 'User Log' || $title == 'All Log' ? 'active' : '' }}">
                <a href="#log_nav" data-bs-toggle="collapse"
                    aria-expanded="{{ $title == 'Hotspot Log' || $title == 'User Log' || $title == 'All Log' ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <i data-feather="list"></i>
                        <span> Log </span>
                    </div>
                    <div>
                        <i data-feather="chevron-right"></i>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ $title == 'Hotspot Log' || $title == 'User Log' || $title == 'All Log' ? 'show' : '' }}"
                    id="log_nav" data-bs-parent="#accordionExample">
                    <li class="{{ $title == 'Hotspot Log' ? 'active' : '' }}">
                        <a href="{{ route('mikapi.log.hotspot') }}{{ $param_router }}"> Hotspot Log </a>
                    </li>
                    <li class="{{ $title == 'User Log' ? 'active' : '' }}">
                        <a href="{{ route('mikapi.log.user') }}{{ $param_router }}"> User Log </a>
                    </li>
                    <li class="{{ $title == 'All Log' ? 'active' : '' }}">
                        <a href="{{ route('mikapi.log.all') }}{{ $param_router }}"> All Log </a>
                    </li>
                </ul>
            </li>

            {{-- <li class="menu {{ $title == 'Log' ? 'active' : '' }}">
                <a href="{{ route('mikapi.log.all') }}{{ $param_router }}"
                    aria-expanded="{{ $title == 'Log' ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="list"></i>
                        <span>Log</span>
                    </div>
                </a>
            </li> --}}

            <li class="menu {{ $title == 'DHCP Lease' ? 'active' : '' }}">
                <a href="{{ route('mikapi.dhcp.lease') }}{{ $param_router }}"
                    aria-expanded="{{ $title == 'DHCP Lease' ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="smartphone"></i>
                        <span>DHCP Lease</span>
                    </div>
                </a>
            </li>

            <li class="menu {{ $title == 'Monitor Interface' ? 'active' : '' }}">
                <a href="{{ route('mikapi.monitor.interface') }}{{ $param_router }}"
                    aria-expanded="{{ $title == 'Monitor Interface' ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="monitor"></i>
                        <span>Monitor</span>
                    </div>
                </a>
            </li>

            <li class="menu {{ $title == 'Report' ? 'active' : '' }}">
                <a href="{{ route('mikapi.report') }}{{ $param_router }}"
                    aria-expanded="{{ $title == 'Report' ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="dollar-sign"></i>
                        <span>Report</span>
                    </div>
                </a>
            </li>

            <li class="menu menu-heading">
                <div class="heading">
                    <i data-feather="minus"></i>
                    <span>SYSTEM</span>
                </div>
            </li>
            <li
                class="menu {{ $title == 'System' || $title == 'Scheduler' || $title == 'Package' || $title == 'Script' ? 'active' : '' }}">
                <a href="#system_nav" data-bs-toggle="collapse"
                    aria-expanded="{{ $title == 'System' || $title == 'Scheduler' || $title == 'Package' || $title == 'Script' ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <i data-feather="cpu"></i>
                        <span> SYSTEM</span>
                    </div>
                    <div>
                        <i data-feather="chevron-right"></i>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ $title == 'System' || $title == 'Scheduler' || $title == 'Package' || $title == 'Script' ? 'show' : '' }}"
                    id="system_nav" data-bs-parent="#accordionExample">
                    <li class="{{ $title == 'System' ? 'active' : '' }}">
                        <a href="{{ route('mikapi.system.index') }}{{ $param_router }}"> System </a>
                    </li>
                    <li class="{{ $title == 'Package' ? 'active' : '' }}">
                        <a href="{{ route('mikapi.system.package') }}{{ $param_router }}"> Package </a>
                    </li>
                    <li class="{{ $title == 'Scheduler' ? 'active' : '' }}">
                        <a href="{{ route('mikapi.system.scheduler') }}{{ $param_router }}"> Scheduler </a>
                    </li>
                    <li class="{{ $title == 'Script' ? 'active' : '' }}">
                        <a href="{{ route('mikapi.system.script') }}{{ $param_router }}"> Script </a>
                    </li>
                </ul>
            </li>

            <li
                class="menu {{ $title == 'System User' || $title == 'System Group' || $title == 'User Active' ? 'active' : '' }}">
                <a href="#user_nav" data-bs-toggle="collapse"
                    aria-expanded="{{ $title == 'System User' || $title == 'System Group' || $title == 'User Active' ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <i data-feather="users"></i>
                        <span> USER</span>
                    </div>
                    <div>
                        <i data-feather="chevron-right"></i>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ $title == 'System User' || $title == 'System Group' || $title == 'User Active' ? 'show' : '' }}"
                    id="user_nav" data-bs-parent="#accordionExample">
                    <li class="{{ $title == 'System Group' ? 'active' : '' }}">
                        <a href="{{ route('mikapi.system.group') }}{{ $param_router }}"> Group </a>
                    </li>
                    <li class="{{ $title == 'System User' ? 'active' : '' }}">
                        <a href="{{ route('mikapi.system.user') }}{{ $param_router }}"> User </a>
                    </li>
                    <li class="{{ $title == 'User Active' ? 'active' : '' }}">
                        <a href="{{ route('mikapi.system.user_active') }}{{ $param_router }}"> User Active </a>
                    </li>
                </ul>
            </li>

            <li class="menu {{ $title == 'Voucher Template' ? 'active' : '' }}">
                <a href="{{ route('mikapi.vouchertemplate.index') }}{{ $param_router }}"
                    aria-expanded="{{ $title == 'Voucher Template' ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="slack"></i>
                        <span>Voucher Template</span>
                    </div>
                </a>
            </li>

            <li class="menu menu-heading"></li>
            <li class="menu menu-heading"></li>
            <li class="menu menu-heading"></li>



        </ul>

    </nav>

</div>
