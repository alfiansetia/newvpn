<header class="app-topbar">
    <div class="page-container topbar-menu">
        <div class="d-flex align-items-center gap-2">

            <!-- Brand Logo -->
            <a href="index.html" class="logo">
                <span class="logo-light">
                    <span class="logo-lg"><img src="{{ $company->logo_light }}" alt="logo"></span>
                    <span class="logo-sm"><img src="{{ $company->logo_dark }}" alt="small logo"></span>
                </span>

                <span class="logo-dark">
                    <span class="logo-lg"><img src="{{ $company->logo_dark }}" alt="dark logo"></span>
                    <span class="logo-sm"><img src="{{ $company->logo_dark }}" alt="small logo"></span>
                </span>
            </a>

            <!-- Sidebar Menu Toggle Button -->
            <button class="sidenav-toggle-button px-2">
                <i class="ti ti-menu-deep fs-24"></i>
            </button>

            <!-- Horizontal Menu Toggle Button -->
            <button class="topnav-toggle-button px-2" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                <i class="ti ti-menu-deep fs-22"></i>
            </button>

            <!-- end topbar-item -->
        </div>

        <div class="d-flex align-items-center gap-2">

            <!-- Search for small devices -->
            <div class="topbar-item d-flex d-xl-none">
                <button class="topbar-link" data-bs-toggle="modal" data-bs-target="#searchModal" type="button">
                    <i class="ti ti-search fs-22"></i>
                </button>
            </div>

            <!-- Language Dropdown -->
            <div class="topbar-item">
                <div class="dropdown">
                    <button class="topbar-link" data-bs-toggle="dropdown" data-bs-offset="0,25" type="button"
                        aria-haspopup="false" aria-expanded="false">
                        <img src="{{ asset('backend/assets/images/flags/us.svg') }}" alt="user-image"
                            class="w-100 rounded" height="18" id="selected-language-image">
                    </button>

                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item" data-translator-lang="en">
                            <img src="{{ asset('backend/assets/images/flags/us.svg') }}" alt="user-image"
                                class="me-1 rounded" height="18" data-translator-image> <span
                                class="align-middle">English</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item" data-translator-lang="hi">
                            <img src="{{ asset('backend/assets/images/flags/in.svg') }}" alt="user-image"
                                class="me-1 rounded" height="18" data-translator-image> <span
                                class="align-middle">Hindi</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="{{ asset('backend/assets/images/flags/de.svg') }}" alt="user-image"
                                class="me-1 rounded" height="18"> <span class="align-middle">German</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="{{ asset('backend/assets/images/flags/it.svg') }}" alt="user-image"
                                class="me-1 rounded" height="18"> <span class="align-middle">Italian</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="{{ asset('backend/assets/images/flags/es.svg') }}" alt="user-image"
                                class="me-1 rounded" height="18"> <span class="align-middle">Spanish</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">
                            <img src="{{ asset('backend/assets/images/flags/ru.svg') }}" alt="user-image"
                                class="me-1 rounded" height="18"> <span class="align-middle">Russian</span>
                        </a>

                    </div>
                </div>
            </div>


            <!-- Button Trigger Customizer Offcanvas -->
            <div class="topbar-item d-none d-sm-flex">
                <button class="topbar-link" data-bs-toggle="offcanvas" data-bs-target="#theme-settings-offcanvas"
                    type="button">
                    <i class="ti ti-settings fs-22"></i>
                </button>
            </div>

            <!-- Light/Dark Mode Button -->
            <div class="topbar-item d-none d-sm-flex">
                <button class="topbar-link" id="light-dark-mode" type="button">
                    <i class="ti ti-moon fs-22"></i>
                </button>
            </div>

            <!-- User Dropdown -->
            <div class="topbar-item nav-user">
                <div class="dropdown">
                    <a class="topbar-link dropdown-toggle drop-arrow-none px-2" data-bs-toggle="dropdown"
                        data-bs-offset="0,19" type="button" aria-haspopup="false" aria-expanded="false">
                        <img src="{{ $user->avatar }}" width="32" class="rounded-circle me-lg-2 d-flex"
                            alt="user-image">
                        <span class="d-lg-flex flex-column gap-1 d-none">
                            <h5 class="my-0">{{ $user->name }}</h5>
                            <h6 class="my-0 fw-normal">{{ $user->role }}</h6>
                        </span>
                        <i class="ti ti-chevron-down d-none d-lg-block align-middle ms-2"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome !</h6>
                        </div>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">
                            <i class="ti ti-user-hexagon me-1 fs-17 align-middle"></i>
                            <span class="align-middle">My Account</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">
                            <i class="ti ti-wallet me-1 fs-17 align-middle"></i>
                            <span class="align-middle">Balance : <span class="fw-semibold">Rp.
                                    {{ hrg($user->balance) }}</span></span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">
                            <i class="ti ti-settings me-1 fs-17 align-middle"></i>
                            <span class="align-middle">Settings</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">
                            <i class="ti ti-lifebuoy me-1 fs-17 align-middle"></i>
                            <span class="align-middle">Support</span>
                        </a>

                        <div class="dropdown-divider"></div>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item">
                            <i class="ti ti-lock-square-rounded me-1 fs-17 align-middle"></i>
                            <span class="align-middle">Lock Screen</span>
                        </a>

                        <!-- item-->
                        <a href="javascript:void(0);" onclick="logout_()"
                            class="dropdown-item active fw-semibold text-danger">
                            <i class="ti ti-logout me-1 fs-17 align-middle"></i>
                            <span class="align-middle">Sign Out</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
