<?php
$form = \yii\widgets\ActiveForm::begin([
            'id' => 'login-form',
            'fieldConfig' => [
                'template' => "{label}<div class='input-affix'>{input}</div>{error}",
                'labelOptions' => ['class' => 'font-weight-semibold'],
            ],
        ]);

echo $form->field($model, 'username')->textInput([
    'class' => 'form-control', 'id' => 'username', 'placeholder' => 'Email Id/Username'
])->label("Email Id/Username");
echo $form->field($model, 'password')->passwordInput([
    'class' => 'form-control', 'id' => 'password', 'placeholder' => 'Password'
])->label("Password");
?>
<div class="form-group">
    <div class="d-flex align-items-end justify-content-between">
        <?= \yii\helpers\Html::submitButton('Sign In', ['class' => 'btn btn-block btn-primary']) ?>
    </div>
</div>
<?php \yii\widgets\ActiveForm::end(); ?>