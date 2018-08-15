<?php

class Response {
  /**
   * send()
   * Send data as plaintext
   * @param data
   * @param status
   */
  public static function send($data, $status = 200) {
    http_response_code($status);
    header('Content-Type: text/plain');
    return print($data);
  }

  /**
   * json()
   * Send data as JSON
   * @param data
   * @param status
   */
  public static function json($data, $status = 200) {
    http_response_code($status);
    header('Content-Type: application/json');
    return print(json_encode($data));
  }

  /**
   * render()
   * Render HTML view
   * @param data
   * @param status
   */
  public static function render($view, $status = 200, $data = array()) {
    http_response_code(200);
    return View::render($view, $data);
  }
}

?>
