<?php

class FacilityController extends Controller{

// __________________________________________ ADMIN __________________________________________
  public function indexFacility()
  {
    $this->authAdmin();
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM facility");
    $stmt->execute();

    return $this->view('admin/facility', ['facility' => $stmt]);
  }

  public function storeFacility()
  {
    $this->authAdmin();
    $this->check_csrf($_POST);

    $stmt = $GLOBALS['pdo']->prepare("INSERT INTO facility(name) VALUES(:name)");
    $status = $stmt->execute(['name' => $_POST['name']]);

    return $this->redirect('admin/facility-type?success=true');
  }

  public function destroyFacility()
  {
    $this->authAdmin();
    if(isset($_GET['id'])){
      $stmt = $GLOBALS['pdo']->prepare('DELETE FROM facility WHERE id=:id');
      $stmt->execute(['id' => $_GET['id']]);

      return $this->redirect('admin/facility-type?deleted=true');
    }
  }

// __________________________________________ STEWARDSHIP __________________________________________
  public function facilityStewardship()
  {
    $this->authStewardship();
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM detail_condition
                                      INNER JOIN facility ON detail_condition.facility_id = facility.id
                                      INNER JOIN facility_condition ON detail_condition.facility_condition_id = facility_condition.id
                                      WHERE worship_place_id=:id ORDER BY detail_condition.updated_at DESC");
    $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM facility");
    $stmt->execute();
    $fac = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM facility_condition");
    $stmt->execute();
    $con = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('stewardship/facility', ['f' => $data, 'fac' => $fac, 'con' => $con]);
  }

  public function storeFacilityStewardship()
  {
    $this->authStewardship();
    $this->check_csrf($_POST);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM detail_condition WHERE worship_place_id=:w AND facility_id=:f AND facility_condition_id=:c");
    $stmt->execute(['w' => $_SESSION['user']->worship_place_id, 'f' => $_POST['facility'], 'c' => $_POST['condition']]);
    $con = $stmt->fetchAll(PDO::FETCH_OBJ);

    if (!empty($con)) {
      $this->flash('This Item is Duplicate!');
      return $this->redirect('stewardship/mosque/facility');
    }

    $stmt = $GLOBALS['pdo']->prepare("INSERT INTO detail_condition(worship_place_id, facility_id, facility_condition_id, total, updated_at)
                                      VALUES(:worship, :facility, :condition, :total, now() )");
    $status = $stmt->execute(['worship' => $_SESSION['user']->worship_place_id,
                              'facility' => $_POST['facility'],
                              'condition' => $_POST['condition'],
                              'total' => $_POST['total']
                             ]);

    $this->flash('Add Facility Successfull!');
    return $this->redirect('stewardship/mosque/facility');
  }

  public function updateFacilityStewardship()
  {
    if (isset($_GET['f']) && isset($_GET['c']) && isset($_GET['w']))
    {
      $this->authStewardship();
      $this->check_csrf($_POST);
      if ($_POST['condition'] == '0') {
        $this->flash('You have to choose condition');
        return $this->redirect('stewardship/mosque/facility');
      }else{

        $stmt = $GLOBALS['pdo']->prepare("UPDATE detail_condition SET facility_condition_id=:c, total=:t
                                          WHERE worship_place_id=:w AND facility_id=:f
                                          AND facility_condition_id=:c_old");
        $status = $stmt->execute(['c' => $_POST['condition'],
                                  't' => $_POST['total'],
                                  'w' => $_SESSION['user']->worship_place_id,
                                  'f' => $_GET['f'],
                                  'c_old' => $_GET['c']
                                 ]);
         $this->flash('Update Facility Successfull!');
         return $this->redirect('stewardship/mosque/facility');
      }
    }else{
      return $this->redirect('stewardship/mosque/facility');
    }
  }

  public function destroyFacilityStewardship()
  {
    if (isset($_GET['f']) && isset($_GET['c']) && isset($_GET['w']))
    {
      $this->authStewardship();
      $this->check_csrf($_POST);

      $stmt = $GLOBALS['pdo']->prepare("DELETE FROM detail_condition
                                        WHERE worship_place_id=:w AND facility_id=:f
                                        AND facility_condition_id=:c_old");
      $status = $stmt->execute([
                                'w' => $_SESSION['user']->worship_place_id,
                                'f' => $_GET['f'],
                                'c_old' => $_GET['c']
                               ]);
       $this->flash('Destroy Facility Successfull!');
       return $this->redirect('stewardship/mosque/facility');

    }else{
      return $this->redirect('stewardship/mosque/facility');
    }
  }

}
