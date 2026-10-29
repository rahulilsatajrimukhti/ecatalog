<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-book"></i>
        </div>
        <div class="sidebar-brand-text mx-3">E-Catalog</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ activeMenu('dashboard') }}">
        <a class="nav-link" href="{{ url('/dashboard') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>

    @foreach ($menus as $menu)
        @php
            $isActiveParent = menuOpen($menu->children);
        @endphp

        @if ($menu->children->count())
            <li class="nav-item {{ $isActiveParent ? 'active' : '' }}">

                <a class="nav-link {{ $isActiveParent ? '' : 'collapsed' }}" href="#" data-toggle="collapse"
                    data-target="#menu{{ $menu->id }}">

                    <i class="fas fa-fw fa-{{ $menu->icon }}"></i>
                    <span>{{ $menu->name }}</span>
                </a>

                <div id="menu{{ $menu->id }}" class="collapse {{ $isActiveParent ? 'show' : '' }}">

                    <div class="bg-white py-2 collapse-inner rounded">

                        @foreach ($menu->children as $child)
                            <a class="collapse-item {{ activeMenu($child->route) }}"
                                href="{{ $child->route ? route($child->route) : '#' }}">
                                {{ $child->name }}
                            </a>
                        @endforeach

                    </div>
                </div>

            </li>
        @else
            <li class="nav-item {{ activeMenu($menu->route) }}">
                <a class="nav-link" href="{{ $menu->route ? route($menu->route) : '#' }}">
                    <i class="fas fa-fw fa-{{ $menu->icon }}"></i>
                    <span>{{ $menu->name }}</span>
                </a>
            </li>
        @endif
    @endforeach


    {{-- Go to Website --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ url('/') }}" target="_blank">
            <i class="fas fa-fw fa-globe"></i>
            <span>Go to Website</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
