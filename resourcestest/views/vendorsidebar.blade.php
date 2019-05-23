<aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="{{route('vendorhome')}}"><i class="menu-icon fa fa-laptop"></i>Dashboard </a>
                    </li>
                    <li class="menu-title">Report</li><!-- /.menu-title -->
                    
                    
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-table"></i>Report</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-file-word-o"></i><a href="{{route('allvendororderitem')}}">All Order</a></li>
                            <li><i class="fa fa-file-word-o"></i><a href="{{route('approvedvendororderitem')}}">Approved Order</a></li>
                            <li><i class="fa fa-file-word-o"></i><a href="">Derivered Order</a></li>
                            <li><i class="fa fa-file-word-o"></i><a href="">Receipt</a></li>
                        </ul>
                    </li>

                    <li>
                        <a href="{{route('producttransactions')}}"> <i class="menu-icon fa fa-id-card-o"></i>Transactions </a> 
                    </li>

                    <li class="menu-title">Items</li><!-- /.menu-title -->

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-tasks"></i>Product</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-fort-awesome"></i><a href="{{route('vendorall_products')}}">All </a></li>
                            <li><i class="menu-icon ti-themify-logo"></i><a href="{{route('vendornew_product')}}">New </a></li>
                        </ul>
                    </li>
                    
                    <!-- <li>
                        <a href="{{route('vendorcustomer')}}"> <i class="menu-icon fa fa-fire"></i>Customer </a> 
                    </li> -->
                    
                    <li>
                        <a href="{{route('vendorcompany_profile')}}"> <i class="menu-icon fa fa-bars"></i>Company Profile </a> 
                    </li>

                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside>