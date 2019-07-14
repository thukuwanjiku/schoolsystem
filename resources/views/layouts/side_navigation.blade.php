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
                <a href="{{ route('groups') }}" class="{{ \Illuminate\Support\Facades\Route::currentRouteName() === 'groups' ? 'active' : '' }}">
                    <i class="fa fa-users"></i> <span>Student Classes</span>
                    <span class="pull-right-container">
                          {{--<small class="label pull-right bg-green">new</small>--}}
                    </span>
                </a>
            </li>

            <li>
                <a href="{{ route('students') }}" class="{{ \Illuminate\Support\Facades\Route::currentRouteName() === 'students' ? 'active' : '' }}">
                    <i class="fa fa-users"></i> <span>Students</span>
                    <span class="pull-right-container">
                          {{--<small class="label pull-right bg-green">new</small>--}}
                    </span>
                </a>
            </li>

            <li>
                <a href="{{ route('academics') }}" class="{{ \Illuminate\Support\Facades\Route::currentRouteName() === 'academics' ? 'active' : '' }}">
                    <i class="fa fa-book"></i> <span>Academics</span>
                    <span class="pull-right-container">
                          {{--<small class="label pull-right bg-green">new</small>--}}
                    </span>
                </a>
            </li>

            <li>
                <a href="{{ route('users') }}" class="{{ \Illuminate\Support\Facades\Route::currentRouteName() === 'users' ? 'active' : '' }}">
                    <i class="fa fa-users"></i> <span>Staff</span>
                    <span class="pull-right-container">
                          {{--<small class="label pull-right bg-green">new</small>--}}
                    </span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin_chat') }}" class="{{ \Illuminate\Support\Facades\Route::currentRouteName() === 'admin_chat' ? 'active' : '' }}">
                    <i class="fa fa-comments-o"></i> <span>Parents Chat</span>
                    <span class="pull-right-container">
                          {{--<small class="label pull-right bg-green">new</small>--}}
                    </span>
                </a>
            </li>
            @elseif(auth()->check() && auth()->user()->role->label === 'teacher')
            <li>
                <a href="{{ route('exam_marks') }}" class="{{ \Illuminate\Support\Facades\Route::currentRouteName() === 'exam_marks' ? 'active' : '' }}">
                    <i class="fa fa-line-chart"></i> <span>Performance</span>
                    <span class="pull-right-container">
                          {{--<small class="label pull-right bg-green">new</small>--}}
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('register') }}" class="{{ \Illuminate\Support\Facades\Route::currentRouteName() === 'register' ? 'active' : '' }}">
                    <i class="fa fa-calendar-check-o"></i> <span>Register</span>
                    <span class="pull-right-container">
                          {{--<small class="label pull-right bg-green">new</small>--}}
                    </span>
                </a>
            </li>
            @elseif(auth()->check() && auth()->user()->role->label === 'disciplinarian')
            <li>
                <a href="{{ route('exam_marks') }}" class="{{ \Illuminate\Support\Facades\Route::currentRouteName() === 'exam_marks' ? 'active' : '' }}">
                    <i class="fa fa-line-chart"></i> <span>Performance</span>
                    <span class="pull-right-container">
                          {{--<small class="label pull-right bg-green">new</small>--}}
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('register') }}" class="{{ \Illuminate\Support\Facades\Route::currentRouteName() === 'register' ? 'active' : '' }}">
                    <i class="fa fa-calendar-check-o"></i> <span>Register</span>
                    <span class="pull-right-container">
                          {{--<small class="label pull-right bg-green">new</small>--}}
                    </span>
                </a>
            </li>
            @elseif(auth()->check() && auth()->user()->role->label === 'medical')
            <li>
                <a href="{{ route('exam_marks') }}" class="{{ \Illuminate\Support\Facades\Route::currentRouteName() === 'exam_marks' ? 'active' : '' }}">
                    <i class="fa fa-user-md"></i> <span>Medical Report</span>
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