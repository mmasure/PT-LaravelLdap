<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p style="overflow: hidden;text-overflow: ellipsis;max-width: 160px;" data-toggle="tooltip" title="{{ Auth::user()->name }}">{{ ucfirst(Auth::user()->name) }}</p>
                </div>
            </div>
        @endif

        <!-- search form (Optional) -->
{{--        <form action="#" method="get" class="sidebar-form">--}}
{{--            <div class="input-group">--}}
{{--                <input type="text" name="q" class="form-control" placeholder="{{ trans('adminlte_lang::message.search') }}..."/>--}}
{{--              <span class="input-group-btn">--}}
{{--                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>--}}
{{--              </span>--}}
{{--            </div>--}}
{{--        </form>--}}
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Manager</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="active"><a href="{{ route('user.list') }}"><i class='fa fa-users'></i> <span>Users config</span></a></li>
            @if (Auth::user()->name == 'spock')
            <li class="header">Panel Admin</li>
            <li class="treeview">
                <a href="#"><i class='fa fa-file'></i> <span>{{ trans('menu.log_viewer') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('log-viewer') }}">{{ trans('menu.dashboard') }}</a></li>
                    <li><a href="{{ url('log-viewer/logs') }}">{{ trans('menu.logs') }}</a></li>
                </ul>
            </li>
            @endif
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
