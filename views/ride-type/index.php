<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between m-b-15">
            <h4 class="m-b-0">Manage - Ride Type</h4>
            <!--<div class="card-toolbar">
                    <ul>
                        <li>
                            <a href="<?= yii\helpers\Url::to(["/cab-type/add"]); ?>" class="btn btn-success m-r-5">
                                <i class="anticon anticon-plus-circle m-r-5"></i>
                                <span>Add</span>
                            </a>
                        </li>
                    </ul>
                </div>-->
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
                'ryb_ride_type_title',
                [
                    'filter' => false,
                    'attribute' => 'ride_type_added_at',
                    'content' => function ($model) {
                        return date("h:i A | d-m-Y", strtotime($model->ride_type_added_at));
                    }
                ],
                [
                    'header' => 'Action',
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return yii\helpers\Html::a('Edit', ['/ride-type/edit', 'id' => $model->ryb_ride_type_id], ['class' => 'btn btn-warning btn-sm cu-grid-btn']);
                        }
                    ]
                ]
            ],
        ]);
        ?>
    </div>
</div>