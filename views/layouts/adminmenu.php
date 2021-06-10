<div class="side-nav">
    <div class="side-nav-inner">
        <ul class="side-nav-menu scrollable">
            <li class="nav-item dropdown open">
                <a href="<?= \yii\helpers\Url::to(["/site/index"]); ?>">
                    <span class="icon-holder"><i class="anticon anticon-dashboard"></i></span>
                    <span class="title">Dashboard</span> 
                </a>
            </li>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="javascript:void(0);">
                    <span class="icon-holder"><i class="anticon anticon-cluster"></i></span>
                    <span class="title">Master Modules</span>
                    <span class="arrow"><i class="arrow-icon"></i></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="<?= \yii\helpers\Url::to(["/cab-type/index"]); ?>">Cab Type</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(["/ride-type/index"]); ?>">Ride Type</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(["/configuration/countries"]); ?>">Country</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(["/configuration/states"]); ?>">State</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(["/configuration/cities"]); ?>">City</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(["/configuration/pincodes"]); ?>">Pincode</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(["/configuration/config-common"]); ?>">Common - Configure</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(["/airport/index"]); ?>">Airport</a></li>
                </ul>
            </li>
            <!--            <li class="nav-item dropdown">
                            <a class="dropdown-toggle" href="javascript:void(0);">
                                <span class="icon-holder"><i class="anticon anticon-appstore"></i></span>
                                <span class="title">Configuration</span>
                                <span class="arrow"><i class="arrow-icon"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="<?= \yii\helpers\Url::to(["/configuration/config-params"]); ?>">Configure - Variables</a></li>
                                
                            </ul>
                        </li>-->
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="javascript:void(0);">
                    <span class="icon-holder"><i class="anticon anticon-deployment-unit"></i></span>
                    <span class="title">Operational</span>
                    <span class="arrow"><i class="arrow-icon"></i></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="<?= \yii\helpers\Url::to(["/promo-code/index"]); ?>">Promo-code</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(["/user/index"]); ?>">Registered User</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(["/driver/index"]); ?>">Drivers & Cabs</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(["/booking/index"]); ?>">Bookings</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(["/track/index"]); ?>">Track - Booking, Cab/Driver</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(["/payment/index"]); ?>">Payment & Transaction</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="javascript:void(0);">
                    <span class="icon-holder"><i class="anticon anticon-area-chart"></i></span>
                    <span class="title">Reporting</span>
                    <span class="arrow"><i class="arrow-icon"></i></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="javascript:void(0);">____</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" href="javascript:void(0);">
                    <span class="icon-holder"><i class="anticon anticon-customer-service"></i></span>
                    <span class="title">Support System</span>
                    <span class="arrow"><i class="arrow-icon"></i></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="<?= \yii\helpers\Url::to(["/support-system/index"]); ?>">Tickets</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(["/support-system/faq"]); ?>">FAQ(Frequently Asked Questions)</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a href="javascript:void(0);">
                    <span class="icon-holder"><i class="anticon anticon-issues-close"></i></span>
                    <span class="title">Content Management</span>
                    <span class="arrow"><i class="arrow-icon"></i></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="<?= \yii\helpers\Url::to(["/content-manage/about-us"]); ?>">About Us</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(["/content-manage/terms-conditions"]); ?>">Terms & Conditions</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(["/content-manage/privacy-policy"]); ?>">Privacy Policy</a></li>
                    <li><a href="<?= \yii\helpers\Url::to(["/content-manage/cancel-refund-policy"]); ?>">Cancellation &  Refund Policy</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown open">
                <a href="<?= \yii\helpers\Url::to(["/admin/index"]); ?>">
                    <span class="icon-holder"><i class="anticon anticon-usergroup-add"></i></span>
                    <span class="title">Employee Admin</span> 
                </a>
            </li>
            <li class="nav-item dropdown">
                <a href="<?= \yii\helpers\Url::to(["/role-access/index"]); ?>">
                    <span class="icon-holder"><i class="anticon anticon-safety"></i></span>
                    <span class="title">Access Control(RBAC)</span>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a href="javascript:void(0);">
                    <span class="icon-holder"><i class="anticon anticon-download"></i></span>
                    <span class="title">Database Backup</span>
                </a>
            </li>
        </ul>
    </div>
</div>
