<?php
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Exception\NoSuchElementException;

ini_set('display_errors', 'On');
error_reporting(E_ALL);

require 'youtube-video-download/php-webdriver-1.6.0/autoloader.php';

$driver = RemoteWebDriver::create(
    'http://localhost:4444/wd/hub', 
    DesiredCapabilities::chrome(),
    1000 * 60 * 5, # Set timeout for the connect phase to remote Selenium WebDriver server
    1000 * 60 * 5  # Set the maximum time of a request to remote Selenium WebDriver server
);
try {
    $driver->get('https://zh.savefrom.net/');
} catch ( Exception $e ) {
    $driver->quit();
}

$urlInput = $driver->findElement(WebDriverBy::id('sf_url'));
$urlInput->sendKeys("https://www.youtube.com/watch?v=zyMBULOtyLs");

$checkBtn = $driver->findElement(WebDriverBy::id('sf_submit'));
$checkBtn->click();

$response = array();
$retryCount = 100;

do {
    try {
        $resultBox = $driver->findElement(WebDriverBy::className('def-btn-box'));
        $defaultDownloadLink = $resultBox->findElement(WebDriverBy::tagName('a'));
        $response['default_download_url'] = $defaultDownloadLink->getAttribute('href');
        break;
    } catch ( NoSuchElementException $e ) {
        usleep(100);
    }
    $retryCount --;
} while ( $retryCount > 0 );

$driver->quit();

echo json_encode($response);