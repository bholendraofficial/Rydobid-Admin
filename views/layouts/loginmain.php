<?php
app\assets\LoginAsset::register($this);
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
        <?php $this->head(); ?>
        <style>
            .help-block {
                color: red;
                font-size: 12px;
                text-align: right;
                margin-top: 0px;
            }
            .logo{
                width: 50%;
                margin-top: 10px;
            }
        </style>
    </head>
    <body>
        <?php $this->beginBody(); ?>
        <div class="app">
            <div class="container-fluid p-h-0 p-v-20 bg full-height d-flex" style="background-image: url('<?= $themeUrl; ?>/images/others/login-3.png')">
                <div class="d-flex flex-column justify-content-between w-100">
                    <div class="container d-flex h-100">
                        <div class="row align-items-center w-100">
                            <div class="col-md-7 col-lg-5 m-h-auto">
                                <div class="card shadow-lg">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between m-b-30">
                                            <img class="img-fluid logo" alt="" src="<?= Yii::$app->request->baseUrl; ?>/images/logo.png">
                                            <h2 class="m-b-0"><?= $this->title; ?></h2>
                                        </div>
                                        <?= $content ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-none d-md-flex p-h-40 justify-content-between">
                        <span class="">© <?= date("Y"); ?> <?= Yii::$app->name; ?></span>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->endBody(); ?>
    </body>
</html>
<?php $this->endPage(); ?>
