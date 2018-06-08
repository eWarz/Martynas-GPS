<div class="row-fluid">
<div class="span6">
	<div id="map-canvas-location-edit" style="width:100%;height:550px;">Loading map...</div>
</div>
<div class="span6 add-contact-box">
	<?php echo $this->Form->create('Location',array('action'=>'edit','class'=>'form-horizontal')); ?>
	<fieldset>
	<?php echo $this->Form->input('name',array('label' => false,'placeholder'=>'Device ID','type'=>'text','class'=>'input-xlarge')); ?>
	<?php echo $this->Form->input('location_category_id',array('label' => false,'placeholder'=>'Selectas','options'=>$locationcategories)); ?>
	<div class="form-actions">
	<?php echo $this->Form->submit(' Save',array( 'div'=>false,'class'=>'btn btn-info')); ?>
	&nbsp;<a href="<?php echo $this->Html->url(array('controller'=>'locations','action'=>'index')); ?>" class="btn btn-primary">&nbsp;Cancel</a>
	<a href="#" class="btn btn-danger cdelete" >&nbsp;Delete</a>
	</div>
	<?php echo $this->Form->input('latitude',array('label' => false,'placeholder'=>'Latitude','type'=>'text','class'=>'input-xlarge','id'=>'input-latitude','readonly'=>'')); ?>
	<?php echo $this->Form->input('longitude',array('label' => false,'placeholder'=>'Longitude','type'=>'text','class'=>'input-xlarge','id'=>'input-longitude','readonly'=>'')); ?>
	
	</fieldset>
	<?php echo $this->Form->end(); ?>
</div>
</div>
<form name="del" id="del" action="<?php echo $this->Html->url(array('controller'=>'locations','action'=>'delete'));?>" method="post">
<input type="hidden" name="id" id="delid" value="<?php echo $this->request->data['Location']['id']; ?>">
</form>
<script>

//Confirm delete modal/dialog with Twitter bootstrap?
// ---------------------------------------------------------- Generic Confirm  

  function confirm(heading, question, cancelButtonTxt, okButtonTxt, callback) {

    var confirmModal = 
      $('<div class="modal hide fade">' +    
          '<div class="modal-header">' +
            '<a class="close" data-dismiss="modal" >&times;</a>' +
            '<h3>' + heading +'</h3>' +
          '</div>' +

          '<div class="modal-body">' +
            '<p>' + question + '</p>' +
          '</div>' +

          '<div class="modal-footer">' +
            '<a href="#" class="btn" data-dismiss="modal">' + 
              cancelButtonTxt + 
            '</a>' +
            '<a href="#" id="okButton" class="btn btn-danger">' + 
              okButtonTxt + 
            '</a>' +
          '</div>' +
        '</div>');

    confirmModal.find('#okButton').click(function(event) {
      callback();
      confirmModal.modal('hide');
    });

    confirmModal.modal('show');     
  };

  // ---------------------------------------------------------- Confirm Put To Use

  $(".cdelete").live("click", function(event) {


    var heading = 'Patvirtinkite';
    var question = 'Ar tikrai norite ištrinti?';
    var cancelButtonTxt = 'Ne';
    var okButtonTxt = 'Taip';

    var callback = function() {
  
	  $('#del').submit();
    };

    confirm(heading, question, cancelButtonTxt, okButtonTxt, callback);

  });
</script>
<script>
var map;
var markersArray = [];

function initialize() {
	var prev_location =  new google.maps.LatLng(<?php echo $this->request->data['Location']['latitude']; ?>, <?php echo $this->request->data['Location']['longitude']; ?>);
	  var mapOptions = {
	    zoom: <?php echo $gmap_scale; ?>,
	    center: prev_location,
	    mapTypeId: google.maps.MapTypeId.ROADMAP
	  }
	  map = new google.maps.Map(document.getElementById("map-canvas-location-edit"), mapOptions);

	  //add event listner
	  google.maps.event.addListener(map, 'click', function(event) {
		  	deleteOverlays();
		  	addMarker(event.latLng);
		  	document.getElementById("input-latitude").value = event.latLng.lat();
            document.getElementById("input-longitude").value = event.latLng.lng();
            
		  });

		addMarker(prev_location);
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