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
                    <p class="">Rp. {{ hrg($user->balance) }}</p>
                </div>
            </div>
        </div>

        <div class="shadow-bottom"></div>
        <ul class="list-unstyled menu-categories" id="accordionExample">

            <li class="menu {{ $title == 'Dashboard' ? 'active' : '' }}">
                <a href="{{ route('home') }}" aria-expanded="{{ $title == 'Dashboard' ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <i data-feather="home"></i>
                        <span>Dashboard</span>
                    </div>
                </a>
            </li>

            <li class="menu menu-heading">
                <div class="heading">
                    <i data-feather="minus"></i><span>APPLICATIONS</span>
                </div>
            </li>
            <li class="menu">
                <a target="_blank" href="{{ $company->link_blog ?? 'javascript:void(0);' }}" aria-expanded="false"
                    class="dropdown-toggle">
                    <div class="">
                        <i data-feather="book"></i>
                        <span>Tutorial</span>
                    </div>
                </a>
            </li>
            <li class="menu">
                <a target="_blank" href="{{ $company->link_status ?? 'javascript:void(0);' }}" aria-expanded="false"
                    class="dropdown-toggle">
                    <div class="">
                        <i data-feather="bar-chart"></i>
                        <span>Status Server</span>
                    </div>
                </a>
            </li>

            <li class="menu {{ $title == 'Speed Test' || $title == 'Isolir' ? 'active' : '' }}">
                <a href="#generator_nav" data-bs-toggle="collapse"
                    aria-expanded="{{ $title == 'Speed Test' || $title == 'Isolir' ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <i data-feather="codepen"></i>
                        <span> Script Gen </span>
                    </div>
                    <div>
                        <i data-feather="chevron-right"></i>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ $title == 'Speed Test' || $title == 'Isolir' ? 'show' : '' }}"
                    id="generator_nav" data-bs-parent="#accordionExample">
                    <li class="{{ $title == 'Speed Test' ? 'active' : '' }}">
                        <a href="{{ route('generate.speed_test') }}"> Speed Test </a>
                    </li>
                    <li class="{{ $title == 'Isolir' ? 'active' : '' }}">
                        <a href="{{ route('generate.isolir') }}"> Isolir </a>
                    </li>
                </ul>
            </li>

            <li class="menu menu-heading">
                <div class="heading">
                    <i data-feather="minus"></i>
                    <span>SERVICE</span>
                </div>
            </li>
            <li
                class="menu {{ $title == 'Data Vpn' || $title == 'Order Vpn' || $title == 'Data Port' ? 'active' : '' }}">
                <a href="#vpn_nav" data-bs-toggle="collapse"
                    aria-expanded="{{ $title == 'Data VPN' || $title == 'Order Vpn' || $title == 'Data Port' ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <i data-feather="share-2"></i>
                        <span> Vpn </span>
                    </div>
                    <div>
                        <i data-feather="chevron-right"></i>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ $title == 'Data Vpn' || $title == 'Order Vpn' || $title == 'Data Port' ? 'show' : '' }}"
                    id="vpn_nav" data-bs-parent="#accordionExample">
                    <li class="{{ $title == 'Order Vpn' ? 'active' : '' }}">
                        <a href="{{ route('vpns.create') }}"> Order Vpn </a>
                    </li>
                    <li class="{{ $title == 'Data Vpn' ? 'active' : '' }}">
                        <a href="{{ route('vpns.index') }}"> List Vpn </a>
                    </li>
                    @if (isAdmin())
                        <li class="{{ $title == 'Data Port' ? 'active' : '' }}">
                            <a href="{{ route('ports.index') }}"> List Port </a>
                        </li>
                    @endif
                </ul>
            </li>

            <li class="menu {{ $title == 'Data Router' ? 'active' : '' }}">
                <a href="{{ route('routers.index') }}"
                    aria-expanded="{{ $title == 'Data Router' ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="cloud"></i>
                        <span>List Router</span>
                    </div>
                </a>
            </li>

            @if ($user->is_admin())
                <li class="menu {{ $title == 'Data Server' ? 'active' : '' }}">
                    <a href="#server_nav" data-bs-toggle="collapse"
                        aria-expanded="{{ $title == 'Data Server' ? 'true' : 'false' }}" class="dropdown-toggle">
                        <div class="">
                            <i data-feather="server"></i>
                            <span>Server</span>
                        </div>
                        <div>
                            <i data-feather="chevron-right"></i>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled {{ $title == 'Data Server' ? 'show' : '' }}"
                        id="server_nav" data-bs-parent="#accordionExample">
                        <li class="{{ $title == 'Data Server' ? 'active' : '' }}">
                            <a href="{{ route('servers.index') }}"> List Server </a>
                        </li>
                    </ul>
                </li>

                <li class="menu {{ $title == 'Data Transaction' ? 'active' : '' }}">
                    <a href="{{ route('transactions.index') }}"
                        aria-expanded="{{ $title == 'Data Transaction' ? 'true' : 'false' }}"
                        class="dropdown-toggle">
                        <div class="">
                            <i data-feather="trending-up"></i>
                            <span>Transaction</span>
                        </div>
                    </a>
                </li>
            @endif

            <li class="menu {{ $title == 'Data Invoice' || $title == 'Data Topup' ? 'active' : '' }}">
                <a href="#billing_nav" data-bs-toggle="collapse"
                    aria-expanded="{{ $title == 'Data Invoice' || $title == 'Data Topup' ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <i data-feather="shopping-cart"></i>
                        <span>Billing</span>
                    </div>
                    <div>
                        <i data-feather="chevron-right"></i>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ $title == 'Data Invoice' || $title == 'Data Topup' ? 'show' : '' }}"
                    id="billing_nav" data-bs-parent="#accordionExample">
                    <li class="{{ $title == 'Data Topup' ? 'active' : '' }}">
                        <a href="{{ route('topups.index') }}"> List Topup </a>
                    </li>
                </ul>
            </li>

            @if ($user->is_admin())
                <li
                    class="menu {{ $title == 'Data User' || $title == 'Data Bank' || $title == 'Data Temporary IP' || $title == 'Data Voucher Template' || $title == 'Data News' ? 'active' : '' }}">
                    <a href="#invoice" data-bs-toggle="collapse"
                        aria-expanded="{{ $title == 'Data User' || $title == 'Data Bank' || $title == 'Data Temporary IP' || $title == 'Data Voucher Template' || $title == 'Data News' ? 'true' : 'false' }}"
                        class="dropdown-toggle">
                        <div class="">
                            <i data-feather="database"></i>
                            <span>Master Data</span>
                        </div>
                        <div>
                            <i data-feather="chevron-right"></i>
                        </div>
                    </a>
                    <ul class="collapse submenu list-unstyled {{ $title == 'Data User' || $title == 'Data Bank' || $title == 'Data Temporary IP' || $title == 'Data Voucher Template' || $title == 'Data News' ? 'show' : '' }}"
                        id="invoice" data-bs-parent="#accordionExample">
                        <li class="{{ $title == 'Data Bank' ? 'active' : '' }}">
                            <a href="{{ route('banks.index') }}"> Bank </a>
                        </li>
                        <li class="{{ $title == 'Data User' ? 'active' : '' }}">
                            <a href="{{ route('users.index') }}"> User </a>
                        </li>
                        <li class="{{ $title == 'Data Temporary IP' ? 'active' : '' }}">
                            <a href="{{ route('temporaryip.index') }}"> Temporary IP </a>
                        </li>
                        <li class="{{ $title == 'Data Voucher Template' ? 'active' : '' }}">
                            <a href="{{ route('template.index') }}"> Voucher Template </a>
                        </li>
                        <li class="{{ $title == 'Data News' ? 'active' : '' }}">
                            <a href="{{ route('news.index') }}"> News </a>
                        </li>
                    </ul>
                </li>
            @endif

            <li class="menu menu-heading">
                <div class="heading">
                    <i data-feather="minus"></i>
                    <span>SETTING</span>
                </div>
            </li>
            <li
                class="menu {{ $title == 'Setting Company' || $title == 'Setting Profile' || $title == 'Profile' || $title == 'Whatsapp Token' ? 'active' : '' }}">
                <a href="#setting_nav" data-bs-toggle="collapse"
                    aria-expanded="{{ $title == 'Setting Company' || $title == 'Setting Profile' || $title == 'Profile' || $title == 'Whatsapp Token' ? 'true' : 'false' }}"
                    class="dropdown-toggle">
                    <div class="">
                        <i data-feather="settings"></i>
                        <span> SETTING</span>
                    </div>
                    <div>
                        <i data-feather="chevron-right"></i>
                    </div>
                </a>
                <ul class="collapse submenu list-unstyled {{ $title == 'Setting Company' || $title == 'Setting Profile' || $title == 'Profile' || $title == 'Whatsapp Token' ? 'show' : '' }}"
                    id="setting_nav" data-bs-parent="#accordionExample">
                    <li class="{{ $title == 'Profile' ? 'active' : '' }}">
                        <a href="{{ route('setting.profile') }}"> Profile </a>
                    </li>
                    <li class="{{ $title == 'Setting Profile' ? 'active' : '' }}">
                        <a href="{{ route('setting.profile.edit') }}"> Account </a>
                    </li>
                    <li class="{{ $title == 'Whatsapp Token' ? 'active' : '' }}">
                        <a href="{{ route('wa_tokens.index') }}"> Whatsapp Token </a>
                    </li>
                    @if ($user->is_admin())
                        <li class="{{ $title == 'Setting Company' ? 'active' : '' }}">
                            <a href="{{ route('setting.company.general') }}"> Company </a>
                        </li>
                    @endif
                </ul>
            </li>
            <li class="menu menu-heading">
                <div class="heading">
                    <i data-feather="minus"></i>
                    <span>HELP</span>
                </div>
            </li>
            <li class="menu {{ $title == 'Page Contact' ? 'active' : '' }}">
                <a href="{{ route('page.contact') }}"
                    aria-expanded="{{ $title == 'Page Contact' ? 'true' : 'false' }}" class="dropdown-toggle">
                    <div class="">
                        <i data-feather="help-circle"></i>
                        <span>Contact</span>
                    </div>
                </a>
            </li>
            <li class="menu menu-heading"></li>
            <li class="menu menu-heading"></li>
            <li class="menu menu-heading"></li>


        </ul>

    </nav>

</div>
