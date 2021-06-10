<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center justify-content-between m-b-15">
            <h4 class="m-b-0"><?= \Yii::$app->params["page_meta_data"]["page_title"]; ?></h4>
            <div class="card-toolbar">
                <ul>
                    <li>
                        <a href="<?= yii\helpers\Url::to(["/admin/add"]); ?>" class="btn btn-success m-r-5">
                            <i class="anticon anticon-plus-circle m-r-5"></i> <span>Add</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <table id="data-table" class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Role</th>
                    <th>Image</th>
                    <th>Full Name</th>
                    <th>Email ID</th>
                    <th>Phone No.</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Registered date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td><a href="#">Master admin</a></td>
                    <td>
                        <div class="avatar avatar-lg avatar-image">
                            <img src="<?= Yii::$app->request->baseUrl; ?>/images/bala-img.jpg" style="max-width: 50px;"/>
                        </div>
                    </td>
                    <td>Balakrishna A.</td>
                    <td>admin@rydobid.xyz</td>
                    <td>9876543210</td>
                    <td>Near Alambagh ISBT, 226005</td>
                    <td>Lucknow</td>
                    <td>09:55 AM 19-04-2020</td>
                    <td><div class="switch m-r-10"><input type="checkbox" id="s1" checked=""><label for="s1"></label></div></td>
                    <td><a href="javascript:void(0);" class="btn btn-warning btn-sm m-r-5 cu-grid-btn"><i class="anticon anticon-edit"></i> <span>Edit</span></a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#data-table').DataTable({"scrollX": true, "ordering": false});
    });
</script>