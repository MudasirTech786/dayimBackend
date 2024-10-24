<nav
    class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-without-dd-arrow fixed-top navbar-semi-dark navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mobile-menu d-md-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs"
                        href="#"><i class="ft-menu font-large-1"></i></a></li>
                <li class="nav-item mr-auto">
                    <a class="navbar-brand" href="">
                        <img class="brand-logo" alt="" src="">
                        <h3 class="brand-text">Dayim Marketing</h3>
                    </a>
                </li>
                {{-- for showing logout and change password on mobile screen --}}


            </ul>
        </div>
        <div class="navbar-container content">
            <div class="collapse navbar-collapse" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">

                </ul>
                <ul class="nav navbar-nav float-right">
                    <li class="dropdown dropdown-user nav-item">
                        <a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                            <span class="mr-1">Hello,
                                <span class="user-name text-bold-700">{{ Auth::user()->name }}</span>
                            </span>
                            @if (Auth::user()->image != null)
                                <span class="avatar avatar-online">
                                    <img src="../../../app-assets/images/profile/{{ Auth::user()->image }}"
                                        alt="avatar" style="width:50px; height:35px"><i></i>
                                </span>
                            @else
                                <span class="avatar avatar-online">
                                    <img src="../../../app-assets/images/profile/profile_picture.jpeg"
                                        alt="avatar"><i></i>
                                </span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="{{ route('change-password') }}">
                                <i class="ft-lock"></i> Change Password
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="javascript:;"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="ft-power"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                            </form>
                        </div>

                    </li>
                </ul>
                </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
