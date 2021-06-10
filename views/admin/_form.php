<div class="card">
    <div class="card-header">
        <h4 class="card-title"><?= \Yii::$app->params["page_meta_data"]["page_title"]; ?></h4>
    </div>
    <div class="card-body">
        <form>
            <div class="row">
                <div class="col-sm-12 col-md-6 form-group cu-form-group">
                    <label for="" class="">Role: </label>
                    <select class="select2">
                        <option value="Master admin">Master admin</option>
                        <option value="City office">City office</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-6 form-group cu-form-group">
                    <label for="" class="">Image: </label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="adminImage">
                        <label class="custom-file-label" for="adminImage">Choose file</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6 form-group cu-form-group">
                    <label for="" class="">Full name: </label>
                    <input type="text" class="form-control" placeholder="Enter full name">
                </div>
                <div class="col-sm-12 col-md-6 form-group cu-form-group">
                    <label for="" class="">Email id: </label>
                    <input type="email" class="form-control" placeholder="Enter email id">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6 form-group cu-form-group">
                    <label for="" class="">Phone no.: </label>
                    <input type="number" class="form-control" placeholder="Enter email id">
                </div>
                <div class="col-sm-12 col-md-6 form-group cu-form-group">
                    <label for="" class="">Address: </label>
                    <input type="text" class="form-control" placeholder="Enter email id">
                </div>                
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-4 form-group cu-form-group">
                    <label for="" class="">Country: </label>
                    <select class="select2" disabled="">
                        <option value="">India</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4 form-group cu-form-group">
                    <label for="" class="">State: </label>
                    <select class="select2">
                        <option value="">Uttar Pradesh</option>
                        <option value="">Karnataka</option>
                    </select>
                </div>
                <div class="col-sm-12 col-md-4 form-group cu-form-group">
                    <label for="" class="">City: </label>
                    <select class="select2">
                        <option value="">Lucknow</option>
                        <option value="">Agra</option>
                        <option value="">Kanpur</option>
                    </select>
                </div>
            </div>
            <div class="form-group text-right row">
                <div class="col-sm-12">
                    <button type="button" class="btn btn-primary m-r-5">
                        <i class="anticon anticon-like"></i> <span>Save</span>
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