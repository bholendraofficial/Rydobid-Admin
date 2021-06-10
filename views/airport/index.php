<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between m-b-15">
            <h4 class="m-b-0"><?= \Yii::$app->params["page_meta_data"]["page_title"]; ?></h4>
            <div class="card-toolbar">
                <ul>
                    <li>
                        <a href="<?= yii\helpers\Url::to(["/airport/add"]); ?>" class="btn btn-success m-r-5">
                            <i class="anticon anticon-plus-circle m-r-5"></i> <span>Add</span>
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
                'ryb_airport_name',
                [
                    'filter' => false,
                    'attribute' => 'ryb_airport_latitude',
                ],
                [
                    'filter' => false,
                    'attribute' => 'ryb_airport_longitude',
                ],
                [
                    'header' => 'Cities',
                    'content' => function($model) {
                        $AirportCities = [];
                        foreach ($model->airportCityMasters as $key => $value) {
                            $AirportCities[] = $value->rybCity->ryb_city_title;
                        }
                        return implode(", ", $AirportCities);
                    }
                ],
                [
                    'filter' => false,
                    'attribute' => 'ryb_airport_added_at',
                    'content' => function ($model) {
                        return date("h:i A | d-m-Y", strtotime($model->ryb_airport_added_at));
                    }
                ],
            /* [
              'header' => 'Action',
              'class' => 'yii\grid\ActionColumn',
              'template' => '{update}',
              'buttons' => [
              'update' => function ($url, $model) {
              return yii\helpers\Html::a('<i class="anticon anticon-edit"></i>&nbsp;<span>Edit</span>', ['/airport/edit', 'id' => $model->ryb_airport_id], ['class' => 'btn btn-warning btn-sm cu-grid-btn']);
              }
              ]
              ] */
            ],
        ]);
        ?>
    </div>
</div>