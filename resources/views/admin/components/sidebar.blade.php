<!-- Clan Sidebar -->
<div class="clan-sidebar">
   
    
    <nav class="sidebar-nav">
        <ul class="space-y-2">
            <li>
               <div class="sidebar-title">Клан</div>
                <a href="{{ route('admin.clan.info.index') }}" class="sidebar-link {{ request()->routeIs('admin.clan.info.*') ? 'active' : '' }}">                    
                    Информация о клане  
                </a>
            </li>
            <li>
                <a href="{{ route('admin.clan.regulation.index') }}" class="sidebar-link {{ request()->routeIs('admin.clan.regulation.*') ? 'active' : '' }}">
                    Устав
                </a>
            </li>
            <li>
                <a href="{{ route('admin.clan.application.index') }}" class="sidebar-link {{ request()->routeIs('admin.clan.application.*') ? 'active' : '' }}">
                    Заявки на вступление
                </a>
            </li>
            <li>
                <a href="{{ route('admin.clan.coslist.index') }}" class="sidebar-link {{ request()->routeIs('admin.clan.coslist.*') ? 'active' : '' }}">
                   Кос лист
                </a>
            </li>

            <li>
                <div class="sidebar-title">Администрирование</div>
                 <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">                    
                     Управление пользователями  
                 </a>
             </li>

            <li>
                <div class="sidebar-title">Форум</div>
                 <a href="{{ route('admin.forum.sections.index') }}" class="sidebar-link {{ request()->routeIs('admin.forum.*') ? 'active' : '' }}">                    
                     Разделы форума  
                 </a>
             </li>

            <li>
                <div class="sidebar-title">Связь</div>
                 <a href="{{ route('admin.link.index') }}" class="sidebar-link {{ request()->routeIs('admin.link.*') ? 'active' : '' }}">                    
                     Добавление информации о связи  
                 </a>
             </li>
           
            
        </ul>
    </nav>
    
</div>
