<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between m-b-15">
            <h4 class="m-b-0">Manage - Cab Type</h4>
            <div class="card-toolbar">
                <ul>
                    <li>
                        <a href="<?= yii\helpers\Url::to(["/cab-type/add"]); ?>" class="btn btn-success m-r-5">
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
                'ryb_cabtype_title',
                'ryb_cabtype_description',
                'ryb_cabtype_seating',
                [
                    'filter' => false,
                    'attribute' => 'ryb_cabtype_icon',
                    'content' => function ($model) {
                        return yii\helpers\Html::img($model->ryb_cabtype_icon, ['style' => 'width:50px;']);
                    }
                ],
                [
                    'filter' => false,
                    'attribute' => 'ryb_cabtype_added_at',
                    'content' => function ($model) {
                        return date("h:i A | d-m-Y", strtotime($model->ryb_cabtype_added_at));
                    }
                ],
                [
                    'header' => 'Status',
                    'content' => function ($model) {
                        return '<div class="switch m-r-10">'
                                . '<input type="checkbox" id="s-' . $model->ryb_cabtype_id . '" value="' . $model->ryb_cabtype_id . '" ' . ($model->ryb_status_id == 2 ? 'checked=""' : '') . ' class="grid-status-checkbox">'
                                . '<label for="s-' . $model->ryb_cabtype_id . '"></label>'
                                . '</div>';
                    }
                ],
                [
                    'header' => 'Action',
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return yii\helpers\Html::a('Edit', ['/cab-type/edit', 'id' => $model->ryb_cabtype_id], ['class' => 'btn btn-warning btn-sm cu-grid-btn']);
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
                "url": "<?= yii\helpers\Url::to(["/cab-type/toggle-status"]); ?>",
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