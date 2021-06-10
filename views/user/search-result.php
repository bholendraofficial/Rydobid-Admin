<div class="card cu-card">
    <div class="card-header">
        <h4 class="card-title"><?= \Yii::$app->params["page_meta_data"]["page_title"]; ?></h4>
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs" id="driverCompleteTabViewList" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="t1" data-toggle="tab" href="#tc1" role="tab" aria-controls="" aria-selected="true">User Info</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="t4" data-toggle="tab" href="#tc4" role="tab" aria-controls="" aria-selected="false">Bookings & Reviews</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="t5" data-toggle="tab" href="#tc5" role="tab" aria-controls="" aria-selected="false">Payment & Transactions</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="t6" data-toggle="tab" href="#tc6" role="tab" aria-controls="" aria-selected="false">Support Tickets</a>
            </li>
            <!--<li class="nav-item"><a class="nav-link" id="t6" data-toggle="tab" href="#tc7" role="tab" aria-controls="" aria-selected="false">Login History</a></li>-->
        </ul>
        <div class="tab-content m-t-15" id="driverCompleteTabView">
            <div class="tab-pane fade show active" id="tc1" role="tabpanel" aria-labelledby="">
                <div class="row">
                    <div class="col-md-12">
                        <?=
                        yii\widgets\DetailView::widget([
                            'model' => $model,
                            'options' => ['class' => 'table table-striped table-bordered table-condensed'],
                            'attributes' => [
                                [
                                    'attribute' => 'ryb_user_picture',
                                    'format' => 'html',
                                    'value' => function ($model) {
                                        return yii\helpers\Html::img($model->ryb_user_picture, ['style' => 'width:75px;']);
                                    }
                                ],
                                'ryb_user_id',
                                [
                                    'attribute' => 'ryb_user_login_method',
                                    'value' => function ($model) {
                                        if ($model->ryb_user_login_method == 1) {
                                            return "Traditional";
                                        } else if ($model->ryb_user_login_method == 1) {
                                            return "Facebook";
                                        } else if ($model->ryb_user_login_method == 1) {
                                            return "Google";
                                        }
                                    }
                                ],
                                'ryb_user_fullname',
                                'ryb_user_emailid:email',
                                'ryb_user_phoneno',
                                'ryb_user_verify_status:boolean',
                                'ryb_user_addr_home',
                                'ryb_user_addr_work',
                                'rybStatus.ryb_status_text',
                                'ryb_user_addedat:datetime',
                            ],
                        ])
                        ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="tc4" role="tabpanel" aria-labelledby="">^Dynamic Content will replace this^</div>
            <div class="tab-pane fade" id="tc5" role="tabpanel" aria-labelledby="">^Dynamic Content will replace this^</div>
            <div class="tab-pane fade" id="tc6" role="tabpanel" aria-labelledby="">^Dynamic Content will replace this^</div>
            <!--<div class="tab-pane fade" id="tc7" role="tabpanel" aria-labelledby="">^Dynamic Content will replace this^</div>-->
        </div>
    </div>
</div>