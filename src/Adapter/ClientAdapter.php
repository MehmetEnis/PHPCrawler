<?php
namespace MehmetEnis\Adapter;

interface ClientAdapter{
  public function request($url,$type);
  public function getresult($haystack, $needlecontainer, $needle);
}
