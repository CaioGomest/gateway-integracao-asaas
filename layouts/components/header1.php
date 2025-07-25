
            <header class="app-header sticky" id="header">

                <!-- Start::main-header-container -->
                <div class="main-header-container container-fluid">

                    <!-- Start::header-content-left -->
                    <div class="header-content-left">

                        <!-- Start::header-element -->
                        <div class="header-element">
                            <div class="horizontal-logo">
                                <a href="index.php" class="header-logo">
                                    <img src="<?php echo $baseUrl; ?>/assets/images/brand-logos/desktop-logo.png" alt="logo" class="desktop-logo">
                                    <img src="<?php echo $baseUrl; ?>/assets/images/brand-logos/toggle-logo.png" alt="logo" class="toggle-logo">
                                    <img src="<?php echo $baseUrl; ?>/assets/images/brand-logos/desktop-dark.png" alt="logo" class="desktop-dark">
                                    <img src="<?php echo $baseUrl; ?>/assets/images/brand-logos/toggle-dark.png" alt="logo" class="toggle-dark">
                                </a>
                            </div>
                        </div>
                        <!-- End::header-element -->

                        <!-- Start::header-element -->
                        <div class="header-element mx-lg-0 mx-2">
                            <a aria-label="Hide Sidebar" class="sidemenu-toggle header-link animated-arrow hor-toggle horizontal-navtoggle" data-bs-toggle="sidebar" href="javascript:void(0);"><span></span></a>
                        </div>
                        <!-- End::header-element -->

                        <!-- Start::header-element -->
                        <div class="header-element header-search d-md-block d-none my-auto">
                            <!-- Start::header-link -->
                            <input type="text" class="header-search-bar form-control" id="header-search" placeholder="Search for Results..." spellcheck=false autocomplete="off" autocapitalize="off">
                            <a href="javascript:void(0);" class="header-search-icon border-0">
                                <i class="bi bi-search"></i>
                            </a>
                            <!-- End::header-link -->
                        </div>
                        <!-- End::header-element -->

                    </div>
                    <!-- End::header-content-left -->

                    <!-- Start::header-content-right -->
                    <ul class="header-content-right">

                        <!-- Start::header-element -->
                        <li class="header-element d-md-none d-block">
                            <a href="javascript:void(0);" class="header-link" data-bs-toggle="modal" data-bs-target="#header-responsive-search">
                                <!-- Start::header-link-icon -->
                                <i class="bi bi-search header-link-icon"></i>
                                <!-- End::header-link-icon -->
                            </a>  
                        </li>
                        <!-- End::header-element -->

                        <!-- Start::header-element -->
                        <li class="header-element country-selector dropdown">
                            <!-- Start::header-link|dropdown-toggle -->
                            <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-auto-close="outside" data-bs-toggle="dropdown">
                                <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" width="32" height="32" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><polygon points="136 184 216 184 176 104 136 184" opacity="0.2"/><path d="M88,127.56A95.78,95.78,0,0,1,56,56h64a95.78,95.78,0,0,1-32,71.56Z" opacity="0.2"/><polyline points="231.97 216 175.97 104 119.97 216" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><line x1="135.97" y1="184" x2="215.97" y2="184" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><line x1="87.97" y1="32" x2="87.97" y2="56" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><line x1="23.97" y1="56" x2="151.97" y2="56" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><path d="M120,56a96,96,0,0,1-96,96" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><path d="M61.44,88A96,96,0,0,0,152,152" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg>
                            </a>
                            <!-- End::header-link|dropdown-toggle -->
                            <ul class="main-header-dropdown dropdown-menu dropdown-menu-end" data-popper-placement="none">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                        <span class="avatar avatar-rounded avatar-xs lh-1 me-2">
                                            <img src="<?php echo $baseUrl; ?>/assets/images/flags/us_flag.jpg" alt="img">
                                        </span>
                                        English
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                        <span class="avatar avatar-rounded avatar-xs lh-1 me-2">
                                            <img src="<?php echo $baseUrl; ?>/assets/images/flags/spain_flag.jpg" alt="img" >
                                        </span>
                                        español
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                        <span class="avatar avatar-rounded avatar-xs lh-1 me-2">
                                            <img src="<?php echo $baseUrl; ?>/assets/images/flags/french_flag.jpg" alt="img" >
                                        </span>
                                        français
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                        <span class="avatar avatar-rounded avatar-xs lh-1 me-2">
                                            <img src="<?php echo $baseUrl; ?>/assets/images/flags/uae_flag.jpg" alt="img" >
                                        </span>
                                        عربي
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                        <span class="avatar avatar-rounded avatar-xs lh-1 me-2">
                                            <img src="<?php echo $baseUrl; ?>/assets/images/flags/germany_flag.jpg" alt="img" >
                                        </span>
                                        Deutsch
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                        <span class="avatar avatar-rounded avatar-xs lh-1 me-2">
                                            <img src="<?php echo $baseUrl; ?>/assets/images/flags/china_flag.jpg" alt="img" >
                                        </span>
                                        中国人
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                        <span class="avatar avatar-rounded avatar-xs lh-1 me-2">
                                            <img src="<?php echo $baseUrl; ?>/assets/images/flags/italy_flag.jpg" alt="img" >
                                        </span>
                                        Italiano
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);">
                                        <span class="avatar avatar-rounded avatar-xs lh-1 me-2">
                                            <img src="<?php echo $baseUrl; ?>/assets/images/flags/russia_flag.jpg" alt="img" >
                                        </span>
                                        Русский
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <!-- End::header-element -->

                        <!-- Start::header-element -->
                        <li class="header-element header-theme-mode">
                            <!-- Start::header-link|layout-setting -->
                            <a href="javascript:void(0);" class="header-link layout-setting">
                                <span class="light-layout">
                                    <!-- Start::header-link-icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M98.31,130.38ZM94.38,17.62h0A64.06,64.06,0,0,1,17.62,94.38h0A64.12,64.12,0,0,0,55,138.93h0a44.08,44.08,0,0,1,43.33-8.54,68.13,68.13,0,0,1,45.47-47.32l.15,0c0-1,.07-2,.07-3A64,64,0,0,0,94.38,17.62Z" opacity="0.1"></path><path d="M164,72a76.45,76.45,0,0,0-12.36,1A71.93,71.93,0,0,0,96.17,9.83a8,8,0,0,0-9.59,9.58A56.45,56.45,0,0,1,88,32,56.06,56.06,0,0,1,32,88a56.45,56.45,0,0,1-12.59-1.42,8,8,0,0,0-9.59,9.59,72.22,72.22,0,0,0,32.29,45.06A52,52,0,0,0,84,224h80a76,76,0,0,0,0-152ZM29.37,104c.87,0,1.75,0,2.63,0a72.08,72.08,0,0,0,72-72c0-.89,0-1.78,0-2.67a55.63,55.63,0,0,1,32,48,76.28,76.28,0,0,0-43,43.4A52,52,0,0,0,54,129.59,56.22,56.22,0,0,1,29.37,104ZM164,208H84a36,36,0,1,1,4.78-71.69c-.37,2.37-.63,4.79-.77,7.23a8,8,0,0,0,16,.92,58.91,58.91,0,0,1,1.88-11.81c0-.16.09-.32.12-.48A60.06,60.06,0,1,1,164,208Z"></path></svg>
                                    <!-- End::header-link-icon -->
                                </span>
                                <span class="dark-layout">
                                    <!-- Start::header-link-icon -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M131.84,84.41v0a68.22,68.22,0,0,0-41.65,46v-.11a44.08,44.08,0,0,0-38.54,5h0a48,48,0,1,1,80.19-50.94Z" opacity="0.1"></path><path d="M156,72a76.2,76.2,0,0,0-20.26,2.73,55.63,55.63,0,0,0-9.41-11.54l9.51-13.57a8,8,0,1,0-13.11-9.18L113.22,54A55.9,55.9,0,0,0,88,48c-.58,0-1.16,0-1.74,0L83.37,31.71a8,8,0,1,0-15.75,2.77L70.5,50.82A56.1,56.1,0,0,0,47.23,65.67L33.61,56.14a8,8,0,1,0-9.17,13.11L38,78.77A55.55,55.55,0,0,0,32,104c0,.57,0,1.15,0,1.72L15.71,108.6a8,8,0,0,0,1.38,15.88,8.24,8.24,0,0,0,1.39-.12l16.32-2.88a55.74,55.74,0,0,0,5.86,12.42A52,52,0,0,0,76,224h80a76,76,0,0,0,0-152ZM48,104a40,40,0,0,1,72.54-23.24,76.26,76.26,0,0,0-35.62,40,52.14,52.14,0,0,0-31,4.17A40,40,0,0,1,48,104ZM156,208H76a36,36,0,1,1,4.78-71.69c-.37,2.37-.63,4.79-.77,7.23a8,8,0,0,0,16,.92,58.91,58.91,0,0,1,1.88-11.81c0-.16.09-.32.12-.48A60.06,60.06,0,1,1,156,208Z"></path></svg>
                                    <!-- End::header-link-icon -->
                                </span>
                            </a>
                            <!-- End::header-link|layout-setting -->
                        </li>
                        <!-- End::header-element -->

                        <!-- Start::header-element -->
                        <li class="header-element cart-dropdown dropdown">
                            <!-- Start::header-link|dropdown-toggle -->
                            <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-auto-close="outside" data-bs-toggle="dropdown">
                                <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M224,72l-28.52,92.71A16,16,0,0,1,180.18,176H84.07a16,16,0,0,1-15.39-11.6L42.29,72Z" opacity="0.1"></path><path d="M96,216a16,16,0,1,1-16-16A16,16,0,0,1,96,216Zm88-16a16,16,0,1,0,16,16A16,16,0,0,0,184,200ZM231.65,74.35l-28.53,92.71A23.89,23.89,0,0,1,180.18,184H84.07A24.11,24.11,0,0,1,61,166.59L24.82,40H8A8,8,0,0,1,8,24H24.82A16.08,16.08,0,0,1,40.21,35.6L48.32,64H224a8,8,0,0,1,7.65,10.35ZM213.17,80H52.89l23.49,82.2a8,8,0,0,0,7.69,5.8h96.11a8,8,0,0,0,7.65-5.65Z"></path></svg>
                                <span class="badge bg-primary rounded-pill header-icon-badge" id="cart-icon-badge">5</span>
                            </a>
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
                            <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" id="messageDropdown" aria-expanded="false">
                                <svg xmlns="http://www.w3.org/2000/svg" class="header-link-icon animate-bell" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M208,192H48a8,8,0,0,1-6.88-12C47.71,168.6,56,139.81,56,104a72,72,0,0,1,144,0c0,35.82,8.3,64.6,14.9,76A8,8,0,0,1,208,192Z" opacity="0.1"></path><path d="M221.8,175.94C216.25,166.38,208,139.33,208,104a80,80,0,1,0-160,0c0,35.34-8.26,62.38-13.81,71.94A16,16,0,0,0,48,200H88.81a40,40,0,0,0,78.38,0H208a16,16,0,0,0,13.8-24.06ZM128,216a24,24,0,0,1-22.62-16h45.24A24,24,0,0,1,128,216ZM48,184c7.7-13.24,16-43.92,16-80a64,64,0,1,1,128,0c0,36.05,8.28,66.73,16,80Z"></path></svg>
                                <span class="header-icon-pulse bg-secondary rounded pulse pulse-secondary"></span>
                            </a>
                            <!-- End::header-link|dropdown-toggle -->
                            <!-- Start::main-header-dropdown -->
                            <div class="main-header-dropdown dropdown-menu dropdown-menu-end" data-popper-placement="none">
                                <div class="p-3">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <p class="mb-0 fs-16">Notifications</p>
                                        <span class="badge bg-secondary-transparent" id="notifiation-data">5 Unread</span>
                                    </div>
                                </div>
                                <div class="dropdown-divider"></div>
                                <ul class="list-unstyled mb-0" id="header-notification-scroll">
                                    <li class="dropdown-item">
                                        <div class="d-flex align-items-center">
                                            <div class="pe-2 lh-1">
                                                <span class="avatar avatar-md avatar-rounded bg-primary">
                                                    <i class="ti ti-message-dots fs-5"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                                                <div>
                                                    <p class="mb-0 fw-medium"><a href="javascript:void(0);">Messages</a></p>
                                                    <div class="text-muted fw-normal fs-12 header-notification-text text-truncate">John Doe messaged you.</div>
                                                </div>
                                                <div>
                                                    <a href="javascript:void(0);" class="min-w-fit-content text-muted dropdown-item-close1"><i class="ri-close-circle-line fs-5"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dropdown-item">
                                        <div class="d-flex align-items-center">
                                            <div class="pe-2 lh-1">
                                                <span class="avatar avatar-md bg-secondary avatar-rounded">
                                                    <i class="ti ti-shopping-cart fs-5"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                                                <div>
                                                    <p class="mb-0 fw-medium"><a href="javascript:void(0);">Orders</a></p>
                                                    <div class="text-muted fw-normal fs-12 header-notification-text text-truncate">Order <span class="text-warning">#12345</span> confirmed.</div>
                                                </div>
                                                <div>
                                                    <a href="javascript:void(0);" class="min-w-fit-content text-muted dropdown-item-close1"><i class="ri-close-circle-line fs-5"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dropdown-item">
                                        <div class="d-flex align-items-center">
                                            <div class="pe-2 lh-1">
                                                <span class="avatar avatar-md bg-success avatar-rounded">
                                                    <i class="ti ti-user-circle fs-5"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                                                <div>
                                                    <p class="mb-0 fw-medium"><a href="javascript:void(0);">Profile</a></p>
                                                    <div class="text-muted fw-normal fs-12 header-notification-text text-truncate">Complete your profile for offers!</div>
                                                </div>
                                                <div>
                                                    <a href="javascript:void(0);" class="min-w-fit-content text-muted dropdown-item-close1"><i class="ri-close-circle-line fs-5"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dropdown-item">
                                        <div class="d-flex align-items-center">
                                            <div class="pe-2 lh-1">
                                                <span class="avatar avatar-md bg-orange avatar-rounded">
                                                    <i class="ti ti-gift fs-5"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                                                <div>
                                                    <p class="mb-0 fw-medium"><a href="javascript:void(0);">Offers</a></p>
                                                    <div class="text-muted fw-normal fs-12 header-notification-text text-truncate">20% off electronics!</div>
                                                </div>
                                                <div>
                                                    <a href="javascript:void(0);" class="min-w-fit-content text-muted dropdown-item-close1"><i class="ri-close-circle-line fs-5"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dropdown-item">
                                        <div class="d-flex align-items-center">
                                            <div class="pe-2 lh-1">
                                                <span class="avatar avatar-md bg-info avatar-rounded">
                                                    <i class="ti ti-calendar fs-5"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1 d-flex align-items-center justify-content-between">
                                                <div>
                                                    <p class="mb-0 fw-medium"><a href="javascript:void(0);">Events</a></p>
                                                    <div class="text-muted fw-normal fs-12 header-notification-text text-truncate">Webinar in 1 hour!</div>
                                                </div>
                                                <div>
                                                    <a href="javascript:void(0);" class="min-w-fit-content text-muted dropdown-item-close1"><i class="ri-close-circle-line fs-5"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
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
                        <li class="header-element header-fullscreen">
                            <!-- Start::header-link -->
                            <a onclick="openFullscreen();" href="javascript:void(0);" class="header-link">
                                <svg xmlns="http://www.w3.org/2000/svg" class=" full-screen-open header-link-icon" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M208,48V88L168,48ZM48,208H88L48,168Zm160,0V168l-40,40ZM48,88,88,48H48Z" opacity="0.1"></path><path d="M208,40H168a8,8,0,0,0-5.66,13.66l40,40A8,8,0,0,0,216,88V48A8,8,0,0,0,208,40Zm-8,28.69L187.31,56H200ZM53.66,162.34A8,8,0,0,0,40,168v40a8,8,0,0,0,8,8H88a8,8,0,0,0,5.66-13.66ZM56,200V187.31L68.69,200Zm155.06-39.39a8,8,0,0,0-8.72,1.73l-40,40A8,8,0,0,0,168,216h40a8,8,0,0,0,8-8V168A8,8,0,0,0,211.06,160.61ZM200,200H187.31L200,187.31ZM88,40H48a8,8,0,0,0-8,8V88a8,8,0,0,0,13.66,5.66l40-40A8,8,0,0,0,88,40ZM56,68.69V56H68.69Z"></path></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="full-screen-close header-link-icon d-none" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M208,48V96L160,48ZM48,208H96L48,160Z" opacity="0.1"></path><path d="M208,40H160a8,8,0,0,0-5.66,13.66L172.69,72l-34.35,34.34a8,8,0,0,0,11.32,11.32L184,83.31l18.34,18.35A8,8,0,0,0,216,96V48A8,8,0,0,0,208,40Zm-8,36.69L179.31,56H200Zm-93.66,61.65L72,172.69,53.66,154.34A8,8,0,0,0,40,160v48a8,8,0,0,0,8,8H96a8,8,0,0,0,5.66-13.66L83.31,184l34.35-34.34a8,8,0,0,0-11.32-11.32ZM56,200V179.31L76.69,200Z"></path></svg>
                            </a>
                            <!-- End::header-link -->
                        </li>
                        <!-- End::header-element -->

                        <!-- Start::header-element -->
                        <li class="header-element dropdown">
                            <!-- Start::header-link|dropdown-toggle -->
                            <a href="javascript:void(0);" class="header-link dropdown-toggle" id="mainHeaderProfile" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                <div class="d-flex align-items-center">
                                    <div class="me-xl-2 me-0">
                                        <img src="<?php echo $baseUrl; ?>/assets/images/faces/14.jpg" alt="img" class="avatar avatar-sm avatar-rounded">
                                    </div>
                                    <div class="d-xl-block d-none lh-1">
                                        <span class="fw-medium lh-1">Mr. Jack</span>
                                    </div>
                                </div>
                            </a>
                            <!-- End::header-link|dropdown-toggle -->
                            <ul class="main-header-dropdown dropdown-menu pt-0 overflow-hidden header-profile-dropdown dropdown-menu-end" aria-labelledby="mainHeaderProfile">
                                <li><a class="dropdown-item d-flex align-items-center" href="profile.php"><i class="ti ti-user me-2 fs-18 text-primary"></i>Profile</a></li>
                                <li><a class="dropdown-item d-flex align-items-center" href="mail.php"><i class="ti ti-mail me-2 fs-18 text-secondary"></i>Inbox</a></li>
                                <li><a class="dropdown-item d-flex align-items-center" href="todo-list.php"><i class="ti ti-checklist me-2 fs-18 text-success"></i>Task Manager</a></li>
                                <li><a class="dropdown-item d-flex align-items-center" href="mail-settings.php"><i class="ti ti-settings me-2 fs-18 text-orange"></i>Settings</a></li>
                                <li><a class="dropdown-item d-flex align-items-center" href="chat.php"><i class="ti ti-headset me-2 fs-18 text-info"></i>Support</a></li>
                                <li><a class="dropdown-item d-flex align-items-center" href="signin-cover.php"><i class="ti ti-logout me-2 fs-18 text-warning"></i>Log Out</a></li>
                            </ul>
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