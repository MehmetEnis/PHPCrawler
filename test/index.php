<?php
require '../vendor/autoload.php';
require_once('../vendor/simpletest/simpletest/autorun.php');

use Goutte\Client;
use MehmetEnis\Page;
use MehmetEnis\Crawler;
use MehmetEnis\JsonPresenter;
use MehmetEnis\GoutteClientAdapter;

// Here I could have used Mock Class Pattern
// or carried out a more thorough testing but this is just to drive point home

class TestOfLogging extends UnitTestCase {
    function testCannotReachWebPage() {

      $page = new Page('https://www.black-ink.or', 'article' , 'span.category > a' , 'Digitalia');
      $client = new GoutteClientAdapter( new Client() );
      $presenter = new JsonPresenter();
      $crawler = new Crawler( $page , $client , $presenter);
      $crawler->request();
      $actual = $crawler->getresult(false);
      $expected = array('error' => 'cannot connect to https://www.black-ink.or');
      $expected = json_encode($expected, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
      $this->assertEqual($expected, $actual);

    }

    function testCanReachWebPageAndGetResult() {

      $page = new Page('https://www.black-ink.org', 'article' , 'span.category > a' , 'Digitalia');
      $client = new GoutteClientAdapter( new Client() );
      $presenter = new JsonPresenter();
      $crawler = new Crawler( $page , $client , $presenter);
      $crawler->request();
      // Test that returned object is not empty
      $this->assertNotEqual('[]', $crawler->getresult(false));

    }

    function testCanReachWebPageAndGetEmptyResult() {

      $page = new Page('https://www.black-ink.org', 'articl' , 'span.category > a' , 'Digitalia');
      $client = new GoutteClientAdapter( new Client() );
      $presenter = new JsonPresenter();
      $crawler = new Crawler( $page , $client , $presenter);
      $crawler->request();
      // Test empty result
      // Changing the parentContainer from article to articl gives empty result
      $this->assertEqual('[]', $crawler->getresult(false));

    }
}
