<div class="row">
	<div class="span6"">
		<div id="map-canvas-options" style="width:100%;height:550px;"></div>
	</div>
	<div class="span6">
		<?php echo $this->Form->create('Option',array('class'=>'form-horizontal','type'=>'file')); ?>
		<fieldset>
		<h5>Google Maps Nustatymai</h5>
		<?php echo $this->Form->input('gmap_key',array('type'=>'text','label'=>'Google Map Key')); ?>
		<?php echo $this->Form->input('center_latitude',array('type'=>'text','readonly'=>'readonly','label'=>'Center Latitude','id'=>'input-latitude')); ?>
		<?php echo $this->Form->input('center_longitude',array('type'=>'text','readonly'=>'readonly','label'=>'Center Longitude','id'=>'input-longitude')); ?>
		<?php echo $this->Form->input('gmap_scale',array('type'=>'text','readonly'=>'readonly','label'=>'Map Scale','id'=>'input-zoom')); ?>	
		</fieldset>
		<?php echo $this->Form->end(); ?>
	</div>
</div>
<script>
var map;
var markersArray = [];

function initialize() {
		var current_latlng = new google.maps.LatLng(<?php echo $center_latitude; ?>, <?php echo $center_longitude; ?>);
	  var mapOptions = {
	    zoom: <?php echo $gmap_scale; ?>,
	    center: current_latlng,
	    mapTypeId: google.maps.MapTypeId.ROADMAP
	  };
	  map = new google.maps.Map(document.getElementById("map-canvas-options"), mapOptions);

	//add event listner
	
	  google.maps.event.addListener(map, 'click', function(event) {
		  	deleteOverlays();
		  	//addMarker(event.latLng);
		  	document.getElementById("input-latitude").value = event.latLng.lat();
            document.getElementById("input-longitude").value = event.latLng.lng();
            
		  });
	  
	  google.maps.event.addListener(map, 'zoom_changed', function() {
		    var zoomLevel = map.getZoom();
		    //map.setCenter(changedLatLng);
		    document.getElementById("input-zoom").value = zoomLevel;
		  });
	  
	  //addMarker(current_latlng);
	  
	}//end of initialize

	function loadScript() {
	  var script = document.createElement("script");
	  script.type = "text/javascript";
	  script.src = "//maps.googleapis.com/maps/api/js?key=<?php echo $gmap_key; ?>&sensor=false&callback=initialize";
	  document.body.appendChild(script);
	}

	//add marker
	function addMarker(location) {
	  marker = new google.maps.Marker({
	    position: location,
	    map: map
	  });
	  
	  markersArray.push(marker);
	}

	//Deletes all markers in the array by removing references to them
	function deleteOverlays() {
	  if (markersArray) {
	    for (i in markersArray) {
	      markersArray[i].setMap(null);
	    }
	    markersArray.length = 0;
	  }
	}
	
	window.onload = loadScript;

	$('#input-zoom').on("change keyup paste",function(){
		var cZoom = $(this).val();
		if($.isNumeric(cZoom) && cZoom <= 21 ){
			map.setZoom(parseInt(cZoom));
		}
		});
	
	$('#input-latitude').on("change keyup paste",function(){
		var lat = $(this).val();
		var lng = $('#input-longitude').val();

		if($.isNumeric(lat) && $.isNumeric(lng)){
			lat = lat - 0;
			lng = lng - 0;
			var clatlng = new google.maps.LatLng(lat,lng);
			deleteOverlays();
			addMarker(clatlng);
			map.panTo(clatlng);
		}
		});
	
	$('#input-longitude').on("change keyup paste",function(){
		var lat = $('#input-latitude').val();
		var lng = $(this).val();
		
		if($.isNumeric(lat) && $.isNumeric(lng)){
			lat = lat - 0;
			lng = lng - 0;
			var clatlng = new google.maps.LatLng(lat,lng);
			deleteOverlays();
			addMarker(clatlng);
			map.panTo(clatlng);
		}
		
		});

	$("#OptionEditForm").validate({
		rules:{
			
			"data[Option][center_latitude]": {required:true,number:true,range:[-90,90]},
			"data[Option][center_longitude]": {required:true,number:true,range:[-180,180]},
			"data[Option][gmap_scale]": {required:true,number:true,range:[0,21]},
			"data[Option][email]": {email:true}
			
		},
		messages:{
		
			"data[Option][gmap_scale]": {required:"Required",
										number:"Digits only please",
										range:"zoom range 0-21"},
			"data[Option][email]": {email:"Valid email please"},
	
		}
		
	});
</script>