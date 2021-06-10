<style>
    /*#data-table_wrapper, label, .form-control, button {
        font-size: 12px !important;
    }
    #data-table thead th, #data-table tbody td{
        text-align: center;
    }*/
    .form-control{
        padding: 7px;
    }
    .cu-card{
        max-width: 48%;
        margin: 10px;
    }
    @media only screen and (max-width: 768px) {
        .cu-card{
            max-width: 100%;
        }
    }
</style>
<div class="row">
    <div class="col-sm-12 col-md-6 card cu-card">
        <div class="card-header">
            <h4 class="card-title">Countries</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?=
                    \kartik\grid\GridView::widget([
                        'moduleId' => 'gridview',
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'responsive' => true,
                        'hover' => true,
                        'pjax' => false,
                        'layout' => '{errors}<div class="fixed-table-body">{items}</div>
                    <div class="row">
                        <div class="col-xs-12 col-md-6">{summary}</div>
                        <div class="col-xs-12 col-md-6">{pager}</div>
                    </div>',
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
                            'ryb_country_title',
                            [
                                'filter' => false,
                                'attribute' => 'ryb_country_added_at',
                                'content' => function ($model) {
                                    return date("h:i A | d-m-Y", strtotime($model->ryb_country_added_at));
                                }
                            ],
                            [
                                'header' => 'Status',
                                'content' => function ($model) {
                                    return '<div class="switch m-r-10">'
                                            . '<input type="checkbox" id="s-' . $model->ryb_country_id . '" value="' . $model->ryb_country_id . '" ' . ($model->ryb_status_id == 2 ? 'checked=""' : '') . ' class="grid-status-checkbox">'
                                            . '<label for="s-' . $model->ryb_country_id . '"></label>'
                                            . '</div>';
                                }
                            ],
                            [
                                'header' => 'Action',
                                'class' => 'yii\grid\ActionColumn',
                                'template' => '{update}',
                                'buttons' => [
                                    'update' => function ($url, $model) {
                                        return yii\helpers\Html::a('Edit', ['/configuration/countries', 'id' => $model->ryb_country_id], ['class' => 'btn btn-warning btn-sm cu-grid-btn']);
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
    <div class="col-sm-12 col-md-6 card cu-card">
        <div class="card-header">
            <h4 class="card-title">Add Country</h4>
        </div>
        <div class="card-body">
            <?php $form = yii\widgets\ActiveForm::begin(['fieldConfig' => ['errorOptions' => ['class' => 'help-block-error']]]); ?>
            <?= $form->field($formModel, 'ryb_country_title')->textInput(['placeholder' => "Enter " . strtolower($formModel->getAttributeLabel('ryb_country_title'))]); ?>
            <div class="form-group text-right">
                <?= yii\helpers\Html::submitButton('Add country', ['class' => 'btn btn-success btn-sm', 'disabled' => $formModel->isNewRecord]) ?>
            </div>
            <?php yii\widgets\ActiveForm::end(); ?>
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
                "data": {"id": id, "status": status, "type": "countries", _csrf: yii.getCsrfToken()},
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
    });
</script>