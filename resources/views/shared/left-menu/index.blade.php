<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">NAVIGATION</li>
            <li>
                <a href="/admin/history"><i class="fa fa-btc"></i>
                    <span>Today Sales</span>
                </a>
            </li>
            <li>
                <a href="/admin/pending"><i class="fa fa-btc"></i>
                    <span>Pending Orders</span>
                </a>
            </li>
            <li>
                <a href="/admin/staff"><i class="fa fa-btc"></i>
                    <span>Staff</span>
                </a>
            </li>
            <li>
                <a href="/admin/balances"><i class="fa fa-btc"></i>
                    <span>Balances</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-exchange"></i>
                    <span>Accounts</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @foreach ($accounts as $account)
                    <li>
                        <a href="#">
                            <i class="fa fa-circle-thin"></i> <span>{{$account}}</span>
                        </a>
                        <ul>
                            <li class="_treeview">
                                <a href="/admin/account/{{$account}}/atomichub">
                                    <i class="fa fa-circle"></i>
                                    <span>Atomic Hub</span>
                                </a>
                            </li>
                            <li class="_treeview">
                                <a href="/admin/history?account={{$account}}">
                                    <i class="fa fa-circle"></i>
                                    <span>Today Sales</span>
                                </a>
                            </li>
                            <li class="_treeview">
                                <a href="/admin/history?account={{$account}}">
                                    <i class="fa fa-circle"></i>
                                    <span>Today Sales</span>
                                </a>
                            </li>
                            <li class="_treeview">
                                <a href="/admin/pending?account={{$account}}">
                                    <i class="fa fa-circle"></i>
                                    <span>Pending Orders</span>
                                </a>
                            </li>
                            <li class="_treeview">
                                <a href="/admin/staff?account={{$account}}">
                                    <i class="fa fa-circle"></i>
                                    <span>Staff</span>
                                </a>
                            </li>
                            <li class="_treeview">
                                <a href="/admin/balances?account={{$account}}">
                                    <i class="fa fa-circle"></i>
                                    <span>Balances</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endforeach
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-exchange"></i>
                    <span>Games</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="/admin/game/alienworlds"><i class="fa fa-circle-o"></i> Alien Worlds</a>
                        <a href="/admin/game/alienships"><i class="fa fa-circle-o"></i> Alien Ships</a>
                    </li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>