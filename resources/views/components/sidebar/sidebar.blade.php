<div
    class="vertical-menu rtl:right-0 fixed ltr:left-0 bottom-0 top-16 h-screen border-r bg-slate-50 border-gray-50 print:hidden dark:bg-zinc-800 dark:border-neutral-700 z-10">

    <div data-simplebar class="h-full">
        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu" id="side-menu">
                @canany(['manage pos', 'manage order'])
                    <x-sidebar.divider title="POS" />
                    @can('manage pos')
                        <x-sidebar.first-single title="Kasir" key="dashboard" icon="crosshair" url="{{ route('admin.pos') }}" />
                    @endcan
                    @can('manage order')
                        <x-sidebar.first-single title="Order" key="dashboard" icon="book-open"
                            url="{{ route('admin.order.index') }}" />
                    @endcan
                @endcanany
                @canany(['manage product', 'manage invoice', 'manage supplier', 'view dashboard'])
                    <x-sidebar.divider title="Main" />
                    @can('view dashboard')
                        <x-sidebar.first-single title="Dashboard" key="dashboard" icon="home"
                            url="{{ route('admin.dashboard') }}" />
                    @endcan
                    @can('manage product')
                        <x-sidebar.first-single title="Product" key="dashboard" icon="briefcase"
                            url="{{ route('admin.product.index') }}" />
                    @endcan
                    @can('manage invoice')
                        <x-sidebar.first-single title="Invoice" key="dashboard" icon="columns"
                            url="{{ route('admin.invoice.index') }}" />
                    @endcan
                    @can('manage supplier')
                        <x-sidebar.first-single title="Supplier" key="dashboard" icon="globe"
                            url="{{ route('admin.supplier.index') }}" />
                    @endcan
                @endcanany
                @can('manage admin')
                    <x-sidebar.divider title="User" />
                    <x-sidebar.first-single title="Admin" key="admin" icon="key"
                        url="{{ route('admin.admin.index') }}" />
                @endcan
                @can('manage unit')
                    <x-sidebar.divider title="Setting" />
                    <x-sidebar.first-single title="Unit" key="admin" icon="settings"
                        url="{{ route('admin.unit.index') }}" />
                @endcan
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
