<?php

/**
 * class untuk inisialisasi database
 */
class WorshipPlaceController extends Controller{

  //______________________________________________ ADMIN ______________________________________________
  public function listMosque()
  {
    $this->authAdmin();
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM worship_place");
    $stmt->execute();
    return $this->view('admin/mosque_list', ['mosque' => $stmt]);
  }

  public function addMosque()
  {
    $this->authAdmin();
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM facility");
    $stmt->execute();
    return $this->view('admin/mosque_new', ['f' => $stmt]);
  }

  public function storeMosque()
  {
    $this->authAdmin();
    $this->check_csrf($_POST);
    $lastId = $this->getLastId('worship_place', 'id');
    $id = (int)substr($lastId->id ,1) + 1;

    $stmt = $GLOBALS['pdo']->prepare("INSERT INTO worship_place(id, name, address, capacity, park_area_size, geom, type, updated_at)
                                      VALUES(:id, :name, :address, :capacity, :park_area_size, ST_GeomFromText(:geom), :type, now())");
    $stmt->execute(['id' => $id, 'name' => $_POST['name'], 'address' => $_POST['address'], 'capacity' => $_POST['capacity'], 'park_area_size' => $_POST['park_area_size'], 'geom' => $_POST['geom'], 'type' => $_POST['type']]);

    foreach ($_POST['facility'] as $key) {
      $stmt = $GLOBALS['pdo']->prepare("INSERT INTO detail_condition(worship_place_id, facility_id, facility_condition_id, total, updated_at)
                                        VALUES(:worship_place_id, :facility_id, :facility_condition_id, :total, now())");
      $stmt->execute(['worship_place_id' => $id, 'facility_id' => $key, 'facility_condition_id' => 2, 'total' => 1]);
    }

    $this->flash('Berhasil menambah data masjid!');
    return $this->redirect('admin/mosque');
  }

  public function galleryMosque()
  {
    $this->authAdmin();
    if(isset($_GET['id'])){
      $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM gallery WHERE worship_place_id=:id");
      $stmt->execute(['id' => $_GET['id']]);
      return $this->view('admin/mosque_gallery', ['data' => $stmt]);
    }else{
      return $this->view('error/404');
    }
  }

  public function storeGalleryMosque()
  {
    $this->authAdmin();
    $this->check_csrf($_POST);

    if (isset($_GET['id'])) {
      $jenis_gambar=$_FILES['image']['type'];
      	if(($jenis_gambar=="image/jpeg" || $jenis_gambar=="image/jpg" || $jenis_gambar=="image/gif"  || $jenis_gambar=="image/png")
            && ($_FILES["image"]["size"] <= 3000000)){

          $sourcename=$_FILES["image"]["name"];
      		$name= time().'_'.$sourcename;
      		$filepath= 'images/mosque/' .$name;
      		move_uploaded_file($_FILES["image"]["tmp_name"], $filepath);

          $stmt = $GLOBALS['pdo']->prepare("INSERT INTO gallery(image, worship_place_id) VALUES(:name, :id)");
          $stmt->execute(['name' => $name, 'id' => $_GET['id']]);

          $this->flash('Data berhasil ditambah!');
          return $this->redirect('admin/mosque/gallery?id='. $_GET['id']);

      	} else if ($_POST['image']=='null' || $_POST['image']=='' || $_POST['image']==null){
          $this->flash('Foto tidak sesuai!');
      		return $this->redirect('admin/mosque/gallery?id='. $_GET['id']);
      	}
    }else{
      return $this->view('error/404');
    }
  }

  public function destroyGalleryMosque()
  {
    $this->authAdmin();
    if(isset($_GET['gallery'])){
      $stmt = $GLOBALS['pdo']->prepare('SELECT image FROM gallery WHERE id=:id');
      $stmt->execute(['id' => $_GET['gallery']]);
      $stmt = $stmt->fetch();

      if(!unlink('images/mosque/' . $stmt['image'])){
        $this->flash('Image destroy error!');
        return $this->redirect('admin/mosque/gallery?id='. $_GET['id']);
      }

      $stmt = $GLOBALS['pdo']->prepare('DELETE FROM gallery WHERE id=:id');
      $stmt->execute(['id' => $_GET['gallery']]);

      $this->flash('Data berhasil dihapus!');
      return $this->redirect('admin/mosque/gallery?id='. $_GET['id']);
    }
  }

  public function destroyMosque()
  {
    $this->authAdmin();
    if(isset($_GET['id'])){

      $stmt = $GLOBALS['pdo']->prepare('SELECT * FROM gallery WHERE worship_place_id=:id');
      $stmt->execute(['id' => $_GET['id']]);

      foreach($stmt as $value){
        unlink('images/mosque/' . $value['image']);
        $stmt = $GLOBALS['pdo']->prepare('DELETE FROM gallery WHERE id=:id');
        $stmt->execute(['id' => $value['id']]);
      }

      $stmt = $GLOBALS['pdo']->prepare('DELETE FROM worship_place WHERE id=:id');
      $stmt->execute(['id' => $_GET['id']]);

      $this->flash('Berhasil menghapus data masjid!');
      return $this->redirect('admin/mosque');
    }
  }
// ______________________________________________ JAMAAH ______________________________________________

  public function about()
  {
    $this->authJamaah();
    $id = $_SESSION['user']->worship_place_id;
    $stmt = $GLOBALS['pdo']->prepare("SELECT a.id, a.name, a.address, a.capacity, a.park_area_size,
                                      ST_X(ST_Centroid(geom)) AS lang, ST_Y(ST_CENTROID(geom)) As lat
                                      FROM worship_place as a WHERE id=:id");
    $stmt->execute(['id' => $id]);
    $data = $stmt->fetch(PDO::FETCH_OBJ);

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
    $stmt = $GLOBALS['pdo']->prepare("SELECT ustad.name as ustad, event.*, ustad_payment.* FROM ustad_payment
                                      INNER JOIN ustad ON ustad_payment.ustad_id = ustad.id
                                      INNER JOIN event ON ustad_payment.event_id = event.id
                                      WHERE event.worship_place_id=:id");
    $stmt->execute(['id' => $id]);
    $e =  $stmt->fetchAll(PDO::FETCH_OBJ);

    if (!empty($e)) {
      foreach ($e as $key) {
        $date = new DateTime($key->schedule);
        $now = new DateTime();
        if($date < $now) {
          $key->status = 'past';
        }else {
          $key->status = 'ongoing';
        }
      }
    }

    $data->image = 'images/mosque/'. $g->image;
    $data->facility = $f;
    $data->event = $e;


    $stmt = $GLOBALS['pdo']->prepare("(SELECT id, status_in, status_out, datetime, description, fund
                                      FROM cash_in WHERE worship_place_id=:id
                                      AND status_in != 'orphan balance' AND status_in != 'project balance' AND status_in != 'poor balance'
                                      AND status_in != 'event balance' AND status_in != 'tpa balance'
                                      AND EXTRACT(YEAR FROM datetime)=:y
                                      AND EXTRACT(MONTH FROM datetime)=:m AND confirmation='true' ORDER BY datetime)
                                      UNION ALL (SELECT id, status_in, status_out, datetime, description, fund
                                      FROM cash_out WHERE worship_place_id=:id
                                      AND status_in != 'orphan balance' AND status_in != 'project balance' AND status_in != 'poor balance'
                                      AND status_in != 'event balance' AND status_in != 'tpa balance'
                                      AND EXTRACT(YEAR FROM datetime)=:y
                                      AND EXTRACT(MONTH FROM datetime)=:m ORDER BY datetime) ORDER BY datetime");
    $stmt->execute(['id' => $_SESSION['user']->worship_place_id, 'y' => date('Y'), 'm' => date('m')]);
    $reportDonation = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT gq.*, mq.max_person FROM group_qurban as gq INNER JOIN
                                      mosque_qurban as mq ON gq.worship_place_id = mq.worship_place_id
                                      AND gq.year = mq.year AND gq.animal_type = mq.animal_type
                                      WHERE gq.worship_place_id=:id AND gq.year=:y ORDER BY gq.group ASC");
    $stmt->execute(['id'=> $id, 'y' => date('Y')]);
    $qurban = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM jamaah WHERE worship_place_id=:worship_id");
    $stmt->execute(['worship_id' => $_SESSION['user']->worship_place_id]);
    $jamaah = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM tpa");
    $stmt->execute();
    $tpa = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM orphanage");
    $stmt->execute();
    $orphan = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM store");
    $stmt->execute();
    $store = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM poor");
    $stmt->execute();
    $poor = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM ustad");
    $stmt->execute();
    $ustad = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM builder");
    $stmt->execute();
    $builder = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM stewardship");
    $stmt->execute();
    $stewardship = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM project WHERE worship_place_id=:id");
    $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
    $project = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM cash_in WHERE worship_place_id=:worship_id");
    $stmt->execute(['worship_id' => $_SESSION['user']->worship_place_id]);
    $cash_in = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM cash_out WHERE worship_place_id=:worship_id");
    $stmt->execute(['worship_id' => $_SESSION['user']->worship_place_id]);
    $cash_out = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('jamaah/report', ['q' => $data,
                       'allReport' => $reportDonation,
                       'qurban' => $qurban,
                       'jamaah' => $jamaah,
                       'tpa' => $tpa,
                       'orphan' => $orphan,
                       'store' => $store,
                       'poor' => $poor,
                       'ustad' => $ustad,
                       'builder' => $builder,
                       'stewardship' => $stewardship,
                       'project' => $project,
                       'cash_in' => $cash_in,
                       'cash_out' => $cash_out
                      ]);
  }
}
