
<div class="row-fluid">
<div class="span6">
	<div id="map-canvas-location-add" style="width:100%;height:550px;">Kraunamas Žemėlapis...</div>
</div>
<div class="span6 add-contact-box">
	<?php echo $this->Form->create('Location',array('class'=>'form-horizontal')); ?>
	<fieldset>
	
	<?php echo $this->Form->input('name',array('label' => false,'placeholder'=>'Device ID', 'type'=>'text','class'=>'')); ?>
	<?php echo $this->Form->input('location_category_id',array('label' => false,'placeholder'=>'Device ID','options'=>$locationcategories)); ?>
	<?php echo $this->Form->input('latitude',array('label' => false,'placeholder'=>'Latitude','type'=>'text','class'=>'input-xlarge','id'=>'input-latitude','readonly'=>'')); ?>
	<?php echo $this->Form->input('longitude',array('label' => false,'placeholder'=>'Longitude','type'=>'text','class'=>'input-xlarge','id'=>'input-longitude','readonly'=>'')); ?>
		<div class="" style="visibility: hidden;"><?php echo $this->Form->input('user_id',array('options'=>$userList)); ?></div>
	
	<div class="form-actions">
	<?php echo $this->Form->submit(' Send',array( 'div'=>false,'class'=>'btn btn-info')); ?>
	</div>
	</fieldset>
	<?php echo $this->Form->end(); ?>
</div>
</div>
<script>
jQuery(function($) {
	$("#date_time").datetimepicker({ dateFormat: 'yy-mm-dd', timeFormat: 'HH:mm' });
	});
</script>
<script>
var map;
var markersArray = [];

function initialize() {
	  var mapOptions = {
	    zoom: <?php echo $gmap_scale; ?>,
	    center: new google.maps.LatLng(<?php echo $center_latitude; ?>, <?php echo $center_longitude; ?>),
	    mapTypeId: google.maps.MapTypeId.ROADMAP
	  }
	  map = new google.maps.Map(document.getElementById("map-canvas-location-add"), mapOptions);

	  //add event listner
	  google.maps.event.addListener(map, 'click', function(event) {
		  	deleteOverlays();
		  	addMarker(event.latLng);
		  	document.getElementById("input-latitude").value = event.latLng.lat();
            document.getElementById("input-longitude").value = event.latLng.lng();
            
		  });
	  
	}

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

	
</script>