<div class="row">
    <div class="col-sm-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><?= \Yii::$app->params["page_meta_data"]["page_title"]; ?></h4>
            </div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-md-12 form-group cu-form-group">
                            <label for="" class="">Role title: </label>
                            <input type="text" class="form-control" placeholder="Enter role title"/>
                        </div>
                        <div class="col-md-12 form-group cu-form-group">
                            <label for="" class="">Role description: </label>
                            <textarea class="form-control" rows="5" cols="10" placeholder="Enter role description"></textarea>
                        </div>
                        <div class="col-md-12 form-group cu-form-group">
                            <label for="" class="">Access rights: </label>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Create(Add)</th>
                                        <th>Read(View/Listing)</th>
                                        <th>Update(Edit)</th>
                                        <th>Delete(Delete/Restore)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $ModuleArray = [
                                        "Admin", "Cab Type", "Country", "State", "City", "Pincode", "Configure Variables", "Common Variables", "Promocode", "Driver & Cabs",
                                        "Registered User", "Bookings", "Track - Booking, Cab & Driver", "Payment & Transaction", "Reporting", "Tickets", "FAQ", "About Us - Content",
                                        "Terms & Conditions - Content", "Privacy Policy - Content", "Cancellation & Refund Policy", "Database Backup"
                                    ];
                                    foreach ($ModuleArray as $key => $value) {
                                        echo "<tr>";
                                        echo "<td>{$value}</td>";
                                        echo '<td><div class="checkbox"><input id="c1-' . $key . '" type="checkbox" checked=""><label for="c1-' . $key . '"></label></div></td>';
                                        echo '<td><div class="checkbox"><input id="c2-' . $key . '" type="checkbox"><label for="c2-' . $key . '"></label></div></td>';
                                        echo '<td><div class="checkbox"><input id="c3-' . $key . '" type="checkbox" checked=""><label for="c3-' . $key . '"></label></div></td>';
                                        echo '<td><div class="checkbox"><input id="c3-' . $key . '" type="checkbox"><label for="c4-' . $key . '"></label></div></td>';
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
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
    </div>
</div>