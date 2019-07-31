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

            <li>
                <a href="{{ route('parents_performance') }}" class="{{ \Illuminate\Support\Facades\Route::currentRouteName() === 'parents_performance' ? 'active' : '' }}">
                    <i class="fa fa-area-chart"></i> <span>Performance</span>
                    <span class="pull-right-container">
                          {{--<small class="label pull-right bg-green">new</small>--}}
                    </span>
                </a>
            </li>

            <li>
                <a href="{{ route('parents_student_welfare') }}" class="{{ \Illuminate\Support\Facades\Route::currentRouteName() === 'parents_student_welfare' ? 'active' : '' }}">
                    <i class="fa fa-heart"></i> <span>Student Welfare</span>
                    <span class="pull-right-container">
                          {{--<small class="label pull-right bg-green">new</small>--}}
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('parents_chat') }}" class="{{ \Illuminate\Support\Facades\Route::currentRouteName() === 'parents_chat' ? 'active' : '' }}">
                    <i class="fa fa-comments-o"></i> <span>Chat</span>
                    <span class="pull-right-container">
                          {{--<small class="label pull-right bg-green">new</small>--}}
                    </span>
                </a>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>