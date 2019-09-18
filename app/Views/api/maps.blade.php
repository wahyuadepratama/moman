<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Maps Api</title>
    <?php $this->include('maps/_google_map'); ?>

    <style media="screen">
      .map{ height : 100%; width : 100%; top : 0; left : 0; position : absolute; z-index : 200;}
    </style>
  </head>
  <body onload="init();">
    <div id="map" class="map"></div>
  </body>
</html>
