<style>
    #map {
        height: 625px;
    }
</style>
<div class="row">
    <div class="col-sm-12 col-md-4">
        <div class="card cu-card">
            <div class="card-header">
                <h4 class="card-title text-center">Booking Information</h4>
            </div>
            <table class="card-body table table-bordered table-striped table-condensed">
                <tr><th>Booking ID: </th><td>123456</td></tr>
                <tr><th>User ID: </th><td>123456</td></tr>
                <tr><th>Full name: </th><td>User 02</td></tr>
                <tr><th>Phone no: </th><td>9876543210</td></tr>
                <tr><th>Email id: </th><td>user02@gmail.com</td></tr>
                <tr><th>Ride type: </th><td> Daily</td></tr>
                <tr><th>Pickup location: </th><td> Alambagh, Lucknow, 226001</td></tr>
                <tr><th>Drop location: </th><td> Saharaganj Mall, Lucknow, 226010</td></tr>
                <tr><th>Cab type: </th><td> Micro</td></tr>
                <tr><th>Bid time: </th><td> 10 minutes</td></tr>
                <tr><th>Payment mode: </th><td> Cash</td></tr>
                <tr><th>Billed amount: </th><td> Rs. 290</td></tr>
                <tr><th>Assigned driver: </th><td> <a href="#">Driver 01</a></td></tr>
                <tr><th>Invoice: </th><td> <a href="#">Download</a></td></tr>
                <tr><th>Status: </th><td> <b>Bidding In-progress</b></td></tr>
                <tr><td colspan="2"><button class="btn btn-default btn-sm">View driver in detail</button></td></tr>
            </table>
        </div>
    </div>
    <div class="col-sm-12 col-md-8">
        <div id="map" style="width:100%;"></div>
    </div>
</div>
<script>
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 26.8467, lng: 80.9462},
            zoom: 13
        });
        var drop = new google.maps.Marker({position: {lat: 26.8542, lng: 80.9448}, map: map});
        var pickup = new google.maps.Marker({position: {lat: 26.8127, lng: 80.9013}, map: map});
        var user = new google.maps.Marker({position: {lat: 26.8127, lng: 80.9013}, map: map, icon: '<?= Yii::$app->request->baseUrl; ?>/images/teamwork.png'});
        var cab = new google.maps.Marker({position: {lat: 26.8323, lng: 80.9214}, map: map, icon: '<?= Yii::$app->request->baseUrl; ?>/images/taxi.png'});
    }
    //setInterval(initMap(), 30000);
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0NZ6OBuL8cW5bfI9a8Auw3Kd4VGnqs5E&callback=initMap" async defer></script>