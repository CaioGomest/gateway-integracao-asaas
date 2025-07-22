



            <header class="app-header sticky" id="header">

                <!-- Start::main-header-container -->
                <div class="main-header-container container-fluid">

                    <!-- Start::header-content-left -->
                    <div class="header-content-left">

                        <!-- Start::header-element -->
                        <div class="header-element">
                            <div class="horizontal-logo">
                                <a href="../home" class="header-logo">
                                    <img src="../img/logo.png" alt="logo" class="desktop-logo">
                                    <img src="../img/logo.png" alt="logo" class="toggle-logo">
                                    <img src="../img/logo.png" alt="logo" class="desktop-dark">
                                    <img src="../img/logo.png" alt="logo" class="toggle-dark">
                                </a>
                            </div>
                        </div>
                        <!-- End::header-element -->

                        <!-- Start::header-element -->
                        <div class="header-element mx-lg-0 mx-2">
                            <a aria-label="Hide Sidebar" class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle" data-bs-toggle="sidebar" href="javascript:void(0);"><span></span></a>
                        </div>
                        <!-- End::header-element -->

                      

                    </div>
                    <!-- End::header-content-left -->

                    <!-- Start::header-content-right -->
                    <ul class="header-content-right">

                  

                        <!-- Start::header-element -->
                        <li class="header-element cart-dropdown dropdown">
                            <!-- Start::header-link|dropdown-toggle -->
                       
                            <!-- End::header-link|dropdown-toggle -->
                            <!-- Start::main-header-dropdown -->
                            <div class="main-header-dropdown dropdown-menu dropdown-menu-end" data-popper-placement="none">
                                <div class="p-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <p class="mb-0 fs-16">Cart Items<span class="badge bg-success-transparent ms-1 fs-12 rounded-circle" id="cart-data">5</span></p>
                                        <a href="ecommerce-search.php" class="btn btn-secondary-light btn-sm btn-wave">Continue Shopping <i class="ti ti-arrow-narrow-right ms-1"></i></a>
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                                <ul class="list-unstyled mb-0" id="header-cart-items-scroll">
                                    <li class="dropdown-item">
                                        <div class="d-flex align-items-center cart-dropdown-item gap-3">
                                            <div class="lh-1">
                                                <span class="avatar avatar-md bg-gray-300">
                                                    <img src="<?php echo $baseUrl; ?>/assets/images/ecommerce/png/30.png" alt="img">
                                                </span>
                                            </div>
                                            <div class="flex-fill">
                                                <div class="d-flex align-items-center justify-content-between mb-0">
                                                    <div class="mb-0 fs-14 fw-medium">
                                                        <a href="ecommerce-customer-cart.php">SoundSync Headphones</a>
                                                        <div class="fs-11 text-muted">
                                                            <span>Qty : 2,</span>
                                                            <span>Color : <span class="text-cart-headset fw-semibold">Ocean Blue</span></span>
                                                        </div>
                                                    </div>
                                                    <div class="text-end">
                                                        <a href="javascript:void(0);" class="header-cart-remove dropdown-item-close"><i class="ri-delete-bin-line"></i></a>
                                                        <h6 class="fw-medium mb-0 mt-1">$75<span class="text-decoration-line-through text-muted fw-normal ms-1 fs-13 d-inline-block">$99</span></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dropdown-item">
                                        <div class="d-flex align-items-center cart-dropdown-item gap-3">
                                            <div class="lh-1">
                                                <span class="avatar avatar-md bg-gray-300">
                                                    <img src="<?php echo $baseUrl; ?>/assets/images/ecommerce/png/31.png" alt="img">
                                                </span>
                                            </div>
                                            <div class="flex-fill">
                                                <div class="d-flex align-items-center justify-content-between mb-0">
                                                    <div class="mb-0 fs-14 fw-medium">
                                                        <a href="ecommerce-customer-cart.php">Western Ladies Bag</a>
                                                        <div class="fs-11 text-muted">
                                                            <span>Qty : 1,</span>
                                                            <span>Color : <span class="text-cart-handbag fw-semibold">Blush Pink</span></span>
                                                        </div>
                                                    </div>
                                                    <div class="text-end">
                                                        <a href="javascript:void(0);" class="header-cart-remove dropdown-item-close"><i class="ri-delete-bin-line"></i></a>
                                                        <h6 class="fw-medium mb-0 mt-1">$120<span class="text-decoration-line-through text-muted fw-normal ms-1 fs-13 d-inline-block">$149</span></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dropdown-item">
                                        <div class="d-flex align-items-center cart-dropdown-item gap-3">
                                            <div class="lh-1">
                                                <span class="avatar avatar-md bg-gray-300">
                                                    <img src="<?php echo $baseUrl; ?>/assets/images/ecommerce/png/32.png" alt="img">
                                                </span>
                                            </div>
                                            <div class="flex-fill">
                                                <div class="d-flex align-items-center justify-content-between mb-0">
                                                    <div class="mb-0 fs-14 fw-medium">
                                                        <a href="ecommerce-customer-cart.php">Elitr Alarm Clock</a>
                                                        <div class="fs-11 text-muted">
                                                            <span>Qty : 2,</span>
                                                            <span>Color : <span class="text-cart-alaramclock fw-semibold">Sky Blue</span></span>
                                                        </div>
                                                    </div>
                                                    <div class="text-end">
                                                        <a href="javascript:void(0);" class="header-cart-remove dropdown-item-close"><i class="ri-delete-bin-line"></i></a>
                                                        <h6 class="fw-medium mb-0 mt-1">$30<span class="text-decoration-line-through text-muted fw-normal ms-1 fs-13 d-inline-block">$49</span></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dropdown-item">
                                        <div class="d-flex align-items-center cart-dropdown-item gap-3">
                                            <div class="lh-1">
                                                <span class="avatar avatar-md bg-gray-300">
                                                    <img src="<?php echo $baseUrl; ?>/assets/images/ecommerce/png/12.png" alt="img">
                                                </span>
                                            </div>
                                            <div class="flex-fill">
                                                <div class="d-flex align-items-center justify-content-between mb-0">
                                                    <div class="mb-0 fs-14 fw-medium">
                                                        <a href="ecommerce-customer-cart.php">Aus Polo Assn</a>
                                                        <div class="fs-11 text-muted">
                                                            <span>Qty : 3,</span>
                                                            <span>Color : <span class="text-cart-sweatshirt fw-semibold">Soft Peach</span></span>
                                                        </div>
                                                    </div>
                                                    <div class="text-end">
                                                        <a href="javascript:void(0);" class="header-cart-remove dropdown-item-close"><i class="ri-delete-bin-line"></i></a>
                                                        <h6 class="fw-medium mb-0 mt-1">$70<span class="text-decoration-line-through text-muted fw-normal ms-1 fs-13 d-inline-block">$129</span></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dropdown-item">
                                        <div class="d-flex align-items-center cart-dropdown-item gap-3">
                                            <div class="lh-1">
                                                <span class="avatar avatar-md bg-gray-300">
                                                    <img src="<?php echo $baseUrl; ?>/assets/images/ecommerce/png/16.png" alt="img">
                                                </span>
                                            </div>
                                            <div class="flex-fill">
                                                <div class="d-flex align-items-center justify-content-between mb-0">
                                                    <div class="mb-0 fs-14 fw-medium">
                                                        <a href="ecommerce-customer-cart.php">Smart Watch</a>
                                                        <div class="fs-11 text-muted">
                                                            <span>Qty : 1,</span>
                                                            <span>Color : <span class="text-cart-smartwatch fw-semibold">Crimson Red</span></span>
                                                        </div>
                                                    </div>
                                                    <div class="text-end">
                                                        <a href="javascript:void(0);" class="header-cart-remove dropdown-item-close"><i class="ri-delete-bin-line"></i></a>
                                                        <h6 class="fw-medium mb-0 mt-1">$200<span class="text-decoration-line-through text-muted fw-normal ms-1 fs-13 d-inline-block">$249</span></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <div class="p-3 empty-header-item border-top">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="fw-medium fs-14">Total :</div>
                                        <h5 class="mb-0">$740</h5>
                                    </div>
                                    <div class="text-center d-grid">
                                        <a href="ecommerce-customer-checkout.php" class="btn btn-primary btn-wave">Proceed to checkout</a>
                                    </div>
                                </div>
                                <div class="p-5 empty-item d-none">
                                    <div class="text-center">
                                        <span class="avatar avatar-xl avatar-rounded bg-primary-transparent">
                                            <i class="ri-shopping-cart-2-line fs-2"></i>
                                        </span>
                                        <h6 class="fw-medium mb-1 mt-3">Your Cart is Empty</h6>
                                        <span class="mb-3 fw-normal fs-13 d-block">Add some items to make it happy :)</span>
                                    </div>
                                </div>
                            </div>
                            <!-- End::main-header-dropdown -->
                        </li>
                        <!-- End::header-element -->

                        <!-- Start::header-element -->
                        <li class="header-element notifications-dropdown d-xl-block d-none dropdown">
                            <!-- Start::header-link|dropdown-toggle -->
                         
                            <!-- End::header-link|dropdown-toggle -->
                            <!-- Start::main-header-dropdown -->
                            <div class="main-header-dropdown dropdown-menu dropdown-menu-end" data-popper-placement="none">
                                <div class="p-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <p class="mb-0 fs-16">Notifications</p>
                                     
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                                <ul class="list-unstyled mb-0" id="header-notification-scroll">
                                 
                                    
                                    
                                </ul>
                                <div class="p-3 empty-header-item1 border-top">
                                    <div class="d-grid">
                                        <a href="javascript:void(0);" class="btn btn-primary btn-wave">View All</a>
                                    </div>
                                </div>
                                <div class="p-5 empty-item1 d-none">
                                    <div class="text-center">
                                        <span class="avatar avatar-xl avatar-rounded bg-secondary-transparent">
                                            <i class="ri-notification-off-line fs-2"></i>
                                        </span>
                                        <h6 class="fw-medium mt-3">No New Notifications</h6>
                                    </div>
                                </div>
                            </div>
                            <!-- End::main-header-dropdown -->
                        </li>
                        <!-- End::header-element -->


                       <!-- Start::header-element -->
<li class="header-element dropdown">
    <!-- Start::header-link|dropdown-toggle -->
    <a href="javascript:void(0);" class="header-link dropdown-toggle" id="mainHeaderProfile" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
        <div class="d-flex align-items-center">
            <div class="me-xl-2 me-0">
            </div>
            <div class="d-xl-block d-none lh-1">
                <span class="fw-medium lh-1"></span>
            </div>
        </div>
    </a>
  <div class="d-xl-block d-none lh-1">
    <span class="fw-medium lh-1"></span>
</div>
</a>
<!-- Adicionando o botão de logout -->
<a href="../logout.php" class="header-link logout-button">
    <img src="https://i.imgur.com/I1Gt2H4.png" alt="Logout" style="width: 24px; height: 24px;">
</a>
</li>

<style>
    .logout-button {
        display: inline-flex;
        align-items: center;
        margin-left: 100px; /* Padrão para mobile */
    }

    @media (min-width: 768px) { /* Para desktop */
        .logout-button {
            margin-left: 280px;
            margin-top: 20px; /* Desce 5px somente no desktop */
        }
    }
</style>


                        <!-- Start::header-element -->
                        <li class="header-element">
                            <!-- Start::header-link|switcher-icon -->
                        
                            <!-- End::header-link|switcher-icon -->
                        </li>
                        <!-- End::header-element -->

                    </ul>
                    <!-- End::header-content-right -->

                </div>
                <!-- End::main-header-container -->

            </header>

            <div class="modal fade" id="header-responsive-search" tabindex="-1" aria-labelledby="header-responsive-search" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="input-group">
                                <input type="text" class="form-control border-end-0" placeholder="Search Anything ..."
                                    aria-label="Search Anything ..." aria-describedby="button-addon2">
                                <button class="btn btn-primary" type="button"
                                    id="button-addon2"><i class="bi bi-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>