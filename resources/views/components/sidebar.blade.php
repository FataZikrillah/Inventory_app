<!-- Sidebar -->
<div class="sidebar" data-background-color="light">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="/home" class="logo">
                <img src="{{ asset('assets') }}/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand" height="20" />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                @foreach ($links as $link)
                    @if ($link['is_dropdown'])
                        <li class="nav-item {{ $link['is_active'] ? 'active' : '' }}">
                            <a data-bs-toggle="collapse" href="#dashboard" class="collapsed" aria-expanded="false">
                                <i class="{{ $link['icon'] }}"></i>
                                <p>{{ $link['label'] }}</p>
                                <span class="caret"></span>
                            </a>
                            <div class="collapse" id="dashboard">
                                <ul class="nav nav-collapse">
                                    @foreach ($link['items'] as $item)
                                        <li>
                                            <a href="{{ route($item['route']) }}">
                                                <span class="sub-item">{{ $item['label'] }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </li>
                    @else
                        <li class="nav-item {{ $link['is_active'] ? 'active' : '' }}">
                            <a href="{{ $link['route'] }}">
                                <i class="{{ $link['icon'] }}"></i>
                                <p>{{ $link['label'] }}</p>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
