
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
  var angkot = [];
  var jalurAngkot=[];
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

  var server = "http://localhost/moman/";

  var cekRadiusStatus = "off";

  // ________________________________________ Base Map dan inisialisasi _____________________________________________________
  function basemap()
  {
    map = new google.maps.Map(document.getElementById('map'),
    {
      zoom: 11,
      zoomControl: false,
      scaleControl: true,
      center: new google.maps.LatLng(-0.9977197, 100.3569001),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
  }

  function init()
  {
    basemap();
  }
  // ______________________________________ End Base Map ________________________________________________________________

  // _______________________ Marker otomatis current location aktif ketika map dipilih_______________________________________
  function aktifkanGeolocation(){ //posisi saat ini

    navigator.geolocation.getCurrentPosition(function(position) {
    hapusMarkerInfowindow();
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
    infowindow.setContent('Current Position, lat' + pos.lat + ' lang: '+ pos.lng);
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
  function cekRadius()
  {
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
        strokeColor: "blue",
        strokeOpacity: 0.8,
        strokeWeight: 2,
        fillColor: "blue",
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
    // clearangkot();
    hapusMarkerTerdekat();

    rad = inputradiusmes.value*100;
    console.log(rad);

	  console.log(pos.lat);
    console.log(pos.lng);

    $.ajax({
      url: server+'maps?page=masjidradius&lat='+pos.lat+'&lng='+pos.lng+'&rad='+rad, data: "", dataType: 'json', success: function(rows){
        console.log("hy");
        for (var i in rows){
          var row     = rows[i];
          var id   = row.id;
          var nama   = row.name;
          var latitude  = row.latitude ;
          var longitude = row.longitude ;
          centerBaru = new google.maps.LatLng(latitude, longitude);
          marker = new google.maps.Marker
          ({
            position: centerBaru,
            icon:'images/markers/now.png',
            map: map,
            animation: google.maps.Animation.DROP,
          });
          console.log(latitude);
          console.log(longitude);
          markersDua.push(marker);
          map.setCenter(centerBaru);
	        klikInfoWindow(id);
          map.setZoom(14);
          $('#hasilcari').append("<tr><td>"+nama+"</td><td><a role='button' title='info' class='btn btn-default fa fa-info' onclick='detailmasjid(\""+id+"\");info1();'></a></td><td><a role='button' class='btn btn-default fa fa-bus' title='jalur angkot' onclick='angkotmesjid(\""+id+"\",\""+latitude+"\",\""+longitude+"\");info12();'></a></td></tr>");
        }
        }
      });
  }

  function klikInfoWindow(id) // memunculkan marker ketika marker di klik
  {
      google.maps.event.addListener(marker, "click", function(){
        detailmes_infow(id);
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

  // ________________________ End fungsi yang berjalan ketika radius di klik __________________________________________

</script>
