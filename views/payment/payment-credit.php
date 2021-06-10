<div class="card">
    <div class="card-header">
        <h4 class="card-title"><?= \Yii::$app->params["page_meta_data"]["page_title"]; ?></h4>
    </div>
    <div class="card-body">
        <form>
            <div class="row">
                <div class="col-md-12 form-group cu-form-group">
                    <label for="" class="">User to credit wallet: </label>
                    <select class="select2" data-placeholder="Search using User ID">
                        <option value="123456">123456</option>
                        <option value="987654">987654</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 form-group cu-form-group">
                    <label for="" class="">Amount to be credited</label>
                    <input type="number" value="" class="form-control" placeholder="0.00">
                </div>
            </div>
            <div class="form-group text-right row">
                <div class="col-sm-12">
                    <button type="button" class="btn btn-primary m-r-5">
                        <i class="anticon anticon-like"></i><span>Save</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.select2').select2();
    });
</script>