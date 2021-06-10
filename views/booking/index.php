<style>
    .cu-grid-btn{
        margin: 2px;
    }
</style>
<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between m-b-15">
            <h4 class="m-b-0">Manage - Booking</h4>
            <div class="card-toolbar">
                <ul>
                    <li>
                        <a href="<?= yii\helpers\Url::to(["/booking/search"]); ?>" class="btn btn-danger m-r-5">
                            <i class="anticon anticon-search m-r-5"></i>
                            <span>Search by Booking ID</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <table id="data-table" class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Booking ID</th>
                    <th>Pickup Location</th>
                    <th>Drop Location</th>
                    <th>User</th>
                    <th>Assigned Driver</th>
                    <th>Ride Type</th>
                    <th>Booking At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>234567</td>
                    <td>Alambagh, Lucknow, 226001</td>
                    <td>Saharaganj Mall, Lucknow, 226010</td>
                    <td><a href="#">{USERNAME}</a></td>
                    <td><a href="#">{DRIVERNAME}</a></td>
                    <td>Local</td>
                    <td>19-04-2020</td>
                    <td style="width:25%;">
                        <a href="#" class="btn btn-primary btn-sm m-r-5 cu-grid-btn">
                            <i class="anticon anticon-pushpin"></i> <span>Track Driver/User</span>
                        </a>
                        <a href="#" class="btn btn-secondary btn-sm m-r-5 cu-grid-btn">
                            <i class="anticon anticon-download"></i> <span>Download Invoice</span>
                        </a>
                        <a href="javascript:void(0);" class="btn btn-danger btn-sm m-r-5 cu-grid-btn cancel-booking-btn">
                            <i class="anticon anticon-close-circle"></i> <span>Cancel Booking</span>
                        </a>
                        <a href="<?= yii\helpers\Url::to(["/booking/search-result"]); ?>" class="btn btn-info btn-sm m-r-5 cu-grid-btn">
                            <i class="anticon anticon-eye"></i> <span>View Booking</span>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
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
        $('#data-table').DataTable({
            "scrollX": true,
            "bAutoWidth": false,
            "ordering": false
        });
        $(".cancel-booking-btn").click(function () {
            $("#cuCancelBooking").modal('show');
        });
    });
</script>