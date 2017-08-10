<?php

namespace MehmetEnis;

class Page {
  public $url;
  public $parentContainer;
  public $tagContainer;
  public $tag;
  public $requestType = 'GET';

  public function __construct($url, $parentContainer, $tagContainer, $tag, $requestType = 'GET'){
      $this->url = $url;
      $this->parentContainer = $parentContainer;
      $this->tagContainer = $tagContainer;
      $this->tag = $tag;
      $this->$requestType = $requestType;
  }

  // I could have used magic getter setter methods, however they are slower, makes it hard to debug and auto-completion does not work in IDE
  public function getUrl()
  {
    return $this->url;
  }

  public function setUrl($url)
  {
    $this->url = $url;
  }

  public function getTag()
  {
    return $this->tag;
  }

  public function setTag($tag)
  {
    $this->tag = $tag;
  }

  public function getParentContainer()
  {
    return $this->parentContainer;
  }

  public function setParentContainer($parentContainer)
  {
    $this->parentContainer = $parentContainer;
  }

  public function getTagContainer()
  {
    return $this->tagContainer;
  }

  public function setTagContainer($tagContainer)
  {
    $this->tagContainer = $tagContainer;
  }

  public function getRequestType()
  {
    return $this->requestType;
  }

  public function setRequestType($requestType)
  {
    $this->requestType = $requestType;
  }

}
