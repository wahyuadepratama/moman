<?php

class MapsController extends Controller{

  public function maps(){

    if(isset($_GET['page'])){
      if($_GET['page'] == 'masjidradius'){
          return $this->masjidRadius();
      }
    }
    return $this->view('guest/maps');

  }

  public function showKecamatan()
  {
    // $stmt = $GLOBALS['pdo']->prepare(
    //   "SELECT row_to_json(fc)
		// 	FROM ( SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
		// 	FROM (SELECT 'Feature' As type , ST_AsGeoJSON(district.geom)::json As geometry , row_to_json((SELECT l
		// 	FROM (SELECT district.id, district.name,ST_X(ST_Centroid(district.geom)) AS lon, ST_Y(ST_CENTROID(district.geom)) As lat) As l )) As properties
		// 	FROM district As district
		// 	) As f ) As fc"
    // );

    $stmt = $GLOBALS['pdo']->prepare(
      "SELECT row_to_json(fc)
			FROM ( SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
			FROM (SELECT 'Feature' As type , ST_AsGeoJSON(district.geom)::json As geometry , row_to_json((SELECT l
			FROM (SELECT district.id, district.name, district.total_male, district.total_female, district.total_qurban_cow, district.total_qurban_goat,
      ST_X(ST_Centroid(district.geom)) AS lon, ST_Y(ST_CENTROID(district.geom)) As lat) As l )) As properties
			FROM village As district
			) As f ) As fc"
    );

    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo $data[0]['row_to_json'];
  }

  public function showDataVillage()
  {
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM village WHERE id=:id");

    $stmt->execute(['id' => $_GET['id']]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($data);
  }

  public function showMosque()
  {
    $stmt = $GLOBALS['pdo']->prepare(
      "SELECT row_to_json(fc)
			FROM ( SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features
			FROM (SELECT 'Feature' As type , ST_AsGeoJSON(a.geom)::json As geometry , row_to_json((SELECT l
			FROM (SELECT a.name,ST_X(ST_Centroid(a.geom)) AS lon, ST_Y(ST_CENTROID(a.geom)) As lat) As l )) As properties
			FROM worship_place As a
			) As f ) As fc"
    );

    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo $data[0]['row_to_json'];
  }

  public function indexMosqueMarker()
  {
    if(isset($_GET['id'])){

      $id = $_GET['id'];
      $stmt = $GLOBALS['pdo']->prepare("SELECT a.id, a.name, a.address, a.capacity, a.park_area_size,
                                        ST_X(ST_Centroid(geom)) AS lang, ST_Y(ST_CENTROID(geom)) As lat
                                        FROM worship_place as a WHERE id=:id");
      $stmt->execute(['id' => $id]);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);

      $stmt = $GLOBALS['pdo']->prepare("SELECT image FROM gallery WHERE worship_place_id=:id");
      $stmt->execute(['id' => $id]);
      $g =  $stmt->fetch(PDO::FETCH_OBJ);

      // $this->authStewardship();
      $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM detail_condition
                                        INNER JOIN facility ON detail_condition.facility_id = facility.id
                                        INNER JOIN facility_condition ON detail_condition.facility_condition_id = facility_condition.id
                                        WHERE worship_place_id=:id ORDER BY detail_condition.updated_at DESC");
      $stmt->execute(['id' => $id]);
      $f =  $stmt->fetchAll(PDO::FETCH_OBJ);

      // $this->authStewardship();
      $stmt = $GLOBALS['pdo']->prepare("SELECT ustad.name as ustad, event.*, schedule.* FROM schedule
                                        INNER JOIN ustad ON schedule.ustad_id = ustad.id
                                        INNER JOIN event ON schedule.event_id = event.id
                                        WHERE schedule.worship_place_id=:id");
      $stmt->execute(['id' => $id]);
      $e =  $stmt->fetchAll(PDO::FETCH_OBJ);

      if (!empty($e)) {
        foreach ($e as $key) {
          $date = new DateTime($key->date);
          $now = new DateTime();
          if($date < $now) {
            $key->status = 'past';
          }else {
            $key->status = 'ongoing';
          }
        }
      }

      $data[0]->image = 'images/mosque/'. $g->image;
      $data[0]->facility = $f;
      $data[0]->event = $e;

      echo json_encode($data);

    }else{

      $stmt = $GLOBALS['pdo']->prepare(
        "SELECT distinct a.id, a.name, a.address, a.capacity,ST_X(ST_Centroid(a.geom)) AS longitude,
        ST_Y(ST_CENTROID(a.geom)) As latitude FROM worship_place as a"
      );

      $stmt->execute();
      $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
      echo json_encode($data);
    }
  }

  public function radius()
  {
    $lat = $_GET['lat'];
    $lang = $_GET['lang'];
    $rad = $_GET['rad'];

    $stmt = $GLOBALS['pdo']->prepare("SELECT id, name,st_x(st_centroid(geom)) as lang,st_y(st_centroid(geom)) as lat,
                                    	st_distance_sphere(ST_GeomFromText('POINT(".$lang." ".$lat.")', -1), worship_place.geom) as jarak
                                    	FROM worship_place where st_distance_sphere(ST_GeomFromText('POINT(".$lang." ".$lat.")',-1),
                                    	worship_place.geom) <= ".$rad." ORDER BY jarak");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($data);
  }

  public function gallery()
  {
    if(isset($_GET['id'])){
      $id = $_GET['id'];
      $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM gallery WHERE worship_place_id=:id");
      $stmt->execute(['id' => $id]);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);

      $stmt = $GLOBALS['pdo']->prepare("SELECT name FROM worship_place WHERE id=:id");
      $stmt->execute(['id' => $id]);
      $n = $stmt->fetch(PDO::FETCH_OBJ);

      $this->view('guest/gallery', ['data' => $data, 'name' => $n]);
    }
  }

  public function filter()
  {
    if(isset($_GET['name']) && isset($_GET['type']) && isset($_GET['park']) ){
      $name = $_GET['name'];
      $type = $_GET['type'];
      $park = $_GET['park'];
      $capacity = $_GET['capacity'];

      //--------------------------------------------------- Cek Park and Capacity
      if ($park == '0' && $capacity == '0') {
        $stmt = $GLOBALS['pdo']->prepare("SELECT distinct a.id, a.name, a.address, a.capacity,ST_X(ST_Centroid(a.geom)) AS longitude,
                                          ST_Y(ST_CENTROID(a.geom)) As latitude FROM worship_place as a WHERE a.type iLIKE '%$type%'
                                          AND name iLIKE '%$name%' AND park_area_size > 0 AND capacity > 0");
      }
      if ($park == '0' && $capacity == '100') {
        $stmt = $GLOBALS['pdo']->prepare("SELECT distinct a.id, a.name, a.address, a.capacity,ST_X(ST_Centroid(a.geom)) AS longitude,
                                          ST_Y(ST_CENTROID(a.geom)) As latitude FROM worship_place as a WHERE a.type iLIKE '%$type%'
                                          AND name iLIKE '%$name%' AND park_area_size > 0 AND capacity > 0 AND capacity <= 100");
      }
      if ($park == '0' && $capacity == '300') {
        $stmt = $GLOBALS['pdo']->prepare("SELECT distinct a.id, a.name, a.address, a.capacity,ST_X(ST_Centroid(a.geom)) AS longitude,
                                          ST_Y(ST_CENTROID(a.geom)) As latitude FROM worship_place as a WHERE a.type iLIKE '%$type%'
                                          AND name iLIKE '%$name%' AND park_area_size > 0 AND capacity >= 100 AND capacity <= 300");
      }
      if ($park == '0' && $capacity == '500') {
        $stmt = $GLOBALS['pdo']->prepare("SELECT distinct a.id, a.name, a.address, a.capacity,ST_X(ST_Centroid(a.geom)) AS longitude,
                                          ST_Y(ST_CENTROID(a.geom)) As latitude FROM worship_place as a WHERE a.type iLIKE '%$type%'
                                          AND name iLIKE '%$name%' AND park_area_size > 0 AND capacity >= 300 AND capacity <= 500");
      }
      if ($park == '0' && $capacity == '500') {
        $stmt = $GLOBALS['pdo']->prepare("SELECT distinct a.id, a.name, a.address, a.capacity,ST_X(ST_Centroid(a.geom)) AS longitude,
                                          ST_Y(ST_CENTROID(a.geom)) As latitude FROM worship_place as a WHERE a.type iLIKE '%$type%'
                                          AND name iLIKE '%$name%' AND park_area_size > 0 AND capacity > 500");
      }

      // -------------------------------------------------------------------------------------------------------------------------

      if ($park == '50' && $capacity == '0') {
        $stmt = $GLOBALS['pdo']->prepare("SELECT distinct a.id, a.name, a.address, a.capacity,ST_X(ST_Centroid(a.geom)) AS longitude,
                                          ST_Y(ST_CENTROID(a.geom)) As latitude FROM worship_place as a WHERE a.type iLIKE '%$type%'
                                          AND name iLIKE '%$name%' AND park_area_size > 0 AND park_area_size <= 50 AND capacity > 0");
      }
      if ($park == '50' && $capacity == '100') {
        $stmt = $GLOBALS['pdo']->prepare("SELECT distinct a.id, a.name, a.address, a.capacity,ST_X(ST_Centroid(a.geom)) AS longitude,
                                          ST_Y(ST_CENTROID(a.geom)) As latitude FROM worship_place as a WHERE a.type iLIKE '%$type%'
                                          AND name iLIKE '%$name%' AND park_area_size > 0 AND park_area_size <= 50 AND capacity > 0 AND capacity <= 100");
      }
      if ($park == '50' && $capacity == '300') {
        $stmt = $GLOBALS['pdo']->prepare("SELECT distinct a.id, a.name, a.address, a.capacity,ST_X(ST_Centroid(a.geom)) AS longitude,
                                          ST_Y(ST_CENTROID(a.geom)) As latitude FROM worship_place as a WHERE a.type iLIKE '%$type%'
                                          AND name iLIKE '%$name%' AND park_area_size > 0 AND park_area_size <= 50 AND capacity >= 100 AND capacity <= 300");
      }
      if ($park == '50' && $capacity == '500') {
        $stmt = $GLOBALS['pdo']->prepare("SELECT distinct a.id, a.name, a.address, a.capacity,ST_X(ST_Centroid(a.geom)) AS longitude,
                                          ST_Y(ST_CENTROID(a.geom)) As latitude FROM worship_place as a WHERE a.type iLIKE '%$type%'
                                          AND name iLIKE '%$name%' AND park_area_size > 0 AND park_area_size <= 50 AND capacity >= 300 AND capacity <= 500");
      }
      if ($park == '50' && $capacity == '500') {
        $stmt = $GLOBALS['pdo']->prepare("SELECT distinct a.id, a.name, a.address, a.capacity,ST_X(ST_Centroid(a.geom)) AS longitude,
                                          ST_Y(ST_CENTROID(a.geom)) As latitude FROM worship_place as a WHERE a.type iLIKE '%$type%'
                                          AND name iLIKE '%$name%' AND park_area_size > 0 AND park_area_size <= 50 AND capacity > 500");
      }

      // -------------------------------------------------------------------------------------------------------------------------

      if ($park == '100' && $capacity == '0') {
        $stmt = $GLOBALS['pdo']->prepare("SELECT distinct a.id, a.name, a.address, a.capacity,ST_X(ST_Centroid(a.geom)) AS longitude,
                                          ST_Y(ST_CENTROID(a.geom)) As latitude FROM worship_place as a WHERE a.type iLIKE '%$type%'
                                          AND name iLIKE '%$name%' AND park_area_size >= 50 AND park_area_size <= 100 AND capacity > 0");
      }
      if ($park == '100' && $capacity == '100') {
        $stmt = $GLOBALS['pdo']->prepare("SELECT distinct a.id, a.name, a.address, a.capacity,ST_X(ST_Centroid(a.geom)) AS longitude,
                                          ST_Y(ST_CENTROID(a.geom)) As latitude FROM worship_place as a WHERE a.type iLIKE '%$type%'
                                          AND name iLIKE '%$name%' AND park_area_size >= 50 AND park_area_size <= 100 AND capacity > 0 AND capacity <= 100");
      }
      if ($park == '100' && $capacity == '300') {
        $stmt = $GLOBALS['pdo']->prepare("SELECT distinct a.id, a.name, a.address, a.capacity,ST_X(ST_Centroid(a.geom)) AS longitude,
                                          ST_Y(ST_CENTROID(a.geom)) As latitude FROM worship_place as a WHERE a.type iLIKE '%$type%'
                                          AND name iLIKE '%$name%' AND park_area_size >= 50 AND park_area_size <= 100 AND capacity >= 100 AND capacity <= 300");
      }
      if ($park == '100' && $capacity == '500') {
        $stmt = $GLOBALS['pdo']->prepare("SELECT distinct a.id, a.name, a.address, a.capacity,ST_X(ST_Centroid(a.geom)) AS longitude,
                                          ST_Y(ST_CENTROID(a.geom)) As latitude FROM worship_place as a WHERE a.type iLIKE '%$type%'
                                          AND name iLIKE '%$name%' AND park_area_size >= 50 AND park_area_size <= 100 AND capacity >= 300 AND capacity <= 500");
      }
      if ($park == '100' && $capacity == '500') {
        $stmt = $GLOBALS['pdo']->prepare("SELECT distinct a.id, a.name, a.address, a.capacity,ST_X(ST_Centroid(a.geom)) AS longitude,
                                          ST_Y(ST_CENTROID(a.geom)) As latitude FROM worship_place as a WHERE a.type iLIKE '%$type%'
                                          AND name iLIKE '%$name%' AND park_area_size >= 50 AND park_area_size <= 100 AND capacity > 500");
      }

      // -------------------------------------------------------------------------------------------------------------------------

      if ($park == '200' && $capacity == '0') {
        $stmt = $GLOBALS['pdo']->prepare("SELECT distinct a.id, a.name, a.address, a.capacity,ST_X(ST_Centroid(a.geom)) AS longitude,
                                          ST_Y(ST_CENTROID(a.geom)) As latitude FROM worship_place as a WHERE a.type iLIKE '%$type%'
                                          AND name iLIKE '%$name%' AND park_area_size >= 100 AND park_area_size <= 200 AND capacity > 0");
      }
      if ($park == '200' && $capacity == '100') {
        $stmt = $GLOBALS['pdo']->prepare("SELECT distinct a.id, a.name, a.address, a.capacity,ST_X(ST_Centroid(a.geom)) AS longitude,
                                          ST_Y(ST_CENTROID(a.geom)) As latitude FROM worship_place as a WHERE a.type iLIKE '%$type%'
                                          AND name iLIKE '%$name%' AND park_area_size >= 100 AND park_area_size <= 200 AND capacity > 0 AND capacity <= 100");
      }
      if ($park == '200' && $capacity == '300') {
        $stmt = $GLOBALS['pdo']->prepare("SELECT distinct a.id, a.name, a.address, a.capacity,ST_X(ST_Centroid(a.geom)) AS longitude,
                                          ST_Y(ST_CENTROID(a.geom)) As latitude FROM worship_place as a WHERE a.type iLIKE '%$type%'
                                          AND name iLIKE '%$name%' AND park_area_size >= 100 AND park_area_size <= 200 AND capacity >= 100 AND capacity <= 300");
      }
      if ($park == '200' && $capacity == '500') {
        $stmt = $GLOBALS['pdo']->prepare("SELECT distinct a.id, a.name, a.address, a.capacity,ST_X(ST_Centroid(a.geom)) AS longitude,
                                          ST_Y(ST_CENTROID(a.geom)) As latitude FROM worship_place as a WHERE a.type iLIKE '%$type%'
                                          AND name iLIKE '%$name%' AND park_area_size >= 100 AND park_area_size <= 200 AND capacity >= 300 AND capacity <= 500");
      }
      if ($park == '200' && $capacity == '500') {
        $stmt = $GLOBALS['pdo']->prepare("SELECT distinct a.id, a.name, a.address, a.capacity,ST_X(ST_Centroid(a.geom)) AS longitude,
                                          ST_Y(ST_CENTROID(a.geom)) As latitude FROM worship_place as a WHERE a.type iLIKE '%$type%'
                                          AND name iLIKE '%$name%' AND park_area_size >= 100 AND park_area_size <= 200 AND capacity > 500");
      }

      // -------------------------------------------------------------------------------------------------------------------------

      if ($park == 'more' && $capacity == '0') {
        $stmt = $GLOBALS['pdo']->prepare("SELECT distinct a.id, a.name, a.address, a.capacity,ST_X(ST_Centroid(a.geom)) AS longitude,
                                          ST_Y(ST_CENTROID(a.geom)) As latitude FROM worship_place as a WHERE a.type iLIKE '%$type%'
                                          AND name iLIKE '%$name%' AND park_area_size > 200 AND capacity > 0");
      }
      if ($park == 'more' && $capacity == '100') {
        $stmt = $GLOBALS['pdo']->prepare("SELECT distinct a.id, a.name, a.address, a.capacity,ST_X(ST_Centroid(a.geom)) AS longitude,
                                          ST_Y(ST_CENTROID(a.geom)) As latitude FROM worship_place as a WHERE a.type iLIKE '%$type%'
                                          AND name iLIKE '%$name%' AND park_area_size > 200 AND capacity > 0 AND capacity <= 100");
      }
      if ($park == 'more' && $capacity == '300') {
        $stmt = $GLOBALS['pdo']->prepare("SELECT distinct a.id, a.name, a.address, a.capacity,ST_X(ST_Centroid(a.geom)) AS longitude,
                                          ST_Y(ST_CENTROID(a.geom)) As latitude FROM worship_place as a WHERE a.type iLIKE '%$type%'
                                          AND name iLIKE '%$name%' AND park_area_size > 200 AND capacity >= 100 AND capacity <= 300");
      }
      if ($park == 'more' && $capacity == '500') {
        $stmt = $GLOBALS['pdo']->prepare("SELECT distinct a.id, a.name, a.address, a.capacity,ST_X(ST_Centroid(a.geom)) AS longitude,
                                          ST_Y(ST_CENTROID(a.geom)) As latitude FROM worship_place as a WHERE a.type iLIKE '%$type%'
                                          AND name iLIKE '%$name%' AND park_area_size > 200 AND capacity >= 300 AND capacity <= 500");
      }
      if ($park == 'more' && $capacity == '500') {
        $stmt = $GLOBALS['pdo']->prepare("SELECT distinct a.id, a.name, a.address, a.capacity,ST_X(ST_Centroid(a.geom)) AS longitude,
                                          ST_Y(ST_CENTROID(a.geom)) As latitude FROM worship_place as a WHERE a.type iLIKE '%$type%'
                                          AND name iLIKE '%$name%' AND park_area_size > 200 AND capacity > 500");
      }

    }else{
      $stmt = $GLOBALS['pdo']->prepare("SELECT distinct a.id, a.name, a.address, a.capacity,ST_X(ST_Centroid(a.geom)) AS longitude,
                                        ST_Y(ST_CENTROID(a.geom)) As latitude FROM worship_place as a");
    }

    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($data);
  }

  public function filterEvent()
  {
    if (isset($_GET['date'])) {
      $dates = date("Y-m-d", strtotime($_GET['date']));
      $stmt = $GLOBALS['pdo']->prepare("SELECT distinct a.id, a.name, a.address, a.capacity,ST_X(ST_Centroid(a.geom)) AS longitude,
                                        ST_Y(ST_CENTROID(a.geom)) As latitude FROM worship_place as a INNER JOIN schedule
                                        ON schedule.worship_place_id=a.id
                                        WHERE schedule.date >= :dates");
      $stmt->execute(['dates' => $dates]);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);
      echo json_encode($data);
    }
  }

  public function filterFacility()
  {
    $str = "";
    $array = explode (",", $_GET['name']);
    foreach ($array as $key) {
      $str .= ",'".$key."'";
    }
    $str = substr($str,1);

    $stmt = $GLOBALS['pdo']->prepare("SELECT distinct a.id, a.name, a.address, a.capacity,ST_X(ST_Centroid(a.geom)) AS longitude,
                                      ST_Y(ST_CENTROID(a.geom)) As latitude FROM worship_place as a INNER JOIN detail_condition ON
                                      detail_condition.worship_place_id=a.id WHERE facility_id IN (". $str .")");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_OBJ);

    echo json_encode($result);
  }

}
