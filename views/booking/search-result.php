<style>
    .cu-bid-box{
        position: relative;
    }
    .cu-list_group{
        max-height: 607px;
        overflow-y: auto;
    }
    .cu-bid_status{
        position: absolute;
        right: 0
    }
    .cu-bid_status .btn{

    }
    .cu-bid_status .btn img{
        width: 75px;
    }
    @media only screen and (max-width: 768px) {
        .cu-bid-box .avatar-image, .card-toolbar{
            display: none;
        }
        .cu-bid_status .btn img{
            width: 25px;
        }
        .cu-bid_status{
            position: absolute;
            right: -5%;
        }
    }
</style>
<div class="row">
    <div class="col-md-12 card cu-card">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between m-b-15">
                <h4 class="m-b-0">BOOKING ID: 123456</h4>
                <div class="card-toolbar">
                    <ul>
                        <li><a class="btn btn-primary btn-sm" href="javascript:void(0)"> Track driver/user </a></li>
                        <li><a class="btn btn-primary btn-sm" href="javascript:void(0)"> View user </a></li>
                        <li><a class="btn btn-primary btn-sm" href="javascript:void(0)"> View driver </a></li>
                        <li><a class="btn btn-primary btn-sm cancel-booking-btn" href="javascript:void(0)"> Cancel booking</a></li>
                        <li><a class="btn btn-primary btn-sm" href="javascript:void(0)"> Manage support ticket</a></li>
                    </ul>
                </div>
            </div>
            <div class="row">

                <div class="col-sm-7">
                    <div class="card cu-card">
                        <div class="card-header"><h5 class="card-title cu_card-title">Booking detail - {BOOKINGID}</h5></div>
                        <table class="card-body table table-bordered table-striped table-condensed">
                            <tr><th>Booking ID: </th><td>123456</td></tr>
                            <tr><th>Ride type: </th><td> Daily</td></tr>
                            <tr><th>Pickup location: </th><td> Alambagh, Lucknow, 226001</td></tr>
                            <tr><th>Pickup location pincode: </th><td> 226001</td></tr>
                            <tr><th>Drop location: </th><td> Saharaganj Mall, Lucknow, 226010</td></tr>
                            <tr><th>Drop location pincode: </th><td> 226010</td></tr>
                            <tr><th>Cab type: </th><td> Micro</td></tr>
                            <tr><th>No of drivers notified: </th><td> 10</td></tr>
                            <tr><th>Bid time: </th><td> 10 minutes</td></tr>
                            <tr><th>Promo code: </th><td> N/A</td></tr>
                            <tr><th>Payment mode: </th><td> Cash</td></tr>
                            <tr><th>Estimated fare: </th><td> Rs. 250</td></tr>
                            <tr><th>Driver bid range(Minimum): </th><td> Rs. 300</td></tr>
                            <tr><th>Driver bid range(Maximum): </th><td> Rs. 275</td></tr>
                            <tr><th>Billed amount: </th><td> Rs. 290</td></tr>
                            <tr><th>RydoBid commission: </th><td> Rs. 40</td></tr>
                            <tr><th>Driver earned: </th><td> Rs. 250</td></tr>
                            <tr><th>Invoice: </th><td> <a href="#">Download</a></td></tr>
                            <tr><th>Transaction: </th><td> <a href="#">View</a></td></tr>
                            <tr><th>Status: </th><td> <b>Bidding In-progress</b></td></tr>
                            <tr><td colspan="2"><button class="btn btn-default btn-sm">View driver in detail</button></td></tr>
                        </table>
                    </div>
                </div>

                <div class="col-sm-5">
                    <div class="card cu-card">
                        <div class="card-header"><h5 class="card-title cu_card-title">Bidding - {BOOKINGID}</h5></div>
                        <div class="card-body">
                            <ul class="list-group cu-list_group">
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center cu-bid-box">
                                        <div class="avatar avatar-image">
                                            <img src="<?= Yii::$app->request->baseUrl; ?>/images/app-icon.png" alt="">
                                        </div>
                                        <div class="m-l-10">
                                            <div class="m-b-0 text-dark font-weight-semibold">Erin Gonzales (Toyota Etios)</div>
                                            <div class="m-b-0 font-size-13">Micro, UP 32 HY 1234</div>
                                            <div class="m-b-0 opacity-07 font-size-13"><b>Bid Amount:</b> Rs. 275.00</div>
                                            <div class="m-b-0 opacity-07 font-size-13"><b>Arrival Time:</b> 10 minutes</div>
                                            <div class="m-b-0 opacity-07 font-size-13"><a href="#">View Driver</a></div>
                                        </div>
                                        <div class="cu-bid_status">
                                            <button class="btn btn-default"><img src="<?= Yii::$app->request->baseUrl; ?>/images/reward.png"/></button>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center cu-bid-box">
                                        <div class="avatar avatar-image">
                                            <img src="<?= Yii::$app->request->baseUrl; ?>/images/app-icon.png" alt="">
                                        </div>
                                        <div class="m-l-10">
                                            <div class="m-b-0 text-dark font-weight-semibold">Darryl Day (Maruti Wagon R)</div>
                                            <div class="m-b-0 font-size-13">Micro, UP 32 HY 1234</div>
                                            <div class="m-b-0 opacity-07 font-size-13"><b>Bid Amount:</b> Rs. 275.00</div>
                                            <div class="m-b-0 opacity-07 font-size-13"><b>Arrival Time:</b> 10 minutes</div>
                                            <div class="m-b-0 opacity-07 font-size-13"><a href="#">View Driver</a></div>
                                        </div>
                                        <div class="cu-bid_status">
                                            <button class="btn btn-default"><img src="<?= Yii::$app->request->baseUrl; ?>/images/hourglass.png"/></button>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center cu-bid-box">
                                        <div class="avatar avatar-image">
                                            <img src="<?= Yii::$app->request->baseUrl; ?>/images/app-icon.png" alt="">
                                        </div>
                                        <div class="m-l-10">
                                            <div class="m-b-0 text-dark font-weight-semibold">Marshall Nichols (Datson Go)</div>
                                            <div class="m-b-0 font-size-13">Micro, UP 32 HY 1234</div>
                                            <div class="m-b-0 opacity-07 font-size-13"><b>Bid Amount:</b> Rs. 275.00</div>
                                            <div class="m-b-0 opacity-07 font-size-13"><b>Arrival Time:</b> 10 minutes</div>
                                            <div class="m-b-0 opacity-07 font-size-13"><a href="#">View Driver</a></div>
                                        </div>
                                        <div class="cu-bid_status">
                                            <button class="btn btn-default"><img src="<?= Yii::$app->request->baseUrl; ?>/images/cancel.png"/></button>
                                        </div>
                                    </div>
                                </li>

                                <li class="list-group-item">
                                    <div class="d-flex align-items-center cu-bid-box">
                                        <div class="avatar avatar-image">
                                            <img src="<?= Yii::$app->request->baseUrl; ?>/images/app-icon.png" alt="">
                                        </div>
                                        <div class="m-l-10">
                                            <div class="m-b-0 text-dark font-weight-semibold">Marshall Nichols (Datson Go)</div>
                                            <div class="m-b-0 font-size-13">Micro, UP 32 HY 1234</div>
                                            <div class="m-b-0 opacity-07 font-size-13"><b>Bid Amount:</b> Rs. 275.00</div>
                                            <div class="m-b-0 opacity-07 font-size-13"><b>Arrival Time:</b> 10 minutes</div>
                                            <div class="m-b-0 opacity-07 font-size-13"><a href="#">View Driver</a></div>
                                        </div>
                                        <div class="cu-bid_status">
                                            <button class="btn btn-default"><img src="<?= Yii::$app->request->baseUrl; ?>/images/cancel.png"/></button>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center cu-bid-box">
                                        <div class="avatar avatar-image">
                                            <img src="<?= Yii::$app->request->baseUrl; ?>/images/app-icon.png" alt="">
                                        </div>
                                        <div class="m-l-10">
                                            <div class="m-b-0 text-dark font-weight-semibold">Marshall Nichols (Datson Go)</div>
                                            <div class="m-b-0 font-size-13">Micro, UP 32 HY 1234</div>
                                            <div class="m-b-0 opacity-07 font-size-13"><b>Bid Amount:</b> Rs. 275.00</div>
                                            <div class="m-b-0 opacity-07 font-size-13"><b>Arrival Time:</b> 10 minutes</div>
                                            <div class="m-b-0 opacity-07 font-size-13"><a href="#">View Driver</a></div>
                                        </div>
                                        <div class="cu-bid_status">
                                            <button class="btn btn-default"><img src="<?= Yii::$app->request->baseUrl; ?>/images/cancel.png"/></button>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center cu-bid-box">
                                        <div class="avatar avatar-image">
                                            <img src="<?= Yii::$app->request->baseUrl; ?>/images/app-icon.png" alt="">
                                        </div>
                                        <div class="m-l-10">
                                            <div class="m-b-0 text-dark font-weight-semibold">Marshall Nichols (Datson Go)</div>
                                            <div class="m-b-0 font-size-13">Micro, UP 32 HY 1234</div>
                                            <div class="m-b-0 opacity-07 font-size-13"><b>Bid Amount:</b> Rs. 275.00</div>
                                            <div class="m-b-0 opacity-07 font-size-13"><b>Arrival Time:</b> 10 minutes</div>
                                            <div class="m-b-0 opacity-07 font-size-13"><a href="#">View Driver</a></div>
                                        </div>
                                        <div class="cu-bid_status">
                                            <button class="btn btn-default"><img src="<?= Yii::$app->request->baseUrl; ?>/images/cancel.png"/></button>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center cu-bid-box">
                                        <div class="avatar avatar-image">
                                            <img src="<?= Yii::$app->request->baseUrl; ?>/images/app-icon.png" alt="">
                                        </div>
                                        <div class="m-l-10">
                                            <div class="m-b-0 text-dark font-weight-semibold">Marshall Nichols (Datson Go)</div>
                                            <div class="m-b-0 font-size-13">Micro, UP 32 HY 1234</div>
                                            <div class="m-b-0 opacity-07 font-size-13"><b>Bid Amount:</b> Rs. 275.00</div>
                                            <div class="m-b-0 opacity-07 font-size-13"><b>Arrival Time:</b> 10 minutes</div>
                                            <div class="m-b-0 opacity-07 font-size-13"><a href="#">View Driver</a></div>
                                        </div>
                                        <div class="cu-bid_status">
                                            <button class="btn btn-default"><img src="<?= Yii::$app->request->baseUrl; ?>/images/cancel.png"/></button>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="d-flex align-items-center cu-bid-box">
                                        <div class="avatar avatar-image">
                                            <img src="<?= Yii::$app->request->baseUrl; ?>/images/app-icon.png" alt="">
                                        </div>
                                        <div class="m-l-10">
                                            <div class="m-b-0 text-dark font-weight-semibold">Marshall Nichols (Datson Go)</div>
                                            <div class="m-b-0 font-size-13">Micro, UP 32 HY 1234</div>
                                            <div class="m-b-0 opacity-07 font-size-13"><b>Bid Amount:</b> Rs. 275.00</div>
                                            <div class="m-b-0 opacity-07 font-size-13"><b>Arrival Time:</b> 10 minutes</div>
                                            <div class="m-b-0 opacity-07 font-size-13"><a href="#">View Driver</a></div>
                                        </div>
                                        <div class="cu-bid_status">
                                            <button class="btn btn-default"><img src="<?= Yii::$app->request->baseUrl; ?>/images/cancel.png"/></button>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-sm-12 col-md-6">
                    <div class="card cu-card">
                        <div class="card-header"><h5 class="card-title cu_card-title">User - {USERNAME}</h5></div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-condensed">
                                <tr><th>User ID: </th><td>123456</td></tr>
                                <tr><th>Full name: </th><td>User 02</td></tr>
                                <tr><th>Phone no: </th><td>9876543210</td></tr>
                                <tr><th>Email id: </th><td>user02@gmail.com</td></tr>
                                <tr><td colspan="2"><button class="btn btn-default btn-sm">View user in detail</button></td></tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6">
                    <div class="card cu-card">
                        <div class="card-header"><h5 class="card-title cu_card-title">Assigned Driver - {DRIVERNAME}</h5></div>
                        <div class="card-body">
                            <table class="table table-bordered table-striped table-condensed">
                                <tr><th>Driver ID: </th><td>123456</td></tr>
                                <tr><th>Full name: </th><td>Driver 02</td></tr>
                                <tr><th>Phone no: </th><td>9876543210</td></tr>
                                <tr><th>Email id: </th><td>user02@gmail.com</td></tr>
                                <tr><td colspan="2"><button class="btn btn-default btn-sm">View driver in detail</button></td></tr>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="cuCancelBooking">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center">Cancel Booking - {BOOKINGID}</h5>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-md-12 form-group cu-form-group">
                            <label for="" class="">Penalty amount for user (Rs.):</label>
                            <input type="text" value="0.00" class="form-control" placeholder="Enter penalty amount for user">
                        </div>
                        <div class="col-md-12 form-group cu-form-group">
                            <label for="" class="">Penalty amount for driver (Rs.):</label>
                            <input type="text" value="0.00" class="form-control" placeholder="Enter penalty amount for user">
                        </div>
                        <div class="col-md-12 form-group cu-form-group">

                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Confirm</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $(".cancel-booking-btn").click(function () {
            $("#cuCancelBooking").modal('show');
        });
    });
</script>