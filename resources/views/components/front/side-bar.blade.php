<!-- Sidebar Area Start Here -->
<div class="sidebar-main sidebar-menu-one sidebar-expand-md sidebar-color">
    <div class="mobile-sidebar-header d-md-none">
         <div class="header-logo">
             <a href="{{ route('home')}}"><img src="{{ asset('img/logo1.png') }}" alt="logo"></a>
         </div>
    </div>
     <div class="sidebar-menu-content">
         <ul class="nav nav-sidebar-menu sidebar-toggle-view">
             @foreach (config('menu') as $name => $elements)
                @if (currentUserIs($elements['profile']))
                    @isset($elements['children'])
                        <li class="nav-item sidebar-nav-item">
                            <a href="#" class="nav-link"><i class="{{ $elements['icon'] }}"></i><span>@lang($name)</span></a>
                            <ul class="nav sub-group-menu @if (menuOpen($elements['children'])) sub-group-active @endif">
                                @foreach ($elements['children'] as $child)
                                    @if (currentUserIs($child['profile']))
                                        <li class="nav-item">
                                            <a href="{{ route($child['route']) }}" class="nav-link @if (currentRoute($child['route'])) menu-active @endif">
                                                <i class="fas fa-angle-right"></i>
                                                @lang($child['name'])
                                            </a>
                                        </li> 
                                    @endif                               
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route($elements['route']) }}" class="nav-link @if (currentRoute($elements['route'])) menu-active @endif">
                                <i class="{{ $elements['icon'] }}"></i>
                                <span @if (currentRoute($elements['route'])) class="menu-active" @endif>@lang($name)</span>
                            </a>
                        </li>
                    @endisset
                @endif
                
             @endforeach
         </ul>
     </div>
 </div>
 <!-- Sidebar Area End Here -->
