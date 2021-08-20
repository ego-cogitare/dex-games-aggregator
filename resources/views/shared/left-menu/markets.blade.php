<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">NAVIGATION</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-bitcoin"></i>
                    <span>Markets</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @foreach ($markets as $mId => $marketName)
                        <li>
                            <a href="/admin/market/{{ $mId }}/{{ $action }}"><i class="fa fa-circle-o"></i> {{ $marketName }}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
            <li>
                <a href="/admin/market/{{ $marketData['id'] }}/settings"><i class="fa fa-gears"></i> <span>Settings</span></a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-exchange"></i>
                    <span>Exchange</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="/admin/market/{{ $marketData['id'] }}/balances"><i class="fa fa-circle-o"></i> <span>Assets</span></a>
                    </li>
                    <li>
                        <a href="/admin/market/{{ $marketData['id'] }}/orders"><i class="fa fa-circle-o"></i> <span>Open orders</span></a>
                    </li>
                    <li>
                        <a href="/admin/market/{{ $marketData['id'] }}/history"><i class="fa fa-circle-o"></i> <span>Trade history</span></a>
                    </li>
                    <li>
                        <a href="/admin/market/{{ $marketData['id'] }}/trade"><i class="fa fa-circle-o"></i> <span>Trade</span></a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-line-chart"></i>
                    <span>Charts</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="/admin/market/{{ $marketData['id'] }}/charts/balance"><i class="fa fa-circle-o"></i> <span>Balance</span></a>
                    </li>
                    <li>
                        <a href="/admin/market/{{ $marketData['id'] }}/charts/triplets"><i class="fa fa-circle-o"></i> <span>Triplets</span></a>
                    </li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-file"></i>
                    <span>Logs</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    @foreach ($marketData['log'] as $type => $link)
                        @if ($link)
                            <li>
                                <a href="{{$link}}" target="_blank"><i class="fa fa-circle-o"></i> <span>{{$type}}</span></a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>