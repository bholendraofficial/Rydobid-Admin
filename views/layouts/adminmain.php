<?php
app\assets\AdminAsset::register($this);
$this->beginPage();
$themeUrl = Yii::$app->request->baseUrl . '/themes/assets';
$this->title = Yii::$app->params["page_meta_data"]["page_title"];
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="shortcut icon" href="<?= $themeUrl; ?>/images/logo/favicon.png">
        <?php $this->registerCsrfMetaTags(); ?>
        <title><?= \yii\helpers\Html::encode($this->title . " | " . Yii::$app->name); ?></title>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
        <?php
        $this->head();
        $this->registerAssetBundle(yii\web\JqueryAsset::className(), yii\web\View::POS_HEAD);
        ?>
        <style>
            .logo-img{
                width: 65%;
                margin-top: 18px;
            }
            .logo-img-fold{
                width:99%;
            }
            label, table thead th, .cu-slot_info{
                font-weight: 500;
            }
            label, .form-control, button, .select2-container, table thead th, table tbody td {
                font-size: 12px !important;
            }
            .table-striped > tbody > tr:nth-of-type(2n+1){
                background-color: rgba(0,0,0,0.05) !important;
            }
            .table tbody th{
                font-weight: 500;
                font-size: 12px;
            }
            table thead th, table tbody td, table tbody th{
                text-align: center;
                padding: 5px !important;
            }
            .cu-slot_info span{
                font-size: 10.9px;
            }
            .cu-btn_bidtime, .cu-label_bidtime{
                position: relative;
                top: 5px;
            }
            .cu_list-group-item{
                background-color: rgba(0,0,0,0.05) !important;
            }
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }
            input[type=number] {
                -moz-appearance: textfield;
            }
            .cu-col-form-label{
                position: relative;
                top: 3px;
                text-align: right;
                font-size: 13px !important;
            }
            .cu-form-group{
                margin-bottom: 1rem !important;
            }
            .card-body{
                padding: 1rem;
            }
            .cu-grid-btn{
                font-size: 12px;
                margin-top: 5px;
                margin-left: 5px;
            }
            .cu_card-title{
                font-size: 13px;
            }
            .cu-badge{
                font-size: 12px;
            }
            .help-block-error {
                color: red;
                font-size: 12px;
                text-align: right;
                margin-top: 0px;
            }
            .has-error .form-control{
                color: red;
                border: 1px solid red;
            }
            .cu-pagination-ul{
                float: right;   
            }
            .cu-grid-btn{
                font-size: 12px;
            }
            /*@media (min-width:320px)  {
                tr.filters {
                    display: none;
                }
            }
            @media (min-width:481px)  {
                tr.filters {
                    display: none;
                }
            }*/
        </style>
<!--        <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>-->
    </head>
    <body>
        <?php $this->beginBody(); ?>
        <div class="notification-toast top-right" id="notification-toast"></div>
        <div class="app is-folded">
            <div class="layout">
                <!-- Header START -->
                <div class="header">
                    <div class="logo logo-dark">
                        <a href="<?= \yii\helpers\Url::to(["/site/index"]); ?>">
                            <img class="logo-img" src="<?= Yii::$app->request->baseUrl; ?>/images/logo.png" alt="Logo">
                            <img class="logo-img-fold logo-fold" src="<?= Yii::$app->request->baseUrl; ?>/images/app-icon.png" alt="Logo">
                        </a>
                    </div>
                    <div class="logo logo-white">
                        <a href="<?= \yii\helpers\Url::to(["/site/index"]); ?>">
                            <img class="logo-img" src="<?= Yii::$app->request->baseUrl; ?>/images/logo.png" alt="Logo">
                            <img class="logo-img-fold logo-fold"  src="<?= Yii::$app->request->baseUrl; ?>/images/app-icon.png" alt="Logo">
                        </a>
                    </div>
                    <div class="nav-wrap">
                        <ul class="nav-left">
                            <li class="desktop-toggle">
                                <a href="javascript:void(0);">
                                    <i class="anticon"></i>
                                </a>
                            </li>
                            <li class="mobile-toggle">
                                <a href="javascript:void(0);">
                                    <i class="anticon"></i>
                                </a>
                            </li>
                        </ul>
                        <ul class="nav-right">
                            <li class="dropdown dropdown-animated scale-left d-none d-md-block">
                                <a href="javascript:void(0);" data-toggle="dropdown">
                                    <i class="anticon anticon-bell notification-badge"></i>
                                </a>
                                <div class="dropdown-menu pop-notification">
                                    <div class="p-v-15 p-h-25 border-bottom d-flex justify-content-between align-items-center">
                                        <p class="text-dark font-weight-semibold m-b-0">
                                            <i class="anticon anticon-bell"></i>
                                            <span class="m-l-10">Notification</span>
                                        </p>
                                        <a class="btn-sm btn-default btn" href="javascript:void(0);">
                                            <small>View All</small>
                                        </a>
                                    </div>
                                    <div class="relative">
                                        <div class="overflow-y-auto relative scrollable" style="max-height: 300px">
                                            <a href="javascript:void(0);" class="dropdown-item d-block p-15 border-bottom">
                                                <div class="d-flex">
                                                    <div class="avatar avatar-blue avatar-icon">
                                                        <i class="anticon anticon-mail"></i>
                                                    </div>
                                                    <div class="m-l-15">
                                                        <p class="m-b-0 text-dark">You received a new message</p>
                                                        <p class="m-b-0"><small>8 min ago</small></p>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown dropdown-animated scale-left">
                                <div class="pointer" data-toggle="dropdown">
                                    <div class="avatar avatar-image  m-h-10 m-r-15">
                                        <img src="<?= Yii::$app->request->baseUrl; ?>/images/bala-img.jpg"  alt="">
                                    </div>
                                </div>
                                <div class="p-b-15 p-t-20 dropdown-menu pop-profile">
                                    <div class="p-h-20 p-b-15 m-b-10 border-bottom">
                                        <div class="d-flex m-r-50">
                                            <div class="avatar avatar-lg avatar-image">
                                                <img src="<?= Yii::$app->request->baseUrl; ?>/images/bala-img.jpg" alt="">
                                            </div>
                                            <div class="m-l-10">
                                                <p class="m-b-0 text-dark font-weight-semibold">Balakrishna A.</p>
                                                <p class="m-b-0 opacity-07">Master Admin</p>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="javascript:void(0);" class="dropdown-item d-block p-h-15 p-v-10">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <i class="anticon opacity-04 font-size-16 anticon-lock"></i>
                                                <span class="m-l-10">Change password</span>
                                            </div>
                                            <i class="anticon font-size-10 anticon-right"></i>
                                        </div>
                                    </a>
                                    <a href="<?= \yii\helpers\Url::to(["/site/logout"]); ?>" class="dropdown-item d-block p-h-15 p-v-10">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <i class="anticon opacity-04 font-size-16 anticon-logout"></i>
                                                <span class="m-l-10">Logout</span>
                                            </div>                                            
                                        </div>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>    
                <!-- Header END -->

                <?php include_once 'adminmenu.php'; ?>

                <!-- Page Container START -->
                <div class="page-container">
                    <!-- Content Wrapper START -->
                    <div class="main-content">
                        <?= $content ?>
                    </div>

                    <footer class="footer">
                        <div class="footer-content">
                            <p class="m-b-0">Copyright © <?= date("Y"); ?> <?= Yii::$app->name; ?>. All rights reserved.</p>
                        </div>
                    </footer>
                    <!-- Footer END -->
                </div>


            </div>
        </div>
        <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage(); ?>
