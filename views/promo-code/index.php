<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between m-b-15">
            <h4 class="m-b-0"><?= \Yii::$app->params["page_meta_data"]["page_title"]; ?></h4>
            <div class="card-toolbar">
                <ul>
                    <li>
                        <a href="<?= yii\helpers\Url::to(["/promo-code/add"]); ?>" class="btn btn-success m-r-5">
                            <i class="anticon anticon-plus-circle m-r-5"></i>
                            <span>Add</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <?php
        echo kartik\grid\GridView::widget([
            'moduleId' => 'gridview',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'responsive' => true,
            'hover' => true,
            'pjax' => true,
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
                'ryb_promocode_remark',
                'ryb_promocode_unique',
                [
                    'filter' => \yii\helpers\Html::dropDownList('PromocodeSearchMaster[ryb_promocode_disc_type]',
                            Yii::$app->request->get('PromocodeSearchMaster')['ryb_promocode_disc_type'],
                            [1 => "Percentage (%)", 2 => "Flat (Rs.)"],
                            ['class' => 'form-control', 'prompt' => 'Select discount type']
                    ),
                    'header' => 'Discount amount-type',
                    'attribute' => 'ryb_promocode_disc_type',
                    'content' => function ($model) {
                        return ($model->ryb_promocode_disc_amnt) . " : " . ($model->ryb_promocode_disc_type == 1 ? " (%) " : " (Rs) ");
                    }
                ],
                [
                    'header' => 'Min. Trans Amt.',
                    'attribute' => 'ryb_promocode_min_trans_amnt',
                    'content' => function ($model) {
                        return "Rs. " . $model->ryb_promocode_min_trans_amnt;
                    }
                ],
                [
                    'header' => 'Max. Disc Amt.',
                    'attribute' => 'ryb_promocode_max_disc_amnt',
                    'content' => function ($model) {
                        return "Rs. " . $model->ryb_promocode_max_disc_amnt;
                    }
                ],
                [
                    'header' => 'Start & End Date',
                    'options' => ['style' => 'width:10%'],
                    'content' => function ($model) {
                        return "<b>Start:</b> " . date("d-m-Y", strtotime($model->ryb_promocode_date_start)) .
                                "<br/><b>End:</b> " . date("d-m-Y", strtotime($model->ryb_promocode_date_end));
                    }
                ],
                [
                    'header' => 'Status',
                    'content' => function ($model) {
                        return '<div class="switch m-r-10">'
                                . '<input class="grid-status-checkbox" type="checkbox" id="s-' . $model->ryb_promocode_id . '" value="' . $model->ryb_promocode_id . '" ' . ($model->ryb_status_id == 2 ? 'checked=""' : '') . '>'
                                . '<label for="s-' . $model->ryb_promocode_id . '"></label>'
                                . '</div>';
                    }
                ],
                [
                    'header' => 'Action',
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return yii\helpers\Html::a('View', $url, [
                                        'class' => 'btn btn-warning btn-sm m-r-5 cu-grid-btn',
                                        'data-promocode-id' => $model->ryb_promocode_id
                            ]);
                        }
                    ]
                ]
            ],
        ]);
        ?>
    </div>
</div>
<div class="modal fade" id="cuDetailPromoCodeView">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center">View - {PROMOCODE}</h5>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-condensed" style="width:100%;">
                        <tr>
                            <th>Unique promocode: </th>
                            <td>QWERTY</td>
                        </tr>
                        <tr>
                            <th>Promocode remark: </th>
                            <td>QWERTY</td>
                        </tr>
                        <tr>
                            <th>Discount type: </th>
                            <td>Percentage (%)</td>
                        </tr>
                        <tr>
                            <th>Discount amount: </th>
                            <td>10</td>
                        </tr>
                        <tr>
                            <th>Minimum transaction: </th>
                            <td>250</td>
                        </tr>
                        <tr>
                            <th>Max discounted amount: </th>
                            <td>100</td>
                        </tr>
                        <tr>
                            <th>Redemption limit: </th>
                            <td>01</td>
                        </tr>
                        <tr>
                            <th>Validity: </th>
                            <td>20-04-2020 to 25-04-2020</td>
                        </tr>
                        <tr>
                            <th>Applicable new user: </th>
                            <td>Yes</td>
                        </tr>
                        <tr>
                            <th>Cab type: </th>
                            <td>Mini, Micro</td>
                        </tr>
                        <tr>
                            <th>Ride type: </th>
                            <td>Daily, Outstation</td>
                        </tr>
                        <tr>
                            <th>Applicable city: </th>
                            <td>Lucknow, Agra</td>
                        </tr>
                        <tr>
                            <th>Created at: </th>
                            <td>02:00 PM, 19-04-2020</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
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
                "url": "<?= yii\helpers\Url::to(["/promo-code/toggle-status"]); ?>",
                "type": "POST",
                "data": {"id": id, "status": status, _csrf: yii.getCsrfToken()},
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