<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNnzxae2AewMUN0Tt_fC3gN38goeLVdVE"></script>
<script type="text/javascript">
  function basemap()
  {
    map = new google.maps.Map(document.getElementById('map'),
    {
      zoom: 12,
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
</script>
