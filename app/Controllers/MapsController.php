<?php

class MapsController extends Controller{

  use Auth;

  public function maps(){

    if(isset($_GET['page'])){
      if($_GET['page'] == 'masjidradius'){
          return $this->masjidRadius();
      }
    }
    return $this->view('guest/maps');

  }

  public function masjidRadius(){
    $dataarray = [
      [
        'id'=> '1', 'name'=> 'Masjid A', 'longitude'=> '100.37564763151181', 'latitude'=> '-0.9766162125961433'
      ],
      [
        'id'=> '2', 'name'=> 'Masjid B', 'longitude'=> '100.97564763151181', 'latitude'=> '-0.9666162125961433'
      ],
      [
        'id'=> '3', 'name'=> 'Masjid C', 'longitude'=> '101.37564763151181', 'latitude'=> '-0.9766162125961433'
      ]
    ];
    echo json_encode($dataarray);
  }

  public function detailMasjid()
  {

  }

}
