<@php
    $user = Sentinel::getUser()
 @endphp
<nav class="navbar navbar-top fixed-top navbar-expand" id="navbarDefault">
    <div class="collapse navbar-collapse justify-content-between">
        <div class="navbar-logo">

            <button class="btn navbar-toggler navbar-toggler-humburger-icon hover-bg-transparent" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarVerticalCollapse"
                    aria-controls="navbarVerticalCollapse" aria-expanded="false" aria-label="Toggle Navigation"><span
                    class="navbar-toggle-icon"><span class="toggle-line"></span></span></button>
            <a class="navbar-brand me-1 me-sm-3" href="#">
                <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center"><img src="{{asset('img/download.jpg')}}" alt="phoenix" width="40" />
                        <p class="logo-text ms-2 d-none d-sm-block">{{env('app_name')}}</p>
                    </div>
                </div>
            </a>
        </div>
        @if(env('DEMO_MODE'))
            <span class="badge bg-danger"><i class="bi bi-exclamation-triangle"></i> Demo mode is enabled features &amp; actions will be
                                             limited.</span>
        @endif
        <ul class="navbar-nav navbar-nav-icons flex-row">
            <li class="nav-item">
                <div class="theme-control-toggle fa-icon-wait px-2">
                    <input class="form-check-input ms-0 theme-control-toggle-input" type="checkbox"
                           data-theme-control="phoenixTheme" value="dark" id="themeControlToggle"/>
                    <label class="mb-0 theme-control-toggle-label theme-control-toggle-light" for="themeControlToggle"
                           data-bs-toggle="tooltip" data-bs-placement="left" title="Switch theme"><span class="icon"
                                                                                                        data-feather="moon"></span></label>
                    <label class="mb-0 theme-control-toggle-label theme-control-toggle-dark" for="themeControlToggle"
                           data-bs-toggle="tooltip" data-bs-placement="left" title="Switch theme"><span class="icon"
                                                                                                        data-feather="sun"></span></label>
                </div>
            </li>
            <li class="nav-item dropdown me-2">
                <a class="nav-link" href="{{route('settings.index')}}">
                    <i data-feather="settings"></i>
                </a>
            </li>
          
            <li class="nav-item dropdown me-2">
                <a class="nav-link" href="{{route('chat.index')}}" data-bs-toggle="tooltip"
                   data-bs-placement="bottom" title="Chat">
                    <i data-feather="message-circle"></i>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link lh-1 pe-0" id="navbarDropdownUser" href="#!" role="button" data-bs-toggle="dropdown"
                   data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                    <div class="avatar avatar-l ">
                        <img class="rounded-circle " src="{{asset('img/user.png')}}" alt=""/>
                    </div>
                    {{$user->first_name.' '.$user->last_name }}
                </a>
                <div
                    class="dropdown-menu dropdown-menu-end navbar-dropdown-caret py-0 dropdown-profile shadow border border-300"
                    aria-labelledby="navbarDropdownUser">
                    <div class="card position-relative border-0">
                        <div class="card-body p-0">
                            <div class="text-center pt-4 pb-1">
                                <div class="avatar avatar-xl ">
                                    <img class="rounded-circle " src="{{asset('img/user.png')}}" alt=""/>
                                </div>
                                <h6 class="mt-2 text-black">{{$user->first_name.' '.$user->last_name }}</h6>
                                <p>{{$user->designation }}</p>
                            </div>
                        </div>
                        <div class="overflow-auto">
                            <ul class="nav d-flex flex-column mb-2 pb-1">
                                {{--  <li class="nav-item"><a class="nav-link px-3" > <span class="me-2 text-900" data-feather="user"></span><span>Profile</span></a></li>--}}
                                <li class="nav-item"><a href="{{route('account.changePassword')}}"
                                                        class="nav-link px-3"><span class="me-2 text-900"
                                                                                    data-feather="log-out"></span>Change
                                        Password</a></li>
                            </ul>
                        </div>
                        <div class="card-footer p-0 border-top">
                            <div class="px-3">
                                <form method="post" action="{{route('auth.logout')}}" class="mt-2 mb-2">
                                    @csrf
                                    <button class="btn btn-danger d-flex flex-center w-100" type="submit">
                                        <span class="me-2" data-feather="log-out"> </span>Log out
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>
