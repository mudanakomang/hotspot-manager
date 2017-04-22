<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset("/bower_components/admin-lte/dist/img/rad-logo.jpeg") }}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>{{ $user->name }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>



        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header bg-black-active" ><h4>{{ \Carbon\Carbon::now('Asia/Makassar')->format('d M Y H:i') }}</h4></li>
            <!-- Optionally, you can add icons to the links -->

                    @if($user->can('all'))
                    <li><a href="{{ url("/user/manage") }}">Manage Administrator</a></li>
                    @endif
            <li><a href="{{ url("/guestinhouse/dashboard") }}">Dashboard</a></li>

                      @if(!$user->hasRole('mice'))
                    <li><a href="{{ url("/guestinhouse") }}">Guest In House</a></li>
                    @endif
                    @if($user->hasRole('operator') || $user->hasRole('master'))
                    <li><a href="{{ url("/guestinhouse/macauth") }}">MAC Address Bypass</a></li>
                    @endif
                    @if(!$user->hasRole('operator'))
                <li><a href="{{ url("/mice") }}">MICE</a></li>
              @endif


            @if(!$user->hasRole('mice'))
            <li class="treeview">
                <a href="#"><span>Room</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-double-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                      @if( !$user->hasRole('mice'))
                    <li><a href="{{ url("/guestinhouse/room") }}">Room List</a></li>
                  @endif
                    @if( $user->hasRole('master'))
                    <li><a href="{{ url("/guestinhouse/addroom") }}">Add Room</a></li>
                    @endif
                </ul>
            </li>
          @endif



            @if(!$user->hasRole('mice'))
            <li class="treeview">
            <a href="#"><span>Voucher</span>
            <span class="pull-right-container">
            <i class="fa fa-angle-double-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                          @if(!$user->hasRole('mice'))
                        <li><a href="{{ url("/voucher/voucherlist") }}">Batch Voucher List</a></li>
                        <li><a href="{{ url("/voucher/voucherhistory") }}">Batch Voucher History</a></li>
                      @endif


                    </ul>
            </li>
          @endif
              <li><a href="{{ url("/guestinhouse/online") }}">Online User</a></li>
              <li><a href="{{ url("/logs") }}">Logs</a></li>



        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
