<!-- Clan Sidebar -->
<div class="clan-sidebar">
   
    
    <nav class="sidebar-nav">
        <ul class="space-y-2">
            <li>
                <a href="/clan" class="sidebar-link {{ request()->is('clan') && !request()->is('clan/*') ? 'active' : '' }}">                    
                    Информация о клане
                </a>
            </li>
            <li>
                <a href="/clan/regulation" class="sidebar-link {{ request()->is('clan/regulation') ? 'active' : '' }}">
                    Устав
                </a>
            </li>
            <li>
                <a href="/clan/application" class="sidebar-link {{ request()->is('clan/application') ? 'active' : '' }}">
                    Заявка на вступление
                </a>
            </li>
            <li>
                <a href="/clan/coslist" class="sidebar-link {{ request()->is('clan/coslist') ? 'active' : '' }}">
                   Кос лист
                </a>
            </li>
         
            
        </ul>
    </nav>
    
</div>
