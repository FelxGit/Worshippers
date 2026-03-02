<nav class="nav-content">
  <div class="path">
    <span><i class="fa-solid fa-bars"></i></span>
    @yield('path')
  </div>
  <div class="profile">
    <div class="dropdown">
      <a href="#" class="profile-button" onclick="toggleDropdown()">
        <img src="{{ asset('images/user-logo.png') }}" />
        <i class="fa-solid fa-caret-down text-black"></i>
      </a>
      <div class="dropdown-content" id="dropdownContent">
        <a href="#" style="display: flex; grid-gap: 1rem">
          <img src="{{ asset('images/user-logo.png') }}" style="height: 50px" />
          <div>
            <span>{{ !empty($user) ? $user->getAttr('username') : '' }}</span><br/>
            <span>{{ !empty($user) ? $user->getAttr('email') : '' }}</span>
          </div>
        </a>
        <a href="#">
          <i class="fa-solid fa-user"></i> Profile
        </a>
        <a href="{{ route('admin.dashboard') }}">
          <i class="fa-solid fa-house"></i> Home
        </a>
        <a
        type="button"
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
        class="btn btn-danger w-100">
          <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
          @csrf
      </form>
        {{-- <button type="button" class="btn btn-danger w-100"><i class="fa-solid fa-right-from-bracket"></i> Logout</button> --}}
      </div>
    </div>
  </div>
</nav>