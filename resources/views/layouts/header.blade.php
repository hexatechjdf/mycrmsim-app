  <div class="d-flex flex-stack flex-lg-row-fluid" id="kt_app_header_wrapper">
                    <!--begin::Page title-->
                    <div class="app-page-title d-flex flex-column gap-1 me-3 mb-5 mb-lg-0" data-kt-swapper="true" data-kt-swapper-mode="{default: 'prepend', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_content_container', lg: '#kt_app_header_wrapper'}">
                        <!--begin::Title-->
                        {{-- <h1 class="fs-2 text-gray-900 fw-bold m-0">{{ $attributes['breadcrumb-label'] }}</h1>
        
                        <span class="fs-base fw-semibold text-gray-500">{{ $attributes['breadcrumb-description'] }}</span> --}}
                    </div>
                    <!--end::Page title-->
                    <!--begin::Navbar-->
                    <div class="app-navbar flex-shrink-0 gap-2 gap-lg-4">
                        <!--begin::User menu-->
                        <div class="app-navbar-item ms-lg-5" id="kt_header_user_menu_toggle">
                            <!--begin::Menu wrapper-->
                            <div class="d-flex align-items-center" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                                <!--begin:Info-->
                                <div class="text-end d-none d-sm-flex flex-column justify-content-center me-3">
                                    {{-- <span class="text-gray-500 fs-8 fw-bold">Hello</span> --}}
                                    <a href="#" class="text-gray-800 text-hover-primary fs-7 fw-bold d-block">{{ auth()->user()->name ?? 'user' }}</a>
                                </div>
                                <!--end:Info-->
                                <!--begin::User-->
                                <div class="cursor-pointer symbol symbol symbol-circle symbol-35px symbol-md-40px">
                                    <img class="" src="{{ asset("assets/media/avatars/user_avatar.avif") }}" alt="user" />

                                    {{-- <div class="position-absolute translate-middle bottom-0 mb-1 start-100 ms-n1 bg-success rounded-circle h-8px w-8px"></div> --}}

                                </div>
                                <!--end::User-->
                            </div>
                            <!--begin::User account menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <div class="menu-content d-flex align-items-center px-3">
                                        <!--begin::Avatar-->
                                        <div class="symbol symbol-50px me-5">
                                            <img alt="Logo" src="{{ asset("assets/media/avatars/user_avatar.avif") }}" />
                                        </div>
                                        <!--end::Avatar-->
                                        <!--begin::Username-->
                                        <div class="d-flex flex-column">
                                            <div class="fw-bold d-flex align-items-center fs-5">{{ auth()->user()->name ?? 'user' }}
                                                <span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Plan updated</span></div>
                                            <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">
                                            {{ auth()->user()->email }}
                                            </a>
                                        </div>
                                        <!--end::Username-->
                                    </div>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu separator-->
                                <div class="separator my-2"></div>
                                <!--end::Menu separator-->
                                <!--begin::Menu item-->

                                {{-- <div class="menu-item px-5">
                                    <a href="account/overview.html" class="menu-link px-5">My Profile</a>
                                </div> --}}
                                
                                <!--end::Menu item-->
                                <!--begin::Menu item-->

                                {{-- <div class="menu-item px-5">
                                    <a href="apps/projects/list.html" class="menu-link px-5">
                                        <span class="menu-text">My Projects</span>
                                        <span class="menu-badge">
													<span class="badge badge-light-danger badge-circle fw-bold fs-7">3</span>
												</span>
                                    </a>
                                </div> --}}


                                <!--end::Menu item-->
                                <!--begin::Menu separator-->
                                <div class="separator my-2"></div>
                                <!--end::Menu separator-->
                                <!--begin::Menu item-->
                                <div class="menu-item px-5 my-1">
                                    <a href="account/settings.html" class="menu-link px-5">Password</a>
                                </div>
                                <!--end::Menu item-->
                                <!--begin::Menu item-->

                                <div class="menu-item px-5">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')"
                                                onclick="event.preventDefault();
                                                            this.closest('form').submit();" class="menu-link px-5">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                    {{-- <a href="authentication/layouts/corporate/sign-in.html" class="menu-link px-5">Sign Out</a> --}}
                                </div>
                                
                                <!--end::Menu item-->
                            </div>
                            <!--end::User account menu-->
                            <!--end::Menu wrapper-->
                        </div>
                        <!--end::User menu-->
                        <!--begin::Sidebar menu toggle-->
                        <div class="app-navbar-item d-flex align-items-center d-lg-none me-n2">
                            <a href="#" class="btn btn-icon btn-color-gray-500 btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_panel_toggle">
                                <i class="ki-outline ki-row-vertical fs-1"></i>
                            </a>
                        </div>
                        <!--end::Sidebar menu toggle-->
                    </div>
                    <!--end::Navbar-->
                </div>