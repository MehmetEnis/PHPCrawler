<?php
require 'vendor/autoload.php';

use Goutte\Client;
use MehmetEnis\Page;
use MehmetEnis\Crawler;
use MehmetEnis\JsonPresenter;
use MehmetEnis\GoutteClientAdapter;

// Initialise the Page Object
$page = new Page('https://www.black-ink.org', 'article' , 'span.category > a' , 'Digitalia');
// Initialise Goutte Adapter Client
$client = new GoutteClientAdapter( new Client() );
// Initialise a JSON Presenter Object for serialising the crawled data
$presenter = new JsonPresenter();
// Initialise the Crawler, passing in the page object, client object and presenter object
$crawler = new Crawler( $page , $client , $presenter);
// Initiate the crawling process
$crawler->request();
// Get the crawling results
$result = $crawler->getresult(true);

echo $result;
