
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNnzxae2AewMUN0Tt_fC3gN38goeLVdVE"></script>
<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

<script type="text/javascript">

  window.onload=init;
  var infoDua = [];
  var markers = [];
  var markersDua = [];
  var markersDua1 = [];
  var circles=[];
  var rute = [];  //NAVIGASI
  var pos ='null';
  var infowindow;
  var centerBaru;
  var centerLokasi;
  var fotosrc = 'foto/';
  var directionsDisplay;
  var marker_1 = []; //MARKER UNTUK POSISI SAAT INIvar marker_2 = []; //MARKER UNTUK POSISI SAAT INI
  var marker_2 = [];
  var awal = 0;
  var tujuan = 0;

  var server = '<?php $this->url('') ?>';

  var cekRadiusStatus = "off";

  // ________________________________________ Base Map dan inisialisasi _____________________________________________________
  function basemap()
  {
    map = new google.maps.Map(document.getElementById('map'),
    {
      zoom: 12,
      zoomControl: false,
      scaleControl: true,
      center: new google.maps.LatLng(-0.9823801061363807 , 100.37055448325032),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
  }

  function init()
  {
    basemap();
    showKecamatan();
    showMosque();
  }

  // _____________________________ Menampilkan masjid dan kecamatan saat first page load ________________________________
  function showMosque() {

    ti = new google.maps.Data();
    ti.loadGeoJson(server+'maps/mosque');
    ti.setStyle(function(feature){
    return({
            fillColor: '#e50c0c',
            strokeColor: '#e50c0c',
            strokeWeight: 1,
            fillOpacity: 7
           });
      });
    ti.setMap(map);
  }

  function showKecamatan(){

    kecamatan = new google.maps.Data();
    console.log(server+'kecamatan');
    kecamatan.loadGeoJson(server+'maps/kecamatan');
    kecamatan.setStyle(function(feature)
    {
      var gid = feature.getProperty('id');
      if (gid == '01'){
        color = '#9a55ffc9'
        return({
          fillColor:color,
          strokeWeight:2.0,
          strokeColor:'#9a55ff',
          fillOpacity:0.3,
          clickable: false
        });
      }
    });
    kecamatan.setMap(map);
  }

  // ___________________________________ Menampilkan data masjid ___________________________________

  function tampilkanSemuaMasjid() {

    hapusRadius();
    hapusMarkerTerdekat();
    $.ajax({ url: server+'maps/mosque/marker', data: "", dataType: 'json', success: function (rows){
      pushData(rows);
    }});
  }

  function pushData(rows){
     $('#infoo').hide();
     $('#hasilcari1').show();
     $('#hasilcari').empty();
     hapusInfo();
     clearroute2();
	   clearroute();

      if(rows[0]==null){
        Swal.fire({
          text: 'Mosque Not Found!'
        });
      }

      for (var i in rows){
        var row        = rows[i];
        var id         = row.id;
        var nama       = row.name;
        var latitude   = row.latitude ;
        var longitude  = row.longitude ;
        centerBaru     = new google.maps.LatLng(latitude, longitude);
        marker         = new google.maps.Marker({
                          position: centerBaru,
                          icon: server + 'images/markers/mosque.png',
                          map: map,
                          animation: google.maps.Animation.DROP,
                        });
        console.log(id);
        markersDua.push(marker);
        map.setCenter(centerBaru);
        klikInfoWindow(id);
        map.setZoom(13);
        $('#hasilcari').append("<tr><td style='font-size: 12px !important'>"+nama+"</td><td><a title='info' style='font-size: 12px !important' class='btn btn-sm fa fa-info' onclick='detailmasjid(\""+id+"\");info1();'></a></td><td><a title='info' style='font-size: 12px !important' class='btn btn-sm fa fa-car' onclick='callRoute(centerLokasi, centerBaru);'></a></td></tr>");
      }
    }

    function detailmasjid(idd){  //menampilkan informasi masjid

       $('#info').empty();
       $('#infoFacility').empty();
       $('#infoEvent').empty();
       hapusInfo();
       clearroute2();
    	 clearroute();
       hapusMarkerTerdekat();
       $.ajax({url: server+'maps/mosque/marker?id='+idd, data: "", dataType: 'json', success: function(rows){

             for (var i in rows){
                var row = rows[i];
                var id = row.id;
                var name = row.name;
                var address=row.address;
                var capacity=row.capacity;
                var park=row.park_area_size;
                var image = row.image;
                var lat  = row.lat;
                var lang = row.lang;
                centerBaru = new google.maps.LatLng(lat, lang);
                marker = new google.maps.Marker({
                            position: centerBaru,
                            icon: server + 'images/markers/mosque.png',
                            map: map,
                            animation: google.maps.Animation.DROP,
                          });

                console.log(lat);
                console.log(lang);
                markersDua.push(marker);
                map.setCenter(centerBaru);
                map.setZoom(16);
                $('#info').append("<tr><td style='font-size:12px'><b>Name</b></td><td style='font-size:12px'>:</td><td style='font-size:12px'> "+name+"</td></tr><tr><td style='font-size:12px'><b>Address </b></td><td style='font-size:12px'>:</td><td style='font-size:12px'> "+address+"</td></tr><tr><td style='font-size:12px'><b>Capacity</b></td><td style='font-size:12px'>:</td><td style='font-size:12px'>"+capacity+" Jamaah</td></tr><tr><td style='font-size:12px'><b>Park Area</b></td><td style='font-size:12px'>:</td><td style='font-size:12px'> "+park+" m<sup>2</sup></td></tr><tr><td style='font-size:12px'><b>Gallery</b></td><td style='font-size:12px'>:</td><td style='font-size:12px'><a href='#' onclick='gallery(\""+id+"\")' class='btn btn-sm btn-danger style='font-size:12px''>Show</a></td></tr>");
    			      infowindow = new google.maps.InfoWindow({
                  position: centerBaru,
                  content: "<span style=color:black><center><b>Information</b><br><br><img src='"+server+image+"' alt='image in infowindow' width='150' class='img-fluid'></center><br><i class='fa fa-home'></i> "+name+"<br>&nbsp;<i class='fa fa-map-marker'></i> "+address+"<br><br><a class='form-control btn btn-sm btn-danger' href='#' onclick='callRoute(centerLokasi, centerBaru);'>Route</a><a class='form-control btn btn-sm btn-success' href='#' onclick='gallery(\""+id+"\")'>Gallery</a><br><br></span>",
                  pixelOffset: new google.maps.Size(0, -33)
                });
                infoDua.push(infowindow);
                hapusInfo();
                infowindow.open(map);
              }
    			//FASILITAS MASJID
              var headFacility="<tr><th style='font-size:12px'>Facility</th><th style='font-size:12px'>Condition</th><th style='font-size:12px'>Total</th><th style='font-size:12px'>Last Updated</th></tr>";
              var isi = '';
              $('#infoFacility').append(headFacility);
              for (var i in rows[0].facility){
                var row = rows[0].facility[i];
                var id_fas = row.id;
                var name = row.name;
                var condition = row.condition;
                var total = row.total;
                var updated = row.updated_at;
                var currentDate = new Date(updated);
                isi = isi+"<tr><td style='font-size:12px'>"+name+"</td><td style='font-size:12px'>"+condition+"</td><td style='font-size:12px'> "+total+" </td><td style='font-size:12px'> "+currentDate+"</td></tr>";
              }//end for
              $('#infoFacility').append(isi);

    		  //KEGIATAN MASJID
              var headEvent="<tr><th style='font-size:12px'>Event</th><th style='font-size:12px'>Description</th><th style='font-size:12px'>Schedule</th><th style='font-size:12px'>Ustad/Pengisi Acara</th><th style='font-size:12px'>Status</th></tr>";
              var isi = '';
              console.log('event');
              $('#infoEvent').append(headEvent);
              for (var i in rows[0].event){
                var row = rows[0].event[i];
                var id_fas = row.id;
                var event = row.name;
                var description = row.description;
                var schedule = row.schedule;
                var ustad = row.ustad;
                var status = row.status;
                isi = isi+"<tr><td style='font-size:12px'>"+event+"</td><td style='font-size:12px'>"+description+"</td><td style='font-size:12px'> "+schedule+" </td><td style='font-size:12px'> "+ustad+"</td><td style='font-size:12px'>"+status+"</td></tr>";
              }//end for
              $('#infoEvent').append(isi);
          }});
    }

  // _______________________ Marker otomatis current location aktif ketika map dipilih_______________________________________
  function aktifkanGeolocation(){ //posisi saat ini

    navigator.geolocation.getCurrentPosition(function(position) {
    // hapusMarkerInfowindow();
    hapusInfo();
      pos = {
      lat: position.coords.latitude,
      lng: position.coords.longitude

      };console.log(pos.lat);
        marker = new google.maps.Marker({
        position: pos,
        map: map,
        icon: "images/markers/now.png",
        animation: google.maps.Animation.DROP,
      });

      centerLokasi = new google.maps.LatLng(pos.lat, pos.lng);
      markers.push(marker);
      infowindow = new google.maps.InfoWindow({
      position: pos,
      content: "<a style='color:black;'>You Are Here</a> "
      });

      infowindow.open(map, marker);
      map.setCenter(pos);

      marker.addListener('click', toggleBounce);
    });
  }

  function toggleBounce() {
    if (marker.getAnimation() !== null) {
      marker.setAnimation(null);
    } else {
      marker.setAnimation(google.maps.Animation.BOUNCE);
    }
  }

  function hapusMarkerInfowindow(){
       setMapOnAll(null);
       hapusMarkerTerdekat();
       pos = 'null';
  }
  // ________________________ End marker current location ___________________________________________________

  // ________________________ Menentukan marker lokasi secara manual _________________________________________
  function manualLocation(){ //posisi manual

    hapusRadius();
    Swal.fire({
      text: 'Click on the map!'
    });
    map.addListener('click', function(event) {
      addMarker(event.latLng);
    });
  }

  function addMarker(location){

    hapusposisi();
    marker = new google.maps.Marker({
      position : location,
      map: map,
      icon: "images/markers/now.png",
      animation: google.maps.Animation.DROP,
      });
    pos = {
      lat: location.lat(), lng: location.lng()
    }
    centerLokasi = new google.maps.LatLng(pos.lat, pos.lng);
    markers.push(marker);
    infowindow = new google.maps.InfoWindow();
    infowindow.setContent('Your Current Position');
    infowindow.open(map, marker);
    usegeolocation=true;
    google.maps.event.clearListeners(map, 'click');
    console.log(pos);

    marker.addListener('click', toggleBounce);
  }
  // _____________________ end menentukan marker lokasi secara manual ______________________________________

  function hapusMarkerInfowindow(){
      setMapOnAll(null);
      hapusMarkerTerdekat();
      pos = 'null';
  }

  function setMapOnAll(map) {
      for (var i = 0; i < markers.length; i++) {
      markers[i].setMap(map);
      }
  }

  function hapusMarkerTerdekat() {
    for (var i = 0; i < markersDua.length; i++) {
          markersDua[i].setMap(null);
      }
  }

  function hapusInfo() {
    for (var i = 0; i < infoDua.length; i++) {
          infoDua[i].setMap(null);
          }
  }

  function hapusposisi(){
    for (var i = 0; i < markers.length; i++){
      markers[i].setMap(null);
    }
    markers = [];
  }

  // ___________________ Fungsi yang berjalan ketika radius di klik ___________________________________

  function cekRadius(){
   document.getElementById('km').innerHTML=document.getElementById('inputradiusmes').value*100
  }

  function aktifkanRadius(){ //fungsi radius mesjid
    if (pos == 'null'){
      Swal.fire({
        type: 'error',
        title: 'Oops...',
        text: 'Click button current position or manual position first !'
      });
    }
    else {
      hapusRadius();
      var inputradiusmes=document.getElementById("inputradiusmes").value;
  	  console.log(inputradiusmes);
      var circle = new google.maps.Circle({
        center: pos,
        radius: parseFloat(inputradiusmes*100),
        map: map,
        strokeColor: "yellow",
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: "#f9fa39",
        fillOpacity: 0.35
        });
        map.setZoom(14);
        map.setCenter(pos);
        circles.push(circle);
    }
    cekRadiusStatus = 'on';
    masjidradius();
  }

  function hapusRadius(){
    for(var i=0;i<circles.length;i++){
      circles[i].setMap(null);
    }
    circles=[];
    cekRadiusStatus = 'off';
  }

  function masjidradius(){ //menampilkan masjid berdasarkan radius

    $('#hasilcari1').show();
    $('#hasilcari').empty();
    hapusInfo();
    clearroute2();
	  clearroute();
    hapusMarkerTerdekat();

    rad = inputradiusmes.value*100;
    console.log(rad);

	  console.log(pos.lat);
    console.log(pos.lng);

    $.ajax({
      url: server+'/maps/mosque/radius?lat='+pos.lat+'&lang='+pos.lng+'&rad='+rad, data: "", dataType: 'json', success: function(rows){
        console.log("hy");
        for (var i in rows){
          var row     = rows[i];
          var id   = row.id;
          var nama   = row.name;
          var latitude  = row.lat;
          var longitude = row.lang;
          centerBaru = new google.maps.LatLng(latitude, longitude);
          marker = new google.maps.Marker
          ({
            position: centerBaru,
            icon:'images/markers/mosque.png',
            map: map,
            animation: google.maps.Animation.DROP,
          });
          console.log(latitude);
          console.log(longitude);
          markersDua.push(marker);
          map.setCenter(centerBaru);
	        klikInfoWindow(id);
          pushData(rows);
          map.setZoom(14);
        }
        }
      });
  }

  function klikInfoWindow(id) // memunculkan marker ketika marker di klik
  {
      google.maps.event.addListener(marker, "click", function(){
        detailMasjidInfo(id);
      });
  }

  function detailMasjidInfo(ids){  //menampilkan informasi masjid

    $('#info').empty();
    hapusInfo();
    clearroute2();
  	clearroute();
    $.ajax({
       url: server+'maps/mosque/marker?id='+ids, data: "", dataType: 'json', success: function(rows)
    {
  		    console.log("data masuk pak eko");
          console.log(ids);
           for (var i in rows)
            {
              console.log('dd');
              var row = rows[i];
              var id = row.id;
              var name = row.name;
              var address=row.address;
              var capacity=row.capacity;
              var park=row.park_area_size;
              var image = row.image;
              var lat  = row.lat;
              var lang = row.lang;
              centerBaru = new google.maps.LatLng(row.lat, row.lang);
              marker = new google.maps.Marker
              ({
                position: centerBaru,
                icon: server + 'images/markers/mosque.png',
                map: map,
                animation: google.maps.Animation.DROP,
              });
              console.log(lat);
              console.log(lang);
              markersDua.push(marker);
              map.setCenter(centerBaru);
              map.setZoom(17);
              infowindow = new google.maps.InfoWindow({
              position: centerBaru,
              content: "<span style=color:black><center><b>Information</b><br><br><img src='"+server+image+"' alt='image in infowindow' width='150' class='img-fluid'></center><br><i class='fa fa-home'></i> "+name+"<br>&nbsp;<i class='fa fa-map-marker'></i> "+address+"<br><br><a class='form-control btn btn-sm btn-danger' href='#' onclick='callRoute(centerLokasi, centerBaru);'>Route</a><a class='form-control btn btn-sm btn-success' href='#' onclick='gallery(\""+id+"\")'>Gallery</a><br><br></span>",
              pixelOffset: new google.maps.Size(0, -33)
              });
            infoDua.push(infowindow);
            hapusInfo();
            infowindow.open(map);

            }


          }
        });
  }

  function hapusInfo() {
    for (var i = 0; i < infoDua.length; i++) {
      infoDua[i].setMap(null);
    }
  }

  function clearroute2(){
      if(typeof(directionsDisplay) != "undefined" && directionsDisplay.getMap() != undefined){
      directionsDisplay.setMap(null);
      $("#detailrute").remove();
      }
  }

  function clearroute(){
    for (i in rute){
      rute[i].setMap(null);
    }
    rute=[];
  }

  function resultt(){
    $("#result").show();
    $("#resultaround").hide();
    // $("#eventt").hide();
    $("#infoo").hide();
    $("#att1").hide();
    // $("#hide2").show();
    // $("#showlist").hide(); --- add this later
    // $("#radiuss").hide();
    // $("#infoo1").hide();
    $("#att2").hide();
    $("#infoev").hide();
  }

  function info1(){
    $("#infoo").show();
    $("#att2").hide();
    $("#radiuss").hide()
    $("#infoo1").hide();;
    $("#infoev").hide();
  }

  function clearroute2(){
      if(typeof(directionsDisplay) != "undefined" && directionsDisplay.getMap() != undefined){
      directionsDisplay.setMap(null);
      $("#detailrute").remove();
      }
  }

  function clearroute(){
     for (i in rute){
       rute[i].setMap(null);
     }
     rute=[];
  }

  function hapusMarkerTerdekat() {
    for (var i = 0; i < markersDua.length; i++) {
          markersDua[i].setMap(null);
      }
  }

  // ________________________ End fungsi yang berjalan ketika radius di klik __________________________________________

  // _________________________________________ Function ketika rute diklik _________________________________________

  function callRoute(start, end) {
    clearroute();
    clearroute2();

     if (pos == 'null' || typeof(pos) == "undefined"){
       Swal.fire({
         text: 'Please click button current position or button manual position first!'
       });
     }else{
        rutetampil();
        directionsService = new google.maps.DirectionsService;
 	      directionsDisplay = new google.maps.DirectionsRenderer({
          polylineOptions: {
            strokeColor: "red"
          }
        });;

       directionsService.route
       (
         {
             origin: start,
             destination: end,
             travelMode: google.maps.TravelMode.DRIVING
         },
         function(response, status)
         {
             if (status === google.maps.DirectionsStatus.OK)
             {
               directionsDisplay.setDirections(response);
             }
             else
             {
               window.alert('Directions request failed due to ' + status);
             }
           }
       );
       directionsDisplay.setMap(map);
       map.setZoom(16);
       $('#rute').append("<div class='form-group' id='detailrute' style='font-size: 12px'></div></div>");
       directionsDisplay.setPanel(document.getElementById('detailrute'));
      }
  }

  function rutetampil(){
    $("#att2").show();
    $("#att1").hide();
    $("#radiuss").hide();
    $("#infoo1").hide();
    $("#infoev").hide();
  }

  function clearroute(){
     for (i in rute){
       rute[i].setMap(null);
     }
     rute=[];
   }

   function clearroute2(){
       if(typeof(directionsDisplay) != "undefined" && directionsDisplay.getMap() != undefined){
       directionsDisplay.setMap(null);
       $("#detailrute").remove();
       }
   }

   // _________________________________________ Gallery _________________________________________

   function gallery(a){
     console.log(a);
     // window.open(server+'maps/gallery?id='+a);
     window.open(server+'maps/gallery?id='+a,'popUpWindow','height=700,width=600,left=800,top=0,,scrollbars=yes,menubar=no');
  }

  // _________________________________________ Filter _________________________________________

  function filterMasjid(){
    hapusRadius();
    hapusMarkerTerdekat();
    console.log(types.value);
    $.ajax({ url: server+'maps/filter?name='+names.value+'&type='+types.value+'&park='+park_area.value+'&capacity='+capacity.value, data: "", dataType: 'json', success: function (rows){
      pushData(rows);
    }});

  }

  function filterFacility(){
    hapusRadius();
    hapusMarkerTerdekat();

    var lay = [];
    $("input:checkbox[name=facility]:checked").each(function(){
        lay.push($(this).val());
    });

    if (lay==''){
      Swal.fire({
        text: 'Please choose facility!'
      });
    }else{
      console.log(server+'maps/filter/facility?name='+lay);
      $.ajax({ url: server+'maps/filter/facility?name='+lay, data: "", dataType: 'json', success: function (rows){
        pushData(rows);
      }});
    }

  }

  function filterEventMasjid(){
    hapusRadius();
    hapusMarkerTerdekat();
    console.log(datepicker.value);
    $.ajax({ url: server+'maps/filter/event?date='+datepicker.value, data: "", dataType: 'json', success: function (rows){
      pushData(rows);
    }});

  }

</script>
