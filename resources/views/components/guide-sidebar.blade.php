<!-- Clan Sidebar -->
<div class="clan-sidebar">
   
    
    <nav class="sidebar-nav">
        <ul class="space-y-2">
            <li>
                <a href="/guide/north" class="sidebar-link {{ request()->is('guide/north') && !request()->is('clan/*') ? 'active' : '' }}">                    
                    Север
                </a>
            </li>
            <li>
                <a href="/guide/east" class="sidebar-link {{ request()->is('guide/east') ? 'active' : '' }}">
                    Восток
                </a>
            </li>
            <li>
                <a href="/guide/west" class="sidebar-link {{ request()->is('guide/west') ? 'active' : '' }}">
                    Запад
                </a>
            </li>
            <li>
                <a href="/guide/central" class="sidebar-link {{ request()->is('guide/central') ? 'active' : '' }}">
                    Центральные
                </a>
            </li>
            <li>
                <a href="/guide/other" class="sidebar-link {{ request()->is('guide/other') ? 'active' : '' }}">
                    Другое
                </a>
            </li>
            
            
        </ul>
    </nav>
    
</div>
