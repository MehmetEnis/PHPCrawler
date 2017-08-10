<?php
namespace MehmetEnis;

use MehmetEnis\Presenter\PresenterInterface;

class JsonPresenter implements PresenterInterface {

  public function present($data, $prettyprint = true) {
    if($prettyprint) header('Content-Type: application/json');
    return json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
  }

}
