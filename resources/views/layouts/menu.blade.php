<ul class="sidebar-nav" id="sidebar-nav">

  <li class="nav-item">
    <a class="nav-link {{ Request::is('dashboard') ? '' : 'collapsed' }}" href="{{ url('/') }}">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link {{ Request::is('character-check') ? '' : 'collapsed' }}" href="{{ url('character-check') }}">
      <i class="bi bi-grid"></i>
      <span>Character Check</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link {{ Request::is('sales') ? '' : 'collapsed' }}" href="{{ url('sales') }}">
      <i class="bi bi-grid"></i>
      <span>Sales</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link {{ Request::is('sales-person') ? '' : 'collapsed' }}" href="{{ url('sales-person') }}">
      <i class="bi bi-grid"></i>
      <span>Sales Person</span>
    </a>
  </li>

  <li class="nav-item">
    <a class="nav-link {{ Request::is('product') ? '' : 'collapsed' }}" href="{{ url('product') }}">
      <i class="bi bi-grid"></i>
      <span>Product</span>
    </a>
  </li>

</ul>
