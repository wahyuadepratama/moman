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
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM facility");
    $stmt->execute();
    return $this->view('admin/mosque_new', ['f' => $stmt]);
  }

  public function storeMosque()
  {
    $this->authAdmin();
    $this->check_csrf($_POST);

    $stmt = $GLOBALS['pdo']->prepare("INSERT INTO worship_place(name, address, capacity, park_area_size, geom, type, updated_at)
                                      VALUES(:name, :address, :capacity, :park_area_size, ST_GeomFromText(:geom), :type, now())");
    $stmt->execute(['name' => $_POST['name'], 'address' => $_POST['address'], 'capacity' => $_POST['capacity'], 'park_area_size' => $_POST['park_area_size'], 'geom' => $_POST['geom'], 'type' => $_POST['type']]);
    $worship_place_id = $GLOBALS['pdo']->lastInsertId();

    foreach ($_POST['facility'] as $key) {
      $stmt = $GLOBALS['pdo']->prepare("INSERT INTO detail_condition(worship_place_id, facility_id, facility_condition_id, total, updated_at)
                                        VALUES(:worship_place_id, :facility_id, :facility_condition_id, :total, now())");
      $stmt->execute(['worship_place_id' => $worship_place_id, 'facility_id' => $key, 'facility_condition_id' => 2, 'total' => 1]);
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


}
