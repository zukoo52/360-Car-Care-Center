<div class="sidebar">
    <div class="site-width">

        <!-- START: Menu-->
        <ul id="side-menu" class="sidebar-menu">
            <li class="dropdown"><a href="#"><i class="icon-home mr-1"></i> Dashboard</a>
                <ul>
                    <li class="{{ $page_option['sub'] === 'dash' ? 'active' : '' }}"><a href="{{route('home')}}"><i
                                class="fa fa-rocket"></i> Dashboard</a></li>
                    <li><a href="{{route('user.profile')}}"><i class="icon-layers"></i> My Account</a></li>
                </ul>
            </li>
            <li class="dropdown"><a href="#"><i class="icon-organization mr-1"></i>Supplier & Products</a>
                <ul>
                <li class="dropdown {{ $page_option['main'] === 'product' ? 'active' : '' }}"><a href="#"><i
                            class="fas fa-sitemap"></i>Products Management</a>
                    <ul class="sub-menu">
                        <li class="{{ $page_option['sub'] === 'product_create' ? 'active' : '' }}"><a
                                href="{{route('product.create')}}">Create New Product</a>
                        </li>
                        <li class="{{ $page_option['sub'] === 'product_index' ? 'active' : '' }}"><a
                            href="{{route('product.index')}}">View All Product</a>
                    </li>
                    </ul>
                </li>
                </ul>
            </li>
            <li class="dropdown"><a href="#"><i class="icon-organization mr-1"></i>Permissions & Users</a>
                                <ul>
                    <li class="dropdown {{ $page_option['main'] === 'permission' ? 'active' : '' }}"><a href="#"><i
                                class="fas fa-sitemap"></i>Roles & Permissions</a>
                        <ul class="sub-menu">
                            <li class="{{ $page_option['sub'] === 'permission_index' ? 'active' : '' }}"><a
                                    href="{{route('permission.index')}}">Manage</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown {{ $page_option['main'] === 'user' ? 'active' : '' }}"><a href="#"><i
                                class="fas fa-user-tie"></i> Users</a>
                        <ul class="sub-menu">
                            <li class="{{ $page_option['sub'] === 'user_create' ? 'active' : '' }}"><a
                                    href="{{route('user.create')}}">Create New User</a>
                            </li>
                            <li class="{{ $page_option['sub'] === 'user_index' ? 'active' : '' }}"><a
                                    href="{{route('user.index')}}">View All Users</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown {{ $page_option['main'] === 'branch' ? 'active' : '' }}"><a href="#"><i
                                class="fas fa-sitemap"></i>Branch Management</a>
                        <ul class="sub-menu">
                            <li class="{{ $page_option['sub'] === 'branch_create' ? 'active' : '' }}"><a
                                    href="{{ route('branch.create') }}">Create New Branch</a>
                            </li>
                            <li class="{{ $page_option['sub'] === 'branch_index' ? 'active' : '' }}"><a
                                    href="{{ route('branch.index') }}">View All Branches</a>
                            </li>
                        </ul>
                    </li>
                </ul>

            </li>
        </ul>
        <!-- END: Menu-->
        <ol class="breadcrumb bg-transparent align-self-center m-0 p-0 ml-auto">
            <li class="breadcrumb-item"><a href="#">Application</a></li>
            <li class="breadcrumb-item active">Blank Page</li>
        </ol>
    </div>
</div>

