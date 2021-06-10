<div class="card cu-card">
    <div class="card-header">
        <h4 class="card-title"><?= \Yii::$app->params["page_meta_data"]["page_title"]; ?></h4>
    </div>
    <div class="card-body">
        <ul class="nav nav-tabs" id="driverCompleteTabViewList" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="t1" data-toggle="tab" href="#tc1" role="tab" aria-controls=""
                   aria-selected="true">User Info</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="t4" data-toggle="tab" href="#tc4" role="tab" aria-controls=""
                   aria-selected="false">Cab Info</a>
            </li>
        </ul>
        <div class="tab-content m-t-15" id="driverCompleteTabView">
            <div class="tab-pane fade show active" id="tc1" role="tabpanel" aria-labelledby="">
                <div class="row">
                    <div class="col-md-12">
                        <?=
                        yii\widgets\DetailView::widget([
                            'model' => $Driver,
                            'options' => ['class' => 'table table-striped table-bordered table-condensed'],
                            'attributes' => [
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
                                'rybDriver.ryb_driver_is_online:boolean',
                                'rybDriver.ryb_driver_pref_is_daily:boolean',
                                'rybDriver.ryb_driver_pref_is_outstation:boolean',
                                'rybDriver.ryb_driver_pref_is_rental:boolean',
                                'rybDriver.ryb_driver_pref_is_airport:boolean',
                                'rybStatus.ryb_status_text',
                                'ryb_user_addedat:datetime',
                                [
                                    'label' => 'Cab Status(KYC)',
                                    'value' => function ($model) {
                                        return $model->rybDriver->driverCab->rybDriverCabStatus->ryb_driver_cab_status_text;
                                    }
                                ],
                                [
                                    'label' => 'Cab Status(KYC) Remark',
                                    'value' => function ($model) {
                                        return $model->rybDriver->driverCab->ryb_driver_cab_status_remark;
                                    }
                                ],
                            ],
                        ])
                        ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="tc4" role="tabpanel" aria-labelledby="">
                <div class="row">
                    <div class="col-md-12">
                        <?=
                        yii\widgets\DetailView::widget([
                            'model' => $Driver->rybDriver->driverCab,
                            'options' => ['class' => 'table table-striped table-bordered table-condensed'],
                            'attributes' => [
                                'ryb_driver_cab_brand',
                                'ryb_driver_cab_model',
                                'ryb_driver_cab_make_year',
                                'ryb_driver_cab_exterior_color',
                                'ryb_driver_cab_interior_color',
                                'ryb_driver_license_no',
                                'ryb_driver_license_expiry',
                                'ryb_driver_cab_chasis_no',
                                'ryb_driver_cab_reg_no',
                                'ryb_driver_cab_permit_no',
                                'ryb_driver_cab_permit_expiry',
                                'ryb_driver_cab_insurance_no',
                                'ryb_driver_cab_insurance_expiry',
                                [
                                    'attribute' => 'ryb_driver_license_cert',
                                    'format' => 'html',
                                    'value' => function ($model) {
                                        return yii\helpers\Html::img($model->ryb_driver_license_cert, ['style' => 'width:225px;']) .
                                            "<br/>" . \yii\helpers\Html::a('View File', $model->ryb_driver_license_cert, ['target' => '_blank']);
                                    }
                                ],
                                [
                                    'attribute' => 'ryb_driver_cab_insurance_cert',
                                    'format' => 'html',
                                    'value' => function ($model) {
                                        return yii\helpers\Html::img($model->ryb_driver_cab_insurance_cert, ['style' => 'width:225px;']) .
                                            "<br/>" . \yii\helpers\Html::a('View File', $model->ryb_driver_cab_insurance_cert, ['target' => '_blank']);
                                    }
                                ],
                                [
                                    'attribute' => 'ryb_driver_cab_permit_cert',
                                    'format' => 'html',
                                    'value' => function ($model) {
                                        return yii\helpers\Html::img($model->ryb_driver_cab_permit_cert, ['style' => 'width:225px;']) .
                                            "<br/>" . \yii\helpers\Html::a('View File', $model->ryb_driver_cab_permit_cert, ['target' => '_blank']);
                                    }
                                ],
                                [
                                    'attribute' => 'ryb_driver_cab_reg_cert',
                                    'format' => 'html',
                                    'value' => function ($model) {
                                        return yii\helpers\Html::img($model->ryb_driver_cab_reg_cert, ['style' => 'width:225px;']) .
                                            "<br/>" . \yii\helpers\Html::a('View File', $model->ryb_driver_cab_reg_cert, ['target' => '_blank']);
                                    }
                                ],
                                'ryb_driver_cab_added_at:datetime'
                            ]
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>