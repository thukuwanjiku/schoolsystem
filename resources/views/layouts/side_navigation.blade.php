<aside class="main-sidebar" style="position:fixed;">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left info">
                <p>&nbsp;</p>
            </div>
        </div>


        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>

            @if(auth()->check() && auth()->user()->role->label === 'admin')
            <li>
                <a href="{{ route('groups') }}">
                    <i class="fa fa-users"></i> <span>Student Groups</span>
                    <span class="pull-right-container">
                          {{--<small class="label pull-right bg-green">new</small>--}}
                    </span>
                </a>
            </li>

            <li>
                <a href="{{ route('students') }}">
                    <i class="fa fa-users"></i> <span>Students</span>
                    <span class="pull-right-container">
                          {{--<small class="label pull-right bg-green">new</small>--}}
                    </span>
                </a>
            </li>

            <li>
                <a href="{{ route('academics') }}">
                    <i class="fa fa-book"></i> <span>Academics</span>
                    <span class="pull-right-container">
                          {{--<small class="label pull-right bg-green">new</small>--}}
                    </span>
                </a>
            </li>

            <li>
                <a href="{{ route('users') }}">
                    <i class="fa fa-users"></i> <span>Users</span>
                    <span class="pull-right-container">
                          {{--<small class="label pull-right bg-green">new</small>--}}
                    </span>
                </a>
            </li>
            @elseif(auth()->check() && auth()->user()->role->label === 'teacher')
            <li>
                <a href="{{ route('exam_marks') }}">
                    <i class="fa fa-line-chart"></i> <span>Performance</span>
                    <span class="pull-right-container">
                          {{--<small class="label pull-right bg-green">new</small>--}}
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('register') }}">
                    <i class="fa fa-calendar-check-o"></i> <span>Register</span>
                    <span class="pull-right-container">
                          {{--<small class="label pull-right bg-green">new</small>--}}
                    </span>
                </a>
            </li>
            @endif
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>