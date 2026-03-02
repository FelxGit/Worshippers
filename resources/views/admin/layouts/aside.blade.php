<aside class="sidebar">
  <div class="logo-sidebar">
    <img class="logo-sm" src="{{ asset('images/communitylogo.png') }}" />
  </div>
  <div class="header-sidebar">
    <div class="bg-overlay"></div>
    {{-- <img src="" /> --}}
    <p>Admin</p>
  </div>
  <div class="sidebar-menu">
    <a href="{{ route('admin.dashboard') }}" class="items {{ strpos(url()->current(), 'admin/dashboard') !== false  ? 'active' : ''}}">
      <i class="fa-solid fa-chart-line"></i>
      <span class="">Dashboard
    </a>
    <a href="{{ route('admin.user' ) }}" class="items {{ strpos(url()->current(), 'admin/user') !== false ? 'active' : ''}}">
      <i class="fa-solid fa-user"></i>
      <span class="">Users</span>
    </a>
    <a href="#" class="items {{ strpos(url()->current(), 'admin/post') !== false ? 'active' : ''}}">
      <i class="fa-solid fa-signs-post"></i>
      <span class="">Post
    </a>
    <a href="#" class="items {{ strpos(url()->current(), 'admin/category') !== false ? 'active' : ''}}">
      <i class="fa-solid fa-layer-group"></i>
      <span class="">Category</span>
    </a>
    <a href="#" class="items {{ strpos(url()->current(), 'admin/tags') !== false ? 'active' : ''}}">
      <i class="fa-solid fa-tags"></i>
      <span>Tags</span>
    </a>
    <a href="#" class="items {{ strpos(url()->current(), 'admin/favorite') !== false ? 'active' : ''}}">
      <i class="fa-regular fa-star"></i>
      <span>Favorites</span>
    </a>
    <a href="#" class="items {{ strpos(url()->current(), 'admin/like') !== false ? 'active' : ''}}">
      <i class="fa-regular fa-thumbs-up"></i>
      <span>Likes</span>
    </a>
  </div>
</aside>