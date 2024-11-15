<?php
session_start();
if (isset($_SESSION['logedin']) && $_SESSION['logedin']) {
  //if (isset($_SESSION['app']) && strcmp($_SESSION['app'], "miapp") === 0 &&   (strcmp($_SESSION['sid'], "012585") === 0 || strcmp($_SESSION['sid'], "010563") === 0)) {
  
  if (isset($_SESSION['app']) && strcmp($_SESSION['app'], "miapp") === 0 ) {
  } else {
    echo "<script type='text/javascript'>alert('App Update Ongoing. Please Try Again Later')</script>";
    echo '<script type="text/javascript"> document.location = "login.html";</script>';
  }
} else {
  header('Location: login.html');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="assets/brand/fiber_fiesta.png">

  <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/dist/css/custom.css">
  <!-- jquery CSS -->
  <link href="assets/dist/css/jquery-ui.css" rel="stylesheet">


  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


  <!-- Filepond stylesheet -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
  <link rel='stylesheet' href='https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css'>
  <link rel='stylesheet' href='https://unpkg.com/filepond/dist/filepond.min.css'> -->

  <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>

</head>

<body>
  <!-- Load FilePond library -->

  <!-- <script src='https://unpkg.com/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.min.js'></script>
  <script src='https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js'></script>
  <script src='https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.min.js'></script>
  <script src='https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js'></script>
  <script src='https://unpkg.com/filepond/dist/filepond.min.js'></script> -->



  <!-- <?php include 'header.php' ?> -->

  <div class="container">
    <!-- Main -->
    <main>
      <!-- Card -->
      <div class="card p-4 my-3">
        <div class="row">
          <div class="col-2">
            <?php  if(strcmp($_SESSION['leader'] ,"Y") != 0){ ?>
              <button class="btn float-left" id="refreshbtn"><i class="fa fa-refresh"></i></button>
           <?php } else{ ?> 
            <!-- <button class="btn float-left" id="refreshbtn"><i class="fa fa-refresh"></i></button> -->
            <div id="nav">
              <a class="dropdown-toggle" href="#"><i class="fa fa-bars"></i></a>
                <ul class="dropdown">
                  <li><a href="#" id="refreshbtn" >Refresh</a></li>
                  <br/>
                  <li><a href="#" id="myteambtn">My Team</a></li>
                </ul>
            </div>
          <?php } ?>
            
          </div>
          <div class="col-8"></div>
          <div class="col-2">
            <button class="btn float-right" id="exitbtn"><i class="fa fa-sign-out "></i></button>
          </div>
        </div>
        <div class="row g-3">
          <h3>Add Customer Record</h3>
        </div>
        <form enctype="multipart/form-data" id="upload_form" method="POST" action="getdata.php?action=saverec" >
          logged in as <lable ><?php  echo $_SESSION['sid']; ?></lable>
          <div class="row ">
            <div class="col-sm-12 d-flex justify-content-center">
              <input type="button" class="btn btn-primary btn-sm float-middle" id="gpsbtn" value="Get Location">
              <input type="text" id="fflat" name="fflat" class="form-control" hidden />
              <input type="text" id="fflon" name="fflon" class="form-control" hidden />
              <input type="text" id="serviceno"  name="serviceno" class="form-control" hidden value="<?php  echo $_SESSION['sid']; ?>" />
            </div>
          </div>

          <br />

          <div id="hidediv" >
         

            <div class="row">
              <div class="col-12">
                <label for="custp" class="form-label" style="font-weight: bold;">SLT - Existing Customer</label>
                <div class="input-group">
                  <div class="row">
                    <!-- <div class="col-3"><input type="number" class="form-control" disabled value="011"> </div>
                    <div class="col-9"> -->
                      <input type="number" name="ffvoice" id="ffvoice" maxlength="10" minlength="10"   oninput="javascript: if (this.value.length > this.maxLength) {this.value = this.value.slice(0, this.maxLength); } else if(this.value.length == this.maxLength) { document.getElementById('ffvoice').style.backgroundColor = 'white'; getservices(); } else if(this.value.length < this.maxLength &&  this.value.length > 0) {document.getElementById('ffvoice').style.backgroundColor = '#E69F9F';}" class="form-control">
                      <input type="text" id="ffcr" name="ffcr" class="form-control" hidden />
                      <input type="text" id="ffacc" name="ffacc" class="form-control" hidden />
                    <!-- </div> -->
                  </div>
                </div>
              </div>
            </div>

            <br />

            <div class="row">
              <div class="col-12">
                <label for="services" class="form-label" style="font-weight: bold;">SLT – Existing Services</label>
                <div class="input-group">
                  <table class="table">
                    <thead>
                      <tr>
                        <td>Service</td>
                        <td>Type</td>
                        <td>Satisfaction</td>
                      </tr>
                    </thead>
                    <tbody id="services">
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <br />

            <div class="row">
              <div class="col-12">
                <label for="custp" class="form-label" style="font-weight: bold;">Other Services</label>
             
                  <div class="row">
                  <div class="col-6">
                    <div class="form-check check-box1">
                      <input class="form-check-input" type="checkbox" value=" D-TV" id="othersv0" name="othersv[]">
                      <label class="form-check-label" for="flexCheckDefault">
                        D-TV
                      </label>
                    </div>

                    <div class="form-check check-box1">
                      <input class="form-check-input" type="checkbox" value="D-BB" id="othersv1" name="othersv[]">
                      <label class="form-check-label" for="flexCheckChecked">
                        D-BB
                      </label>
                    </div>


                    <div class="form-check check-box1">
                      <input class="form-check-input" type="checkbox" value="D-TV & D-BB" id="othersv2" name="othersv[]" >
                      <label class="form-check-label" for="flexCheckChecked">
                        D-TV & D-BB
                      </label>
                    </div>
                    
                  </div>


                  <div class="col-6">
                   

                  <div class="form-check check-box1">
                      <input class="form-check-input" type="checkbox" value="SAT TV" id="othersv3" name="othersv[]" >
                      <label class="form-check-label" for="flexCheckChecked">
                        SAT TV
                      </label>
                    </div>


                    <div class="form-check check-box1">
                      <input class="form-check-input" type="checkbox" value="Other" id="othersv4" name="othersv[]" >
                      <label class="form-check-label" for="flexCheckChecked">
                        Other
                      </label>
                    </div>
                    
                  </div>

                  </div>
              </div>
            </div>
            <hr/>

            <br/>

            <div class="row">
              <div class="col-12">
                <label for="fdp" class="form-label" style="font-weight: bold;">Nearest FDP</label>
                <div class="input-group">
                  <!-- <input type="text" list="fdplist" id="ffdp" name="ffdp" class="form-control" />
                  <datalist id="fdplist">
                  </datalist> -->
                  <select id="ffdp" name="ffdp" class="form-control" required>

                  </select>
                </div>
              </div>
            </div>

            <br />

            <div class="row">
              <div class="col-12">
                <label for="custp" class="form-label" style="font-weight: bold;">Customer Mobile</label>
                <div class="input-group">
                  <div class="row">
                    <div class="col-3"><input type="number" class="form-control" disabled value="07"> </div>
                    <div class="col-9">
                      <input type="number" name="ffmob" id="ffmob" maxlength="8" class="form-control" oninput="javascript: if (this.value.length > this.maxLength) {this.value = this.value.slice(0, this.maxLength); } else if(this.value.length == this.maxLength) { document.getElementById('ffmob').style.backgroundColor = 'white'; getservices(); } else if(this.value.length < this.maxLength &&  this.value.length > 0) {document.getElementById('ffmob').style.backgroundColor = '#E69F9F';}">
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <br />

            <div class="row">
              <div class="col-6">
                <div class="form-check check-box">
                  <input class="form-check-input" type="radio" name="ffcuscat" id="exampleRadios11" value="Residential">
                  <label class="form-check-label" for="exampleRadios11">
                    Residential
                  </label>
                </div>
                <div class="form-check check-box">
                  <input class="form-check-input" type="radio" name="ffcuscat" id="exampleRadios22" value="Business">
                  <label class="form-check-label" for="exampleRadios22">
                    Business
                  </label>
                </div>
              </div>
              <div class="col-6">
                <div class="form-check check-box">
                  <input class="form-check-input" type="radio" name="ffcat" id="exampleRadios1" value="Closed Sale">
                  <label class="form-check-label" for="exampleRadios1">
                    Closed Sale
                  </label>
                </div>
                <div class="form-check check-box">
                  <input class="form-check-input" type="radio" name="ffcat" id="exampleRadios2" value="Future Sale">
                  <label class="form-check-label" for="exampleRadios2">
                    Future Sale
                  </label>
                </div>
                <div class="form-check check-box">
                  <input class="form-check-input" type="radio" name="ffcat" id="exampleRadios3" value="Not Interested">
                  <label class="form-check-label" for="exampleRadios3">
                    Not Interested
                  </label>
                </div>
              </div>
            </div>

            <br />

              <div class="row">
                <div class="col-12">
                  <label for="comment" class="form-label" style="font-weight: bold;">Comment</label>
                  <div class="input-group">
                    <div class="row">
                    <textarea  cols="40" id="commentx"  name="commentx" rows="5"></textarea>
                    </div>
                  </div>
                </div>
              </div>


            <div class="row ">
              <div class="col-12">
                <br />
                <input type="submit" class="btn btn-primary btn-sm float-end" id="searchbtn" name="mysubmit" value="Submit">
              </div>
            </div>

          </div>
        </form>
      </div>
      <!-- End Card -->

  
      <div id="myModal" class="modal">
      <div class="modal-content" >
        <span class="close">&times;</span>
        <div id="map" style="width: 600px; height: 650px;"></div>
      </div>

      </div> 


    </main>
  </div>


  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASK8AY8h8GMLUtMg2ac01RbpL1m2bVV5w&libraries=drawing&callback=initMap">
	</script>

  <!-- OpenLayers Map -->
  <!-- <script src="https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v5.3.0/build/ol.js"></script>
  <link rel="stylesheet" href="https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v5.3.0/css/ol.css" type="text/css"> -->




  <!-- jQuery -->
  <script src="assets/dist/js/jquery-3.4.1.min.js"></script>
  <script src="assets/dist/js/jquery-ui.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script src="assets/dist/js/bootstrap.bundle.min.js"></script>

  <script src="assets/dist/js/custom.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


  <script>
    var myInterval;

  

    function getservices() {
      $.post("getdata.php?action=getsvlist", {
        no: $('#ffvoice').val()
      }, function(data) {
        if (data) {
          //console.log(data);
          var $div = $("#services");
          $div.empty();
          $.each(data, function() {
            $div.append("<tr><td>" + this.CIRT_DISPLAYNAME + "</td><td>" + this.CIRT_SERT_ABBREVIATION + "</td><td>" +
              "<div class=\"form-check form-check-inline\">" +
              "<input class=\"form-check-input\" type=\"radio\" name=\"" + this.CIRT_DISPLAYNAME + "#radio\" id=\"" + this.CIRT_DISPLAYNAME + "#radio\" value=\"Yes\" required>" +
              "<label class=\"form-check-label\" for=\"inlineRadio1\">Yes</label>" +
              "</div>" +
              "<div class=\"form-check form-check-inline\">" +
              "<input class=\"form-check-input\" type=\"radio\" name=\"" + this.CIRT_DISPLAYNAME + "#radio\" id=\"" + this.CIRT_DISPLAYNAME + "#radio\" value=\"No\" required>" +
              "<label class=\"form-check-label\" for=\"inlineRadio2\">No</label>" +
              "</div>" +
              "</td>" +
              "</tr>");


            $('#ffcr').val(this.CIRT_CUSR_ABBREVIATION);
            $('#ffacc').val(this.CIRT_ACCT_NUMBER);
          });
        }
      });
    }


    function xx(){
      $('#mysubmit').hide();
      return true;
    }

    function getfdp(userlat, userlatlon) {
      $('#fflat').val(userlat);
      $('#fflon').val(userlatlon);

      recorduserloc(userlat, userlatlon) ;

      Android.hideloading();
      $('#hidediv').show();

      $.post("getdata.php?action=getfdplistnew", {
        lat: userlat,
        lon: userlatlon
      }, function(data) {
        if (data) {
          var $dropdown = $("#ffdp");
          $dropdown.empty();
          $dropdown.append($("<option >").val("").text("Select or Type FDP Name"));
          $.each(data, function() {
            $dropdown.append($("<option >").val(this.LOCATION).text(this.LOCATION));
          });


        } else {
          $('#hidediv').hide();
          $('#gpsbtn').show();
        }
      });
    }


    function recorduserloc(userlat, userlatlon) {
      $.post("getdata.php?action=saveuserloc", {
        lat: userlat,
        lon: userlatlon
      }, function(data) {});
    }

    function initMap() {

        var marker;

        map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(7.927079, 80.761244),
          zoom: 7,
          // mapTypeId: 'satellite'
        });


       
}


function getteamloc() {

      $.post("getdata.php?action=getteam", {
      }, function(data) {
        console.log(data.length);
        if (data) {
          $.each(data, function(x) {
            
            var pinColor = "#FF8C00";

              if (parseInt(data[x].UTIME) > 60) {

                pinColor = '#FF0000';

              } else if (parseInt(data[x].UTIME) < 12) {

                pinColor = '#00FF00' ;

              } else {

                pinColor = '#FFFF00';

              }

            var latLng = new google.maps.LatLng(data[x].XLAT, data[x].XLON);
            console.log(x)

					var marker = new google.maps.Marker({
						position: latLng,
						map: map,
						//icon: 'img/EXFDP.png',
						title: data[x].USR_ID,
					//  icon: pinImage,

						icon: {
							path: "M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z",
							fillColor: pinColor,
							fillOpacity: .9,
							anchor: new google.maps.Point(0, 0),
							strokeWeight: 0,
							scale: 0.03
						},
						//shadow: pinShadow
					});

         

          var details = '<!DOCTYPE html>' +
						'<html>' +
						'<head>' +
						'<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">' +
						'</head>' +
						'<body>' +
						'<table class="table table-borderless" style="width:100%">' +
						'<tr>' +
						'<td><b>Captured User</b></td>' +
						'<td>' + data[x].USR_ID +'</td>' +
						'</tr>' +						
						'</table>' +
						'</body>' +
						'</html>';

					bindInfoWindow(marker, map, new google.maps.InfoWindow(), details);

          });


        } 
      });
    }


    function bindInfoWindow(marker, map, infowindow, strDescription) {
				google.maps.event.addListener(marker, 'click', function() {
					infowindow.setContent(strDescription);
					infowindow.open(map, marker);
				});
			}

    $(document).ready(function() {


//       var attribution = new ol.control.Attribution({
//      collapsible: false
//  });

//  var map = new ol.Map({
//      controls: ol.control.defaults({attribution: false}).extend([attribution]),
//      layers: [
//          new ol.layer.Tile({
//              source: new ol.source.OSM({
//                  url: 'https://tile.openstreetmap.be/osmbe/{z}/{x}/{y}.png',
//                  attributions: [ ol.source.OSM.ATTRIBUTION, 'Tiles courtesy of <a href="https://geo6.be/">GEO-6</a>' ],
//                  maxZoom: 18
//              })
//          })
//      ],
//      target: 'map',
//      view: new ol.View({
//          center: ol.proj.fromLonLat([4.35247, 50.84673]),
//          maxZoom: 18,
//          zoom: 12
//      })
//  });
 

      $('.dropdown-toggle').click(function() { $(this).next('.dropdown').slideToggle();
      });

      $(document).click(function(e) 
      { 
      var target = e.target; 
      if (!$(target).is('.dropdown-toggle') && !$(target).parents().is('.dropdown-toggle')) 
      //{ $('.dropdown').hide(); }
        { $('.dropdown').slideUp(); }
      });
      

      $("#ffdp").select2({
        tags: true
      });

      $('#hidediv').hide();

      $('#gpsbtn').click(function() {
        $('#gpsbtn').hide();
        Android.showloading();
        Android.getcuslocation();
      });

      $('#refreshbtn').click(function() {            
       clearInterval(myInterval);
       location.reload();              
      });

      $('#exitbtn').click(function() {
        clearInterval(myInterval);
        window.location.href = "logout.php";
      });

     
      $('#myteambtn').click(function() {      
        getteamloc();
        document.getElementById("myModal").style.display = "block";
      });

      myInterval = setInterval(function() {
        Android.getuserlocation();
      }, 300000);


      // the modal
      var modal = document.getElementById("myModal");
      var span = document.getElementsByClassName("close")[0];

      span.onclick = function() {
        modal.style.display = "none";
      }
      window.onclick = function(event) {
        if (event.target == modal) {
          modal.style.display = "none";
        }
      }

    });
  </script>

</body>

</html>