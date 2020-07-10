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
    $id = "M".$id;

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
      $stmt = $GLOBALS['pdo']->prepare('SELECT image FROM gallery WHERE serial_number=:id');
      $stmt->execute(['id' => $_GET['gallery']]);
      $stmt = $stmt->fetch();

      if(!unlink('images/mosque/' . $stmt['image'])){
        $this->flash('Image destroy error!');
        return $this->redirect('admin/mosque/gallery?id='. $_GET['id']);
      }

      $stmt = $GLOBALS['pdo']->prepare('DELETE FROM gallery WHERE serial_number=:id');
      $stmt->execute(['id' => $_GET['gallery']]);

      $this->flash('Data berhasil dihapus!');
      return $this->redirect('admin/mosque/gallery?id='. $_GET['id']);
    }
  }

  public function destroyMosque()
  {
    $this->authAdmin();
    if(isset($_GET['id'])){

      $stmt = $GLOBALS['pdo']->prepare('SELECT * FROM jamaah_worship WHERE worship_place_id=:id');
      $stmt->execute(['id' => $_GET['id']]);
      $stmt = $stmt->fetch();

      if (isset($stmt)) {
        $this->flash('Masih ada jamaah yang terdaftar di masjid ini!');
        return $this->redirect('admin/mosque');
      }

      $stmt = $GLOBALS['pdo']->prepare('SELECT * FROM gallery WHERE worship_place_id=:id');
      $stmt->execute(['id' => $_GET['id']]);

      foreach($stmt as $value){
        unlink('images/mosque/' . $value['image']);
        $stmt = $GLOBALS['pdo']->prepare('DELETE FROM gallery WHERE serial_number=:id');
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

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM jamaah_worship INNER JOIN worship_place
                                      ON worship_place.id=jamaah_worship.worship_place_id
                                      WHERE jamaah_worship.jamaah_id=:id");
    $stmt->execute(['id' => $_SESSION['user']->id]);
    $worships =  $stmt->fetchAll(PDO::FETCH_OBJ);

    if (empty($worships))
      return $this->redirect('jamaah/dashboard');

    if (!isset($_GET['worship']))
      $id = $worships[0]->worship_place_id;
    else
      $id = $_GET['worship'];

    $stmt = $GLOBALS['pdo']->prepare("SELECT a.id, a.name, a.address, a.capacity, a.park_area_size,
                                      ST_X(ST_Centroid(geom)) AS lang, ST_Y(ST_CENTROID(geom)) As lat
                                      FROM worship_place as a WHERE id=:id");
    $stmt->execute(['id' => $id]);
    $data = $stmt->fetch(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT ustad.name as ustad, event.*, schedule.* FROM schedule
                                      INNER JOIN ustad ON schedule.ustad_id = ustad.id
                                      INNER JOIN event ON schedule.event_id = event.id
                                      WHERE schedule.worship_place_id=:id");
    $stmt->execute(['id' => $id]);
    $e =  $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM detail_condition
                                      INNER JOIN facility ON detail_condition.facility_id = facility.id
                                      INNER JOIN facility_condition ON detail_condition.facility_condition_id = facility_condition.id
                                      WHERE worship_place_id=:id ORDER BY detail_condition.updated_at DESC");
    $stmt->execute(['id' => $id]);
    $f =  $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT SUM(uang_muka) as uang_muka, SUM(uang_pelunasan) as pelunasan
                                      FROM qurban_order WHERE jamaah_id IN
                                      (SELECT jamaah_id FROM qurban_detail WHERE worship_place_id=:id
                                      AND year=:y)");
    $stmt->execute(['id'=> $id, 'y' => $_GET['year']]);
    $fundRaised = $stmt->fetch(PDO::FETCH_OBJ);
    $fundRaised = $fundRaised->uang_muka + $fundRaised->pelunasan;

    $stmt = $GLOBALS['pdo']->prepare("SELECT COUNT(*) FROM qurban_detail INNER JOIN qurban_group
                                      ON qurban_group.worship_place_id=qurban_detail.worship_place_id
                                      AND qurban_group.year=qurban_detail.year
                                      AND qurban_group.group_name=qurban_detail.group_name
                                      WHERE qurban_detail.worship_place_id=:id
                                      AND qurban_detail.year=:y AND qurban_group.animal=:animal");
    $stmt->execute(['id'=> $id, 'y' => $_GET['year'], 'animal' => 'Goat']);
    $goat = $stmt->fetch(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT COUNT(*) FROM qurban_group
                                      WHERE worship_place_id=:id AND year=:y AND animal=:animal");
    $stmt->execute(['id'=> $id, 'y' => $_GET['year'], 'animal' => 'Cow']);
    $cow = $stmt->fetch(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT COUNT(*)
                                      FROM qurban_order WHERE jamaah_id IN
                                      (SELECT jamaah_id FROM qurban_detail WHERE worship_place_id=:id
                                      AND year=:y)");
    $stmt->execute(['id'=> $id, 'y' => $_GET['year']]);
    $participant = $stmt->fetch(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT group_name, animal FROM qurban_group WHERE worship_place_id=:id AND year=:y ORDER BY group_name");
    $stmt->execute(['id'=> $id, 'y' => $_GET['year']]);
    $group = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT year FROM qurban WHERE worship_place_id=:id");
    $stmt->execute(['id'=> $id]);
    $year = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('jamaah/report', ['group' => $group,
                                          'year' => $year,
                                          'fundRaised' => $fundRaised,
                                          'goat' => $goat->count,
                                          'cow' => $cow->count,
                                          'participant' => $participant->count,
                                          'q' => $data,
                                          'event' => $e,
                                          'facility' => $f,
                                          'worships' => $worships]);
  }
}
