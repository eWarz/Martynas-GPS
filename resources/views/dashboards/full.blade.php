<div class="full-map-category-list ">

<div class="">
<strong>Naudotojų DEVICES</strong>
</div>
<div class="full-map-category-list-container">
<?php foreach($userList as $user): ?>
<?php $stripcolor = "background-color:#f5f5f5;"; ?>
<div style="<?php echo $stripcolor; ?>">
<label class="checkbox" >
<input class="select-user" type="checkbox" id="uid<?php echo $user['User']['id']; ?>" value="<?php echo $user['User']['id']; ?>"  checked="<?php echo 'checked'; ?>" /><?php echo $user['User']['username']; ?></label>
</div>
<?php endforeach; ?>
</div>
</div>
<div id="map-canvas-dashboard-full" style="width:100%;height:100%;">Loading map...</div>

<script>
var plot1;
var map;
var markersArray = [];
//var marker = [];
var infowindowArray = [];
var cindex = <?php echo json_encode($cindex); ?>;
var uindex = <?php echo json_encode($uindex); ?>;
var userids = <?php echo json_encode($userids); ?>;
var cids = <?php echo json_encode($cids); ?>;
var indexcu = <?php echo json_encode($indexcu); ?>;
var indexu = <?php echo json_encode($indexu); ?>;
var sizeDensity = <?php echo json_encode($sizeDensity); ?>;
var showDensity = 1;
var locationCategories = <?php echo json_encode($locationCategories); ?>;

/**
 * The HomeControl adds a control to the map that simply
 * returns the user to Chicago. This constructor takes
 * the control DIV as an argument.
 * @constructor
 */
function HomeControl(controlDiv, map) {

  // Set CSS styles for the DIV containing the control
  // Setting padding to 5 px will offset the control
  // from the edge of the map
  controlDiv.style.padding = '5px';

  // Set CSS for the control border
  var controlUI = document.createElement('div');
  controlUI.style.backgroundColor = 'white';
  controlUI.style.borderStyle = 'solid';
  controlUI.style.borderColor = 'white';
  controlUI.style.borderWidth = '3px';
  controlUI.style.textAlign = 'center';
  controlUI.title = 'Grįžti Atgal';
  controlDiv.appendChild(controlUI);

  // Set CSS for the control interior
  var controlText = document.createElement('div');
  controlText.style.fontFamily = 'Arial,sans-serif';
  controlText.style.fontSize = '12px';
  controlText.style.paddingLeft = '5px';
  controlText.style.paddingRight = '5px';
  controlText.innerHTML = '<strong><?php echo $this->Html->link('Grįžti Atgal',array('controller'=>'dashboards','action'=>'index'),array('style'=>'font-size:15px;')); ?></strong>';
  controlUI.appendChild(controlText);


}

function initialize() {
	// Enable the visual refresh
	google.maps.visualRefresh = true;
	
	  var mapOptions = {
	    zoom: <?php echo $gmap_scale; ?>,
	    center: new google.maps.LatLng(<?php echo $center_latitude; ?>, <?php echo $center_longitude; ?>),
	    mapTypeId: google.maps.MapTypeId.ROADMAP
	  };
	  map = new google.maps.Map(document.getElementById("map-canvas-dashboard-full"), mapOptions);
	// Create the DIV to hold the control and
	  // call the HomeControl() constructor passing
	  // in this DIV.
	  var homeControlDiv = document.createElement('div');
	  var homeControl = new HomeControl(homeControlDiv, map);

	  homeControlDiv.index = 1;
	  map.controls[google.maps.ControlPosition.TOP_CENTER].push(homeControlDiv);
	  
	  loadFromCookie();
	  setMarkers(locationCategories);
	}

	function loadScript() {
		$.cookie.secure = ('https:' == document.location.protocol ? true : false);
		$.cookie.raw = true;
		 
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
				    if (cids[i] == false){
							marker.setVisible(false);
					    }
				    else {
				    	var u = indexu[m]; // get user
						if (userids[u] == false){ // is user dissabled
							marker.setVisible(false);
						}
				    }
				    markersArray.push(marker);
				    
				    var infowindow = new google.maps.InfoWindow({
					    content:'<a href="'+location.url+'">'+location.name+'</a>'
					    		
						    });
				    infowindowArray.push(infowindow);
				    google.maps.event.addListener(marker, 'click', infoCallback(infowindow,marker,location.id,location.name,location.url));
					m++;
		    	}//for j
		  }
		}//end of setMarker

	function getInfowindowContent(locid,locname,locurl){
		var htm = '<div id="info-container" style="overflow:hidden;">'+
			'<div id="info-link" style="width:100%;text-align:center;"><a style="font-weight:bold;font-size:15px;" href="'+locurl+'">'+locname+'</a></div>'+
			'<div id="info-graph" style="overflow:hidden;"><iframe style="border:none;overflow:hidden;width:440px;height:245px" src="<?php echo $this->Html->url(array('plugin'=>'','controller'=>'distributions','action'=>'popupgraph'),true); ?>/'+locid+'"></iframe></div>'+
		'</div>';
		return htm;
	}
	function infoCallback(infowindow,marker,locid,locname,locurl) {
		return function (){
			closeInfos();
			var cont = getInfowindowContent(locid,locname,locurl);
			infowindow.setContent(cont);
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
		  if (infowindowArray) {
			    for (i in infowindowArray) {
			      infowindowArray[i].close();
			    }
			    infowindowArray.length = 0;
			  }
		}
	
	//hide all markers
	function hideAllMarkers() {
		  if (markersArray) {
		    for (i in markersArray) {
		      markersArray[i].setVisible(false);
		      infowindowArray[i].close();
		    }
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
	
	function loadFromCookie() {
			for (var i in cids) {
				var k = $.cookie('cids'+i);
				console.log(k);
				if (k == 'false') {
					cids[i] = false;
					$('#ci'+i).attr('checked',false);
				}
			}

			for (var i in userids) {
				var k = $.cookie('uids'+i);
				if (k == 'false') {
					userids[i] = false;
					$('#uid'+i).attr('checked',false);
				}
			}

			var s = $.cookie('density');
			if (s == 1) {
				showDensity = 1;
				$('.select-show-density').attr('checked',true);
			}
			else {
				showDensity = 0;
				$('.select-show-density').attr('checked',false);
			}
		}
	
	$(".select-show-density").click(function(){
		if($(this).is(':checked')) {
				deleteOverlays();
				$.cookie('density',1);
				showDensity = 1;
				setMarkers(locationCategories); //redraw
			}
		else {
			deleteOverlays();
			$.cookie('density',0);
			showDensity = 0;
			setMarkers(locationCategories); //redraw map icons
		}
		});
	
	$(".select-user").click(function(){

		var ui = $(this).val();
		
		if($(this).is(':checked')) {
				userids[ui] = true;
				$.cookie('uids'+ui,true); // save it in cookie
				for (var i in uindex[ui]) {
						k = uindex[ui][i];
						//get category
						var c = indexcu[k];
						if (cids[c[0]]) {
								showMarkers(k);
							}
					}
			} else {
				userids[ui] = false;
				$.cookie('uids'+ui,false); // save it in cookie
				for (var i in uindex[ui]) {
						k = uindex[ui][i];
						hideMarkers(k);
					}
				//$(".select-user-all").attr("checked",false);
			}
	});

	$("#category-select-all").click(function(){
			for (var i in cids) {
				cids[i] = true;
				$.cookie('cids'+i,true); // save it in cookie
			}
			for (var k in indexu) {
					var u = indexu[k];
		
					if (userids[u]){ // is user enabled
						showMarkers(k);
					}
				}
			$(".select-category").attr("checked",true);
		});
	
	$("#category-select-none").click(function(){
			for (var i in cids) {
				cids[i] = false;
				$.cookie('cids'+i,false); // save it in cookie
			}
			hideAllMarkers();
			$(".select-category").attr("checked",false);
		});
	
	$("#user-select-all").click(function(){
			for (var i in userids) {
				userids[i] = true;
				$.cookie('uids'+i,true); // save it in cookie
			}
			for (var k in indexcu){
				var c = indexcu[k];
				if (cids[c[0]]) {
					showMarkers(k);
				}
			}
			$(".select-user").attr("checked",true);
		});
	$("#user-select-none").click(function(){
			for (var i in userids) {
				userids[i] = false;
				$.cookie('uids'+i,false); // save it in cookie
			}
			hideAllMarkers();
			$(".select-user").attr("checked",false);
		});
	/*
	$(".select-user-all").click(function(){
		if($(this).is(':checked')) {
			for (var i in userids) {
				userids[i] = true;
				$.cookie('uids'+i,true); // save it in cookie
			}
			for (var k in indexcu){
				var c = indexcu[k];
				if (cids[c[0]]) {
					showMarkers(k);
				}
			}
			$(".select-user").attr("checked",true);
		} else {
			for (var i in userids) {
				userids[i] = false;
				$.cookie('uids'+i,false); // save it in cookie
			}
			hideAllMarkers();
			$(".select-user").attr("checked",false);
		}
	});

	$(".select-category-all").click(function(){
		if($(this).is(':checked')) {
			for (var i in cids) {
					cids[i] = true;
					$.cookie('cids'+i,true); // save it in cookie
				}
			for (var k in indexu) {
					var u = indexu[k];
	
					if (userids[u]){ // is user enabled
						showMarkers(k);
					}
				}
			$(".select-category").attr("checked",true);
		}
		else {
			for (var i in cids) {
				cids[i] = false;
				$.cookie('cids'+i,false); // save it in cookie
			}
			hideAllMarkers();
			$(".select-category").attr("checked",false);
			}
		});
	*/
	$(".select-category").click(function(){
		var ci = $(this).val();
		if($(this).is(':checked')) {
				cids[ci] = true;
				$.cookie('cids'+ci,true); // save it in cookie
				
				for (var i in cindex[ci]){
					k = cindex[ci][i];
					// check if related user is enabled
					var u = indexu[k]; // get user
					if (userids[u]){ // is user enabled
						showMarkers(k);
					}
				}
			} else {
				cids[ci] = false;
				$.cookie('cids'+ci,false); // save it in cookie
				for (var i in cindex[ci]){
					k = cindex[ci][i];
					hideMarkers(k);
				}
				//$(".select-category-all").attr("checked",false);
			}
		});


	$(".full-map-category-list").draggable({ snap: "#map-canvas-dashboard-full" });


	
</script>