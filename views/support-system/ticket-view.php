<style>
    .cu_user-msg{
        text-align: left;
        background-color: #EEEEEE;
    }
    .cu_admin-msg{
        text-align: right;
    }
    .cu-message_group{
        max-height: 300px;
        overflow-y: scroll;
        font-size: 12px;
    }
</style>
<div class="card cu-card">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between m-b-15">
            <h4 class="m-b-0">Cab driver is conning us to pay extra income [BOOKING ID: 123456]</h4>
            <div class="card-toolbar">
                <ul>
                    <li><a class="btn btn-default" href="javascript:void(0)"> View booking </a></li>
                    <li><a class="btn btn-primary" href="javascript:void(0)"> Add money (Refund)</a></li>
                    <li><a class="btn btn-danger" href="javascript:void(0)"> Cancel booking</a></li>
                </ul>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="card cu-card">
                    <div class="card-header"><h5 class="card-title cu_card-title">Ticket/User - Sample User 01</h5></div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-condensed">
                            <tr><th>Ticket Category: </th><td>Payment Issue</td></tr>
                            <tr><th>Ticket ID: </th><td>123456</td></tr>
                            <tr><th>Ticket Created At: </th><td>09:44 AM 19-01-2020</td></tr>
                            <tr><th>User ID: </th><td>123456</td></tr>
                            <tr><th>Full Name: </th><td>User 02</td></tr>
                            <tr><th>Phone No: </th><td>986543210</td></tr>
                            <tr><th>Email ID: </th><td>user02@gmail.com</td></tr>
                        </table>
                    </div>
                </div>
            </div>            
            <div class="col-sm-12 col-md-6">
                <div class="card cu-card">
                    <div class="card-header"><h5 class="card-title cu_card-title">Booking - Sample User 01</h5></div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-condensed">
                            <tr><th>Ride Type: </th><td>Daily</td></tr>
                            <tr><th>Booking ID: </th><td>123456</td></tr>
                            <tr><th>Pickup Location: </th><td>Indira Karan Plaza, Lalbagh, 226010</td></tr>
                            <tr><th>Drop Location: </th><td>Sahara Ganj Mall, Hazratganj, 226010</td></tr>
                            <tr><th>Billed/Estimated Amount: </th><td>Rs. 250</td></tr>
                            <tr><th>Driver Assigned: </th><td><a href="#">Driver 01</a></td></tr>
                            <tr><td colspan="2"><button class="btn btn-default btn-sm">Details booking</button></td></tr>
                        </table>
                    </div>
                </div>
            </div>            
        </div>

        <div class="row">
            <div class="col-sm-12">
                <ul class="list-group cu-message_group">
                    <li class="list-group-item cu_user-msg">
                        <b>Message:</b> this is the sample message for ticket 01<br/>
                        <b>Attachment:</b> <a href="#">File 01</a>, <a href="#">File 02</a><br/>
                        <b>-- <a href="#">User 01 [09:44 AM 19-01-2020] --</a></b>
                    </li>
                    <li class="list-group-item cu_admin-msg">
                        <b>Message:</b> this is the sample message from admin for ticket 01<br/>
                        <b>Attachment:</b> <a href="#">File 01</a>, <a href="#">File 02</a><br/>
                        <b>-- <a href="#">Admin 01 [09:50 AM 19-01-2020] --</a></b>
                    </li>
                    <li class="list-group-item cu_user-msg">
                        <b>Message:</b> this is the sample message for ticket 01<br/>
                        <b>-- <a href="#">User 01 [10:05 AM 19-01-2020] --</a></b>
                    </li>
                    <li class="list-group-item cu_user-msg">
                        <b>Message:</b> this is the sample message for ticket 01<br/>
                        <b>-- <a href="#">User 01 [10:09 AM 19-01-2020] --</a></b>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="card cu-card">
    <div class="card-header cu_card-title"><h5 class="card-title">Add Reply</h5></div>
    <div class="card-body">
        <form>
            <div class="row">
                <div class="col-md-12 form-group cu-form-group">
                    <label for="" class="">Enter message</label>
                    <textarea class="form-control" rows="3" cols="5" placeholder="Enter answer for ticket"></textarea>
                </div>
            </div>
            <div class="form-group text-right row">
                <div class="col-sm-12"><button type="button" class="btn btn-primary m-r-5"><i class="anticon anticon-like"></i> <span>Reply to ticket</span></button></div>
            </div>
        </form>
    </div>
</div>