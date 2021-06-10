<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between m-b-15">
            <h4 class="m-b-0">Manage - User</h4>
            <div class="card-toolbar">
                <ul>
                    <li>
                        <a href="<?= yii\helpers\Url::to(["/user/add"]); ?>" class="btn btn-success m-r-5">
                            <i class="anticon anticon-plus-circle m-r-5"></i>
                            <span>Add User</span>
                        </a>
                    </li>
                    <!--<li>
                            <a href="<?= yii\helpers\Url::to(["/user/search"]); ?>" class="btn btn-danger m-r-5">
                                <i class="anticon anticon-search m-r-5"></i>
                                <span>Search by User ID/Mobile Number</span>
                            </a>
                        </li>-->
                </ul>
            </div>
        </div>
        <?=
        kartik\grid\GridView::widget([
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
                'ryb_user_id',
                [
                    'filter' => yii\helpers\Html::dropDownList('UserSearchMaster[ryb_user_verify_status]',
                            Yii::$app->request->get('UserSearchMaster')['ryb_user_verify_status'],
                            [true => "Yes", false => "No"],
                            ['class' => 'form-control', 'prompt' => 'Select verification']
                    ),
                    'attribute' => 'ryb_user_verify_status',
                    'content' => function ($model) {
                        return '<span class="badge badge-primary cu-badge">' . ($model->ryb_user_verify_status == true ? 'No' : 'Yes') . '</span>';
                    }
                ],
                'ryb_user_fullname',
                'ryb_user_emailid',
                'ryb_user_phoneno',
                [
                    'filter' => false,
                    'attribute' => 'ryb_user_picture',
                    'content' => function ($model) {
                        return yii\helpers\Html::img($model->ryb_user_picture, ['style' => 'width:50px;']);
                    }
                ],
                [
                    'filter' => false,
                    'attribute' => 'ryb_user_addedat',
                    'content' => function ($model) {
                        return date("d-m-Y", strtotime($model->ryb_user_addedat));
                    }
                ],
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
                    'template' => '{update}{view}',
                    'buttons' => [
                        'update' => function ($url, $model) {
                            return yii\helpers\Html::a('<i class="anticon anticon-edit"></i><span>Edit</span>', ['/user/edit', 'id' => $model->ryb_user_id], ['class' => 'btn btn-warning btn-sm cu-grid-btn']);
                        },
                        'view' => function ($url, $model) {
                            return yii\helpers\Html::a('<i class="anticon anticon-eye"></i><span>View</span>', ['/user/search-result', 'id' => $model->ryb_user_id], ['class' => 'btn btn-info btn-sm cu-grid-btn']);
                        }
                    ]
                ]
            ],
        ]);
        ?>
    </div>
</div>