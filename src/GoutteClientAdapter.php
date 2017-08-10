<?php
namespace MehmetEnis;

use GuzzleHttp\Client as GuzzleClient;
use Goutte\Client;
use MehmetEnis\Adapter\ClientAdapter;

class GoutteClientAdapter implements ClientAdapter {

  private $client;
  private $result;
  private $items;
  private $status;

  public function __construct(Client $client){

    $this->client = $client;

    $guzzleClient = new GuzzleClient(array(
        'timeout' => 90,
        'verify' => false,
    ));
    $this->client->setClient($guzzleClient);

  }

  public function request($url, $type = 'GET')
  {
    try {
      $this->result = $this->client->request($type, $url);
      $this->status = true;
    } catch (\GuzzleHttp\Exception\ConnectException $e) {
      $this->status = false;
    }
  }

  public function getStatus()
  {
    return $this->status;
  }

  public function getresult($haystack, $needlecontainer, $needle)
  {

      if(!$this->getStatus()) return array('error' => 'cannot connect to '.$this->client->getHistory()->current()->getUri() );

      $this->result->filter($haystack)->each(function ($article) use ($needlecontainer, $needle) {

        $categorycount = $article->filter($needlecontainer)->count();
        if($categorycount > 0)
        {
          $category = $article->filter($needlecontainer);
          if($category->text() == $needle) {
            $article->filter('div.entry-summary a')->each(function($title) {
                $page = $this->client->request('GET', $title->attr('href'));
                $request_meta = $this->client->getResponse()->getHeaders();
                // Some pages do not have Content-Length specified
                $filesize = !empty($request_meta['Content-Length'][0]) ? $request_meta['Content-Length'][0] * 0.001 : 'Not Available';
                $page_meta = @get_meta_tags($title->attr('href'));
                $description = !empty($page_meta['description']) ? str_replace("\n", "", $page_meta['description']) : 'Not Available';
                $keywords = !empty($page_meta['keywords']) ? $page_meta['keywords'] : 'Not Available';

                $this->items['results'][] = array('url' => $title->attr('href'), 'link' => $title->text(), 'meta description' => $description, 'keywords' => $keywords, 'filesize' => $filesize);
            });
          }
        }

      });

      // I could have used Decorator Pattern to add extras to output such as totalfilesize and any other future requirements / additions
      if(count($this->items))
      {
        $totalsize = 0;
        foreach ($this->items['results'] as &$value) {
          if(is_numeric($value['filesize'])) {
            $totalsize += $value['filesize'];
            $value['filesize'] .= 'kb';
          }
        }
        $this->items['total'] = $totalsize . 'kb';
      }
      else {
        $this->items = array();
      }

      return $this->items;
  }

}
