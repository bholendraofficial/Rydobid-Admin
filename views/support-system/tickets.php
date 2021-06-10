<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between m-b-15">
            <h4 class="m-b-0">Manage - Support System</h4>
            <div class="card-toolbar">
                <ul>
                    <li>
                        <a href="<?= yii\helpers\Url::to(["/support-system/search"]); ?>" class="btn btn-warning m-r-5">
                            <i class="anticon anticon-search m-r-5"></i>
                            <span>Search by Ticket ID</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <table id="data-table" class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Priority</th>
                    <th>Title</th>
                    <th>User</th>
                    <th>Booking</th>
                    <th>Assigned Employee</th>
                    <th>Time Created</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td><span class="badge badge-danger cu-badge">High</span></td>
                    <td><span class="badge badge-secondary cu-badge">New</span>&nbsp;Cab driver is conning</td>
                    <td><a href="<?= yii\helpers\Url::to(["/user/search-result"]); ?>">{USERNAME}</a></td>
                    <td><a href="<?= yii\helpers\Url::to(["/booking/view"]); ?>">{BOOKING_ID}</a></td>
                    <td><a href="<?= yii\helpers\Url::to(["/admin/view"]); ?>">{EMPLOYEE_VIEW}</a></td>
                    <td>01:00 AM 19-04-2020</td>
                    <td>
                        <a href="<?= yii\helpers\Url::to(["/support-system/ticket-view"]); ?>" class="btn btn-secondary btn-sm m-r-5 cu-grid-btn">
                            <i class="anticon anticon-eye"></i> <span>View</span>
                        </a>
                        <a href="javascript:void(0);" class="btn btn-danger btn-sm m-r-5 cu-grid-btn">
                            <i class="anticon anticon-bell"></i> <span>Mark Close</span>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#data-table').DataTable({
            "scrollX": true,
            "bAutoWidth": false,
            "ordering": false
        });
    });
</script>