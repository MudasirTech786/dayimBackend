<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            @if (auth()->user()->can('users-list') || auth()->user()->can('users-create') || auth()->user()->can('roles-list'))
                <li class="nav-item"><a href=""><i class="la la-user"></i><span class="menu-title"
                            data-i18n="nav.dash.main">Users</span></a>
                    <ul class="menu-content">

                        @can('users-create')
                            <li class="">
                                <a class="menu-item" href="{{ route('users.create') }}" data-i18n="nav.dash.ecommerce">Add
                                    User</a>
                            </li>
                        @endcan
                        @can('users-list')
                            <li class="">
                                <a class="menu-item" href="{{ route('users.index') }}" data-i18n="nav.dash.ecommerce">View
                                    Users</a>
                            </li>
                        @endcan
                        @can('roles-list')
                            <li class="">
                                <a class="menu-item" href="{{ route('roles.index') }}" data-i18n="nav.dash.ecommerce">roles
                                    Management</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif

            @can('users-edit')
                <li class="nav-item">
                    <a href="{{ route('users.edit', Auth::user()->id) }}">
                        <i class="la la-user"></i>
                        <span class="menu-title" data-i18n="nav.dash.main">Edit Profile</span>
                    </a>

                </li>
                @endif

                @can('contacts-view')
                    <li class="nav-item"><a href="{{ route('contacts.index') }}"><i class="la la-phone"></i><span
                                class="menu-title" data-i18n="nav.dash.main">View User Contacts</span></a>
                    </li>
                @endcan

                @can('view-statement')
                    <li class="nav-item">
                        <a href="{{ route('sheet.index') }}"><i class="la la-dropbox"></i><span class="menu-title"
                                data-i18n="nav.dash.main">online statement</span></a>
                    </li>
                    @endif

                    <li class="nav-item d-lg-none">
                        <a class="" href="{{ route('change-password') }}">
                            <i class="ft-lock"></i> <span class="menu-title" data-i18n="nav.dash.main">Change Password</span>
                        </a>
                    </li>
                    <li class="nav-item d-lg-none">
                        <a class="" href="javascript:;"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="ft-power"></i> <span class="menu-title" data-i18n="nav.dash.main">Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                        </form>
                    </li>


                    @if (auth()->user()->can('users-list') || auth()->user()->can('users-create') || auth()->user()->can('roles-list'))
                        <li class="nav-item"><a href=""><i class="la la-user"></i><span class="menu-title"
                                    data-i18n="nav.dash.main">Products</span></a>
                            <ul class="menu-content">
                                <li class="">
                                    <a class="menu-item" href="{{ route('products.create') }}"
                                        data-i18n="nav.dash.ecommerce">Create New Property
                                    </a>
                                </li>
                            </ul>
                            <ul class="menu-content">
                                <li class="">
                                    <a class="menu-item" href="{{ route('products.index') }}" data-i18n="nav.dash.ecommerce">DSA
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    <li class="nav-item"><a href=""><i class="la la-user"></i><span class="menu-title"
                                data-i18n="nav.dash.main">Events</span></a>
                        <ul class="menu-content">
                            <li class="">
                                <a class="menu-item" href="{{ route('dayim.index') }}"
                                    data-i18n="nav.dash.ecommerce">DM
                                </a>
                            </li>
                        </ul>
                        <ul class="menu-content">
                            <li class="">
                                <a class="menu-item" href="{{ route('dsa.index') }}"
                                    data-i18n="nav.dash.ecommerce">DSA
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
