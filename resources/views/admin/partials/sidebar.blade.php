<nav id="sidebar" class="navbar-dark">
    <div class="user">
        <div class="profile">
            <a class="nav-link d-flex align-items-center collapsed" href="#collapseExample" data-bs-toggle="collapse"
                aria-expanded="false">
                <img class="rounded-circle profile-picture me-2"
                    src="{{ Auth::user() ? 'https://avatarfiles.alphacoders.com/373/373447.jpg' : 'https://thumbs.dreamstime.com/b/default-profile-picture-avatar-photo-placeholder-vector-illustration-default-profile-picture-avatar-photo-placeholder-vector-189495158.jpg' }}"
                    alt="{{ Auth::user() ? Auth::user()->name : 'Default' }} profile picture">
                <span>{{ Auth::user() ? Auth::user()->name : 'Ospite' }}</span>
                <i class="fa-solid fa-caret-down ms-auto"></i>
            </a>
            <div class="collapse" id="collapseExample">
                @if (Auth::user())
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="{{ url('profile') }}">
                            <i class="fa-solid fa-user"></i> {{ __('Profilo') }}
                        </a>
                    </li>
                              
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            <i class="fa-solid fa-sign-out"></i> {{ __('Disconnetti') }}
                        </a>
                    </li>
                   
                </ul>
                @else
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="{{ route('login') }}">
                            <i class="fa-solid fa-arrow-right-to-bracket"></i> {{ __('Accedi') }}
                        </a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center" href="{{ route('register') }}">
                                <i class="fa-solid fa-id-card"></i> {{ __('Registrati') }}
                            </a>
                        </li>
                    @endif
                </ul>
                @endif
            </div>
        </div>
    </div>
    @if (Auth::user())
    <ul id="routes-list" class="navbar-nav">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="{{ Route::is('admin.dashboard') ? 'active' : '' }} nav-link d-flex align-items-center">
                <i class="fa-solid fa-building-columns"></i><span>Dashboard</span> 
            </a>
        </li>
        @if (Auth::user()->apartments()->exists())
        <li>
            <a href="{{ route('admin.apartments.index') }}" class="{{ Route::is('admin.apartments.*') ? 'active' : '' }} nav-link d-flex align-items-center">
                <i class="fa-solid fa-building"></i>
                <span>Appartamenti</span> 
            </a>
        </li>
        
        <li>
            <a href="{{ route('admin.messages.index') }}" class="{{ Route::is('admin.messages.*') ? 'active' : '' }} nav-link d-flex align-items-center">
                <i class="fa-solid fa-envelope"></i>
                <span>Messaggi</span> 
            </a>
        </li>
        @endif
    </ul>
    @endif
</nav>

