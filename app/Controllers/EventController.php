<?php

/**
 * class untuk inisialisasi database
 */
class EventController extends Controller{

  public function index()
  {
    $this->authStewardship();
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM event WHERE worship_place_id=:id");
    $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('stewardship/event', ['event' => $data]);
  }

  public function store()
  {
    $this->authStewardship();
    $this->check_csrf($_POST);

    $stmt = $GLOBALS['pdo']->prepare("INSERT INTO event(name, description, worship_place_id)
                                      VALUES(:name, :description, :id)");
    $stmt->execute(['name'=> $_POST['name'], 'description' => $_POST['description'], 'id' => $_SESSION['user']->worship_place_id]);

    $this->flash('Add Event Data Successfully!');
    return $this->redirect('stewardship/mosque/event');
  }

  public function update()
  {
    if (isset($_GET['id'])) {
      $this->authStewardship();
      $this->check_csrf($_POST);

      $stmt = $GLOBALS['pdo']->prepare("UPDATE event SET name=:name, description=:description WHERE id=:id AND worship_place_id=:worship");
      $stmt->execute(['name'=> $_POST['name'], 'description' => $_POST['description'], 'id' => $_GET['id'], 'worship' => $_SESSION['user']->worship_place_id]);

      $this->flash('Edit Event Data Successfully!');
      return $this->redirect('stewardship/mosque/event');
    }else{
      return $this->redirect('stewardship/mosque/event');
    }
  }

  public function indexSchedule()
  {
    $this->authStewardship();
    $stmt = $GLOBALS['pdo']->prepare("SELECT ustad_payment.id, ustad.name as ustad, event.name, ustad_payment.schedule FROM ustad_payment
                                      INNER JOIN ustad ON ustad_payment.ustad_id = ustad.id
                                      INNER JOIN event ON ustad_payment.event_id=event.id
                                      WHERE event.worship_place_id=:id");
    $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM ustad");
    $stmt->execute();
    $ustad = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM event WHERE worship_place_id=:id");
    $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
    $event = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('stewardship/schedule', ['sch' => $data, 'ustad' => $ustad, 'event' => $event]);
  }

  public function storeSchedule()
  {
    $this->authStewardship();
    $this->check_csrf($_POST);

    $date = new DateTime($_POST['schedule']);
    $_POST['schedule'] = $date->format('Y-m-d');

    $stmt = $GLOBALS['pdo']->prepare("INSERT INTO ustad_payment(ustad_id, event_id, schedule)
                                      VALUES(:ustad, :event, :sch)");
    $stmt->execute(['ustad'=> $_POST['ustad'], 'event' => $_POST['event'], 'sch' => $_POST['schedule']]);

    $this->flash('Add Schedule Success!');
    return $this->redirect('stewardship/mosque/schedule');
  }

  public function destroySchedule()
  {
    if (isset($_GET['id'])) {
      $this->authStewardship();

      $stmt = $GLOBALS['pdo']->prepare("DELETE FROM ustad_payment WHERE id=:id");
      $stmt->execute(['id' => $_GET['id']]);

      $this->flash('Delete Schedule Success!');
      return $this->redirect('stewardship/mosque/schedule');
    }else{
      return $this->redirect('stewardship/mosque/schedule');
    }
  }

}
