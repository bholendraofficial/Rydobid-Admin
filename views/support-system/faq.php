<style>
    .ck-editor__editable_inline {
        min-height: 250px;
    }
    .cu-title{
        position: relative;
    }
    .delete-button{
        position: absolute;
        right: 10px;
        top: 10px;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header"><h4 class="card-title">Add - FAQ | Support System</h4></div>
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
                            'options' => ['id' => 'add-form', 'method' => 'POST']
                ]);
                ?>

                <div class="row">

                    <div class="col-md-12 form-group cu-form-group">
                        <?=
                        $form->field($model, 'ryb_cm_faq_question')->textInput([
                            'class' => 'form-control', 'placeholder' => 'Enter question'
                        ])->label($model->getAttributeLabel('ryb_cm_faq_question'));
                        ?>
                    </div>

                    <div class="col-md-12">
                        <?=
                        $form->field($model, 'ryb_cm_faq_answer')->textArea([
                            'class' => 'form-control html-editor', 'rows' => 10
                        ])->label($model->getAttributeLabel('ryb_cm_faq_answer'));
                        ?>
                    </div>

                    <div class="col-sm-12">
                        <?= \yii\helpers\Html::submitButton('Save', ['class' => 'btn btn-primary m-r-5']) ?>
                    </div>

                </div>

                <?php yii\widgets\ActiveForm::end(); ?>

            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header"><h4 class="card-title">Manage - FAQ | Support System</h4></div>
            <div class="card-body">
                <div class="accordion" id="faq-q1">
                    <?php
                    $FIndex = 1;
                    foreach ($FAQArray as $key => $value) {
                        ?>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title cu-title">
                                    <a data-toggle="collapse" href="#q<?= $FIndex; ?>">
                                        <span><?= $value["ryb_cm_faq_question"]; ?></span>
                                    </a>
                                    <button data-faq_question-id="<?= $value["ryb_cm_faq_id"]; ?>" class="btn btn-sm btn-danger delete-button">Delete</button>
                                </h5>
                            </div>
                            <div id="q<?= $FIndex; ?>" class="collapse" data-parent="#faq-q1">
                                <div class="card-body">
                                    <?= $value["ryb_cm_faq_answer"]; ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        $FIndex++;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.ckeditor.com/ckeditor5/19.0.0/classic/ckeditor.js"></script>
<script>ClassicEditor.create(document.querySelector('.html-editor'));</script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".delete-button").click(function () {
            if (confirm("Are you sure?")) {
                var QuestionId = $(this).attr("data-faq_question-id");
                $.ajax({
                    "url": "<?= yii\helpers\Url::to(["/support-system/faq"]); ?>",
                    "type": "GET",
                    "data": {"QuestionId": QuestionId},
                    "success": function (r) {
                        window.location.reload();
                    }
                });
            }
        });
    });
</script>
