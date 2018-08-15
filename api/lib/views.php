<?php

class View {
  /**
   * render()
   * Render a view with the specified data
   * @param view
   * @param data
   */
  public static function render($view, $data = array()) {
    $filename = '../api/views/' . $view . '.php';

    if (!file_exists($filename)) {
      die('Unknown view! ' . $filename);
    }

    include_once($filename);
  }
}

?>
