<style>
    .table tbody th {
        font-weight: bold;
    }
</style>
<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between m-b-15">
            <h4 class="m-b-0"><?= \Yii::$app->params["page_meta_data"]["page_title"]; ?></h4>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-5">
                <?php
                $form = yii\widgets\ActiveForm::begin([
                    'action' => \yii\helpers\Url::to(["driver/kyc", "id" => Yii::$app->request->get('id')]),
                    'fieldConfig' => [
                        'template' => '{label}<div class="col-sm-9">{input}{error}</div>',
                        'labelOptions' => [
                            'class' => 'col-sm-3 col-form-label cu-col-form-label'
                        ],
                        'inputOptions' => array(
                            'class' => 'form-control cu-form-control'
                        ),
                        'errorOptions' => array(
                            'class' => 'help-block-error'
                        ),
                        'options' => [
                            'class' => 'form-group row'
                        ]
                    ],
                    'options' => [
                        'id' => 'kyc-form',
                        'method' => 'POST',
                        'enctype' => 'multipart/form-data'
                    ]
                ]);
                echo $form->field($DriverCabModel, 'ryb_driver_cab_status_id')->widget(\kartik\widgets\Select2::className(), [
                    'data' => $KYCStatusArray,
                    'options' => ['placeholder' => 'Select KYC status', 'style' => 'width:100%;'],
                    'pluginOptions' => ['allowClear' => true]
                ]);
                echo $form->field($DriverCabModel, 'ryb_driver_cab_status_remark')->textarea(['rows' => 10]);
                ?>
                <div class="form-group text-right row">
                    <div class="col-sm-12">
                        <?= \yii\helpers\Html::submitButton('Save KYC', ['class' => 'btn btn-primary m-r-5']) ?>
                    </div>
                </div>
                <?php yii\widgets\ActiveForm::end(); ?>
            </div>
            <div class="col-xs-12 col-md-7">
                <?=
                yii\widgets\DetailView::widget([
                    'model' => $DriverCab->driverCab,
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
<script type="text/javascript">
    $(document).ready(function () {
        $('#drivercabmaster-ryb_driver_cab_status_id').on('select2:select', function (e) {
            /*alert($(this).val());*/
        });
    });
</script>
