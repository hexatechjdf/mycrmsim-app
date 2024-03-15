<div id="kt_app_sidebar" class="app-sidebar" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_toggle">
                <!--begin::Header-->
                <div class="d-none d-lg-flex flex-center px-6 pt-10 pb-10" id="kt_app_sidebar_header">
                    <a href="{{ route('dashboard') }}">
                        <img alt="Logo" src="{{ asset("assets/media/logos/logo.png") }}" class="h-25px" />
                    </a>
                </div>
                <!--end::Header-->
                <div class="flex-grow-1">
                    <div id="kt_app_sidebar_menu_wrapper" class="hover-scroll-y" data-kt-scroll="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_header, #kt_app_sidebar_footer" data-kt-scroll-offset="20px">
                        <div class="app-sidebar-navs-default px-5 mb-10">
                            <div id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false" class="menu menu-column menu-rounded menu-sub-indention">
                                <!--begin:Menu item-->
                                @php
                                    $menuItems = [
                                        "dashboard" => ["label" => "Dashboard", "route" => route('dashboard')],
                                        "workspace" => ["label" => "Subaccount SIM", "route" => route('workspace')],
                                        "devices" => ["label" => "Devices", "route" => route('devices')],
                                        "messages" => ["label" => "Messages", "route" => route('messages')],
                                    ];

                                    $currentRouteName = \Illuminate\Support\Facades\Route::currentRouteName();
                                @endphp
                                @foreach($menuItems as $key => $item)
                                    <div class="menu-item {{ $currentRouteName === $key ? "here" : "" }}">
                                        <!--begin:Menu link-->
                                        <span class="menu-link">
										    <a class="menu-title" href="{{ $item["route"] }}">{{ $item["label"] }}</a>
									    </span>
                                        <!--end:Menu link-->
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>