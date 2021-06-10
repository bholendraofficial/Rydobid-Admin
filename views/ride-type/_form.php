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
        ?>
        <?= $form->field($model, 'ryb_ride_type_title')->textInput(['placeholder' => "Enter " . strtolower($model->getAttributeLabel('ryb_ride_type_title'))]); ?>
        <div class="form-group text-right row">
            <div class="col-sm-12">
                <?= \yii\helpers\Html::submitButton('Save', ['class' => 'btn btn-primary m-r-5']) ?>
            </div>
        </div>
        <?php yii\widgets\ActiveForm::end(); ?>
    </div>
</div>