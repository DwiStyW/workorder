<div class="container-fluid">
    <div class="topnav">

        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('dashboard') }}">
                            <i class="uil-home-alt me-2"></i> Dashboard
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('ticket') }}">
                            <i class="uil-file me-2"></i> Lampiran WO
                        </a>
                    </li>


                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-pages" role="button">
                            <i class="uil-apps me-2"></i>@lang('translation.Apps') <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-pages">

                            <a href="calendar" class="dropdown-item">@lang('translation.Calendar')</a>
                            <a href="chat" class="dropdown-item">@lang('translation.Chat')</a>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-email"
                                    role="button">
                                    @lang('translation.Email') <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-email">
                                    <a href="email-inbox" class="dropdown-item">@lang('translation.Inbox')</a>
                                    <a href="email-read" class="dropdown-item">@lang('translation.Read_Email')</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-ecommerce"
                                    role="button">
                                    @lang('translation.Ecommerce') <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-ecommerce">
                                    <a href="ecommerce-products" class="dropdown-item">@lang('translation.Products')</a>
                                    <a href="ecommerce-product-detail" class="dropdown-item">@lang('translation.Product_Detail')</a>
                                    <a href="ecommerce-orders" class="dropdown-item">@lang('translation.Orders')</a>
                                    <a href="ecommerce-customers" class="dropdown-item">@lang('translation.Customers')</a>
                                    <a href="ecommerce-cart" class="dropdown-item">@lang('translation.Cart')</a>
                                    <a href="ecommerce-checkout" class="dropdown-item">@lang('translation.Checkout')</a>
                                    <a href="ecommerce-shops" class="dropdown-item">@lang('translation.Shops')</a>
                                    <a href="ecommerce-add-product" class="dropdown-item">@lang('translation.Add_Product')</a>
                                </div>
                            </div>

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-invoice"
                                    role="button">
                                    @lang('translation.Invoices') <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-invoice">
                                    <a href="invoices-list" class="dropdown-item">@lang('translation.Invoice_List')</a>
                                    <a href="invoices-detail" class="dropdown-item">@lang('translation.Invoice_Detail')</a>
                                </div>
                            </div>

                            <div class="dropdown">
                                <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-contact"
                                    role="button">
                                    @lang('translation.Contacts') <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-contact">
                                    <a href="contacts-grid" class="dropdown-item">@lang('translation.User_Grid')</a>
                                    <a href="contacts-list" class="dropdown-item">@lang('translation.User_List')</a>
                                    <a href="contacts-profile" class="dropdown-item">@lang('translation.Profile')</a>
                                </div>
                            </div>
                        </div>
                    </li>

                </ul>
            </div>
        </nav>
    </div>
</div>
