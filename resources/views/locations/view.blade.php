<?
function getaddress($lat,$lng)
{
$url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($lat).','.trim($lng).'&sensor=false';
$json = @file_get_contents($url);
$data=json_decode($json);
$status = $data->status;
if($status=="OK")
return $data->results[0]->formatted_address;
else
return false;
}
?>

<div>
	<div class="row-fluid">
		<div class="span6">
			<div id="map-canvas-location-view" style="width:100%;height:550px;" >
			Kraunamas Žemėlapis...
			</div>
		</div>
		<div class="span6">
			<div class="view-location-box">
				<div class="row-fluid">
					<div class="span12">
						<table class="table table-condensed">
							<thead>
								<tr>
									<th>Device ID:</th>
									<th><?php echo $location['Location']['name']?></th>
								<tr>
							</thead>
							<tbody>
								<tr>
									<td>Selectas:</td>
									<td><?php echo $location['LocationCategory']['name']; ?></td>
								<tr>
								<tr>
									<td>Vartotojas:</td>
									<td><?php echo $location['User']['username']?></td>
								<tr>
								<tr>
									<td>Latitude:</td>
									<td><?php echo $location['Location']['latitude']; ?></td>
								<tr>
								<tr>
									<td>Longitude:</td>
									<td><?php echo $location['Location']['longitude']; ?></td>
								<tr>
																<tr>
									<td>Adresas:</td>
									<td>
									
									<?
$lat= $location['Location']['latitude']; //latitude
$lng= $location['Location']['longitude']; //longitude
$address= getaddress($lat,$lng);
if($address)
{
echo $address;
}
else
{
echo "Nerastas";
}
?>
									
									</td>
								<tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			
			  	


<script>
var map;
var markersArray = [];

function initialize() {
	var current_location = new google.maps.LatLng(<?php echo $location['Location']['latitude']; ?>, <?php echo $location['Location']['longitude']; ?>);
	  var mapOptions = {
	    zoom: <?php echo $gmap_scale; ?>,
	    center: current_location,
	    mapTypeId: google.maps.MapTypeId.ROADMAP
	  };
	  map = new google.maps.Map(document.getElementById("map-canvas-location-view"), mapOptions);

	  addMarker(current_location);
	  
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

window.onload = loadScript;

	
</script>