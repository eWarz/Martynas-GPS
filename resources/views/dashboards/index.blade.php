<div class="row">
	<div class="span12" style="height:550px;">
		<div id="map-canvas-dashboard-index" style="width:100%;height:100%;">Kraunamas Žemėlapis... </div>
	</div>
<div class="full-map-category-list" id="full-map-category-list" style="display:none;">
<div class="">
<strong>Filter by category</strong> <?php echo $this->Html->link('Back to dashboard',array('controller'=>'dashboards','action'=>'index'),array('class'=>'pull-right')); ?>

</div>
<div class="full-map-category-list-container">
<?php $i=0; foreach($locationCategories as $locationCategory): ?>
<?php $stripcolor = "background-color:#f5f5f5;"; ?>
<div style="<?php echo $stripcolor; ?>">
<label class="checkbox" >
<input class="select-category" style="margin-left:0px;" type="checkbox" value="<?php echo $i++; ?>"  checked="checked" /><?php echo $locationCategory[0]; ?></label>
</div>
<?php endforeach; ?>
</div>
</div>

<script>
var map;
var markersArray = [];
var infowindowArray = [];
var cindex = <?php echo json_encode($cindex); ?>;
var sizeDensity = <?php echo json_encode($sizeDensity); ?>;
var showDensity = 0;
var locationCategories = <?php echo json_encode($locationCategories); ?>;
function initialize() {
	// Enable the visual refresh
	google.maps.visualRefresh = true;
	
	  var mapOptions = {
	    zoom: <?php echo $gmap_scale; ?>,
	    center: new google.maps.LatLng(<?php echo $center_latitude; ?>, <?php echo $center_longitude; ?>),
	    mapTypeId: google.maps.MapTypeId.ROADMAP
	  };
	  map = new google.maps.Map(document.getElementById("map-canvas-dashboard-index"), mapOptions);

	  setMarkers(locationCategories);

	  map.controls[google.maps.ControlPosition.RIGHT_TOP].push(
			  document.getElementById('full-map-category-list'));
	}

	function loadScript() {
	  var script = document.createElement("script");
	  script.type = "text/javascript";
	  script.src = "//maps.googleapis.com/maps/api/js?key=<?php echo $gmap_key; ?>&sensor=false&callback=initialize";
	  document.body.appendChild(script);

	 
	}

	function setMarkers(locationCategories) {
		var m = 0;
		  // Add markers to the map
		  for (var i = 0; i < locationCategories.length; i++) {

		     var pinColor = locationCategories[i][2];
		     var w,h;
		     if (showDensity) {
			     w = sizeDensity[m][0];
			     h = sizeDensity[m][1];
		     } else {
			     w = 21;
			     h = 34;
		     }
		     var pinImage = new google.maps.MarkerImage("//chart.googleapis.com/chart?chst=d_map_pin_letter&chld=%E2%80%A2|" + pinColor,
		         null, //new google.maps.Size(21, 34),
		         null, //new google.maps.Point(0,0),
		         null, //new google.maps.Point(10, 34)
		         new google.maps.Size(w, h) //10,17 - 63,102
	         );
	         
		    var categoryLocations = locationCategories[i][1];
		   // console.log(categoryLocations);
		    	for(var j = 0; j < categoryLocations.length; j++) {
			    	var location = categoryLocations[j];
			    	//console.log(location);
				    var myLatLng = new google.maps.LatLng(location.lat, location.lon);
				    
				    //console.log(m);
				    var marker = new google.maps.Marker({
				        position: myLatLng,
				        icon: pinImage,
				        map: map,
				        title: location.name
				    });
				    markersArray.push(marker);
				    
				    var infowindow = new google.maps.InfoWindow({
					    content:'<a href="'+location.url+'">'+location.name+'</a>'
						    });
				    infowindowArray.push(infowindow);
				    google.maps.event.addListener(marker, 'mouseover', infoCallback(infowindow,marker));
					m++;
		    	}//for j
		  }
		}//end of setMarker

		
	function infoCallback(infowindow,marker) {
		return function (){
			closeInfos();
        	infowindow.open(map, marker);
		};
    }
    
	function infoCloseCallback(infowindow) {
		return function(){
        infowindow.close();
		};
    }

    
	function closeInfos() {
		  if (infowindowArray) {
		    for (i in infowindowArray) {
		      infowindowArray[i].close();
		    }
		    //infowindowArray.length = 0;
		  }
		}
	//add marker
	function addMarker(location) {
	  marker = new google.maps.Marker({
	    position: location,
	    map: map
	  });
	  
	  markersArray.push(marker);
	}

	//delete markers
	function deleteOverlays() {
		  if (markersArray) {
		    for (i in markersArray) {
		      markersArray[i].setMap(null);
		    }
		    markersArray.length = 0;
		  }
		}

	//hide markers
	function hideMarkers(n) {
		  if (markersArray) {
		      markersArray[n].setVisible(false);
		      infowindowArray[n].close();
		  }
		}

	//show markers
	function showMarkers(n) {
		  if (markersArray) {
		      markersArray[n].setVisible(true);
		  }
		}
	window.onload = loadScript;

	$(".select-category").click(function(){
		var ci = $(this).val();
		if($(this).is(':checked')) {
			//show
			for (var i in cindex[ci]){
				k = cindex[ci][i];
				//console.log(k);
				showMarkers(k);
			}
		}
		else {
			//hide

			for (var i in cindex[ci]){
				k = cindex[ci][i];
				//console.log(k);
				hideMarkers(k);
			}
		}
		});

	$(".full-map-category-list").draggable({ snap: "#map-canvas-dashboard-index" });

	//-full screen stuff
	 function goFullscreen(id) {
   		 var element = document.getElementById(id);
	    if (element.mozRequestFullScreen) {
	      //fullscren mode in Firefox
	      element.mozRequestFullScreen();
	    } else if (element.webkitRequestFullScreen) {
     	 element.webkitRequestFullScreen();
  		 }
  	 	
  		};


  	$(document).on('webkitfullscreenchange mozfullscreenchange fullscreenchange',function(){
  		if (!document.fullscreenElement &&    // alternative standard method
  	  	      !document.mozFullScreenElement && !document.webkitFullscreenElement) {
  			$('#full-map-category-list').hide();
  		}
  		else {
  	  		//console.log('full screen');
  	  		$('#full-map-category-list').show();
  		}
  	  	});
	$("#click-full-map").click(function(){

		goFullscreen('map-canvas-dashboard-index');
		 
		});
</script>