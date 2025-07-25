<!-- This code generates the base URL for the website by combining the protocol, domain name, and directory path -->
<?php
    $rootFolder = basename($_SERVER['DOCUMENT_ROOT']);
    $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . str_replace('/pages', '', dirname($_SERVER['SCRIPT_NAME']));
?>
<!-- This code generates the base URL for the website by combining the protocol, domain name, and directory path -->

<!-- This code is useful for internal styles  -->
<?php ob_start(); ?>


<?php $styles = ob_get_clean(); ?>
<!-- This code is useful for internal styles  -->

<!-- This code is useful for content -->
<?php ob_start(); ?>

            <div class="main-content app-content">
                <div class="container-fluid">

                    <!-- Page Header -->
                    <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
                        <div>
                            <h1 class="page-title fw-medium fs-18 mb-2">Profile Settings</h1>
                            <div class="">
                                <nav>
                                    <ol class="breadcrumb mb-0">
                                        <li class="breadcrumb-item"><a href="javascript:void(0);">Pages</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Profile Settings</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <div class="btn-list">
                            <button class="btn btn-primary-light btn-wave me-2">
                                <i class="bx bx-crown align-middle"></i> Plan Upgrade
                            </button>
                            <button class="btn btn-secondary-light btn-wave me-0">
                                <i class="ri-upload-cloud-line align-middle"></i> Export Report
                            </button>
                        </div>
                    </div>
                    <!-- Page Header Close -->

                    <!-- Start::row-1 -->
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card custom-card">
                                <div class="card-header">
                                    <div class="card-title">
                                        PROFILE SETTINGS
                                    </div>
                                </div>
                                <div class="card-body p-4">
                                    <span class="fw-semibold mb-3 d-block">ACCOUNT :</span>
                                    <div class="row gy-3 mb-4">
                                        <div class="col-xl-12">
                                            <div class="d-flex align-items-start flex-wrap gap-3">
                                                <div>
                                                    <span class="avatar avatar-xxl">
                                                        <img src="<?php echo $baseUrl; ?>/assets/images/faces/9.jpg" alt="">
                                                    </span>
                                                </div>
                                                <div>
                                                    <span class="fw-medium d-block mb-2">Profile Picture</span>
                                                    <div class="btn-list mb-1">
                                                        <button class="btn btn-sm btn-primary btn-wave"><i class="ri-upload-2-line me-1"></i>Change Image</button>
                                                        <button class="btn btn-sm btn-light btn-wave"><i class="ri-delete-bin-line me-1"></i>Remove</button>
                                                    </div>
                                                    <span class="d-block fs-12 text-muted">Use JPEG, PNG, or GIF. Best size: 200x200 pixels. Keep it under 5MB</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="profile-user-name" class="form-label">User Name :</label>
                                            <input type="text" class="form-control" id="profile-user-name" value="" placeholder="Enter Name">
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="profile-email" class="form-label">Email :</label>
                                            <input type="email" class="form-control" id="profile-email" value="" placeholder="Enter Email">
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="profile-phn-no" class="form-label">Phone No :</label>
                                            <input type="text" class="form-control" id="profile-phn-no" value="" placeholder="Enter Number">
                                        </div>
                                        <div class="col-xl-3">
                                            <label for="profile-age" class="form-label">Age :</label>
                                            <input type="number" class="form-control" id="profile-age" value="" placeholder="Enter Age">
                                        </div>
                                        <div class="col-xl-3">
                                            <label for="profile-designation" class="form-label">Designation :</label>
                                            <input type="text" class="form-control" id="profile-designation" value="" placeholder="Enter Designation">
                                        </div>
                                        <div class="col-xl-12">
                                            <label for="profile-address" class="form-label">Address :</label>
                                            <textarea class="form-control" id="profile-address" rows="3"></textarea>
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="profile-language" class="form-label">Language :</label>
                                            <select class="form-control" data-trigger id="profile-language">
                                                <option>Us English</option>
                                                <option>Arabic</option> 
                                                <option>Korean</option> 
                                            </select>
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="profile-timezone" class="form-label">Timezone :</label>
                                            <select class="form-control" data-trigger id="profile-timezone">
                                                <option value="Pacific/Midway" data-select2-id="6"> (GMT-11:00) Midway Island, Samoa</option> 
                                                <option value="America/Adak" data-select2-id="16"> (GMT-10:00) Hawaii-Aleutian</option> 
                                                <option value="Etc/GMT+10" data-select2-id="17"> (GMT-10:00) Hawaii</option> 
                                                <option value="Pacific/Marquesas" data-select2-id="18"> (GMT-09:30) Marquesas Islands</option> 
                                                <option value="Pacific/Gambier" data-select2-id="19"> (GMT-09:00) Gambier Islands</option> 
                                                <option value="America/Anchorage" data-select2-id="20"> (GMT-09:00) Alaska</option> 
                                                <option value="America/Ensenada" data-select2-id="21"> (GMT-08:00) Tijuana, Baja California</option> 
                                                <option value="Etc/GMT+8" data-select2-id="22"> (GMT-08:00) Pitcairn Islands</option> 
                                                <option value="America/Los_Angeles" data-select2-id="23">(GMT-08:00) Pacific Time (US &amp; Canada)</option> 
                                                <option value="America/Denver" data-select2-id="24"> (GMT-07:00) Mountain Time (US &amp; Canada)</option> 
                                                <option value="America/Chihuahua" data-select2-id="25"> (GMT-07:00) Chihuahua, La Paz, Mazatlan</option> 
                                                <option value="America/Dawson_Creek" data-select2-id="26">(GMT-07:00) Arizona</option> 
                                                <option value="America/Belize" data-select2-id="27"> (GMT-06:00) Saskatchewan, Central America</option> 
                                                <option value="America/Cancun" data-select2-id="28"> (GMT-06:00) Guadalajara, Mexico City, Monterrey </option> 
                                                <option value="Chile/EasterIsland" data-select2-id="29"> (GMT-06:00) Easter Island</option> 
                                                <option value="America/Chicago" data-select2-id="30"> (GMT-06:00) Central Time (US &amp; Canada)</option> 
                                                <option value="America/New_York" data-select2-id="31"> (GMT-05:00) Eastern Time (US &amp; Canada)</option> 
                                                <option value="America/Havana" data-select2-id="32"> (GMT-05:00) Cuba</option> 
                                                <option value="America/Bogota" data-select2-id="33"> (GMT-05:00) Bogota, Lima, Quito, Rio Branco</option> 
                                                <option value="America/Caracas" data-select2-id="34"> (GMT-04:30) Caracas</option> 
                                                <option value="America/Santiago" data-select2-id="35"> (GMT-04:00) Santiago</option> 
                                                <option value="America/La_Paz" data-select2-id="36"> (GMT-04:00) La Paz</option> 
                                                <option value="Atlantic/Stanley" data-select2-id="37"> (GMT-04:00) Faukland Islands</option> 
                                                <option value="America/Campo_Grande" data-select2-id="38">(GMT-04:00) Brazil</option> 
                                                <option value="America/Goose_Bay" data-select2-id="39"> (GMT-04:00) Atlantic Time (Goose Bay)</option> 
                                                <option value="America/Glace_Bay" data-select2-id="40"> (GMT-04:00) Atlantic Time (Canada)</option> 
                                                <option value="America/St_Johns" data-select2-id="41"> (GMT-03:30) Newfoundland</option> 
                                                <option value="America/Araguaina" data-select2-id="42"> (GMT-03:00) UTC-3</option> 
                                                <option value="America/Montevideo" data-select2-id="43"> (GMT-03:00) Montevideo</option> 
                                                <option value="America/Miquelon" data-select2-id="44"> (GMT-03:00) Miquelon, St. Pierre</option> 
                                                <option value="America/Godthab" data-select2-id="45"> (GMT-03:00) Greenland</option> 
                                                <option value="America/Argentina/Buenos_Aires" data-select2-id="46">(GMT-03:00) Buenos Aires </option> 
                                                <option value="America/Sao_Paulo" data-select2-id="47"> (GMT-03:00) Brasilia</option> 
                                                <option value="America/Noronha" data-select2-id="48"> (GMT-02:00) Mid-Atlantic</option> 
                                                <option value="Atlantic/Cape_Verde" data-select2-id="49">(GMT-01:00) Cape Verde Is. </option> 
                                                <option value="Atlantic/Azores" data-select2-id="50"> (GMT-01:00) Azores</option> 
                                                <option value="Europe/Belfast" data-select2-id="51"> (GMT) Greenwich Mean Time : Belfast</option> 
                                                <option value="Europe/Dublin" data-select2-id="52">(GMT) Greenwich Mean Time : Dublin</option> 
                                                <option value="Europe/Lisbon" data-select2-id="53">(GMT) Greenwich Mean Time : Lisbon</option> 
                                                <option value="Europe/London" data-select2-id="54">(GMT) Greenwich Mean Time : London</option> 
                                                <option value="Africa/Abidjan" data-select2-id="55"> (GMT) Monrovia, Reykjavik</option> 
                                                <option value="Europe/Amsterdam" data-select2-id="56"> (GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna</option> 
                                                <option value="Europe/Belgrade" data-select2-id="57"> (GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague</option> 
                                                <option value="Europe/Brussels" data-select2-id="58"> (GMT+01:00) Brussels, Copenhagen, Madrid, Paris </option> 
                                                <option value="Africa/Algiers" data-select2-id="59"> (GMT+01:00) West Central Africa</option> 
                                                <option value="Africa/Windhoek" data-select2-id="60"> (GMT+01:00) Windhoek</option> 
                                                <option value="Asia/Beirut" data-select2-id="61"> (GMT+02:00) Beirut</option> 
                                                <option value="Africa/Cairo" data-select2-id="62"> (GMT+02:00) Cairo</option> 
                                                <option value="Asia/Gaza" data-select2-id="63"> (GMT+02:00) Gaza</option> 
                                                <option value="Africa/Blantyre" data-select2-id="64"> (GMT+02:00) Harare, Pretoria</option> 
                                                <option value="Asia/Jerusalem" data-select2-id="65"> (GMT+02:00) Jerusalem</option> 
                                                <option value="Europe/Minsk" data-select2-id="66"> (GMT+02:00) Minsk</option> 
                                                <option value="Asia/Damascus" data-select2-id="67"> (GMT+02:00) Syria</option> 
                                                <option value="Europe/Moscow" data-select2-id="68"> (GMT+03:00) Moscow, St. Petersburg, Volgograd </option> 
                                                <option value="Africa/Addis_Ababa" data-select2-id="69"> (GMT+03:00) Nairobi</option> 
                                                <option value="Asia/Tehran" data-select2-id="70"> (GMT+03:30) Tehran</option> 
                                                <option value="Asia/Dubai" data-select2-id="71"> (GMT+04:00) Abu Dhabi, Muscat</option> 
                                                <option value="Asia/Yerevan" data-select2-id="72"> (GMT+04:00) Yerevan</option> 
                                                <option value="Asia/Kabul" data-select2-id="73"> (GMT+04:30) Kabul</option> 
                                                <option value="Asia/Yekaterinburg" data-select2-id="74"> (GMT+05:00) Ekaterinburg</option> 
                                                <option value="Asia/Tashkent" data-select2-id="75"> (GMT+05:00) Tashkent</option> 
                                                <option value="Asia/Kolkata" data-select2-id="76"> (GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi </option> 
                                                <option value="Asia/Katmandu" data-select2-id="77"> (GMT+05:45) Kathmandu</option> 
                                                <option value="Asia/Dhaka" data-select2-id="78"> (GMT+06:00) Astana, Dhaka</option> 
                                                <option value="Asia/Novosibirsk" data-select2-id="79"> (GMT+06:00) Novosibirsk</option> 
                                                <option value="Asia/Rangoon" data-select2-id="80"> (GMT+06:30) Yangon (Rangoon)</option> 
                                                <option value="Asia/Bangkok" data-select2-id="81"> (GMT+07:00) Bangkok, Hanoi, Jakarta</option> 
                                                <option value="Asia/Krasnoyarsk" data-select2-id="82"> (GMT+07:00) Krasnoyarsk</option> 
                                                <option value="Asia/Hong_Kong" data-select2-id="83"> (GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi </option> 
                                                <option value="Asia/Irkutsk" data-select2-id="84"> (GMT+08:00) Irkutsk, Ulaan Bataar</option> 
                                                <option value="Australia/Perth" data-select2-id="85"> (GMT+08:00) Perth</option> 
                                                <option value="Australia/Eucla" data-select2-id="86"> (GMT+08:45) Eucla</option> 
                                                <option value="Asia/Tokyo" data-select2-id="87"> (GMT+09:00) Osaka, Sapporo, Tokyo</option> 
                                                <option value="Asia/Seoul" data-select2-id="88"> (GMT+09:00) Seoul</option> 
                                                <option value="Asia/Yakutsk" data-select2-id="89"> (GMT+09:00) Yakutsk</option> 
                                                <option value="Australia/Adelaide" data-select2-id="90"> (GMT+09:30) Adelaide</option> 
                                                <option value="Australia/Darwin" data-select2-id="91"> (GMT+09:30) Darwin</option> 
                                                <option value="Australia/Brisbane" data-select2-id="92"> (GMT+10:00) Brisbane</option> 
                                                <option value="Australia/Hobart" data-select2-id="93"> (GMT+10:00) Hobart</option> 
                                                <option value="Asia/Vladivostok" data-select2-id="94"> (GMT+10:00) Vladivostok</option> 
                                                <option value="Australia/Lord_Howe" data-select2-id="95">(GMT+10:30) Lord Howe Island </option> 
                                                <option value="Etc/GMT-11" data-select2-id="96"> (GMT+11:00) Solomon Is., New Caledonia</option> 
                                                <option value="Asia/Magadan" data-select2-id="97"> (GMT+11:00) Magadan</option> 
                                                <option value="Pacific/Norfolk" data-select2-id="98"> (GMT+11:30) Norfolk Island</option> 
                                                <option value="Asia/Anadyr" data-select2-id="99"> (GMT+12:00) Anadyr, Kamchatka</option> 
                                                <option value="Pacific/Auckland" data-select2-id="100"> (GMT+12:00) Auckland, Wellington</option> 
                                                <option value="Etc/GMT-12" data-select2-id="101"> (GMT+12:00) Fiji, Kamchatka, Marshall Is.</option> 
                                                <option value="Pacific/Chatham" data-select2-id="102"> (GMT+12:45) Chatham Islands</option> 
                                                <option value="Pacific/Tongatapu" data-select2-id="103"> (GMT+13:00) Nuku'alofa</option> 
                                                <option value="Pacific/Kiritimati" data-select2-id="104">(GMT+14:00) Kiritimati </option> 
                                            </select>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="mb-sm-0 mb-2 w-75">
                                                <label for="profile-age" class="form-label">Verification :</label>
                                                <div class="mb-0 authentication-btn-group">
                                                    <div class="btn-group btn-group-sm" role="group" aria-label="Basic radio toggle button group">
                                                        <input type="radio" class="btn-check" name="btnradio" id="btnradio1" checked="">
                                                        <label class="btn btn-outline-light btn-sm" for="btnradio1"><i class="ri-mail-line me-1 align-middle d-inline-block"></i>Email</label>
                                                        <input type="radio" class="btn-check" name="btnradio" id="btnradio2">
                                                        <label class="btn btn-outline-light btn-sm" for="btnradio2"><i class="ri-chat-4-line me-1 align-middle d-inline-block"></i>Sms</label>
                                                        <input type="radio" class="btn-check" name="btnradio" id="btnradio3">
                                                        <label class="btn btn-outline-light btn-sm" for="btnradio3"><i class="ri-phone-line me-1 align-middle d-inline-block"></i>Phone</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row gy-3 mb-4">
                                        <div class="col-xl-12">
                                            <span class="fw-semibold mb-3 d-block">SECURITY SETTINGS :</span>
                                            <div class="d-sm-flex d-block align-items-top justify-content-between">
                                                <div class="w-50">
                                                    <p class="fs-14 mb-1 fw-medium">Login Verification</p>
                                                    <p class="fs-12 mb-0 text-muted">This helps protect accounts from unauthorized access, even if a password is compromised.</p>
                                                </div>
                                                <a href="javascript:void(0);" class="link-primary text-decoration-underline">Set Up Verification</a>
                                            </div>
                                            <div class="d-sm-flex d-block align-items-top justify-content-between mt-3">
                                                <div class="w-50">
                                                    <p class="fs-14 mb-1 fw-medium">Password Verification</p>
                                                    <p class="fs-12 mb-0 text-muted">This additional step helps ensure that the person attempting to modify account details is the legitimate account owner.</p>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="personal-details">
                                                    <label class="form-check-label" for="personal-details">
                                                        Require Personal Details
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <span class="fw-semibold mb-3 d-block">NOTIFICATIONS :</span>
                                            <div class="row gx-5 gy-3">
                                                <div class="col-xl-12">
                                                    <p class="fs-14 mb-1 fw-medium">Configure Notifications</p>
                                                    <p class="fs-12 mb-0 text-muted">By configuring notifications, users can tailor their experience to receive alerts for the types of events that matter to them.</p>
                                                </div>
                                                <div class="col-xl-12">
                                                    <div class="d-flex align-items-top justify-content-between mt-sm-0 mt-3">
                                                        <div class="mail-notification-settings">
                                                            <p class="fs-14 mb-1 fw-medium">In-App Notifications</p>
                                                            <p class="fs-12 mb-0 text-muted">Alerts that appear within the application interface.</p>
                                                        </div>
                                                        <div class="toggle toggle-success on mb-0 float-sm-end" id="in-app-notifications">
                                                            <span></span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-top justify-content-between mt-3">
                                                        <div class="mail-notification-settings">
                                                            <p class="fs-14 mb-1 fw-medium">Email Notifications</p>
                                                            <p class="fs-12 mb-0 text-muted">Messages sent to the user's email address.</p>
                                                        </div>
                                                        <div class="toggle toggle-success on mb-0 float-sm-end" id="email-notifications">
                                                            <span></span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-top justify-content-between mt-3">
                                                        <div class="mail-notification-settings">
                                                            <p class="fs-14 mb-1 fw-medium">Push Notifications</p>
                                                            <p class="fs-12 mb-0 text-muted">Alerts sent to the user's mobile device or desktop.</p>
                                                        </div>
                                                        <div class="toggle toggle-success mb-0 float-sm-end" id="push-notifications">
                                                            <span></span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex align-items-top justify-content-between mt-3">
                                                        <div class="mail-notification-settings">
                                                            <p class="fs-14 mb-1 fw-medium">SMS Notifications</p>
                                                            <p class="fs-12 mb-0 text-muted">Text messages sent to the user's mobile phone.</p>
                                                        </div>
                                                        <div class="toggle toggle-success on mb-0 float-sm-end" id="sms-notifications">
                                                            <span></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="btn-list float-end">
                                        <button class="btn btn-danger btn-wave">Deactivate Account</button>
                                        <button class="btn btn-light btn-wave">Restore Defaults</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End::row-1 -->

                </div>
            </div>
            
<?php $content = ob_get_clean(); ?>
<!-- This code is useful for content -->

<!-- This code is useful for internal scripts  -->
<?php ob_start(); ?>



<?php $scripts = ob_get_clean(); ?>
<!-- This code is useful for internal scripts  -->

<!-- This code use for render base file -->
<?php include 'layouts/base.php'; ?>
<!-- This code use for render base file -->