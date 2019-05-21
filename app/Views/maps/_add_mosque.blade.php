<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNnzxae2AewMUN0Tt_fC3gN38goeLVdVE&libraries=drawing"></script>
<script type="text/javascript">

  var selectedShape;

  function basemap(){
    var map = new google.maps.Map(document.getElementById('map'),
    {
      zoom: 11,
      zoomControl: false,
      scaleControl: true,
      center: new google.maps.LatLng(-0.9977197, 100.3569001),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });
    var geocoder = new google.maps.Geocoder;
    var infowindow = new google.maps.InfoWindow;

    // Menampilkan marker lokasi pada map ketika button check di klik
    document.getElementById('showLocation').addEventListener('click', function() {
      geocodeLatLng(geocoder, map, infowindow);
    });

    // Menampilkan drawer pada google map
    drawingManager = new google.maps.drawing.DrawingManager({
      drawingMode: google.maps.drawing.OverlayType.POLYGON,
      drawingControl: true,
      drawingControlOptions: {
        position: google.maps.ControlPosition.LEFT_CENTER,
        drawingModes: [google.maps.drawing.OverlayType.POLYGON]
      },
      polygonOptions: {
        editable: true
      }
    });
    drawingManager.setMap(map);

    // Membuat polygon / multypoligon ketika drawer selesai dibentuk
    google.maps.event.addListener(drawingManager, "overlaycomplete", function(event) {

      if (event.type == google.maps.drawing.OverlayType.POLYGON){
        //console.log('polygon path array', event.overlay.getPath().getArray());
        var str_input ='MULTIPOLYGON(((';
        var i=0;
        var coor = [];
        $.each(event.overlay.getPath().getArray(), function(key, latlng){
          var lat = latlng.lat();
          var lon = latlng.lng();
          coor[i] = lon +' '+ lat;
          str_input += lon +' '+ lat +',';
          i++;
        });
        str_input = str_input+''+coor[0]+')))';
        $("#geom").val(str_input);
        drawingManager.setDrawingMode(null);
        drawingManager.setOptions({
          drawingControl: false
        });
        // Add an event listener that selects the newly-drawn shape when the user mouses down on it.
        var newShape = event.overlay;
        newShape.type = event.type;
        setSelection(newShape);
        google.maps.event.addListener(newShape, 'click', function(){
          setSelection(newShape);
        });
      }
    });

    function getCoordinate(){
      var polygonBounds = newShape.getPath();
      str_input ='MULTIPOLYGON(((';
      for(var i = 0 ; i < polygonBounds.length ; i++){
        coor[i] = polygonBounds.getAt(i).lng() +' '+ polygonBounds.getAt(i).lat();
        str_input += polygonBounds.getAt(i).lng() +' '+ polygonBounds.getAt(i).lat() +',';
      }
      str_input = str_input+''+coor[0]+')))';
      $("#geom").val(str_input);
    }

    google.maps.event.addListener(drawingManager, 'set_at', getCoordinate);
    // Memanggil fungsi untuk menghapus polygon yang sudah diinputkan
    google.maps.event.addDomListener(document.getElementById('delete-polygon'), 'click', deleteSelectedShape);
  }

  // Menampilkan polygon/multypoligon pada textarea
  function overlayClickListener(overlay) {
    google.maps.event.addListener(overlay, "mouseup", function(event) {
      $('#geom').val(overlay.getPath().getArray());
    });
  }

  // Menampilkan drawer select
  function setSelection(shape) {
    clearSelection();
    selectedShape = shape;
    shape.setEditable(true);
  }

  // Menghapus drawer select
  function clearSelection() {
    if (selectedShape) {
      selectedShape.setEditable(false);
      selectedShape = null;
    }
  }

  // Menghapus polygon yang sudah diinputkan
  function deleteSelectedShape() {
    if (selectedShape) {
    $("#geom").val('');
    selectedShape.setMap(null);
    drawingManager.setOptions({
      drawingControl: true
    });
    }
  }

  function init(){
    basemap();
  }

  // Mengambil data lat dan lang dari form input untuk menampilkan lokasi
  function geocodeLatLng(geocoder, map, infowindow) {
    var input = document.getElementById('latlng').value;
    var latlngStr = input.split(',', 2);
    var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
    geocoder.geocode({'location': latlng}, function(results, status) {
      if (status === 'OK') {
        if (results[0]) {
          map.setZoom(11);
          var marker = new google.maps.Marker({
            position: latlng,
            map: map
          });
          infowindow.setContent(results[0].formatted_address);
          infowindow.open(map, marker);
        } else {
          window.alert('No results found');
        }
      } else {
        window.alert('Geocoder failed due to: ' + status);
      }
    });
  }

</script>
