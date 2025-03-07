<div class="sidenav-menu">

    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="logo">
        <span class="logo-light">
            <span class="logo-lg"><img src="{{ $company->logo_light }}" alt="logo">{{ $company->name }}</span>
            <span class="logo-sm"><img src="{{ $company->logo_dark }}" alt="small logo"></span>
        </span>

        <span class="logo-dark">
            <span class="logo-lg"><img src="{{ $company->logo_light }}" alt="dark logo">{{ $company->name }}</span>
            <span class="logo-sm"><img src="{{ $company->logo_dark }}" alt="small logo"></span>
        </span>
    </a>

    <!-- Sidebar Hover Menu Toggle Button -->
    <button class="button-sm-hover">
        <i class="ti ti-circle align-middle"></i>
    </button>

    <!-- Full Sidebar Menu Close Button -->
    <button class="button-close-fullsidebar">
        <i class="ti ti-x align-middle"></i>
    </button>

    <div data-simplebar>

        <!--- Sidenav Menu -->
        <ul class="side-nav">
            <li class="side-nav-title">Dash</li>

            <li class="side-nav-item">
                <a href="{{ route('home') }}" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-dashboard"></i></span>
                    <span class="menu-text"> Sales </span>
                    <span class="badge bg-success rounded-pill">5</span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="dashboard-clinic.html" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-building-hospital"></i></span>
                    <span class="menu-text"> Clinic </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="dashboard-wallet.html" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-wallet"></i></span>
                    <span class="menu-text"> eWallet </span>
                    <span class="badge p-0 menu-alert fs-16 text-danger">
                        <i class="ti ti-info-triangle" data-bs-html="true" data-bs-toggle="tooltip"
                            data-bs-placement="top" data-bs-custom-class="tooltip-warning"
                            data-bs-title="Your wallet balance is <b>low!</b>"></i>
                    </span>
                </a>
            </li>

            <li class="side-nav-title mt-2">Components</li>

            @php
                $nav_master = ['Data User', 'Data Bank', 'Data Temporary IP', 'Data Voucher Template'];
                $nav_master_state = in_array($title, $nav_master);
            @endphp

            <li class="side-nav-item {{ $nav_master_state ? 'active' : '' }}">
                <a data-bs-toggle="collapse" href="#master_data_nav" aria-expanded="false"
                    aria-controls="master_data_nav" class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-database"></i></span>
                    <span class="menu-text"> Master Data </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse {{ $nav_master_state ? 'show' : '' }}" id="master_data_nav">
                    <ul class="sub-menu">
                        <li class="side-nav-item {{ $title == 'Data User' ? 'active' : '' }}">
                            <a href="{{ route('users.index') }}"
                                class="side-nav-link {{ $title == 'Data User' ? 'active' : '' }}">
                                <span class="menu-text">User</span>
                            </a>
                        </li>
                        <li class="side-nav-item {{ $title == 'Data Bank' ? 'active' : '' }}">
                            <a href="{{ route('bank.index') }}"
                                class="side-nav-link {{ $title == 'Data Bank' ? 'active' : '' }}">
                                <span class="menu-text">Bank</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="ui-avatars.html" class="side-nav-link">
                                <span class="menu-text">Avatars</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#setting_nav" aria-expanded="false" aria-controls="setting_nav"
                    class="side-nav-link">
                    <span class="menu-icon"><i class="ti ti-settings"></i></span>
                    <span class="menu-text"> Setting </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="setting_nav">
                    <ul class="sub-menu">
                        <li class="side-nav-item">
                            <a href="maps-google.html" class="side-nav-link">
                                <span class="menu-text">Google Maps</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="maps-vector.html" class="side-nav-link">
                                <span class="menu-text">Vector Maps</span>
                            </a>
                        </li>
                        <li class="side-nav-item">
                            <a href="maps-leaflet.html" class="side-nav-link">
                                <span class="menu-text">Leaflet Maps</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

        </ul>

        <!-- Help Box -->
        <div class="help-box text-center">
            <img src="{{ cdn('backend/assets/images/coffee-cup.svg') }}" height="90" alt="Helper Icon Image" />
            <h5 class="mt-3 fw-semibold fs-16">Unlimited Access</h5>
            <p class="mb-3 text-muted">Upgrade to plan to get access to unlimited reports</p>
            <a href="javascript: void(0);" class="btn btn-danger btn-sm">Upgrade</a>
        </div>

        <div class="clearfix"></div>
    </div>
</div>
