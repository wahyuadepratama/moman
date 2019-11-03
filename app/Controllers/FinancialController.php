<?php

class FinancialController extends Controller{

  // __________________________________ STEWARDSHIP ____________________________________
  public function indexPayment()
  {
    $this->authStewardship();
    $stmt = $GLOBALS['pdo']->prepare("SELECT p.id, p.name, EXTRACT(YEAR FROM date) FROM project as p
                                      WHERE p.worship_place_id=:worship_id ORDER BY EXTRACT(YEAR FROM date) desc");
    $stmt->execute(['worship_id' => $_SESSION['user']->worship_place_id]);
    $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund), EXTRACT(YEAR FROM datetime) FROM cash_in WHERE worship_place_id=:id AND status_out='orphanage'
                                      AND confirmation='true' GROUP BY EXTRACT(YEAR FROM datetime) ORDER BY EXTRACT(YEAR FROM datetime) desc");
    $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
    $orphans = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund), EXTRACT(YEAR FROM datetime) FROM cash_in WHERE worship_place_id=:id AND status_out='poor'
                                      AND confirmation='true' GROUP BY EXTRACT(YEAR FROM datetime) ORDER BY EXTRACT(YEAR FROM datetime) desc");
    $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
    $poor = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund), EXTRACT(YEAR FROM datetime) FROM cash_in WHERE worship_place_id=:id AND status_out='tpa'
                                      AND confirmation='true' GROUP BY EXTRACT(YEAR FROM datetime) ORDER BY EXTRACT(YEAR FROM datetime) desc");
    $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
    $tpa = $stmt->fetchAll(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund), EXTRACT(YEAR FROM datetime) FROM cash_in WHERE worship_place_id=:id AND status_out='event'
                                      AND confirmation='true' GROUP BY EXTRACT(YEAR FROM datetime) ORDER BY EXTRACT(YEAR FROM datetime) desc");
    $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
    $event = $stmt->fetchAll(PDO::FETCH_OBJ);

    return $this->view('stewardship/payment', ['project' => $data, 'orphans' => $orphans, 'poor' => $poor, 'event' => $event, 'tpa' => $tpa]);
  }

  public function storeProject()
  {
    $this->authStewardship();
    $this->check_csrf($_POST);

    $_POST['fund'] = substr($_POST['fund'], 4);
    $_POST['fund'] = str_replace(".", "", $_POST['fund']);

    $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund) FROM cash_in WHERE project_id=:id AND status_out='project' AND confirmation='true'");
    $stmt->execute(['id' => $_GET['id']]);
    $cash_in = $stmt->fetch(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund) FROM cash_out WHERE project_id=:id");
    $stmt->execute(['id' => $_GET['id']]);
    $cash_out = $stmt->fetch(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund) FROM cash_in WHERE project_id=:id AND status_out=:s");
    $stmt->execute(['id' => $_GET['id'], 's' => 'cash']);
    $cash = $stmt->fetch(PDO::FETCH_OBJ);

    $cash_out->sum = $cash_out->sum + $cash->sum;

    if ($cash_in->sum - ($cash_out->sum + $_POST['fund']) < 0) {
      $t = $cash_in->sum - $cash_out->sum;
      $this->flash('Not enough funds! You just have Rp '. number_format(($t),0,',','.'). ' saldo for this project!');
      return $this->redirect('stewardship/donation/payment');

    }else{

      if ($_POST['cash_out'] == 'store') {
        $stmt = $GLOBALS['pdo']->prepare("INSERT INTO cash_out(worship_place_id, project_id, fund, datetime, description, status_in, status_out, store_id)
                                          VALUES(:_wpi, :_pi, :_f, now(), :_d, :_si, :_so, :_store)");
        $stmt->execute([
          '_wpi' => $_SESSION['user']->worship_place_id,
          '_pi' => $_GET['id'],
          '_f' => $_POST['fund'],
          '_d' => $_POST['keterangan'],
          '_si' => 'project',
          '_so' => 'store payment',
          '_store' => $_POST['store']
        ]);
      }

      if ($_POST['cash_out'] == 'builder') {
        $stmt = $GLOBALS['pdo']->prepare("INSERT INTO cash_out(worship_place_id, project_id, fund, datetime, description, status_in, status_out, builder_id)
                                          VALUES(:_wpi, :_pi, :_f, now(), :_d, :_si, :_so, :_b)");
        $stmt->execute([
          '_wpi' => $_SESSION['user']->worship_place_id,
          '_pi' => $_GET['id'],
          '_f' => $_POST['fund'],
          '_d' => $_POST['keterangan'],
          '_si' => 'project',
          '_so' => 'builder payment',
          '_b' => $_POST['builder']
        ]);
      }

      if ($_POST['cash_out'] == 'cash') {
        $stmt = $GLOBALS['pdo']->prepare("INSERT INTO cash_in(worship_place_id, project_id, fund, status_in, status_out,datetime, description, confirmation)
                                          VALUES(:_wpi, :_pi, :_f, :_si, :_so, now(), :_d, :_c)");
        $stmt->execute([
          '_wpi' => $_SESSION['user']->worship_place_id,
          '_pi' => $_GET['id'],
          '_f' => $_POST['fund'],
          '_si' => 'project balance',
          '_so' => 'cash',
          '_d' => 'Sisa saldo dari project',
          '_c' => 'true'
        ]);
      }

      $this->flash('Fund Used Successfully!');
      return $this->redirect('stewardship/donation/payment');

    }
  }

  public function storeOrphans()
  {
    $this->authStewardship();
    $this->check_csrf($_POST);

    $_POST['fund'] = substr($_POST['fund'], 4);
    $_POST['fund'] = str_replace(".", "", $_POST['fund']);

    $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund) FROM cash_in WHERE worship_place_id=:id AND status_out='orphanage'
                                      AND confirmation='true'");
    $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
    $cash_in = $stmt->fetch(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund) FROM cash_out WHERE status_out='orphanage payment' AND worship_place_id=:worship_id ");
    $stmt->execute(['worship_id' => $_SESSION['user']->worship_place_id]);
    $d_cash_out = $stmt->fetch(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund) FROM cash_in WHERE worship_place_id=:id AND status_out='cash' AND confirmation='true' AND status_in='orphan balance'");
    $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
    $d_cash = $stmt->fetch(PDO::FETCH_OBJ);

    $d_cash_out->sum = $d_cash_out->sum + $d_cash->sum;

    if ($cash_in->sum - ($d_cash_out->sum + $_POST['fund']) < 0) {
      $t = $cash_in->sum - $d_cash_out->sum;
      $this->flash('Not enough funds! You just have Rp '. number_format(($t),0,',','.'). ' saldo for this orphans donation!');
      return $this->redirect('stewardship/donation/payment');

    }else{

      if ($_POST['cash_out'] == 'orphan') {
        $stmt = $GLOBALS['pdo']->prepare("INSERT INTO cash_out(worship_place_id, fund, datetime, description, status_in, status_out, orphanage_id)
                                          VALUES(:_wpi, :_f, now(), :_d, :_si, :_so, :_o)");
        $stmt->execute([
          '_wpi' => $_SESSION['user']->worship_place_id,
          '_f' => $_POST['fund'],
          '_d' => $_POST['keterangan'],
          '_si' => 'orphanage',
          '_so' => 'orphanage payment',
          '_o' => $_POST['orphan']
        ]);
      }

      if ($_POST['cash_out'] == 'cash') {

          $stmt = $GLOBALS['pdo']->prepare("INSERT INTO cash_in(worship_place_id,  fund, status_in, status_out, datetime, description, confirmation)
                                            VALUES(:_wpi, :_f, :_si, :_so, now(), :_d,  :_c)");
        $stmt->execute([
          '_wpi' => $_SESSION['user']->worship_place_id,
          '_f' => $_POST['fund'],
          '_si' => 'orphan balance',
          '_so' => 'cash',
          '_d' => 'Sisa saldo dari orphanage',
          '_c' => 'true'
        ]);
      }

      $this->flash('Fund Used Successfully!');
      return $this->redirect('stewardship/donation/payment');

    }
  }

  public function storePoor()
  {
    $this->authStewardship();
    $this->check_csrf($_POST);

    $_POST['fund'] = substr($_POST['fund'], 4);
    $_POST['fund'] = str_replace(".", "", $_POST['fund']);

    $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund) FROM cash_in WHERE worship_place_id=:id AND status_out='poor'
                                      AND confirmation='true'");
    $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
    $cash_in = $stmt->fetch(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund) FROM cash_out WHERE status_out='poor payment' AND worship_place_id=:worship_id ");
    $stmt->execute(['worship_id' => $_SESSION['user']->worship_place_id]);
    $d_cash_out = $stmt->fetch(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund) FROM cash_in WHERE worship_place_id=:id AND status_out='cash' AND confirmation='true' AND status_in='poor balance'");
    $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
    $d_cash = $stmt->fetch(PDO::FETCH_OBJ);

    $d_cash_out->sum = $d_cash_out->sum + $d_cash->sum;

    if ($cash_in->sum - ($d_cash_out->sum + $_POST['fund']) < 0) {
      $t = $cash_in->sum - $d_cash_out->sum;
      $this->flash('Not enough funds! You just have Rp '. number_format(($t),0,',','.'). ' saldo for this poor donation!');
      return $this->redirect('stewardship/donation/payment');

    }else{

      if ($_POST['cash_out'] == 'poor') {
        $stmt = $GLOBALS['pdo']->prepare("INSERT INTO cash_out(worship_place_id, fund, datetime, description, status_in, status_out, poor_id)
                                          VALUES(:_wpi, :_f, now(), :_d, :_si, :_so, :_poor)");
        $stmt->execute([
          '_wpi' => $_SESSION['user']->worship_place_id,
          '_f' => $_POST['fund'],
          '_d' => $_POST['keterangan'],
          '_si' => 'poor',
          '_so' => 'poor payment',
          '_poor' => $_POST['poor']
        ]);
      }

      if ($_POST['cash_out'] == 'cash') {

        $stmt = $GLOBALS['pdo']->prepare("INSERT INTO cash_in(worship_place_id,  fund, status_in, status_out, datetime, description, confirmation)
                                          VALUES(:_wpi, :_f, :_si, :_so, now(), :_d,  :_c)");
        $stmt->execute([
          '_wpi' => $_SESSION['user']->worship_place_id,
          '_f' => $_POST['fund'],
          '_si' => 'poor balance',
          '_so' => 'cash',
          '_d' => 'Sisa saldo dari poor',
          '_c' => 'true'
        ]);
      }

      $this->flash('Fund Used Successfully!');
      return $this->redirect('stewardship/donation/payment');

    }
  }

  public function storeTpa()
  {
    $this->authStewardship();
    $this->check_csrf($_POST);

    $_POST['fund'] = substr($_POST['fund'], 4);
    $_POST['fund'] = str_replace(".", "", $_POST['fund']);

    $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund) FROM cash_in WHERE worship_place_id=:id AND status_out='tpa'
                                      AND confirmation='true'");
    $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
    $cash_in = $stmt->fetch(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund) FROM cash_out WHERE status_out='tpa payment' AND worship_place_id=:worship_id ");
    $stmt->execute(['worship_id' => $_SESSION['user']->worship_place_id]);
    $d_cash_out = $stmt->fetch(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund) FROM cash_in WHERE worship_place_id=:id AND status_out='cash' AND confirmation='true' AND status_in='tpa balance'");
    $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
    $d_cash = $stmt->fetch(PDO::FETCH_OBJ);

    $d_cash_out->sum = $d_cash_out->sum + $d_cash->sum;

    if ($cash_in->sum - ($d_cash_out->sum + $_POST['fund']) < 0) {
      $t = $cash_in->sum - $d_cash_out->sum;
      $this->flash('Not enough funds! You just have Rp '. number_format(($t),0,',','.'). ' saldo for this tpa donation!');
      return $this->redirect('stewardship/donation/payment');

    }else{

      if ($_POST['cash_out'] == 'tpa') {
        $stmt = $GLOBALS['pdo']->prepare("INSERT INTO cash_out(worship_place_id, fund, datetime, description, status_in, status_out, tpa_id)
                                          VALUES(:_wpi, :_f, now(), :_d, :_si, :_so, :_poor)");
        $stmt->execute([
          '_wpi' => $_SESSION['user']->worship_place_id,
          '_f' => $_POST['fund'],
          '_d' => $_POST['keterangan'],
          '_si' => 'tpa',
          '_so' => 'tpa payment',
          '_poor' => $_POST['tpa']
        ]);
      }

      if ($_POST['cash_out'] == 'cash') {

        $stmt = $GLOBALS['pdo']->prepare("INSERT INTO cash_in(worship_place_id,  fund, status_in, status_out, datetime, description, confirmation)
                                          VALUES(:_wpi, :_f, :_si, :_so, now(), :_d,  :_c)");
        $stmt->execute([
          '_wpi' => $_SESSION['user']->worship_place_id,
          '_f' => $_POST['fund'],
          '_si' => 'tpa balance',
          '_so' => 'cash',
          '_d' => 'Sisa saldo dari infaq tpa',
          '_c' => 'true'
        ]);
      }

      $this->flash('Fund Used Successfully!');
      return $this->redirect('stewardship/donation/payment');

    }
  }

  public function storeEvent()
  {
    $this->authStewardship();
    $this->check_csrf($_POST);

    $_POST['fund'] = substr($_POST['fund'], 4);
    $_POST['fund'] = str_replace(".", "", $_POST['fund']);

    $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund) FROM cash_in WHERE worship_place_id=:id AND status_out='event'
                                      AND confirmation='true'");
    $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
    $cash_in = $stmt->fetch(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund) FROM cash_out WHERE (status_out='ustad payment' OR status_out='stewardship payment' OR status_out='store payment')
                                      AND worship_place_id=:worship_id AND status_in='event'");
    $stmt->execute(['worship_id' => $_SESSION['user']->worship_place_id]);
    $e_cash_out = $stmt->fetch(PDO::FETCH_OBJ);

    $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund) FROM cash_in WHERE worship_place_id=:id AND status_out='cash'
                                      AND confirmation='true' AND status_in='event blance'");
    $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
    $e_cash = $stmt->fetch(PDO::FETCH_OBJ);

    $e_cash_out->sum = $e_cash_out->sum + $e_cash->sum;

    if ($cash_in->sum - ($e_cash_out->sum + $_POST['fund']) < 0) {
      $t = $cash_in->sum - $e_cash_out->sum;
      $this->flash('Not enough funds! You just have Rp '. number_format(($t),0,',','.'). ' saldo here!');
      return $this->redirect('stewardship/donation/payment');

    }else{

      if ($_POST['cash_out'] == 'ustad') {
        $stmt = $GLOBALS['pdo']->prepare("INSERT INTO cash_out(worship_place_id, fund, datetime, description, status_in, status_out, ustad_id)
                                          VALUES(:_wpi, :_f, now(), :_d, :_si, :_so, :_ustad)");
        $stmt->execute([
          '_wpi' => $_SESSION['user']->worship_place_id,
          '_f' => $_POST['fund'],
          '_d' => $_POST['keterangan'],
          '_si' => 'event',
          '_so' => 'ustad payment',
          '_ustad' => $_POST['ustad']
        ]);
      }

      if ($_POST['cash_out'] == 'stewardship') {
        $stmt = $GLOBALS['pdo']->prepare("INSERT INTO cash_out(worship_place_id, fund, datetime, description, status_in, status_out, stewardship_id)
                                          VALUES(:_wpi, :_f, now(), :_d, :_si, :_so, :_ustad)");
        $stmt->execute([
          '_wpi' => $_SESSION['user']->worship_place_id,
          '_f' => $_POST['fund'],
          '_d' => $_POST['keterangan'],
          '_si' => 'event',
          '_so' => 'stewardship payment',
          '_ustad' => $_POST['stewardship']
        ]);
      }

      if ($_POST['cash_out'] == 'store') {
        $stmt = $GLOBALS['pdo']->prepare("INSERT INTO cash_out(worship_place_id, fund, datetime, description, status_in, status_out, store_id)
                                          VALUES(:_wpi, :_f, now(), :_d, :_si, :_so, :_ustad)");
        $stmt->execute([
          '_wpi' => $_SESSION['user']->worship_place_id,
          '_f' => $_POST['fund'],
          '_d' => $_POST['keterangan'],
          '_si' => 'event',
          '_so' => 'store payment',
          '_ustad' => $_POST['store']
        ]);
      }

      if ($_POST['cash_out'] == 'cash') {

        $stmt = $GLOBALS['pdo']->prepare("INSERT INTO cash_in(worship_place_id,  fund, status_in, status_out, datetime, description, confirmation)
                                          VALUES(:_wpi, :_f, :_si, :_so, now(), :_d,  :_c)");
        $stmt->execute([
          '_wpi' => $_SESSION['user']->worship_place_id,
          '_f' => $_POST['fund'],
          '_si' => 'event balance',
          '_so' => 'cash',
          '_d' => 'stewardship',
          '_c' => 'true'
        ]);
      }

      $this->flash('Fund Used Successfully!');
      return $this->redirect('stewardship/donation/payment');

    }
  }

  public function storeCashMosque()
  {
    $this->authStewardship();
    $this->check_csrf($_POST);

    $_POST['fund'] = substr($_POST['fund'], 4);
    $_POST['fund'] = str_replace(".", "", $_POST['fund']);

    // $this->die($_POST);

    $stmt = $GLOBALS['pdo']->prepare("SELECT sum(fund) FROM cash_in WHERE worship_place_id=:id AND status_out='cash' AND confirmation='true'");
    $stmt->execute(['id' => $_SESSION['user']->worship_place_id]);
    $cashb = $stmt->fetch(PDO::FETCH_OBJ);

    if ($cashb->sum - $_POST['fund'] < 0) {
      $this->flash('Not enough funds! You just have Rp '. number_format(($cashb->sum),0,',','.'). ' saldo here!');
      return $this->redirect('stewardship/donation/payment');

    }else{

      if ($_POST['cash_out'] == 'poor') {
        $stmt = $GLOBALS['pdo']->prepare("INSERT INTO cash_out(worship_place_id, fund, datetime, description, status_in, status_out, poor_id)
                                          VALUES(:_wpi, :_f, now(), :_d, :_si, :_so, :_ustad)");
        $stmt->execute([
          '_wpi' => $_SESSION['user']->worship_place_id,
          '_f' => $_POST['fund'],
          '_d' => $_POST['keterangan'],
          '_si' => 'cash',
          '_so' => 'poor payment',
          '_ustad' => $_POST['poor']
        ]);
      }

      if ($_POST['cash_out'] == 'tpa') {
        $stmt = $GLOBALS['pdo']->prepare("INSERT INTO cash_out(worship_place_id, fund, datetime, description, status_in, status_out, tpa_id)
                                          VALUES(:_wpi, :_f, now(), :_d, :_si, :_so, :_ustad)");
        $stmt->execute([
          '_wpi' => $_SESSION['user']->worship_place_id,
          '_f' => $_POST['fund'],
          '_d' => $_POST['keterangan'],
          '_si' => 'cash',
          '_so' => 'tpa payment',
          '_ustad' => $_POST['tpa']
        ]);
      }

      if ($_POST['cash_out'] == 'orphanage') {
        $stmt = $GLOBALS['pdo']->prepare("INSERT INTO cash_out(worship_place_id, fund, datetime, description, status_in, status_out, orphanage_id)
                                          VALUES(:_wpi, :_f, now(), :_d, :_si, :_so, :_ustad)");
        $stmt->execute([
          '_wpi' => $_SESSION['user']->worship_place_id,
          '_f' => $_POST['fund'],
          '_d' => $_POST['keterangan'],
          '_si' => 'cash',
          '_so' => 'orphanage payment',
          '_ustad' => $_POST['orphanage']
        ]);
      }

      if ($_POST['cash_out'] == 'ustad') {
        $stmt = $GLOBALS['pdo']->prepare("INSERT INTO cash_out(worship_place_id, fund, datetime, description, status_in, status_out, ustad_id)
                                          VALUES(:_wpi, :_f, now(), :_d, :_si, :_so, :_ustad)");
        $stmt->execute([
          '_wpi' => $_SESSION['user']->worship_place_id,
          '_f' => $_POST['fund'],
          '_d' => $_POST['keterangan'],
          '_si' => 'cash',
          '_so' => 'ustad payment',
          '_ustad' => $_POST['ustad']
        ]);
      }

      if ($_POST['cash_out'] == 'stewardship') {
        $stmt = $GLOBALS['pdo']->prepare("INSERT INTO cash_out(worship_place_id, fund, datetime, description, status_in, status_out, stewardship_id)
                                          VALUES(:_wpi, :_f, now(), :_d, :_si, :_so, :_ustad)");
        $stmt->execute([
          '_wpi' => $_SESSION['user']->worship_place_id,
          '_f' => $_POST['fund'],
          '_d' => $_POST['keterangan'],
          '_si' => 'cash',
          '_so' => 'stewardship payment',
          '_ustad' => $_POST['stewardship']
        ]);
      }

      if ($_POST['cash_out'] == 'store') {
        $stmt = $GLOBALS['pdo']->prepare("INSERT INTO cash_out(worship_place_id, fund, datetime, description, status_in, status_out, store_id)
                                          VALUES(:_wpi, :_f, now(), :_d, :_si, :_so, :_ustad)");
        $stmt->execute([
          '_wpi' => $_SESSION['user']->worship_place_id,
          '_f' => $_POST['fund'],
          '_d' => $_POST['keterangan'],
          '_si' => 'cash',
          '_so' => 'store payment',
          '_ustad' => $_POST['store']
        ]);
      }

      if ($_POST['cash_out'] == 'builder') {
        $stmt = $GLOBALS['pdo']->prepare("INSERT INTO cash_out(worship_place_id, project_id, fund, datetime, description, status_in, status_out, builder_id)
                                          VALUES(:_wpi, :_pi, :_f, now(), :_d, :_si, :_so, :_b)");
        $stmt->execute([
          '_wpi' => $_SESSION['user']->worship_place_id,
          '_pi' => $_POST['project'],
          '_f' => $_POST['fund'],
          '_d' => $_POST['keterangan'],
          '_si' => 'cash',
          '_so' => 'builder payment',
          '_b' => $_POST['builder']
        ]);
      }

      $this->flash('Fund Used Successfully!');
      return $this->redirect('stewardship/donation/payment');

    }
  }

  public function report()
  {
    $this->authStewardship();

    if ($_GET['type'] == 'All Donation') {

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
      $stmt->execute(['id' => $_SESSION['user']->worship_place_id, 'y' => $_GET['year'], 'm' => $_GET['month']]);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    }elseif($_GET['type'] == 'Infaq Poor'){

      $stmt = $GLOBALS['pdo']->prepare("(SELECT id, status_in, status_out, datetime, description, fund
                                        FROM cash_in WHERE worship_place_id=:id
                                        AND (status_out = 'poor' OR status_out = 'poor payment')
                                        AND EXTRACT(YEAR FROM datetime)=:y
                                        AND EXTRACT(MONTH FROM datetime)=:m AND confirmation='true' ORDER BY datetime)
                                        UNION ALL (SELECT id, status_in, status_out, datetime, description, fund
                                        FROM cash_out WHERE worship_place_id=:id
                                        AND (status_out = 'poor' OR status_out = 'poor payment')
                                        AND EXTRACT(YEAR FROM datetime)=:y
                                        AND EXTRACT(MONTH FROM datetime)=:m ORDER BY datetime) ORDER BY datetime");
      $stmt->execute(['id' => $_SESSION['user']->worship_place_id, 'y' => $_GET['year'], 'm' => $_GET['month']]);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    }elseif($_GET['type'] == 'Infaq TPA/MDA'){

      $stmt = $GLOBALS['pdo']->prepare("(SELECT id, status_in, status_out, datetime, description, fund
                                        FROM cash_in WHERE worship_place_id=:id
                                        AND (status_out = 'tpa' OR status_out = 'tpa payment')
                                        AND EXTRACT(YEAR FROM datetime)=:y
                                        AND EXTRACT(MONTH FROM datetime)=:m AND confirmation='true' ORDER BY datetime)
                                        UNION ALL (SELECT id, status_in, status_out, datetime, description, fund
                                        FROM cash_out WHERE worship_place_id=:id
                                        AND (status_out = 'tpa' OR status_out = 'tpa payment')
                                        AND EXTRACT(YEAR FROM datetime)=:y
                                        AND EXTRACT(MONTH FROM datetime)=:m ORDER BY datetime) ORDER BY datetime");
      $stmt->execute(['id' => $_SESSION['user']->worship_place_id, 'y' => $_GET['year'], 'm' => $_GET['month']]);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    }elseif($_GET['type'] == 'Infaq Orphan'){

      $stmt = $GLOBALS['pdo']->prepare("(SELECT id, status_in, status_out, datetime, description, fund
                                        FROM cash_in WHERE worship_place_id=:id
                                        AND (status_out = 'orphanage' OR status_out = 'orphanage payment')
                                        AND EXTRACT(YEAR FROM datetime)=:y
                                        AND EXTRACT(MONTH FROM datetime)=:m AND confirmation='true' ORDER BY datetime)
                                        UNION ALL (SELECT id, status_in, status_out, datetime, description, fund
                                        FROM cash_out WHERE worship_place_id=:id
                                        AND (status_out = 'orphanage' OR status_out = 'orphanage payment')
                                        AND EXTRACT(YEAR FROM datetime)=:y
                                        AND EXTRACT(MONTH FROM datetime)=:m ORDER BY datetime) ORDER BY datetime");
      $stmt->execute(['id' => $_SESSION['user']->worship_place_id, 'y' => $_GET['year'], 'm' => $_GET['month']]);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    }elseif($_GET['type'] == 'Infaq Event'){

      $stmt = $GLOBALS['pdo']->prepare("(SELECT id, status_in, status_out, datetime, description, fund
                                        FROM cash_in WHERE worship_place_id=:id
                                        AND (status_out = 'event' OR status_out = 'ustad payment' OR status_out = 'stewardship payment'
                                        OR (status_out = 'store payment' AND status_in = 'event'))
                                        AND EXTRACT(YEAR FROM datetime)=:y
                                        AND EXTRACT(MONTH FROM datetime)=:m AND confirmation='true' ORDER BY datetime)
                                        UNION ALL (SELECT id, status_in, status_out, datetime, description, fund
                                        FROM cash_out WHERE worship_place_id=:id
                                        AND (status_out = 'event' OR status_out = 'ustad payment' OR status_out = 'stewardship payment'
                                        OR (status_out = 'store payment' AND status_in = 'event'))
                                        AND EXTRACT(YEAR FROM datetime)=:y
                                        AND EXTRACT(MONTH FROM datetime)=:m ORDER BY datetime) ORDER BY datetime");
      $stmt->execute(['id' => $_SESSION['user']->worship_place_id, 'y' => $_GET['year'], 'm' => $_GET['month']]);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    }elseif($_GET['type'] == 'Infaq Project Construction'){

      $stmt = $GLOBALS['pdo']->prepare("(SELECT id, status_in, status_out, datetime, description, fund
                                        FROM cash_in WHERE worship_place_id=:id
                                        AND (status_out = 'project' OR status_out = 'builder payment' OR status_out = 'store payment')
                                        AND EXTRACT(YEAR FROM datetime)=:y
                                        AND EXTRACT(MONTH FROM datetime)=:m AND confirmation='true' ORDER BY datetime)
                                        UNION ALL (SELECT id, status_in, status_out, datetime, description, fund
                                        FROM cash_out WHERE worship_place_id=:id
                                        AND (status_out = 'project' OR status_out = 'builder payment' OR status_out = 'store payment')
                                        AND EXTRACT(YEAR FROM datetime)=:y
                                        AND EXTRACT(MONTH FROM datetime)=:m ORDER BY datetime) ORDER BY datetime");
      $stmt->execute(['id' => $_SESSION['user']->worship_place_id, 'y' => $_GET['year'], 'm' => $_GET['month']]);
      $data = $stmt->fetchAll(PDO::FETCH_OBJ);

    }

    $stmt = $GLOBALS['pdo']->prepare("SELECT gq.*, mq.max_person FROM group_qurban as gq INNER JOIN
                                      mosque_qurban as mq ON gq.worship_place_id = mq.worship_place_id
                                      AND gq.year = mq.year AND gq.animal_type = mq.animal_type
                                      WHERE gq.worship_place_id=:id AND gq.year=:y ORDER BY gq.group ASC");
    $stmt->execute(['id'=> $_SESSION['user']->worship_place_id, 'y' => $_GET['year']]);
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

    // $this->die($data);
    return $this->view('stewardship/report', ['allReport' => $data,
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
