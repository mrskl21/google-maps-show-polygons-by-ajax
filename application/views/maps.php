<!doctype html>
<html lang="en">

  <?php $this->load->view('partial/header');?>

  <body>

    <?php $this->load->view('partial/navbar');?>
    
    <div class="container">
        <div class="row mb-5">
            <div class="col-12">
                <h5 class="title mt-5">Maps</h5>
                <p class="subtitle mb-2 text-muted">Zoom to reveal the markers</p>
                <div id="googleMap" style="width:100%;height:700px;"></div>
                
            </div>
            <div class="col-12">
                <h5 class="title mt-5">Table</h5>
                <button href="" class="btn btn-danger float-right" data-toggle="modal" data-target="#exampleModal">Upload Data</button>
                <p class="subtitle mb-2 text-muted">Total <?= number_format(count($data))?> record(s)</p>
                <div class="table-responsive mt-5">
                    <table class="table table-sm text-nowrap" id="myTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID SURVEI</th>
                                <th>ID PJU</th>
                                <th>ULP</th>
                                <th>PEMDA</th>
                                <th>KECAMATAN</th>
                                <th>LATITUDE</th>
                                <th>LONGITUDE</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no=1;foreach ($data as $d):?>
                            <tr>
                                <td><?=$no++;?></td>
                                <td><?=$d->id_survey;?></td>
                                <td><?=$d->id_pju;?></td>
                                <td><?=$d->ulp;?></td>
                                <td><?=$d->pemda;?></td>
                                <td><?=$d->kecamatan;?></i></td>
                                <td><?=$d->lat;?></td>
                                <td><?=$d->lng;?></td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Upload File</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="<?= base_url();?>home/upload" enctype="multipart/form-data" class="form" method="POST">
              <div class="modal-body">
                <div class="form-group">
                    <label for="file">File</label>
                    <input id="file" class="form-control" type="file" name="file" required>
                    <small class="text-danger">extention .xls .xlxs .csv only</small>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Save changes</button>
              </div>
          </form>
        </div>
      </div>
    </div>
    
    <script>
        function myMap() {
            var points = [
                <?php 

                    foreach ($data as $d) {
                        echo "['".$d->id_survey."',".$d->lat.",".$d->lng.",'".$d->pemda."','".$d->kecamatan."'],";
                    }
                ?>
            ];

            var mapProp= {
                center:new google.maps.LatLng(1.5441505,124.8121588),
                zoom:12,
                styles: [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels.text","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#dbdbdb"},{"visibility":"on"}]}]
            };

            var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

            var infowindow = new google.maps.InfoWindow();
            var marker, i;
            var markers = [];

            for (i = 0; i < points.length; i++) {  
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(points[i][1], points[i][2]),
                    icon: "<?=base_url()?>assets/images/marker/marker.png",
                    map: map,
                    visible: false,
                    zIndex: 10
                });
                markers.push(marker);

                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                    const content = '<address><strong>' + points[i][0] + '</strong><br>Loc : ' + points[i][1] + ',' + points[i][2] + '<br>Pemda : ' + points[i][3] + '<br>Kecamatan : ' + points[i][4];
                    infowindow.setContent(content);
                    infowindow.open(map, marker);
                    }
                })(marker, i));
            }

            google.maps.event.addListener(map, 'zoom_changed', function() {
                var zoom = map.getZoom();
                // iterate over markers and call setVisible
                for (i = 0; i < points.length; i++) {
                    if(zoom >= 16){
                        markers[i].setVisible(true);
                    }
                    if(zoom < 16){
                        markers[i].setVisible(false);
                    }
                }
            });
        }

    </script>
    <!-- <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=myMap"></script> -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBk7maZZbWS4I3odR82HiAUoJDuGbzi-iw&callback=myMap"></script>

    <?php $this->load->view('partial/footer');?>
    
  </body>
</html>