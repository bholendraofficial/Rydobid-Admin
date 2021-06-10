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
        <div class="row">
            <div class="col-md-12">
                <?=
                $form->field($model, 'ryb_cm_cancel_refund_text')->textArea([
                    'class' => 'form-control html-editor', 'rows' => 10
                ])->label($model->getAttributeLabel('ryb_cm_cancel_refund_text'));
                ?>
            </div>

            <div class="col-md-12">
                <?=
                $form->field($model, 'ryb_cm_cancel_refund_file')->fileInput([
                    'class' => 'form-control', 'accept' => '.pdf'
                ])->label($model->getAttributeLabel('ryb_cm_cancel_refund_file'));
                ?>
                <a target="_blank" href="<?= $model->ryb_cm_cancel_refund_file; ?>">Click here to view the PDF File</a>
            </div>

            <div class="col-sm-12 text-right">
                <?= \yii\helpers\Html::submitButton('<i class = "anticon anticon-like"></i> Save', ['class' => 'btn btn-primary m-r-5']) ?>
            </div>
        </div>

        <?php yii\widgets\ActiveForm::end(); ?>
    </div>
</div>
<script src="https://cdn.ckeditor.com/ckeditor5/19.0.0/classic/ckeditor.js"></script>
<script>ClassicEditor.create(document.querySelector('.html-editor'));</script>