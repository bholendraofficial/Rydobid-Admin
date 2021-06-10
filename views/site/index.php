<script src="<?= Yii::$app->request->baseUrl; ?>/themes/assets/vendors/chartist/chartist.min.js"></script>
<script src="<?= Yii::$app->request->baseUrl; ?>/themes/assets/js/pages/dashboard-crm.js"></script>
<div class="row">
    <div class="col-md-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="m-b-0">No. of users</p>
                        <h2 class="m-b-0"><span>---</span></h2>
                    </div>
                    <div class="avatar avatar-icon avatar-lg avatar-blue">
                        <i class="anticon anticon-usergroup-add"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="m-b-0">No. of rides</p>
                        <h2 class="m-b-0"><span>---</span></h2>
                    </div>
                    <div class="avatar avatar-icon avatar-lg avatar-cyan">
                        <i class="anticon anticon-sliders"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="m-b-0">No. of cancelled rides</p>
                        <h2 class="m-b-0"><span>---</span></h2>
                    </div>
                    <div class="avatar avatar-icon avatar-lg avatar-red">
                        <i class="anticon anticon-heat-map"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="m-b-0">No. of on-going rides</p>
                        <h2 class="m-b-0"><span>---</span></h2>
                    </div>
                    <div class="avatar avatar-icon avatar-lg avatar-gold">
                        <i class="anticon anticon-rise"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="m-b-0">No. of drivers</p>
                        <h2 class="m-b-0"><span>---</span></h2>
                    </div>
                    <div class="avatar avatar-icon avatar-lg avatar-blue">
                        <i class="anticon anticon-team"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="m-b-0">Suspending/pending</p>
                        <h2 class="m-b-0"><span>---</span></h2>
                    </div>
                    <div class="avatar avatar-icon avatar-lg avatar-cyan">
                        <i class="anticon anticon-car"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="m-b-0">Total earning</p>
                        <h2 class="m-b-0"><span>---</span></h2>
                    </div>
                    <div class="avatar avatar-icon avatar-lg avatar-red">
                        <i class="anticon anticon-audit"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="m-b-0">Total earning by drivers</p>
                        <h2 class="m-b-0"><span>---</span></h2>
                    </div>
                    <div class="avatar avatar-icon avatar-lg avatar-gold">
                        <i class="anticon anticon-gold"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="d-md-flex justify-content-between align-items-center">
                    <h5>Users - New Users v/s Date</h5>
                </div>
                <div class="m-t-50" style="height: 100%;width: 100%;">
                    <div class="ct-chart user-dbd"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="d-md-flex justify-content-between align-items-center">
                    <h5>Revenue - Earning v/s Date</h5>
                </div>
                <div class="m-t-50" style="height: 100%;width: 100%;">
                    <div class="ct-chart revenue-dbd"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="d-md-flex justify-content-between align-items-center">
                    <h5>Drivers - Drivers & Online Driver v/s Date</h5>
                </div>
                <div class="m-t-50" style="height: 100%;width: 100%;">
                    <div class="ct-chart driver-dbd"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="d-md-flex justify-content-between align-items-center">
                    <h5>Rides - Ride v/s Date</h5>
                </div>
                <div class="m-t-50" style="height: 100%;width: 100%;">
                    <div class="ct-chart ride-dbd"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Latest rides</h5>
                    <div>
                        <a href="javascript:void(0);" class="btn btn-sm btn-default">View All</a>
                    </div>
                </div>
                <div class="m-t-30">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" class="text-center">No results found!</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Latest users</h5>
                    <div>
                        <a href="javascript:void(0);" class="btn btn-sm btn-default">View All</a>
                    </div>
                </div>
                <div class="m-t-30">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Full name</th>
                                    <th>Phone no.</th>
                                    <th>Email id</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" class="text-center">No results found!</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    new Chartist.Line('.user-dbd', {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
        series: [
            [2, 11, 6, 8, 15],
            [2, 8, 3, 4, 9]
        ]
    }, {
        fullWidth: true,
        chartPadding: {
            right: 40
        }
    });

    new Chartist.Line('.driver-dbd', {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
        series: [
            [2, 11, 6, 8, 15],
            [1, 4, 10, 4, 13]
        ]
    }, {
        fullWidth: true,
        chartPadding: {
            right: 40
        }
    });

    new Chartist.Bar('.revenue-dbd', {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        series: [
            [5, 4, 3, 7, 5, 10, 3]
        ]
    }, {
        seriesBarDistance: 10,
        reverseData: true,
        horizontalBars: true,
        axisY: {
            offset: 70
        }
    });

    new Chartist.Line('.ride-dbd', {
        labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11],
        series: [
            [5, 9, 7, 8, 5, 3, 5, 4, 10, 11, 2]
        ]
    }, {
        low: 0,
        showArea: true
    });
</script>