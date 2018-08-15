<?php

class HomeController {
  public static function index($req, $res) {
    return $res->render('index');
  }
}

?>
