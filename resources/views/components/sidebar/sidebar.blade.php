<div
    class="vertical-menu rtl:right-0 fixed ltr:left-0 bottom-0 top-16 h-screen border-r bg-slate-50 border-gray-50 print:hidden dark:bg-zinc-800 dark:border-neutral-700 z-10">

    <div data-simplebar class="h-full">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu" id="side-menu">
                <x-sidebar.divider title="Menu" />
                @if (auth()->user()->getRoleNames()->first() == 'admin')
                <x-sidebar.first-single title="Dashboard" key="dashboard" icon="home"
                    url="{{ route('admin.dashboard') }}" />
                <x-sidebar.first-single title="Corporate" key="dashboard" icon="briefcase"
                    url="{{ route('admin.corporate.index') }}" />
                <x-sidebar.first-single title="Admin" key="admin" icon="key"
                    url="{{ route('admin.admin.index') }}" />
                @elseif (auth()->user()->getRoleNames()->first() == 'user_corporate')
                <x-sidebar.first-single title="Dashboard" key="dashboard" icon="home"
                    url="{{ route('corporate.dashboard') }}" />
                <x-sidebar.first-single title="Admin" key="admin" icon="key"
                    url="{{ route('corporate.admin.index') }}" />
                <x-sidebar.first-single title="Encrypt" key="admin" icon="command"
                url="{{ route('corporate.encrypt.index') }}" />
                @endif
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
