<!doctype html>
<html lang="en">

  <?php $this->load->view('partial/header');?>

  <body>

    <?php $this->load->view('partial/navbar');?>
    
    <div class="container">
        <div class="row mb-5">
            <div class="col-12">
                <div class="float-right mt-5">
                    <button class="btn btn-outline-dark" style="display: block;" id="offbutton">Marker OFF</button>
                    <button class="btn btn-danger" style="display: none;" id="onbutton">Marker ON</button>
                </div>
                <h5 class="title mt-5">Maps</h5>
                <p class="subtitle mb-2 text-muted">Set the polygons show/hide by the right button</p>
                <div id="googleMap" style="width:100%;height:700px;"></div>
                
            </div>
        </div>
    </div>

    <?php $this->load->view('partial/footer');?>
    
    <script>
        $(document).ready(function() {
            var lingkungan = [];
            var infowindow = new google.maps.InfoWindow();
            var polygon, i, point;

            var mapProp= {
                center:new google.maps.LatLng(1.5441505,124.8121588),
                zoom:12,
                styles: [{"featureType":"administrative","elementType":"labels.text.fill","stylers":[{"color":"#444444"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels.text","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#dbdbdb"},{"visibility":"on"}]}]
            };
        
            var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

            function clearOverlays() {
                for (var i = 0; i < lingkungan.length; i++ ) {
                  	lingkungan[i].setMap(null);
                }
                lingkungan.length = 0;
            }

            $('#offbutton').on('click', function (){                
                $.ajax({
                    url : "<?php echo site_url('/home/get_data')?>",
                    type: "GET",
                    dataType: "JSON",
                    beforeSend :function () {
                        swal({
                            title: 'Waiting',
                            content: 'Processing data',
                            allowOutsideClick: false,
                            onOpen: () => {
                                swal.showLoading()
                            }
                        })      
                    },
                    success: function(data)
                    {

						$.each(data.location, function(indx, valx) {
							$.each(data.polygon[valx.location_id], function(indy, valy) {
								const path = [];

								$.each(valy, function(indz, valz) {
									var point = new google.maps.LatLng(valz.lingkungan_latitude, valz.lingkungan_longitude);
									path.push(point);

								});

								const polygon = new google.maps.Polygon({
									paths: path,
									strokeColor: "#FF0000",
									strokeOpacity: 0.8,
									strokeWeight: 2,
									fillColor: "#FF0000",
									fillOpacity: 0.09,
								});
								polygon.setMap(map);
								lingkungan.push(polygon);


							});
						});

                        
                        $('[id="offbutton"]').hide();
                        $('[id="onbutton"]').show();
                        swal({
                            title: 'Success',
                            text: 'All Marker is ON!',
                            icon: 'success',
                            buttons: false,
                            timer: 3000,
                        });
                        
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        swal({
                            title: 'Error',
                            text: 'Error get data from ajax!',
                            icon: 'error',
                            buttons: false
                        });
                    }
                });
            });

            $('#onbutton').on('click', function (){                
                swal({
                    title: 'All Marker is OFF',
                    text: 'Click the button to show all markers again!',
                    icon: 'success',
                    buttons: false,
                    timer: 3000,
                });

                clearOverlays()

                $('[id="onbutton"]').hide();
                $('[id="offbutton"]').show();
            });
        });
        


    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=myMap"></script>
    
  </body>
</html>
