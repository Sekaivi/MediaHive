<?php
// the goal of this class is to render pages, just call a view that holds the page structure, and specify in $data all the
// fields that should be filled

class View
{
  public static function render($view, $data = []) 
  {
    extract($data);
    ob_start();
    require "./views/$view.php";
    $content = ob_get_clean();
    require "./views/Base.php";
  }
}

?>
