<div class="card">
    <div class="card-header">
        <h4 class="card-title"><?= \Yii::$app->params["page_meta_data"]["page_title"]; ?></h4>
    </div>
    <div class="card-body">
        <?php
        $form = yii\widgets\ActiveForm::begin([
                    'fieldConfig' => [
                        'template' => '{label}{input}{error}',
                        'labelOptions' => [
                            'class' => ''
                        ],
                        'inputOptions' => array(
                            'class' => 'form-control cu-form-control'
                        ),
                        'errorOptions' => array(
                            'class' => 'help-block-error'
                        ),
                        'options' => [
                            'class' => 'form-group cu-form-group'
                        ]
                    ],
                    'options' => [
                        'id' => 'add-form',
                        'method' => 'POST',
                        'enctype' => 'multipart/form-data'
                    ]
        ]);
        ?>

        <div class="row">

            <div class="col-md-6">
                <?php
                echo $form->field($model, 'ryb_promocode_unique')->textInput([
                    'placeholder' => "Enter unique promo code or click button to auto-generate",
                    'class' => 'form-control',
                ])->label('Unique promo code: ');
                ?>
                <div class="m-t-5 text-right"><button type="button" class="btn btn-info btn-sm cu-generatePromoCode">Generate code</button></div>
            </div>

            <div class="col-md-6">
                <?php
                echo $form->field($model, 'ryb_promocode_remark')->textInput([
                    'placeholder' => "Enter promo code remark",
                    'class' => 'form-control',
                ])->label('Promo code remark: ');
                ?>
            </div>

        </div>

        <div class="row">

            <div class="col-md-6">
                <?php
                echo $form->field($model, 'ryb_promocode_disc_type')->dropDownList([
                    1 => "Percentage (%)",
                    2 => "Flat (Rs.)"
                        ], [
                    'prompt' => "Select discount type",
                    'class' => 'form-control cu-discount_type',
                ])->label('Discount type: ');
                ?>
            </div>

            <div class="col-md-6">
                <?=
                $form->field($model, 'ryb_promocode_disc_amnt')->textInput([
                    'placeholder' => "Enter discount amount",
                    'class' => 'form-control cu-discount_amount',
                ])->label('Discount amount: ');
                ?>
            </div>

        </div>

        <div class="row">

            <div class="col-md-6">
                <?=
                $form->field($model, 'ryb_promocode_min_trans_amnt')->textInput([
                    'placeholder' => "Enter minimum transaction amount",
                    'class' => 'form-control',
                ])->label('Minimum transaction amount(Rs.): ');
                ?>
            </div>

            <div class="col-md-6">
                <?=
                $form->field($model, 'ryb_promocode_max_disc_amnt')->textInput([
                    'placeholder' => "Enter maximum discount amount",
                    'class' => 'form-control',
                ])->label('Maximum discounted amount(Rs.): ');
                ?>
            </div>

        </div>

        <div class="row">
            <div class="col-md-12">
                <?=
                $form->field($model, 'ryb_promocode_redemption_lmt')->textInput([
                    'placeholder' => "Enter redemption limit",
                    'class' => 'form-control',
                ])->label('Redemption limit for promo code: ');
                ?>
            </div>
        </div>

        <div class="row">

            <div class="col-md-12">
                <?= $form->field($model, 'ryb_promocode_for_new_user')->checkbox(['label' => 'Set only for newly registered users?']); ?>
            </div>

            <div class="col-md-12">
                <?= $form->field($model, 'ryb_promocode_is_date_range')->checkbox(['label' => 'Set a date range for this promo code', 'class' => 'cu-promocode_daterange']); ?>
            </div>

            <div class="col-md-12">
                <?= $form->field($model, 'ryb_promocode_is_ride_type')->checkbox(['label' => 'Select ride type (Ignore this, If you want to apply to all)', 'class' => 'cu-promocode_ridetype']); ?>
            </div>

            <div class="col-md-12">
                <?= $form->field($model, 'ryb_promocode_is_cab_type')->checkbox(['label' => 'Select cab type (Ignore this, If you want to apply to all)', 'class' => 'cu-promocode_cabtype']); ?>
            </div>

            <div class="col-md-12">
                <?= $form->field($model, 'ryb_promocode_is_city_type')->checkbox(['label' => 'Select city (Ignore this, If you want to apply to all)', 'class' => 'cu-promocode_location']); ?>
            </div>

        </div>

        <div class="row cu-promocode-daterange-box" style="display: none;">

            <div class="col-md-6 form-group cu-form-group">
                <label for="" class="">Start date: </label>
                <div class="input-affix m-b-10">
                    <i class="prefix-icon anticon anticon-calendar"></i>
                    <?=
                    kartik\widgets\DatePicker::widget([
                        'name' => 'PromocodeMaster[ryb_promocode_date_start]',
                        'type' => kartik\widgets\DatePicker::TYPE_INPUT,
                        'value' => date("Y-m-d"),
                        'pluginOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd']
                    ]);
                    ?>
                </div>
            </div>

            <div class="col-md-6 form-group cu-form-group">
                <label for="" class="">End date: </label>
                <div class="input-affix m-b-10">
                    <i class="prefix-icon anticon anticon-calendar"></i>
                    <?=
                    kartik\widgets\DatePicker::widget([
                        'name' => 'PromocodeMaster[ryb_promocode_date_end]',
                        'type' => kartik\widgets\DatePicker::TYPE_INPUT,
                        'value' => date("Y-m-d"),
                        'pluginOptions' => ['autoclose' => true, 'format' => 'yyyy-mm-dd']
                    ]);
                    ?>
                </div>
            </div>

        </div>

        <div class="row cu-promocode_ridetype-box" style="display: none;">

            <div class="col-md-12 form-group cu-form-group">
                <?php
                echo $form->field($rideTypeModel, 'ryb_ride_type_id[]')->widget(\kartik\widgets\Select2::className(), [
                    'data' => $rideTypeArray,
                    'options' => ['prompt' => 'Select ride type', 'style' => 'width:100%;', 'multiple' => true],
                    'pluginOptions' => ['allowClear' => true]
                ]);
                ?>
            </div>

        </div>

        <div class="row cu-promocode_cabtype-box" style="display: none;">

            <div class="col-md-12 form-group">
                <?php
                echo $form->field($cabTypeModel, 'ryb_cabtype_id[]')->widget(\kartik\widgets\Select2::className(), [
                    'data' => $cabTypeArray,
                    'options' => ['multiple' => true, 'prompt' => 'Select cab type', 'style' => 'width:100%;'],
                    'pluginOptions' => ['allowClear' => true]
                ]);
                ?>
            </div>

        </div>

        <div class="row cu-promocode_location-box" style="display: none;">

            <div class="col-md-6">
                <?php
                echo $form->field($cityModel, 'ryb_country_id')->widget(\kartik\widgets\Select2::className(), [
                    'data' => $countryArray,
                    'options' => ['placeholder' => 'Select country', 'style' => 'width:100%;'],
                    'pluginOptions' => ['allowClear' => true]
                ]);
                ?>
            </div>

            <div class="col-md-6">
                <?php
                echo $form->field($cityModel, 'ryb_state_id')->widget(\kartik\widgets\DepDrop::classname(), [
                    'type' => \kartik\widgets\DepDrop::TYPE_SELECT2,
                    'pluginOptions' => [
                        'depends' => ['promocodecitymaster-ryb_country_id'],
                        'placeholder' => 'Select state',
                        'url' => yii\helpers\Url::to(['/configuration/fetch-states']),
                        'params' => ['selected_state_id'],
                        'initialize' => true,
                        'initDepends' => ['promocodecitymaster-ryb_country_id'],
                    ]
                ]);
                ?>
            </div>

            <div class="col-md-12">
                <?php
                echo \yii\helpers\Html::hiddenInput('', $formModel->ryb_state_id, ['id' => 'selected_state_id']);
                echo \yii\helpers\Html::hiddenInput('', $formModel->ryb_city_id, ['id' => 'selected_city_id']);
                echo $form->field($cityModel, 'ryb_city_id[]')->widget(\kartik\widgets\DepDrop::classname(), [
                    'type' => \kartik\widgets\DepDrop::TYPE_SELECT2,
                    'options' => ['prompt' => 'Select city', 'multiple' => true],
                    'pluginOptions' => [
                        'depends' => ['promocodecitymaster-ryb_state_id'],
                        'placeholder' => 'Select city',
                        'url' => yii\helpers\Url::to(['/configuration/fetch-cities']),
                        'params' => ['selected_city_id'],
                        'initialize' => true,
                        'initDepends' => ['promocodecitymaster-ryb_state_id'],
                    ]
                ]);
                ?>
            </div>

        </div>

        <div class="form-group text-right row">
            <div class="col-sm-12">
                <?= \yii\helpers\Html::submitButton('<i class = "anticon anticon-like"></i> Save', ['class' => 'btn btn-primary m-r-5']) ?>
            </div>
        </div>

        <?php yii\widgets\ActiveForm::end(); ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        var generatePromoCode = function (length) {
            var result = '';
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for (var i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result.toUpperCase();
        };
        
        $(".cu-generatePromoCode").click(function () {
            $("#promocodemaster-ryb_promocode_unique").val(generatePromoCode(6));
        });
        
        $(".cu-promocode_daterange").click(function () {
            $(".cu-promocode-daterange-box").hide();
            if ($(this).is(":checked")) {
                $(".cu-promocode-daterange-box").show();
            }
        });
        
        $(".cu-promocode_ridetype").click(function () {
            $(".cu-promocode_ridetype-box").hide();
            if ($(this).is(":checked")) {
                $(".cu-promocode_ridetype-box").show();
            }
        });
        
        $(".cu-promocode_cabtype").click(function () {
            $(".cu-promocode_cabtype-box").hide();
            if ($(this).is(":checked")) {
                $(".cu-promocode_cabtype-box").show();
            }
        });

        $(".cu-promocode_location").click(function () {
            $(".cu-promocode_location-box").hide();
            if ($(this).is(":checked")) {
                $(".cu-promocode_location-box").show();
            }
        });

        $(".cu-discount_amount").on("blur", function () {
            if (!isNaN($(this).val())) {
                if (parseInt($(".cu-discount_type").val()) === 1) {
                    if (parseInt($(this).val()) > 100) {
                        alert("Error: Invalid discount amount.");
                        $(this).val("").focus();
                        return false;
                    }
                }
            } else {
                alert("Error: Invalid discount amount.");
                $(this).val("").focus();
                return false;
            }
        });

    });
</script>