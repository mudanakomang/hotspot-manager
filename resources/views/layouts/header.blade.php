<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="#" class="logo"><b>HOTSPOT</b>Manager</a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <!-- /.messages-menu -->

                <!-- Notifications Menu -->

                <!-- Tasks Menu -->

                <!-- User Account Menu -->


                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="{{ asset("/bower_components/admin-lte/dist/img/rad-logo.jpeg") }}" class="user-image" alt="User Image"/>
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">{{ $user->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="{{ asset("/bower_components/admin-lte/dist/img/rad-logo.jpeg") }}" class="img-circle" alt="User Image" />
                            <p>
                               {{ $user->name }}
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">


                            <form id="logout-form" action="{{ url('/password/resetpass/'.Auth::user()->id) }}" method="GET" >
                            <div class="pull-left">
                                <button type="submit" class="btn btn-link" >
                                   Reset Password
                                </button>
                            </div>
                            </form>



				            <form id="logout-form" action="{{ url('/logout') }}" method="POST" >
                             {{ csrf_field() }}
					            <div class="pull-right">
					                <button type="submit" class="btn btn-default btn-flat">Sign Out</button>
                                </div>
                             </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
