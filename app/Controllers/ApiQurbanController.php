<?php

class ApiQurbanController extends Controller
{

  function __construct()
  {
    header('content-type: application/json; charset=utf8');
	  header("access-control-allow-origin: *");
  }

  function index()
  {
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM qurban INNER JOIN worship_place
                                      ON worship_place.id=qurban.worship_place_id");
    $stmt->execute();
    $r = $stmt->fetchAll(PDO::FETCH_OBJ);

    foreach ($r as $key) {
      $stmt = $GLOBALS['pdo']->prepare("SELECT q.animal_price, q.deadline_payment, q.year
                                        FROM qurban AS q WHERE worship_place_id=:id
                                        AND q.year=:y");
      $stmt->execute(['id'=>$key->id, 'y' => date('Y')]);
      $t = $stmt->fetchAll(PDO::FETCH_OBJ);
      $key->animal_type = $t;
    }

    echo json_encode($r);
  }

  function show()
  {
    if (isset($_GET['id'])) {

      $id = $_GET['id'];
      $_GET['year']= date('Y');

      $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM qurban INNER JOIN worship_place
                                        ON worship_place.id=qurban.worship_place_id
                                        WHERE qurban.worship_place_id=:id AND qurban.year=:y");
      $stmt->execute(['id'=> $id, 'y' => $_GET['year']]);
      $r = $stmt->fetch(PDO::FETCH_OBJ);

      // $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM bank_account
      //                                   INNER JOIN bank ON bank_account.bank_code=bank.bank_code
      //                                   WHERE bank_account.worship_place_id=:id");
      // $stmt->execute(['id' => $id]);
      // $account = $stmt->fetchAll(PDO::FETCH_OBJ);
      //
      // $stmt = $GLOBALS['pdo']->prepare("SELECT DISTINCT group_name, animal FROM qurban_group
      //                                   WHERE worship_place_id=:id AND year=:y ORDER BY group_name");
      // $stmt->execute(['id'=> $id, 'y' => $_GET['year']]);
      // $group = $stmt->fetchAll(PDO::FETCH_OBJ);
      $r->description = strip_tags($r->description);
      $r->description = str_replace("\r\n", '', $r->description);
      echo json_encode($r);

    }else{
      $result = ['status' => 'error get data'];
      echo json_encode($result);
    }
  }

  public function store()
  {
    $worship_id = $_GET['id'];
    $_POST['year'] = date('Y');
    $_POST['group_name'] = substr($_POST['group_name'], -2);

    // check group available
    $stmt = $GLOBALS['pdo']->prepare("SELECT COUNT(*) as available FROM qurban_detail
                                      WHERE worship_place_id=:id AND year=:year AND group_name=:grup");
    $stmt->execute(['id' => $worship_id, 'year' => $_POST['year'],
                    'grup' => $_POST['group_name']]);
    $avai = $stmt->fetch(PDO::FETCH_OBJ);
    // end check group available

    // -------------------------------- Checking total cannot bigger tahn available
    if ($_POST['total_qurban'] + $avai->available > 7) {
      $result = ['status' => 'Group full ! Max 7, Please choose another group..'];
      echo json_encode($result);
      return true;
    }
    // end checking

    // Get serial numbers
    $stmt = $GLOBALS['pdo']->prepare("SELECT serial_number FROM qurban_detail WHERE worship_place_id=:id
                                      AND year=:year AND group_name=:grup ORDER BY serial_number DESC");
    $stmt->execute(['id' => $worship_id, 'year' => $_POST['year'], 'grup' => $_POST['group_name']]);
    $serial = $stmt->fetch(PDO::FETCH_OBJ);

    if (!$serial)
        $nextSerial = 1;
    else
        $nextSerial = $serial->serial_number + 1;
    // End get serial number

    // Get last number order
    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM qurban_order WHERE date=:dates
                                      ORDER BY order_number DESC");
    $stmt->execute(['dates' => date('Y-m-d')]);
    $lastInput = $stmt->fetch(PDO::FETCH_OBJ);

    if (!$lastInput)
        $order_number = 1;
    else
        $order_number = $lastInput->order_number + 1;
    // End get last number order

    // insert to qurban_order
    $stmt = $GLOBALS['pdo']->prepare("INSERT INTO qurban_order(jamaah_id, uang_muka,
                                      uang_pelunasan, date, payment_completed, order_number)
                                      VALUES(:id, 0, 0, now(), 'false', :order)");
    $stmt->execute(['id' => $_POST['user'], 'order' => $order_number]);
    // end insert qurban_order

    // insert data to qurban_detail
    for ($i=0; $i < $_POST['total_qurban']; $i++) {

      $stmt = $GLOBALS['pdo']->prepare('INSERT INTO qurban_detail(worship_place_id, year,
                                        group_name, jamaah_id, serial_number, order_number, date)
                                        VALUES(:worship, :year, :group, :jamaah,
                                        :serial_number, :order_number, now())');
      $stmt->execute(['worship' => $worship_id,
                      'year' => $_POST['year'],
                      'group' => $_POST['group_name'],
                      'jamaah' => $_POST['user'],
                      'serial_number' => $nextSerial,
                      'order_number' => $order_number
                    ]);

      $nextSerial++;
    }

    $result = [
                'status' => '"Qurban transaction success! Please check your history transaction for payment!',
                'id' => date('Ymd').$order_number.$_POST['user']
              ];
    echo json_encode($result);
  }

  public function invoice()
  {
    $invoice = $_GET['invoice'];
    $_GET['date'] = substr($invoice, 0, 8);
    $_GET['jamaah_id'] = substr($invoice, -16);
    $_GET['order_number'] = str_replace($_GET['date'], '', $invoice);
    $_GET['order_number'] = str_replace($_GET['jamaah_id'], '', $_GET['order_number']);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM qurban_order
                                      WHERE date=:dates
                                      AND order_number=:order
                                      AND jamaah_id=:jamaah");
    $stmt->execute(['dates' => $_GET['date'],
                    'order' => $_GET['order_number'],
                    'jamaah' =>$_GET['jamaah_id']]);
    $qurban = $stmt->fetch(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM qurban_detail INNER JOIN qurban_group
                                      ON qurban_detail.worship_place_id=qurban_group.worship_place_id
                                      AND qurban_detail.year=qurban_group.year
                                      AND qurban_detail.group_name=qurban_group.group_name
                                      WHERE date=:dates
                                      AND order_number=:order
                                      AND jamaah_id=:jamaah");
    $stmt->execute(['dates' => $_GET['date'],
                    'order' => $_GET['order_number'],
                    'jamaah' =>$_GET['jamaah_id']
                  ]);
    $detail = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT animal, animal_price, qurban_detail.worship_place_id, worship_place.name
                                      FROM qurban_detail INNER JOIN qurban_group
                                      ON qurban_detail.worship_place_id=qurban_group.worship_place_id
                                      AND qurban_detail.year=qurban_group.year
                                      AND qurban_detail.group_name=qurban_group.group_name
                                      INNER JOIN qurban ON qurban.worship_place_id=qurban_group.worship_place_id
                                      AND qurban.year=qurban_group.year
                                      INNER JOIN worship_place ON qurban_detail.worship_place_id=worship_place.id
                                      WHERE date=:dates
                                      AND order_number=:order
                                      AND jamaah_id=:jamaah");
    $stmt->execute(['dates' => $_GET['date'],
                    'order' => $_GET['order_number'],
                    'jamaah' =>$_GET['jamaah_id']
                  ]);
    $animal = $stmt->fetch(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM bank_account INNER JOIN bank
                                      ON bank_account.bank_code=bank.bank_code
                                      WHERE bank_account.worship_place_id=:worship");
    $stmt->execute(['worship' => $animal->worship_place_id]);
    $account = $stmt->fetch(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM stewardship
                                      INNER JOIN jamaah ON jamaah.id=stewardship.jamaah_id
                                      WHERE worship_place_id=:worship");
    $stmt->execute(['worship' => $animal->worship_place_id]);
    $steward = $stmt->fetch(PDO::FETCH_OBJ);

    $date = new DateTime($qurban->date);
    $result = (object)[];
    $result->id = "#".$invoice;
    $result->date = $date->format('j F Y');
    $result->worship_place = $animal->name;
    $result->animal_price = 'Rp '.number_format($animal->animal_price,0,',','.');
    $result->total_order = count($detail);
    $result->unpaid = 'Rp '.number_format((($animal->animal_price * $result->total_order) - ($qurban->uang_muka + $qurban->uang_pelunasan)),0,',','.');
    $result->paid = 'Rp '.number_format(($qurban->uang_muka + $qurban->uang_pelunasan),0,',','.');
    if ($qurban->payment_completed) {
      $result->payment_completed = "Payment Completed";
    }else {
      $result->payment_completed = "Payment Incompleted";
    }
    $result->rekening_number = $account->rekening_number;
    $result->bank = $account->bank_name;
    $result->stewardship = $steward->name;
    $result->stewardship_phone = $steward->phone;
    echo json_encode($result);
  }

  public function history()
  {
    $stmt = $GLOBALS['pdo']->prepare("SELECT DISTINCT qurban_order.*, jamaah.name as jamaah_name,
                                      worship_place.name, qurban.year, qurban.animal_price
                                      FROM qurban_order
                                      INNER JOIN jamaah ON jamaah.id=qurban_order.jamaah_id
                                      INNER JOIN jamaah_worship ON jamaah_worship.jamaah_id = jamaah.id
                                      INNER JOIN qurban_detail ON qurban_order.jamaah_id=qurban_detail.jamaah_id
                                      AND qurban_order.order_number=qurban_detail.order_number
                                      AND qurban_order.date=qurban_detail.date
                                      INNER JOIN worship_place ON qurban_detail.worship_place_id=worship_place.id
                                      INNER JOIN qurban ON qurban.worship_place_id=worship_place.id
                                      WHERE qurban_order.jamaah_id=:jamaah_id ORDER BY qurban_order.date DESC");
    $stmt->execute(['jamaah_id' => $_GET['user']]);
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    foreach ($data as $key) {
      $date = new DateTime($key->date);
      $key->invoice = '#'.$date->format('Ymd') . $key->order_number . $key->jamaah_id;
      $key->date = $date->format('j F Y');

      if ($key->payment_completed) {
        $key->payment_completed = "Payment Completed";
      }else {
        $key->payment_completed = "Payment Incompleted";
      }
    }

    echo json_encode($data);
  }

  public function transaction()
  {
    $stmt = $GLOBALS['pdo']->prepare("SELECT qurban_order.*, jamaah.name as jamaah_name,
                                      worship_place.name, qurban.year, qurban.animal_price FROM qurban_order
                                      INNER JOIN jamaah ON jamaah.id=qurban_order.jamaah_id
                                      INNER JOIN jamaah_worship ON jamaah.id=jamaah_worship.jamaah_id
                                      INNER JOIN worship_place ON jamaah_worship.worship_place_id=worship_place.id
                                      INNER JOIN qurban ON qurban.worship_place_id=worship_place.id
                                      WHERE qurban_order.jamaah_id IN
                                      (SELECT jamaah_id FROM qurban_detail WHERE qurban_detail.worship_place_id IN
                                      (SELECT worship_place_id FROM jamaah_worship WHERE jamaah_worship.jamaah_id = :id))
                                      ORDER BY qurban_order.date DESC");
    $stmt->execute(['id' => $_GET['id']]);
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    foreach ($data as $key) {
      $date = new DateTime($key->date);
      $key->invoice = '#'.$date->format('Ymd') . $key->order_number . $key->jamaah_id;
      $key->date = $date->format('j F Y');

      if ($key->payment_completed) {
        $key->payment_completed = "Payment Completed";
      }else {
        $key->payment_completed = "Payment Incompleted";
      }
    }

    echo json_encode($data);
  }

  public function confirm()
  {
// 2020052811388127831827123
    $_GET['unpaid'] = str_replace(".", "", $_GET['unpaid']);
    $_GET['unpaid'] = str_replace("%", "", $_GET['unpaid']);
    $_GET['unpaid'] = str_replace(" ", "", $_GET['unpaid']);
    $_GET['unpaid'] = str_replace("Rp", "", $_GET['unpaid']);

    $invoice = $_GET['id'];
    $_GET['date'] = substr($invoice, 0, 8);
    $_GET['jamaah_id'] = substr($invoice, -16);
    $_GET['order_number'] = str_replace($_GET['date'], '', $invoice);
    $_GET['order_number'] = str_replace($_GET['jamaah_id'], '', $_GET['order_number']);

    $stmt = $GLOBALS['pdo']->prepare("SELECT * FROM qurban_order WHERE order_number=:orn
                                      AND jamaah_id=:ji AND date=:d");
    $stmt->execute(['orn' => $_GET['order_number'], 'ji' => $_GET['jamaah_id'], 'd' => $_GET['date']]);
    $qurban = $stmt->fetch(PDO::FETCH_OBJ);

    $_POST['fund'] = $_GET['total'];
    $_POST['unpaid'] = $_GET['unpaid'];
    $_POST['uang_muka'] = $qurban->uang_muka;

    if ($_POST['unpaid'] < $_POST['fund']) {
      $result = ['status' => 'Dana terlalu besar'];
      echo json_encode($result);
      return true;
    }

    if ($_POST['uang_muka'] == "0") {

      if ($_POST['unpaid'] == $_POST['fund']) {
        $stmt = $GLOBALS['pdo']->prepare("UPDATE qurban_order SET uang_muka=:lunas, payment_completed='true'
                                          WHERE jamaah_id=:jamaah AND date=:dates AND order_number=:order");
        $stmt->execute(['lunas' => $_POST['fund'],
                        'jamaah' => $_GET['jamaah_id'],
                        'dates' => $_GET['date'],
                        'order' => $_GET['order_number']]);
      }else{
        $stmt = $GLOBALS['pdo']->prepare('UPDATE qurban_order SET uang_muka=:muka WHERE jamaah_id=:jamaah
                                          AND date=:dates AND order_number=:order');
        $stmt->execute(['muka' => $_POST['fund'],
                        'jamaah' => $_GET['jamaah_id'],
                        'dates' => $_GET['date'],
                        'order' => $_GET['order_number']]);
      }

    }else{

      if ($_POST['unpaid'] != $_POST['fund']) {
        $result = ['status' => 'Dana terlalu besar'];
        echo json_encode($result);
        return true;
      }

      $stmt = $GLOBALS['pdo']->prepare("UPDATE qurban_order SET uang_pelunasan=:lunas, payment_completed='true'
                                        WHERE jamaah_id=:jamaah AND date=:dates AND order_number=:order");
      $stmt->execute(['lunas' => $_POST['fund'],
                      'jamaah' => $_GET['jamaah_id'],
                      'dates' => $_GET['date'],
                      'order' => $_GET['order_number']]);
    }

    $result = ['status' => 'Data berhasil diupdate'];
    echo json_encode($result);
  }
}
