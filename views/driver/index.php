<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between m-b-15">
            <h4 class="m-b-0">Manage - Driver</h4>
            <div class="card-toolbar">
                <ul>
                    <li>
                        <a href="javascript:void(0);" onclick="return alert('Work in Progress');"
                           class="btn btn-success m-r-5">
                            <i class="anticon anticon-plus-circle m-r-5"></i>
                            <span>Add Driver</span>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" onclick="return alert('Work in Progress');"
                           class="btn btn-danger m-r-5">
                            <i class="anticon anticon-search m-r-5"></i>
                            <span>Search by Driver ID</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <?= \kartik\grid\GridView::widget([
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
                'rybDriver.ryb_driver_id',
                'ryb_user_fullname',
                'ryb_user_emailid:email',
                'ryb_user_phoneno',
                'rybDriver.driverCab.ryb_driver_cab_reg_no',
                'rybDriver.driverCab.rybDriverCabStatus.ryb_driver_cab_status_text',
                'ryb_user_addedat:date',
                [
                    'header' => 'Status',
                    'content' => function ($model) {
                        return '<div class="switch m-r-10">'
                            . '<input type="checkbox" id="s-' . $model->ryb_user_id . '" value="' . $model->ryb_user_id . '" ' . ($model->ryb_status_id == 2 ? 'checked=""' : '') . ' class="grid-status-checkbox">'
                            . '<label for="s-' . $model->ryb_user_id . '"></label>'
                            . '</div>';
                    }
                ],
                [
                    'header' => 'Action',
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update}{view}{kyc}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return yii\helpers\Html::a('<i class="anticon anticon-edit"></i> View', ['/driver/view', 'id' => $model->ryb_user_id], ['class' => 'btn btn-info btn-sm cu-grid-btn']);
                        },
                        'update' => function ($url, $model) {
                            return yii\helpers\Html::a('<i class="anticon anticon-eye"></i> Edit', 'javascript:void(0);', ['onclick' => 'return alert("Work in Progress");', 'class' => 'btn btn-warning btn-sm cu-grid-btn']);
                        },
                        'kyc' => function ($url, $model) {
                            return yii\helpers\Html::a('<i class="anticon anticon-exception"></i> Driver KYC', ['/driver/kyc', 'id' => $model->ryb_user_id], ['class' => 'btn btn-success btn-sm cu-grid-btn']);
                        }
                    ]
                ]
            ],
        ]);
        ?>
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
                "url": "<?= yii\helpers\Url::to(["/driver/toggle-status"]); ?>",
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