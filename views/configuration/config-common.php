<div class="row">
    <div class="col-md-12 card cu-card">
        <div class="card-header">
            <h4 class="card-title">Common Parameters</h4>
        </div>
        <div class="card-body">
            <?= \yii\helpers\Html::beginForm(["/configuration/config-common"], 'POST', []); ?>
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="">
                        Rental package (hour/kilometer)
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
                                        $ExistValue = app\models\RentalPackageMaster::find()->where(["ryb_cabtype_id" => $key, "ryb_rental_package_hour" => $h])->asArray()->one();
                                        echo '<td>
                                            <input type="number" name="ryb_rental_package_master[' . $h . '][ryb_rental_package_km_allowed][' . $key . ']" value="' . $ExistValue["ryb_rental_package_km_allowed"] . '" placeholder="Kilometers" class="form-control"/>
                                            <input type="number" name="ryb_rental_package_master[' . $h . '][ryb_rental_package_km_ext_charge][' . $key . ']" value="' . $ExistValue["ryb_rental_package_km_ext_charge"] . '" placeholder="Extra KM Charges" class="form-control"/>
                                            <input type="number" name="ryb_rental_package_master[' . $h . '][ryb_rental_package_hr_ext_charge][' . $key . ']" value="' . $ExistValue["ryb_rental_package_hr_ext_charge"] . '" placeholder="Extra HR Charges" class="form-control"/>
                                        </td>';
                                    }
                                    ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="form-group col-md-12">
                    <label for="">Waiting time (minutes) and charges (Rs.)</label>
                    <table class="table table-striped table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <?php
                                foreach ($RideTypeArray as $key => $value) {
                                    echo "<th>{$value}</th>";
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="cu-slot_info">Waiting time (minutes)</td>
                                <?php
                                foreach ($RideTypeArray as $key => $value) {
                                    echo '<td><input type="number" name="ryb_ride_waitng_master[' . $key . '][ryb_ride_waitng_time]" value="' . (app\models\RideWaitngMaster::find()->where([
                                        "ryb_ride_type_id" => $key,
                                    ])->asArray()->one())["ryb_ride_waitng_time"] . '" class="form-control"/></td>';
                                }
                                ?>
                            </tr>
                            <tr>
                                <td class="cu-slot_info">Waiting charges (Rs.)</td>
                                <?php
                                foreach ($RideTypeArray as $key => $value) {
                                    echo '<td><input type="number" name="ryb_ride_waitng_master[' . $key . '][ryb_ride_waitng_charges]" value="' . (app\models\RideWaitngMaster::find()->where([
                                        "ryb_ride_type_id" => $key,
                                    ])->asArray()->one())["ryb_ride_waitng_charges"] . '" class="form-control"/></td>';
                                }
                                ?>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="form-group col-md-12">
                    <label for="">Set night charges (11:00 PM to 05:00 AM)</label>
                    <table class="table table-striped table-condensed table-bordered">
                        <thead>
                            <tr>
                                <?php
                                foreach ($RideTypeArray as $key => $value) {
                                    echo "<th>{$value}</th>";
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php
                                foreach ($RideTypeArray as $key => $value) {
                                    echo '<td><input type="number" name="ryb_night_charge_master[' . $key . ']" value="' . (app\models\NightChargeMaster::find()->where([
                                        "ryb_ride_type_id" => $key,
                                    ])->asArray()->one())["ryb_night_charge"] . '" class="form-control"/></td>';
                                }
                                ?>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-12 form-group">
                    <label for="" class="">GST TAX percentage(%) for ride</label>
                    <input type="number" class="form-control" name="ryb_tax_master[ryb_tax_percentage]" placeholder="Enter tax percentage for ride" value="<?= $Tax->ryb_tax_percentage; ?>">
                </div>

                <div class="form-group text-right col-md-12">
                    <button type="submit" class="btn btn-primary m-r-5"><i class="anticon anticon-like"></i> <span>Save</span></button>
                </div>

            </div>
            <?= \yii\helpers\Html::endForm(); ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".cu-conf-year-selector").change(function () {
            $(".r_year").hide();
            if ($(this).val()) {
                $("#r" + $(this).val()).show();
            }
        });
    });
</script>