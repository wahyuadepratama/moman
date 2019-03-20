<?php

/**
 *  Define your authentication here
 */
trait Auth
{
  function AuthJamaah()
  {
    echo "Proses pengecekan session jamaah..";
  }

  function AuthCaretaker()
  {
    echo "Proses pengecekan session pengurus..";
  }

  function AuthAdmin()
  {
    echo "Proses pengecekan session admin..";
  }

}
