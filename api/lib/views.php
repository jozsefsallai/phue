<?php

class View {
  public static $viewsPath = '../api/views/';

  /**
   * getViewFile()
   * Returns the path to the specified view
   * @param $name
   */
  public static function getViewFile($name) {
    return self::$viewsPath . $name . '.php';
  }

  /**
   * render()
   * Render a view with the specified data
   * @param view
   * @param data
   */
  public static function render($view, $data = array()) {
    $filename = self::getViewFile($view);

    if (!file_exists($filename)) {
      die('Unknown view! ' . $filename);
    }

    include_once($filename);
  }
}

?>
