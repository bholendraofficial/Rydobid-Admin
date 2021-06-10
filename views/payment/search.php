<style>
    .cu-search_field{
        font-size: 16px !important;
    }
    .cu-logo_search{
        width: 350px;
    }
    .cu-logo_search-box{
        margin-bottom: 25px;
    }
    .cu-search_btn-box{
        margin-top: 25px;
    }
    .cu-search_box{
        padding: 0px 50px;
    }
    .cu-search_btn{
        font-size: 14px !important;
    }
    
    @media only screen and (max-width: 768px) {
        .cu-logo_search{
            width: 100%;
        }
    }
</style>
<div class="card cu-card">
    <div class="card-body">
        <form method="GET" action="">
            <div class="row text-center cu-search_box">

                <div class="col-md-12 cu-logo_search-box">
                    <img class="cu-logo_search" src="<?= Yii::$app->request->baseUrl; ?>/images/logo.png">
                </div>

                <div class="col-md-12">
                    <input type="number" class="form-control font-weight-bold cu-search_field" value="" placeholder="Enter Transaction ID">
                </div>

                <div class="col-md-12 cu-search_btn-box">
                    <a href="<?= \yii\helpers\Url::to(["/payment/payment-view"]); ?>" class="btn btn-primary cu-search_btn">
                        <i class="anticon anticon-search"></i>
                        <span>Search</span>
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>