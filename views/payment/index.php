<style>
    @media only screen and (max-width: 768px) {
        .card-toolbar{
            display: none;
        }
    }
</style>
<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between m-b-15">
            <h4 class="m-b-0">Payment & Transactions</h4>
            <div class="card-toolbar">
                <ul>
                    <li>
                        <a href="<?= yii\helpers\Url::to(["/payment/payment-credit"]); ?>" class="btn btn-success m-r-5">
                            <i class="anticon anticon-plus-circle m-r-5"></i><span>Credit wallet(Manual)</span>
                        </a>
                    </li>
                    <!--<li>
                        <a href="<?= yii\helpers\Url::to(["/payment/settlement"]); ?>" class="btn btn-success m-r-5">
                            <i class="anticon anticon-search m-r-5"></i><span>View all Settlements</span>
                        </a>
                    </li>-->
                    <li>
                        <a href="<?= yii\helpers\Url::to(["/payment/search"]); ?>" class="btn btn-success m-r-5">
                            <i class="anticon anticon-search m-r-5"></i><span>Search by Transaction ID</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <table id="data-table" class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Transaction ID</th>
                    <th>Category</th>
                    <th>Type(DR/CR)</th>
                    <th>Transaction Description</th>
                    <th>Amount (Rs.)</th>
                    <th>User</th>
                    <th>Transaction Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td><a href="#">TC-0004-160420</a></td>
                    <td>RydoBid Commission</td>
                    <td><span class="badge badge-primary cu-badge">Debit</span></td>
                    <td>
                        (<i class="anticon anticon-minus"></i>) Fund transferred to 
                        "Master Admin Wallet[<a href="#">TC-0001-160420</a>]" 
                        from "Driver 02[<a href="#">TC-0003-160420</a>]"
                    </td>
                    <td>Rs. 250</td>
                    <td><a href="#">Driver 02</a></td>
                    <td>04:00 AM 19-04-2020</td>
                    <td>
                        <a href="<?= yii\helpers\Url::to(["/payment/payment-view"]); ?>" class="btn btn-warning btn-sm m-r-5 cu-grid-btn">
                            <i class="anticon anticon-eye"></i> <span>View</span>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>1</td>
                    <td><a href="#">TC-0004-160420</a></td>
                    <td>Income earned</td>
                    <td><span class="badge badge-success cu-badge">Credit</span></td>
                    <td>
                        (<i class="anticon anticon-plus"></i>) Fund transferred to 
                        "Master Admin Wallet[<a href="#">TC-0001-160420</a>]" 
                        from "Driver 02[<a href="#">TC-0003-160420</a>]"
                    </td>
                    <td>Rs. 250</td>
                    <td><a href="#">Driver 02</a></td>
                    <td>04:00 AM 19-04-2020</td>
                    <td>
                        <a href="<?= yii\helpers\Url::to(["/payment/payment-view"]); ?>" class="btn btn-warning btn-sm m-r-5 cu-grid-btn">
                            <i class="anticon anticon-eye"></i> <span>View</span>
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
            "ordering": false,
            dom: 'Bfrtip',
            buttons: [
                {extend: 'copy', className: 'btn btn-sm btn-primary'},
                {extend: 'csv', className: 'btn btn-sm btn-primary'},
                {extend: 'excel', className: 'btn btn-sm btn-primary'},
                {extend: 'pdf', className: 'btn btn-sm btn-primary'},
                {extend: 'print', className: 'btn btn-sm btn-primary'},
            ]
        });
    });
</script>