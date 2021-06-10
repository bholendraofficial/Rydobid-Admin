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
            <h4 class="m-b-0"><?= \Yii::$app->params["page_meta_data"]["page_title"]; ?></h4>
            <div class="card-toolbar">
                <ul>
                    <li>
                        <a href="<?= yii\helpers\Url::to(["/role-access/add"]); ?>" class="btn btn-success m-r-5">
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
                    <th>Role Title</th>
                    <th>Description</th>
                    <th>No. of User</th>
                    <th>Registered At</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Master Admin</td>
                    <td>Role belongs to "Master Admin"</td>
                    <td><span class="badge badge-primary cu-badge">25</span></td>
                    <td>09:55 AM 19-04-2020</td>
                    <td><div class="switch m-r-10"><input type="checkbox" id="s1" checked=""><label for="s1"></label></div></td>
                    <td>
                        <a href="javascript:void(0);" class="btn btn-secondary btn-sm m-r-5 cu-grid-btn">
                            <i class="anticon anticon-form"></i> <span>View and Modify access</span>
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