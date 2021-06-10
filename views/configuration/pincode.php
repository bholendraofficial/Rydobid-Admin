<style>
    #data-table_wrapper, label, .form-control, button, .select2-container {
        font-size: 12px !important;
    }
    #data-table thead th, #data-table tbody td{
        text-align: center;
    }
    /*.cu-card{
        max-width: 48%;
        margin: 10px;
    }*/
    @media only screen and (max-width: 768px) {
        .cu-card{
            max-width: 100%;
        }
    }
</style>
<div class="row">
    <div class="col-sm-12 col-md-8 card cu-card">
        <div class="card-header">
            <h4 class="card-title">Pincodes - Lucknow - Uttar Pradesh - India</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 mb-2 text-right">
                    <button type="button" class="btn btn-info btn-sm btn-import-file"><i class="anticon anticon-download"></i> Import</button>
                </div>
                <div class="col-md-12">
                    <?=
                    \kartik\grid\GridView::widget([
                        'moduleId' => 'gridview',
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'responsive' => true,
                        'hover' => true,
                        'pjax' => false,
                        'layout' => '{errors}<div class="fixed-table-body">{items}</div><div class="row"><div class="col-xs-12 col-md-6">{summary}</div><div class="col-xs-12 col-md-6">{pager}</div></div>',
                        'emptyCell' => '',
                        'emptyText' => 'No results found!',
                        'pager' => [
                            'options' => ['class' => 'pagination cu-pagination-ul'],
                            'firstPageLabel' => false,
                            'lastPageLabel' => false,
                            'prevPageCssClass' => 'page-pre',
                            'prevPageLabel' => '<i class="font-icon font-icon-arrow-left"></i>',
                            'nextPageCssClass' => 'page-next',
                            'nextPageLabel' => '<i class="font-icon font-icon-arrow-right"></i>',
                            'pageCssClass' => 'page-number',
                            'activePageCssClass' => 'active',
                            'disabledListItemSubTagOptions' => ['tag' => 'a', 'href' => 'javascript:void(0);']
                        ],
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'filter' => \kartik\widgets\Select2::widget([
                                    'name' => 'PincodeSearchMaster[ryb_country_id]',
                                    'value' => Yii::$app->request->get('PincodeSearchMaster')['ryb_country_id'],
                                    'data' => $countryArray,
                                    'options' => ['placeholder' => 'Select country', 'id' => 'fl_country_id'],
                                    'pluginOptions' => ['allowClear' => true],
                                ]),
                                'attribute' => 'ryb_country_id',
                                'content' => function ($model) {
                                    return $model->rybCountry->ryb_country_title;
                                }
                            ],
                            [
                                'filter' => \yii\helpers\Html::hiddenInput('', Yii::$app->request->get('PincodeSearchMaster')['ryb_state_id'], ['id' => 'flselected_state_id']) .
                                \kartik\widgets\DepDrop::widget([
                                    //'type' => \kartik\widgets\DepDrop::TYPE_SELECT2,
                                    'name' => 'PincodeSearchMaster[ryb_state_id]',
                                    'id' => 'fl_state_id',
                                    'pluginOptions' => [
                                        'depends' => ['fl_country_id'],
                                        'placeholder' => 'Select state',
                                        'url' => yii\helpers\Url::to(['/configuration/filter-fetch-states']),
                                        'params' => ['flselected_state_id'],
                                        'initialize' => true,
                                        'initDepends' => ['fl_country_id'],
                                    ]
                                ]),
                                'attribute' => 'ryb_state_id',
                                'content' => function ($model) {
                                    return $model->rybState->ryb_state_title;
                                }
                            ],
                            [
                                'filter' => \yii\helpers\Html::hiddenInput('', Yii::$app->request->get('PincodeSearchMaster')['ryb_city_id'], ['id' => 'flselected_city_id']) .
                                \kartik\widgets\DepDrop::widget([
                                    //'type' => \kartik\widgets\DepDrop::TYPE_SELECT2,
                                    'name' => 'PincodeSearchMaster[ryb_city_id]',
                                    'pluginOptions' => [
                                        'depends' => ['fl_state_id'],
                                        'placeholder' => 'Select state',
                                        'url' => yii\helpers\Url::to(['/configuration/filter-fetch-cities']),
                                        'params' => ['flselected_city_id'],
                                        'initialize' => true,
                                        'initDepends' => ['fl_state_id'],
                                    ]
                                ]),
                                'attribute' => 'ryb_city_id',
                                'content' => function ($model) {
                                    return $model->rybCity->ryb_city_title;
                                }
                            ],
                            'ryb_pincode_title',
                            'ryb_pincode_number',
                            /* [
                              'filter' => false,
                              'attribute' => 'ryb_pincode_added_at',
                              'content' => function ($model) {
                              return date("h:i A | d-m-Y", strtotime($model->ryb_pincode_added_at));
                              }
                              ], */
                            [
                                'header' => 'Status',
                                'content' => function ($model) {
                                    return '<div class="switch m-r-10">'
                                            . '<input type="checkbox" id="s-' . $model->ryb_pincode_id . '" value="' . $model->ryb_pincode_id . '" ' . ($model->ryb_status_id == 2 ? 'checked=""' : '') . ' class="grid-status-checkbox">'
                                            . '<label for="s-' . $model->ryb_pincode_id . '"></label>'
                                            . '</div>';
                                }
                            ],
                            [
                                'header' => 'Action',
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{update}{configure}',
                                'buttons' => [
                                    'update' => function ($url, $model) {
                                        return yii\helpers\Html::a('Edit', ['/configuration/pincodes', 'id' => $model->ryb_pincode_id], ['class' => 'btn btn-warning btn-sm cu-grid-btn']);
                                    },
                                    'configure' => function ($url, $model) {
                                        return yii\helpers\Html::a('Configure', ['/configuration/config-params', 'PincodeId' => $model->ryb_pincode_id], ['class' => 'btn btn-danger btn-sm cu-grid-btn']);
                                    }
                                ]
                            ]
                        ],
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-4 card cu-card">
        <div class="card-header">
            <h4 class="card-title">Add Pincode</h4>
        </div>
        <div class="card-body">
            <?php
            $form = yii\widgets\ActiveForm::begin(['fieldConfig' => ['errorOptions' => ['class' => 'help-block-error']]]);
            echo $form->field($formModel, 'ryb_country_id')->widget(\kartik\widgets\Select2::className(), [
                'data' => $countryArray,
                'options' => ['placeholder' => 'Select country'],
                'pluginOptions' => ['allowClear' => true]
            ]);
            echo \yii\helpers\Html::hiddenInput('', $formModel->ryb_state_id, ['id' => 'selected_state_id']);
            echo \yii\helpers\Html::hiddenInput('', $formModel->ryb_city_id, ['id' => 'selected_city_id']);
            echo $form->field($formModel, 'ryb_state_id')->widget(\kartik\widgets\DepDrop::classname(), [
                'type' => \kartik\widgets\DepDrop::TYPE_SELECT2,
                'pluginOptions' => [
                    'depends' => ['pincodemaster-ryb_country_id'],
                    'placeholder' => 'Select state',
                    'url' => yii\helpers\Url::to(['/configuration/fetch-states']),
                    'params' => ['selected_state_id'],
                    'initialize' => true,
                    'initDepends' => ['pincodemaster-ryb_country_id'],
                ]
            ]);
            echo $form->field($formModel, 'ryb_city_id')->widget(\kartik\widgets\DepDrop::classname(), [
                'type' => \kartik\widgets\DepDrop::TYPE_SELECT2,
                'pluginOptions' => [
                    'depends' => ['pincodemaster-ryb_state_id'],
                    'placeholder' => 'Select city',
                    'url' => yii\helpers\Url::to(['/configuration/fetch-cities']),
                    'params' => ['selected_city_id'],
                    'initialize' => true,
                    'initDepends' => ['pincodemaster-ryb_state_id'],
                ]
            ]);
            echo $form->field($formModel, 'ryb_pincode_title')->textInput(['placeholder' => "Enter " . strtolower($formModel->getAttributeLabel('ryb_pincode_title'))]);
            echo $form->field($formModel, 'ryb_pincode_number')->textInput(['placeholder' => "Enter " . strtolower($formModel->getAttributeLabel('ryb_pincode_number'))]);
            echo '<div class="form-group text-center">' . yii\helpers\Html::submitButton('Add pincode', ['class' => 'btn btn-success btn-sm']) . '</div>';
            yii\widgets\ActiveForm::end();
            ?>
        </div>
    </div>
</div>
<div class="modal fade" id="importFileModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importFileModal">Import - CSV File</h5>
            </div>
            <div class="modal-body">
                <?php
                $form = yii\widgets\ActiveForm::begin([
                            'action' => ["configuration/pincode-import"],
                            'options' => [
                                'enctype' => 'multipart/form-data',
                            ],
                            'fieldConfig' => ['errorOptions' => ['class' => 'help-block-error']]
                ]);
                echo $form->field($importPincodeModel, 'ryb_country_id')->widget(\kartik\widgets\Select2::className(), [
                    'data' => $countryArray,
                    'options' => ['placeholder' => 'Select country', 'id' => 'imp-country-selector'],
                    'pluginOptions' => ['allowClear' => true]
                ]);
                echo $form->field($importPincodeModel, 'ryb_state_id')->widget(\kartik\widgets\DepDrop::classname(), [
                    'type' => \kartik\widgets\DepDrop::TYPE_SELECT2,
                    'options' => ['id' => 'imp-state-selector'],
                    'pluginOptions' => [
                        'depends' => ['imp-country-selector'],
                        'placeholder' => 'Select state',
                        'url' => yii\helpers\Url::to(['/configuration/fetch-states']),
                    ]
                ]);
                echo $form->field($importPincodeModel, 'ryb_city_id')->widget(\kartik\widgets\DepDrop::classname(), [
                    'type' => \kartik\widgets\DepDrop::TYPE_SELECT2,
                    'options' => ['id' => 'imp-city-selector'],
                    'pluginOptions' => [
                        'depends' => ['imp-state-selector'],
                        'placeholder' => 'Select city',
                        'url' => yii\helpers\Url::to(['/configuration/fetch-cities']),
                    ]
                ]);
                echo $form->field($importPincodeModel, 'ryb_csv_file')->fileInput(['class' => 'form-control', 'accept' => '.csv']);
                echo '<div class="form-group text-center">' . yii\helpers\Html::submitButton('Import CSV', ['class' => 'btn btn-success btn-sm']) . '</div>';
                yii\widgets\ActiveForm::end();
                ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".grid-status-checkbox").click(function () {
            var status = 3, id = $(this).val();
            if ($(this).is(":checked")) {
                status = 2;
            }
            $.ajax({
                "url": "<?= yii\helpers\Url::to(["/configuration/toggle-status"]); ?>",
                "type": "POST",
                "data": {"id": id, "status": status, "type": "pincodes", _csrf: yii.getCsrfToken()},
                "success": function (r) {
                    r = JSON.parse(r);
                    $('#notification-toast').append(r.message);
                    $('#notification-toast .toast').toast('show');
                    setTimeout(function () {
                        $('#notification-toast .toast:first-child').remove();
                    }, 3000);
                }
            });
        });
        $(".btn-import-file").click(function () {
            $("#importFileModal").modal('show');
        });
    });
</script>