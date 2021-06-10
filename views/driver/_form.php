<div class="card">
    <div class="card-header">
        <h4 class="card-title"><?= \Yii::$app->params["page_meta_data"]["page_title"]; ?></h4>
    </div>
    <div class="card-body">
        <form>
            <div class="card">
                <div class="card-header"><h5 class="card-title cu_card-title">Driver Information</h5></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 form-group cu-form-group">
                            <label for="" class="">Driver ID</label>
                            <input type="number" class="form-control" value="123456" readonly="">
                        </div>
                        <div class="col-md-6 form-group cu-form-group">
                            <label for="" class="">Email ID</label>
                            <input type="text" class="form-control" placeholder="Enter email id">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group cu-form-group">
                            <label for="" class="">Full Name</label>
                            <input type="text" class="form-control" placeholder="Enter full name">
                        </div>
                        <div class="col-md-6 form-group cu-form-group">
                            <label for="" class="">Phone no</label>
                            <input type="text" class="form-control" placeholder="Enter phone no">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 form-group cu-form-group">
                            <label for="" class="">Gender</label>
                            <select class="select2">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>                        
                        <div class="col-md-4 form-group cu-form-group">
                            <label for="" class="">DOB</label>
                            <input type="text" class="form-control datepicker-input" placeholder="Enter date of birth">
                        </div>
                        <div class="col-md-4 form-group cu-form-group">
                            <label for="" class="">Password</label>
                            <input type="password" class="form-control" placeholder="Enter password">
                            <div class="checkbox mt-1">
                                <input id="c1" type="checkbox" checked="">
                                <label for="c1">Auto-generate password</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group cu-form-group">
                            <label for="" class="">Country</label>
                            <select class="select2">
                                <option value="India">India</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group cu-form-group">
                            <label for="" class="">State</label>
                            <select class="select2">
                                <option value="Uttar Pradesh">Uttar Pradesh</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group cu-form-group">
                            <label for="" class="">City</label>
                            <select class="select2" data-placeholder="Select city">
                                <option value="Lucknow">Lucknow</option>
                                <option value="Kanpur">Kanpur</option>
                                <option value="Agra">Agra</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group cu-form-group">
                            <label for="" class="">Pincode</label>
                            <select class="select2" data-placeholder="Select pincode">
                                <option value="226001">226001</option>
                                <option value="226002">226002</option>
                                <option value="226003">226003</option>
                                <option value="226004">226004</option>
                                <option value="226005">226005</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h5 class="card-title cu_card-title">Cab Information</h5></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 form-group cu-form-group">
                            <label for="" class="">Cab Type</label>
                            <select class="select2">
                                <option value="Micro">Micro</option>
                                <option value="Mini">Mini</option>
                                <option value="Sedan">Sedan</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group cu-form-group">
                            <label for="" class="">Vehicle Chasis No.</label>
                            <input type="text" class="form-control" placeholder="Enter cab chasis no.">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group cu-form-group">
                            <label for="" class="">Brand Name</label>
                            <select class="select2">
                                <option value="Maruti">Maruti</option>
                                <option value="Tata">Tata</option>
                                <option value="Honda">Honda</option>
                            </select>
                        </div>
                        <div class="col-md-6 form-group cu-form-group">
                            <label for="" class="">Make & Model</label>
                            <input type="text" class="form-control" placeholder="Enter cab model name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group cu-form-group">
                            <label for="" class="">RTO(Road Transport Office) Registration Year</label>
                            <select class="select2" data-placeholder="Select year">
                                <?php
                                for ($y = date("Y"); $y >= (date("Y") - 7); $y--) {
                                    echo "<option value='{$y}'>{$y}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header"><h5 class="card-title cu_card-title">KYC Documents</h5></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 form-group cu-form-group">
                            <label for="" class="">Driver - Identity Type</label>
                            <select class="select2">
                                <option value="Aadhaar Card">Aadhaar Card</option>
                                <option value="PAN Card">PAN Card</option>
                                <option value="Passport">Passport</option>
                            </select>
                        </div>
                        <div class="col-md-4 form-group cu-form-group">
                            <label for="" class="">Driver - Identity No.</label>
                            <input type="text" class="form-control" placeholder="Enter driver identity no">
                        </div>
                        <div class="col-md-4 form-group cu-form-group">
                            <label for="" class="">Driver - Identity Image</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="identityImage">
                                <label class="custom-file-label" for="identityImage">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group cu-form-group">
                            <label for="" class="">Driver - License No.</label>
                            <input type="text" class="form-control" placeholder="Enter driver license no">
                        </div>

                        <div class="col-md-6 form-group cu-form-group">
                            <label for="" class="">Driver - License Image</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="licenseImage">
                                <label class="custom-file-label" for="licenseImage">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group cu-form-group">
                            <label for="" class="">Cab - RTO(Road Transport Office) Registration No.</label>
                            <input type="text" class="form-control" placeholder="Enter cab rto(road transport office) registration no.">
                        </div>
                        <div class="col-md-6 form-group cu-form-group">
                            <label for="" class="">Cab - RTO(Road Transport Office) Registration Certificate</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="regCertImage">
                                <label class="custom-file-label" for="regCertImage">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group cu-form-group">
                            <label for="" class="">Cab - RTO Permit No.</label>
                            <input type="text" class="form-control" placeholder="Enter cab rto permit no.">
                        </div>
                        <div class="col-md-6 form-group cu-form-group">
                            <label for="" class="">Cab - RTO Permit Certificate</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="prtCertImage">
                                <label class="custom-file-label" for="prtCertImage">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group cu-form-group">
                            <label for="" class="">Cab - Insurance No.</label>
                            <input type="text" class="form-control" placeholder="Enter insurance no.">
                        </div>
                        <div class="col-md-6 form-group cu-form-group">
                            <label for="" class="">Cab - Insurance Certificate</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="inrCertImage">
                                <label class="custom-file-label" for="inrCertImage">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 form-group cu-form-group">
                            <label for="" class="">KYC Status</label>
                            <select class="select2">
                                <option value="Pending">Pending</option>
                                <option value="Approved">Approved</option>
                                <option value="Rejected">Rejected</option>
                            </select>
                            <div class="checkbox mt-1">
                                <input id="c2" type="checkbox" checked="">
                                <label for="c2">Notify driver ?</label>
                            </div>
                        </div>
                        <div class="col-md-6 form-group cu-form-group">
                            <label for="" class="">KYC Status - Remark</label>
                            <textarea placeholder="Enter verification status remark" class="form-control" rows="2" cols="5"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group text-right row">
                <div class="col-sm-12">
                    <button type="button" class="btn btn-primary m-r-5">
                        <i class="anticon anticon-like"></i>
                        <span>Save</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('.datepicker-input').datepicker();
        $('.select2').select2();
    });
</script>