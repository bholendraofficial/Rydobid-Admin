<div class="card">
    <div class="card-header">
        <h4 class="card-title"><?= \Yii::$app->params["page_meta_data"]["page_title"]; ?></h4>
    </div>
    <div class="card-body">
        <?php
        $form = yii\widgets\ActiveForm::begin([
                    'fieldConfig' => [
                        'template' => '{label}<div class="col-sm-10">{input}{error}</div>',
                        'labelOptions' => [
                            'class' => 'col-sm-2 col-form-label cu-col-form-label'
                        ],
                        'inputOptions' => array(
                            'class' => 'form-control cu-form-control'
                        ),
                        'errorOptions' => array(
                            'class' => 'help-block-error'
                        ),
                        'options' => [
                            'class' => 'form-group row'
                        ]
                    ],
                    'options' => [
                        'id' => 'add-form',
                        'method' => 'POST',
                        'enctype' => 'multipart/form-data'
                    ]
        ]);
        echo $form->field($model, 'ryb_airport_name')->textInput(['placeholder' => "Enter " . strtolower($model->getAttributeLabel('ryb_airport_name'))]);
        echo $form->field($model, 'ryb_airport_latitude')->textInput(['placeholder' => "Enter " . strtolower($model->getAttributeLabel('ryb_airport_latitude'))]);
        echo $form->field($model, 'ryb_airport_longitude')->textInput(['placeholder' => "Enter " . strtolower($model->getAttributeLabel('ryb_airport_longitude'))]);

        echo $form->field($airportCityModel, 'ryb_country_id')->widget(\kartik\widgets\Select2::className(), [
            'data' => $countryArray,
            'options' => ['placeholder' => 'Select country', 'style' => 'width:100%;'],
            'pluginOptions' => ['allowClear' => true]
        ]);

        echo $form->field($airportCityModel, 'ryb_state_id')->widget(\kartik\widgets\DepDrop::classname(), [
            'type' => \kartik\widgets\DepDrop::TYPE_SELECT2,
            'pluginOptions' => [
                'depends' => ['airportcitymaster-ryb_country_id'],
                'placeholder' => 'Select state',
                'url' => yii\helpers\Url::to(['/configuration/fetch-states']),
                'params' => ['selected_state_id'],
                'initialize' => true,
                'initDepends' => ['airportcitymaster-ryb_country_id'],
            ]
        ]);

        echo \yii\helpers\Html::hiddenInput('', $airportCityModel->ryb_state_id, ['id' => 'selected_state_id']);
        echo \yii\helpers\Html::hiddenInput('', $airportCityModel->ryb_city_id, ['id' => 'selected_city_id']);

        echo $form->field($airportCityModel, 'ryb_city_id[]')->widget(\kartik\widgets\DepDrop::classname(), [
            'type' => \kartik\widgets\DepDrop::TYPE_SELECT2,
            'options' => ['prompt' => 'Select city', 'multiple' => true],
            'pluginOptions' => [
                'depends' => ['airportcitymaster-ryb_state_id'],
                'placeholder' => 'Select city',
                'url' => yii\helpers\Url::to(['/configuration/fetch-cities']),
                'params' => ['selected_city_id'],
                'initialize' => true,
                'initDepends' => ['airportcitymaster-ryb_state_id'],
            ]
        ]);
        ?>
        <div class="form-group text-right row">
            <div class="col-sm-12">
                <?= \yii\helpers\Html::submitButton('Save', ['class' => 'btn btn-primary m-r-5']) ?>
            </div>
        </div>
        <?php yii\widgets\ActiveForm::end(); ?>
    </div>
</div>