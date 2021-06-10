<style>
    .table tbody th{
        font-weight: bold;
    }
</style>
<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between m-b-15">
            <h4 class="m-b-0"><?= \Yii::$app->params["page_meta_data"]["page_title"]; ?></h4>
        </div>
        <div class="row">
            <div class="col-xs-12 col-md-8">
                <?=
                yii\widgets\DetailView::widget([
                    'model' => $model,
                    'options' => ['class' => 'table table-striped table-bordered table-condensed'],
                    'attributes' => [
                        'ryb_promocode_unique',
                        'ryb_promocode_remark:ntext',
                        [
                            'attribute' => 'ryb_promocode_disc_type',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return ($model->ryb_promocode_disc_type == 1 ? "Percentage (%)" : "Flat(Rs.)");
                            }
                        ],
                        [
                            'attribute' => 'ryb_promocode_disc_amnt',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return "Rs. " . $model->ryb_promocode_disc_amnt;
                            }
                        ],
                        [
                            'attribute' => 'ryb_promocode_min_trans_amnt',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return "Rs. " . $model->ryb_promocode_min_trans_amnt;
                            }
                        ],
                        [
                            'attribute' => 'ryb_promocode_max_disc_amnt',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return "Rs. " . $model->ryb_promocode_max_disc_amnt;
                            }
                        ],
                        'ryb_promocode_redemption_lmt',
                        'ryb_promocode_for_new_user:boolean',
                        'ryb_promocode_is_date_range:boolean',
                        'ryb_promocode_date_start:date',
                        'ryb_promocode_date_end:date',
                        'ryb_promocode_is_ride_type:boolean',
                        [
                            'label' => 'Selected Ride Types',
                            'value' => function ($model) {
                                if ($model->ryb_promocode_is_ride_type == true) {
                                    $RideTypeArray = [];
                                    foreach ($model->promocodeRideTypeMasters as $RideType) {
                                        $RideTypeArray[] = $RideType->rybRideType->ryb_ride_type_title;
                                    }
                                    return implode(", ", $RideTypeArray);
                                } else {
                                    return 'Applied to all';
                                }
                            }
                        ],
                        'ryb_promocode_is_cab_type:boolean',
                        [
                            'label' => 'Selected Cab Types',
                            'value' => function ($model) {
                                if ($model->ryb_promocode_is_cab_type == true) {
                                    $CabTypeArray = [];
                                    foreach ($model->promocodeCabTypeMasters as $CabType) {
                                        $CabTypeArray[] = $CabType->rybCabtype->ryb_cabtype_title;
                                    }
                                    return implode(", ", $CabTypeArray);
                                } else {
                                    return 'Applied to all';
                                }
                            }
                        ],
                        'ryb_promocode_is_city_type:boolean',
                        [
                            'label' => 'Selected Cities',
                            'value' => function ($model) {
                                if ($model->ryb_promocode_is_city_type == true) {
                                    $CityArray = [];
                                    foreach ($model->promocodeCityMasters as $City) {
                                        $CityArray[] = $City->rybCity->ryb_city_title;
                                    }
                                    return implode(", ", $CityArray);
                                } else {
                                    return 'Applied to all';
                                }
                            }
                        ],
                        'rybStatus.ryb_status_text',
                        'ryb_promocode_added_at:datetime',
                    ],
                ])
                ?>
            </div>
        </div>
    </div>
</div>
