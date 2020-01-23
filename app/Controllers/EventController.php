<?php

/**
 * class untuk inisialisasi database
 */
class EventController extends Controller{

  public function index()
  {
    $this->authStewardship();
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM event");
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('stewardship/event', ['event' => $data]);
  }

  public function store()
  {
    $this->authStewardship();
    $this->check_csrf($_POST);

    $stmt = $GLOBALS['pdo']->prepare("INSERT INTO event(name, description, last_editor)
                                      VALUES(:name, :description, :last)");
    $stmt->execute(['name'=> $_POST['name'], 'description' => $_POST['description'],
                    "last" => "Edited by ". $_SESSION['user']->username." at ".date('Y-m-d H:i:s')]);

    $this->flash('Add Event Data Successfully!');
    return $this->redirect('stewardship/mosque/event');
  }

  public function update()
  {
    if (isset($_GET['id'])) {
      $this->authStewardship();
      $this->check_csrf($_POST);

      $stmt = $GLOBALS['pdo']->prepare("UPDATE event SET name=:name, description=:description, last_editor=:last WHERE id=:id");
      $stmt->execute(['name'=> $_POST['name'], 'description' => $_POST['description'], 'id' => $_GET['id'],
                      "last" => "Edited by ". $_SESSION['user']->username." at ".date('Y-m-d H:i:s')]);

      $this->flash('Edit Event Data Successfully!');
      return $this->redirect('stewardship/mosque/event');
    }else{
      return $this->redirect('stewardship/mosque/event');
    }
  }

  public function indexSchedule()
  {
    $this->authStewardship();
    $stmt = $GLOBALS['pdo']->prepare("SELECT ustad.name as ustad, event.name, schedule.worship_place_id,
                                      schedule.date, schedule.time FROM schedule
                                      INNER JOIN ustad ON schedule.ustad_id = ustad.id
                                      INNER JOIN event ON schedule.event_id = event.id
                                      WHERE schedule.worship_place_id=:id");
    $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);
    // $this->die($data);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM ustad");
    $stmt->execute();
    $ustad = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM event ");
    $stmt->execute();
    $event = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('stewardship/schedule', ['sch' => $data, 'ustad' => $ustad, 'event' => $event]);
  }

  public function storeSchedule()
  {
    $this->authStewardship();
    $this->check_csrf($_POST);

    $date = new DateTime($_POST['schedule']);
    $_POST['schedule'] = $date->format('Y-m-d');

    $stmt = $GLOBALS['pdo']->prepare("INSERT INTO schedule(ustad_id, event_id, worship_place_id, date, time)
                                      VALUES(:ustad, :event, :worship, :dates, :times)");
    $stmt->execute(['ustad'=> $_POST['ustad'], 'event' => $_POST['event'], 'worship' => $_SESSION['user']->worship_place_id,
                    'dates' => $_POST['schedule'], 'times' => $_POST['time']]);

    $this->flash('Add Schedule Success!');
    return $this->redirect('stewardship/mosque/schedule');
  }

  public function destroySchedule()
  {
    if (isset($_GET['id'])) {
      $this->authStewardship();

      $stmt = $GLOBALS['pdo']->prepare("DELETE FROM schedule WHERE worship_place_id=:id AND date=:dates AND time=:times");
      $stmt->execute(['id' => $_GET['id'], 'dates' => $_GET['date'], 'times' => $_GET['time']]);

      $this->flash('Delete Schedule Success!');
      return $this->redirect('stewardship/mosque/schedule');
    }else{
      return $this->redirect('stewardship/mosque/schedule');
    }
  }

}
