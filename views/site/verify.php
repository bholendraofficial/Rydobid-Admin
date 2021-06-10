<?php echo \yii\helpers\Html::beginForm(); ?>
<div class="form-group">
    <label class="font-weight-semibold" for="otp_code">OTP Code:</label>
    <div class="input-affix m-b-10">
        <i class="prefix-icon anticon anticon-lock"></i>
        <?php echo \yii\helpers\Html::textInput('', '', ['class' => 'form-control', 'type' => 'number', 'placeholder' => 'OTP Code', 'id' => 'otp_code']); ?>
    </div>
</div>
<div class="form-group">
    <div class="d-flex align-items-end justify-content-between">
        <?= \yii\helpers\Html::submitButton('Verify & Proceed', ['class' => 'btn btn-block btn-primary']) ?>
    </div>
</div>
<?php echo \yii\helpers\Html::endForm(); ?>