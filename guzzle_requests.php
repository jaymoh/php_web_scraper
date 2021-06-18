<?php
# scraping books to scrape: https://books.toscrape.com/

require 'vendor/autoload.php';

$httpClient = new \GuzzleHttp\Client();

$response = $httpClient->get('https://books.toscrape.com/');

$htmlString = (string) $response->getBody();

//add this line to suppress any warnings
libxml_use_internal_errors(true);

$doc = new DOMDocument();
$doc->loadHTML($htmlString);

$xpath = new DOMXPath($doc);

$titles = $xpath->evaluate('//ol[@class="row"]//li//article//h3/a');
$prices = $xpath->evaluate('//ol[@class="row"]//li//article//div[@class="product_price"]//p[@class="price_color"]');

foreach ($titles as $key => $title) {
  echo $title->textContent . ' @ '. $prices[$key]->textContent.PHP_EOL;
}
