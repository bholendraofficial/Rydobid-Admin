<div class="row">
    <div class="col-md-12 card cu-card">
        <div class="card-header">
            <h4 class="card-title">Configure Parameters</h4>
        </div>
        <div class="card-body">
            <?= \yii\helpers\Html::beginForm($FormUrl, 'POST', []); ?>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="">Select country</label>
                    <?=
                    \kartik\widgets\Select2::widget([
                        'name' => 'ryb_conf_package_master[ryb_country_id]',
                        'data' => $CountryArray,
                        'value' => $SelectedCountry,
                        'options' => ['placeholder' => 'Select country', 'id' => 'country_id', 'readonly' => true],
                        'pluginOptions' => ['allowClear' => true]
                    ])
                    ?>
                </div>
                <div class="form-group col-md-4">
                    <label for="">Select state</label>
                    <?=
                    \kartik\widgets\DepDrop::widget([
                        'name' => 'ryb_conf_package_master[ryb_state_id]',
                        'type' => \kartik\widgets\DepDrop::TYPE_SELECT2,
                        'value' => $SelectedState,
                        'options' => ['id' => 'state_id', 'placeholder' => 'Select state', 'readonly' => true],
                        'pluginOptions' => [
                            'depends' => ['country_id'],
                            'url' => yii\helpers\Url::to(['/configuration/fetch-states']),
                            'initialize' => true,
                            'initDepends' => ['country_id'],
                        ]
                    ]);
                    ?>
                </div>
                <div class="form-group col-md-4">
                    <label for="">Select city</label>
                    <?=
                    \kartik\widgets\DepDrop::widget([
                        'name' => 'ryb_conf_package_master[ryb_city_id][]',
                        'value' => array_keys($SelectedCity),
                        'type' => \kartik\widgets\DepDrop::TYPE_SELECT2,
                        'options' => ['id' => 'city_id', 'multiple' => true, 'placeholder' => 'Select cities', 'readonly' => true],
                        'pluginOptions' => [
                            'depends' => ['state_id'],
                            'url' => yii\helpers\Url::to(['/configuration/fetch-cities']),
                            'initialize' => true,
                            'initDepends' => ['state_id'],
                        ]
                    ]);
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="">Select pincode (multiple/single)</label>
                    <?=
                    \kartik\widgets\DepDrop::widget([
                        'name' => 'ryb_conf_package_master[ryb_pincode_id][]',
                        'value' => array_keys($SelectedPincode),
                        'type' => \kartik\widgets\DepDrop::TYPE_SELECT2,
                        'options' => ['multiple' => true, 'placeholder' => 'Select pincodes', 'readonly' => true],
                        'pluginOptions' => [
                            'depends' => ['city_id'],
                            'url' => yii\helpers\Url::to(['/configuration/fetch-pincodes']),
                            'initialize' => true,
                            'initDepends' => ['city_id'],
                        ]
                    ]);
                    ?>
                </div>
            </div>
            <div class="row">

                <?php
                $ConfPackage_D = app\models\ConfPackageMaster::find()
                                ->where(['IN', 'ryb_country_id', [$SelectedCountry]])
                                ->andWhere(['IN', 'ryb_state_id', [$SelectedState]])
                                ->andWhere(['IN', 'ryb_city_id', array_keys($SelectedCity)])
                                ->andWhere(['IN', 'ryb_pincode_id', array_keys($SelectedPincode)])
                                ->limit(1)->asArray()->one();
                ?>

                <div class="form-group col-md-6">
                    <label for="">Set user response time (minutes)</label>
                    <input type="number" value="<?= ($ConfPackage_D ? $ConfPackage_D["ryb_conf_package_response_time"] : ''); ?>" name="ryb_conf_package_master[ryb_conf_package_response_time]" class="form-control" placeholder="Enter response time"/>
                </div>
                <div class="form-group col-md-6">
                    <label for="">No of drivers to notify</label>
                    <input type="number" value="<?= ($ConfPackage_D ? $ConfPackage_D["ryb_conf_package_no_of_driver"] : ''); ?>" name="ryb_conf_package_master[ryb_conf_package_no_of_driver]" class="form-control" placeholder="Enter no of drivers"/>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="">Set <?= Yii::$app->name; ?> commission percentage(%)</label>
                    <table class="table table-striped table-condensed table-bordered">
                        <thead>
                            <?php
                            foreach ($RideTypeArray as $key => $value) {
                                echo "<th>{$value}</th>";
                            }
                            ?>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($RideTypeArray as $key => $value) {
                                $Commission_D = app\models\CommPercentMaster::find()
                                                ->where(['ryb_ride_type_id' => $key])
                                                ->andWhere(['IN', 'ryb_country_id', [$SelectedCountry]])
                                                ->andWhere(['IN', 'ryb_state_id', [$SelectedState]])
                                                ->andWhere(['IN', 'ryb_city_id', array_keys($SelectedCity)])
                                                ->andWhere(['IN', 'ryb_pincode_id', array_keys($SelectedPincode)])
                                                ->limit(1)->asArray()->one();
                                if ($Commission_D) {
                                    if ($Commission_D["ryb_ride_type_id"] == $key) {
                                        echo '<td><input type="number" name="ryb_comm_percent_master[' . $key . '][ryb_comm_percent_amt]" value="' . $Commission_D["ryb_comm_percent_amt"] . '" placeholder="%" class="form-control"/></td>';
                                    }
                                } else {
                                    echo '<td><input type="number" name="ryb_comm_percent_master[' . $key . '][ryb_comm_percent_amt]" value="0" placeholder="%" class="form-control"/></td>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="form-group col-md-6">
                    <label for="">Set bid amount percentage(%)</label>
                    <table class="table table-striped table-condensed table-bordered">
                        <thead>
                            <?php
                            foreach ($RideTypeArray as $key => $value) {
                                echo "<th>{$value}</th>";
                            }
                            ?>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($RideTypeArray as $key => $value) {
                                $BidAmount_D = app\models\BidamntPercentMaster::find()
                                                ->where(['ryb_ride_type_id' => $key])
                                                ->andWhere(['IN', 'ryb_country_id', [$SelectedCountry]])
                                                ->andWhere(['IN', 'ryb_state_id', [$SelectedState]])
                                                ->andWhere(['IN', 'ryb_city_id', array_keys($SelectedCity)])
                                                ->andWhere(['IN', 'ryb_pincode_id', array_keys($SelectedPincode)])
                                                ->limit(1)->asArray()->one();
                                if ($BidAmount_D) {
                                    if ($BidAmount_D["ryb_ride_type_id"] == $key) {
                                        echo '<td><input type="number" name="ryb_bidamnt_percent_master[' . $key . '][ryb_bid_amnt_percent_amt]" value="' . $BidAmount_D["ryb_bid_amnt_percent_amt"] . '" placeholder="%" class="form-control"/></td>';
                                    }
                                } else {
                                    echo '<td><input type="number" name="ryb_bidamnt_percent_master[' . $key . '][ryb_bid_amnt_percent_amt]" value="0" placeholder="%" class="form-control"/></td>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label for="">Set penalty amount (Rs.)</label>
                    <table class="table table-striped table-condensed table-bordered">
                        <thead>
                            <?php
                            foreach ($RideTypeArray as $key => $value) {
                                echo "<th>{$value}</th>";
                            }
                            ?>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($RideTypeArray as $key => $value) {
                                $PenaltyAmount_D = app\models\PenaltyAmntMaster::find()
                                                ->where(['ryb_ride_type_id' => $key])
                                                ->andWhere(['IN', 'ryb_country_id', [$SelectedCountry]])
                                                ->andWhere(['IN', 'ryb_state_id', [$SelectedState]])
                                                ->andWhere(['IN', 'ryb_city_id', array_keys($SelectedCity)])
                                                ->andWhere(['IN', 'ryb_pincode_id', array_keys($SelectedPincode)])
                                                ->limit(1)->asArray()->one();
                                if ($PenaltyAmount_D) {
                                    if ($PenaltyAmount_D["ryb_ride_type_id"] == $key) {
                                        echo '<td><input type="number" name="ryb_penalty_amnt_master[' . $key . '][ryb_penalty_amnt]" value="' . $PenaltyAmount_D["ryb_penalty_amnt"] . '" placeholder="Rs." class="form-control"/></td>';
                                    }
                                } else {
                                    echo '<td><input type="number" name="ryb_penalty_amnt_master[' . $key . '][ryb_penalty_amnt]" value="0" placeholder="Rs." class="form-control"/></td>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="form-group col-md-6">
                    <label for="">Set driver radius (meters)</label>
                    <table class="table table-striped table-condensed table-bordered">
                        <thead>
                            <?php
                            foreach ($RideTypeArray as $key => $value) {
                                echo "<th>{$value}</th>";
                            }
                            ?>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($RideTypeArray as $key => $value) {
                                $DriverRadius_D = app\models\DriverRadiusMaster::find()
                                                ->where(['ryb_ride_type_id' => $key])
                                                ->andWhere(['IN', 'ryb_country_id', [$SelectedCountry]])
                                                ->andWhere(['IN', 'ryb_state_id', [$SelectedState]])
                                                ->andWhere(['IN', 'ryb_city_id', array_keys($SelectedCity)])
                                                ->andWhere(['IN', 'ryb_pincode_id', array_keys($SelectedPincode)])
                                                ->limit(1)->asArray()->one();
                                if ($DriverRadius_D) {
                                    if ($DriverRadius_D["ryb_ride_type_id"] == $key) {
                                        echo '<td><input type="number" name="ryb_driver_radius_master[' . $key . '][ryb_driver_radius_metres]" value="' . $DriverRadius_D["ryb_driver_radius_metres"] . '" placeholder="In metres" class="form-control"/></td>';
                                    }
                                } else {
                                    echo '<td><input type="number" name="ryb_driver_radius_master[' . $key . '][ryb_driver_radius_metres]" value="0" placeholder="In metres" class="form-control"/></td>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-12">
                    <label for="">Select Ride Type: </label>
                    <select class="form-control cu-conf-ridetype-selector">
                        <option value="">Select</option>
                        <?php
                        foreach ($RideTypeArray as $RTK => $RTV) {
                            if ($RTK != 3) {
                                echo '<option value="' . $RTK . '">' . $RTV . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <?php
            foreach ($RideTypeArray as $RTK => $RTV) {
                if ($RTK != 3) {
                    ?>
                    <div class="row ridetype-rate-box rdt_<?= $RTK; ?>" style="display:none;">
                        <div class="form-group col-md-12">
                            <label for="">Set pricing / per km (kilometer) - <?= $RTV; ?></label>
                            <table class="table table-striped table-condensed table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 10%;">Slot</th>
                                        <?php
                                        foreach ($CabTypeArray as $key => $value) {
                                            echo '<th>' . $value . ' (Rs. /per km)</th>';
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($TimeSlotArray as $key => $value) {
                                        echo '<tr>';
                                        echo '<td class="cu-slot_info"><span>' . date("h:i A", strtotime($value["ryb_time_slot_start"])) . ' to ' . date("h:i A", strtotime($value["ryb_time_slot_end"])) . '</span></td>';
                                        foreach ($CabTypeArray as $k => $v) {
                                            $RateCard_D = app\models\RateCardMaster::find()
                                                            ->where([
                                                                'ryb_ride_type_id' => $RTK,
                                                                'ryb_cabtype_id' => $k,
                                                                'ryb_time_slot_id' => $value["ryb_time_slot_id"]
                                                            ])
                                                            ->andWhere(['IN', 'ryb_country_id', [$SelectedCountry]])
                                                            ->andWhere(['IN', 'ryb_state_id', [$SelectedState]])
                                                            ->andWhere(['IN', 'ryb_city_id', array_keys($SelectedCity)])
                                                            ->andWhere(['IN', 'ryb_pincode_id', array_keys($SelectedPincode)])
                                                            ->limit(1)
                                                            ->asArray()->one();
                                            if ($RateCard_D) {
                                                echo '<td><input type="number" name="ryb_rate_card_master[' . $RTK . '][' . $k . '][' . $value["ryb_time_slot_id"] . '][ryb_rate_card_pr_km]" value="' . $RateCard_D["ryb_rate_card_pr_km"] . '" class="form-control"/></td>';
                                            } else {
                                                echo '<td><input type="number" name="ryb_rate_card_master[' . $RTK . '][' . $k . '][' . $value["ryb_time_slot_id"] . '][ryb_rate_card_pr_km]" value="0" class="form-control"/></td>';
                                            }
                                        }
                                        echo '</tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>

            <div class="row">
                <div class="form-group col-md-12">
                    <label for="">
                        Rental package (Rs./kilometer)
                        <select class="form-control cu-conf-year-selector">
                            <option value="">Select</option>
                            <?php
                            for ($h = 1; $h <= 12; $h++) {
                                echo '<option value="' . $h . '">' . $h . ' hour</option>';
                            }
                            ?>
                        </select>
                    </label>
                    <table class="table table-striped table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <?php
                                foreach ($CabTypeArray as $key => $value) {
                                    echo "<th>{$value}</th>";
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($h = 1; $h <= 12; $h++) { ?>
                                <tr id="r<?= $h; ?>" class="r_year" style="display:none;">
                                    <td class="cu-slot_info"><?= $h; ?> hour</td>
                                    <?php
                                    foreach ($CabTypeArray as $key => $value) {
                                        $RentalRate_D = app\models\RentalRateCardMaster::find()
                                                        ->where([
                                                            'ryb_ride_type_id' => 3,
                                                            'ryb_cabtype_id' => $key,
                                                        ])
                                                        ->andWhere(['IN', 'ryb_country_id', [$SelectedCountry]])
                                                        ->andWhere(['IN', 'ryb_state_id', [$SelectedState]])
                                                        ->andWhere(['IN', 'ryb_city_id', array_keys($SelectedCity)])
                                                        ->andWhere(['IN', 'ryb_pincode_id', array_keys($SelectedPincode)])
                                                        ->limit(1)
                                                        ->asArray()->one();
                                        if ($RentalRate_D) {
                                            echo '<td><input type="number" name="ryb_rental_rate_card_master[' . $key . '][ryb_rental_rate_card_' . $h . 'hr]" value="' . $RentalRate_D ['ryb_rental_rate_card_' . $h . 'hr'] . '" placeholder="" class="form-control"/></td>';
                                        } else {
                                            echo '<td><input type="number" name="ryb_rental_rate_card_master[' . $key . '][ryb_rental_rate_card_' . $h . 'hr]" value="0" placeholder="" class="form-control"/></td>';
                                        }
                                    }
                                    ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-12">
                    <div class="row">
                        <div class="col-md-8">
                            <label for="">Set bid time (minutes)</label>        
                        </div>
                        <div class="col-md-4 text-right">
                            <button type="button" class="btn btn-warning btn-sm mb-2 cu-add_bidtime-btn"><i class="anticon anticon-plus-circle"></i> Add bid time</button>
                        </div>
                        <div class="col-md-12">
                            <?php
                            $BidTime_D = \app\models\BidTimeMaster::find()
                                            ->where(['IN', 'ryb_country_id', [$SelectedCountry]])
                                            ->andWhere(['IN', 'ryb_state_id', [$SelectedState]])
                                            ->andWhere(['IN', 'ryb_city_id', array_keys($SelectedCity)])
                                            ->andWhere(['IN', 'ryb_pincode_id', array_keys($SelectedPincode)[0]])
                                            ->asArray()->all();
                            if ($BidTime_D) {
                                echo '<input type="hidden" value="' . count($BidTime_D) . '" class="cu-btn-bidtime-count"/>';
                            } else {
                                echo '<input type="hidden" value="1" class="cu-btn-bidtime-count"/>';
                            }
                            ?>

                            <ul class="list-group cu-add_bidtime-list">
                                <?php
                                if ($BidTime_D) {
                                    $TIndex = 1;
                                    foreach ($BidTime_D as $Time) {
                                        ?>
                                        <li class="list-group-item" id="li_<?= $TIndex; ?>">
                                            <div class="row">
                                                <div class="col-md-3 text-right cu-label_bidtime"><label for="">Enter bid time (minutes):&nbsp;</label></div>
                                                <div class="col-md-7"><input required="" type="number" placeholder="In minutes" name="ryb_bid_time_master[ryb_bid_time_minute][]" class="form-control" value="<?= $Time["ryb_bid_time_minute"]; ?>"/></div>
                                                <?php if ($TIndex != 1) { ?>
                                                    <div class="col-md-2"><button type="button" data-bidtimebox_id="<?= $TIndex; ?>" class="btn btn-danger btn-sm cu-btn_bidtime cu-btn_bidtime-deletebtn"><i class="anticon anticon-delete"></i></button></div>
                                                <?php } ?>
                                            </div>
                                        </li>
                                        <?php
                                        $TIndex++;
                                    }
                                } else {
                                    ?>
                                    <li class="list-group-item" id="li_1">
                                        <div class="row">
                                            <div class="col-md-3 text-right cu-label_bidtime"><label for="">Enter bid time (minutes):&nbsp;</label></div>
                                            <div class="col-md-7"><input required="" type="number" placeholder="In minutes" name="ryb_bid_time_master[ryb_bid_time_minute][]" class="form-control" value="0"/></div>
                                            <div class="col-md-2"><button style="display: none;" type="button" data-bidtimebox_id="1" class="btn btn-danger btn-sm cu-btn_bidtime cu-btn_bidtime-deletebtn"><i class="anticon anticon-delete"></i></button></div>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-success">Save configuration</button>
            </div>
            <?= \yii\helpers\Html::endForm(); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.select2').select2();
        $('.select2-pincode').select2();
        $(".cu-add_bidtime-btn").click(function () {
            var newBidTimeBoxCount = parseInt($(".cu-btn-bidtime-count").val()) + 1;
            $(".cu-btn-bidtime-count").val(newBidTimeBoxCount);
            $(".cu-add_bidtime-list").append(`
        <li class="list-group-item" id="li_` + newBidTimeBoxCount + `">
            <div class="row">
                <div class="col-md-3 text-right cu-label_bidtime"><label for="">Enter bid time (minutes):&nbsp;</label></div>
                <div class="col-md-7"><input required="" type="number" placeholder="In minutes" name="ryb_bid_time_master[ryb_bid_time_minute][]" class="form-control" value="0"/></div>
                <div class="col-md-2"><button type="button" data-bidtimebox_id="` + newBidTimeBoxCount + `" class="btn btn-danger btn-sm cu-btn_bidtime cu-btn_bidtime-deletebtn"><i class="anticon anticon-delete"></i></button></div>
            </div>
        </li>
`);
        });
        $("body").on("click", ".cu-btn_bidtime-deletebtn", function () {
            $("#li_" + $(this).attr("data-bidtimebox_id")).remove();
        });
        $(".cu-conf-year-selector").change(function () {
            $(".r_year").hide();
            if ($(this).val()) {
                $("#r" + $(this).val()).show();
            }
        });
        $(".cu-conf-ridetype-selector").change(function () {
            $(".ridetype-rate-box").hide();
            if ($(this).val()) {
                $(".rdt_" + $(this).val()).show();
            }
        });
    });
</script>