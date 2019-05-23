<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset("public/img/prof.jpg") }}" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>



        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="active"><i class="fa fa-dashboard"></i> <a href="#"><span>Home</span></a></li>

            <li class="header">Main Menu</li>


            <li class="treeview">
                <a href="#"> <i class="fa fa-edit"></i> <span>Membership</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#">Add Member</a></li>
                    <li><a href="#">View Member</a></li>
                </ul>
            </li>

            <li><a href="#"> <i class="fa fa-book"></i> <span>Send Message</span></a></li>

            <li><a href="#"> <i class="fa fa-book"></i> <span>Message Request</span></a></li>

            <li class="treeview">
                <a href="#"> <i class="fa fa-dashboard"></i>  <span>Analysis</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#">Frequency</a></li>
                    <li><a href="#">Amount</a></li>
                </ul>
            </li>

            <li><a href="#"> <i class="fa fa-files-o"></i><span>Report</span></a></li>


            @foreach(explode(',', Auth::user()->task) as $task)
                <?php
                $array=array($task);
                $tasks = array_flip( $array );
                ?>

                @if (isset($tasks['view_report']))

                    <li class="treeview">

                        <a href="#">
                            <i class="fa fa-book"></i> <span>Settings</span>

                            <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                        </span>

                        </a>

                        <ul class="treeview-menu">
                            <li class="active"><a href=""><i class="fa fa-circle-o"></i> Assign Roles</a></li>
                            <li><a href=""><i class="fa fa-circle-o"></i>  Mail Settings</a></li>
                            <li><a href=""><i class="fa fa-circle-o"></i>  Sms Setting</a></li>
                        </ul>
                    </li>
                @else

                @endif

            @endforeach

        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>