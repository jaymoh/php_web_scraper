<?php
# scraping books to scrape: https://books.toscrape.com/

require 'vendor/autoload.php';

$httpClient = new \simplehtmldom\HtmlWeb();

$response = $httpClient->load('https://books.toscrape.com/');

// echo the title
echo $response->find('title', 0)->plaintext . PHP_EOL . PHP_EOL;

// get the prices into an array
$prices = [];
foreach ($response->find('.row li article div.product_price p.price_color') as $price) {
  $prices[] = $price->plaintext;
}

// echo titles and prices
foreach ($response->find('.row li article h3 a') as $key => $title) {
  echo "{$title->plaintext} @ {$prices[$key]} \n";
}
