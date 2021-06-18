<?php
# scraping books to scrape: https://books.toscrape.com/

require 'vendor/autoload.php';

$httpClient = new \Goutte\Client();

$response = $httpClient->request('GET', 'https://books.toscrape.com/');

// get prices into an array
$prices = [];
$response->filter('.row li article div.product_price p.price_color')
  ->each(function ($node) use (&$prices) {
    $prices[] = $node->text();
  });

// echo title, price, and description
$priceIndex = 0;
$response->filter('.row li article h3 a')
  ->each(function ($node) use ($prices, &$priceIndex, $httpClient) {
    $title = $node->text();
    $price = $prices[$priceIndex];

    //getting the description
    $description = $httpClient->click($node->link())
      ->filter('.content #content_inner article p')->eq(3)->text();

    // display the result
    echo "{$title} @ {$price} :  {$description}\n\n";

    $priceIndex++;
  });