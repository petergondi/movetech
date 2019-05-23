<aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="{{route('admin.home')}}"><i class="menu-icon fa fa-laptop"></i>Dashboard </a>
                    </li>
                    <li class="menu-title">Report</li><!-- /.menu-title -->
                    
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-table"></i>Report</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-file-word-o"></i><a href="{{route('adminallcartorder')}}">All Order</a></li>
                            <li><i class="fa fa-file-word-o"></i><a href="{{route('adminapprovedorder')}}">Approved Order</a></li>
                            <li><i class="fa fa-file-word-o"></i><a href="">Derivered Order</a></li>
                            <li><i class="fa fa-file-word-o"></i><a href="">Receipts</a></li>
                            <li><i class="fa fa-file-word-o"></i><a href="{{route('admincustomer')}}">Customer</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="{{route('transactions_vendors')}}"> <i class="menu-icon fa fa-id-card-o"></i>Transactions </a> 
                    </li>
                    
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-th"></i>Query</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-th"></i><a href="{{route('askedquestions')}}">Asked Questions</a></li>
                        </ul>
                    </li>

                    <li class="menu-title">Retailor</li><!-- /.menu-title -->

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-tasks"></i>Vendors</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-fort-awesome"></i><a href="{{route('all_vendors')}}">All </a></li>
                            <li><i class="menu-icon ti-themify-logo"></i><a href="{{route('new_vendors')}}">New </a></li>
                            <li><i class="menu-icon ti-themify-logo"></i><a href="{{route('products_vendor')}}">4 Pay Products </a></li>
                            <li><i class="menu-icon ti-themify-logo"></i><a href="{{route('newproducts_vendor')}}">New Product </a></li>
                            <li><i class="menu-icon ti-themify-logo"></i><a href="{{route('newslides_vendor')}}">Slides </a></li>
                        </ul>
                    </li>
                    
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-id-badge"></i>Users</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-fort-awesome"></i><a href="{{route('user_settings')}}">All </a></li>
                            <li><i class="menu-icon ti-themify-logo"></i><a href="{{route('user_new')}}">New </a></li>
                        </ul>
                    </li>
                    
                    <li class="menu-title">Extras</li><!-- /.menu-title -->
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-cogs"></i>Settings</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon ti-email"></i><a href="{{route('sms_settings')}}">SMS </a></li>
                            <li><i class="menu-icon ti-email"></i><a href="{{route('email_settings')}}">Email</a></li>
                            <li><i class="menu-icon ti-email"></i><a href="{{route('capping_settings')}}">Capping</a></li>
                             <li><i class="fa fa-money"></i><a href="{{route('adminfee')}}">Admin Fee</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-fire"></i>Category</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-sign-in"></i><a href="{{route('categorysettings')}}"> Category</a></li>
                            <li><i class="menu-icon fa fa-sign-in"></i><a href="{{route('subcategorysettings')}}">Sub-Category</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{route('companyprofile')}}"> <i class="menu-icon fa fa-bars"></i>Company Profile </a> 
                    </li>

                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside>