<!-- Clan Sidebar -->
<div class="clan-sidebar">
   
    
    <nav class="sidebar-nav">
        <ul class="space-y-2">
            <li>
                <a href="/gallery/photo" class="sidebar-link {{ request()->is('gallery') && !request()->is('clan/*') ? 'active' : '' }}">                    
                    Фотографии
                </a>
            </li>
            <li>
                <a href="/gallery/screenshots" class="sidebar-link {{ request()->is('gallery/screenshots') ? 'active' : '' }}">
                    Скриншоты
                </a>
            </li>
            <li>
                <a href="/gallery/other" class="sidebar-link {{ request()->is('gallery/other') ? 'active' : '' }}">
                    Прочее
                </a>
            </li>
            
            
        </ul>
    </nav>
    
</div>
