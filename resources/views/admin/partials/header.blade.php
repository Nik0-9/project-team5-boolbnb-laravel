<header>
    <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light">
        <!-- Container wrapper -->
        <div class="container-fluid d-flex align-items-center justify-content-between">
            {{-- Left button --}}
            <div class="d-flex align-items-center">
                <div class="minimize-button me-3">
                    <button class="btn" type="button" id="closeSidebar">
                        <i class="fa-solid fa-chevron-left"></i>
                    </button>
                </div>
            </div>
            {{-- Right buttons --}}
            {{--@if (Auth::user())
                <div id="navigation" class="d-flex">
                    <form class="me-3">
                        <div class="input-group no-border h-100">
                            <input type="text" value="" class="form-control" placeholder="Search...">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </div>
                            </div>
                        </div>
                    </form>
                    <ul class="navbar-nav">
                        <li class="nav-item mx-1">
                            <a class="nav-link" href="#">
                                <i class="fa-solid fa-shapes"></i>
                            </a>
                        </li>
                        <li class="nav-item dropdown mx-1">
                            <a class="nav-link dropdown-toggle position-relative" href="#"
                                id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="fa-solid fa-bell"></i>
                                <span class="badge rounded-pill badge-notification bg-danger">1</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li>
                        <li class="nav-item ms-1">
                            <a class="nav-link" href="#">
                                <i class="fa-solid fa-gear"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            @endif--}}
        </div>
    </nav>
</header>
