<div class="card">
    <div class="card-header">
        <h4 class="card-title"><?= \Yii::$app->params["page_meta_data"]["page_title"]; ?></h4>
    </div>
    <div class="card-body">
        <?php
        $form = yii\widgets\ActiveForm::begin([
                    'fieldConfig' => [
                        'template' => '{label}{input}{error}',
                        'labelOptions' => ['class' => ''],
                        'inputOptions' => ['class' => 'form-control cu-form-control'],
                        'errorOptions' => ['class' => 'help-block-error'],
                        'options' => ['class' => 'form-group cu-form-group']
                    ],
                    'options' => ['id' => 'add-form', 'method' => 'POST', 'enctype' => 'multipart/form-data']
        ]);
        ?>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label for="" class="">User ID</label>
                    <input type="number" class="form-control" value="<?= (!$model->isNewRecord ? $model->ryb_user_id : "Will be auto generated"); ?>" disabled="">
                </div>
                <div class="col-md-6">
                    <?=
                    $form->field($model, 'ryb_user_fullname')->textInput([
                        'placeholder' => "Enter " . $model->getAttributePlaceholder('ryb_user_fullname'), 'class' => 'form-control'
                    ])->label($model->getAttributeLabel('ryb_user_fullname'));
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?=
                    $form->field($model, 'ryb_user_emailid')->textInput([
                        'placeholder' => "Enter " . $model->getAttributePlaceholder('ryb_user_emailid'), 'class' => 'form-control', 'type' => 'email'
                    ])->label($model->getAttributeLabel('ryb_user_emailid'));
                    ?>
                </div>
                <div class="col-md-6">
                    <?=
                    $form->field($model, 'ryb_user_password')->passwordInput([
                        'placeholder' => "Enter " . $model->getAttributePlaceholder('ryb_user_password'), 'class' => 'form-control'
                    ])->label($model->getAttributeLabel('ryb_user_password'));
                    ?>
                    <div class="m-t-5 text-right"><button type="button" class="btn btn-info btn-sm cu-generatePassword">Generate password</button></div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?=
                    $form->field($model, 'ryb_user_phoneno')->textInput([
                        'placeholder' => "Enter " . $model->getAttributePlaceholder('ryb_user_phoneno'), 'class' => 'form-control'
                    ])->label($model->getAttributeLabel('ryb_user_phoneno'));
                    ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'ryb_user_picture')->fileInput(['class' => 'form-control'])->label($model->getAttributeLabel('ryb_user_picture')); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?=
                    $form->field($model, 'ryb_user_addr_home')->textInput([
                        'placeholder' => "Enter " . $model->getAttributePlaceholder('ryb_user_addr_home'), 'class' => 'form-control'
                    ])->label($model->getAttributeLabel('ryb_user_addr_home'));
                    ?>
                </div>
                <div class="col-md-6">
                    <?=
                    $form->field($model, 'ryb_user_addr_work')->textInput([
                        'placeholder' => "Enter " . $model->getAttributePlaceholder('ryb_user_addr_work'), 'class' => 'form-control'
                    ])->label($model->getAttributeLabel('ryb_user_addr_work'));
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?=
                    $form->field($model, 'ryb_status_id')->dropdownList(\yii\helpers\ArrayHelper::map(
                                    \app\models\StatusMaster::find()->asArray()->all(), 'ryb_status_id', 'ryb_status_text'
                            ), [
                        'prompt' => "Select " . $model->getAttributePlaceholder('ryb_status_id'), 'class' => 'form-control'
                    ])->label($model->getAttributeLabel('ryb_status_id'));
                    ?>
                </div>
                <div class="col-md-6">
                    <?=
                    $form->field($model, 'ryb_user_verify_status')->dropdownList([true => "Yes", false => "No"], [
                        'prompt' => "Select " . $model->getAttributePlaceholder('ryb_user_verify_status'), 'class' => 'form-control'
                    ])->label($model->getAttributeLabel('ryb_user_verify_status'));
                    ?>
                </div>
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
        var generatePassword = function (length) {
            var result = '';
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for (var i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result.toUpperCase();
        };
        $(".cu-generatePassword").click(function () {
            $("#usermaster-ryb_user_password").prop("type", "text").val(generatePassword(8));
        });
    });
</script>