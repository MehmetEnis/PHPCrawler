<?php
namespace MehmetEnis;

use MehmetEnis\Adapter\ClientAdapter;
use MehmetEnis\Presenter\PresenterInterface;

class Crawler {

  private $page;
  private $clientadapter;
  private $presenter;

  public function __construct(Page $page, ClientAdapter $adapter, PresenterInterface $presenter){
    $this->page = $page;
    $this->clientadapter = $adapter;
    $this->presenter = $presenter;
  }

  public function request(){
    $this->clientadapter->request($this->page->getUrl(), $this->page->getRequestType());
  }

  public function getresult($prettyprint){
    return $this->presenter->present( $this->clientadapter->getresult($this->page->getParentContainer(), $this->page->getTagContainer(), $this->page->getTag()), $prettyprint );
  }

}
