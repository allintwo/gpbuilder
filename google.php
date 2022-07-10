<?php
/**
 * Created by PhpStorm.
 * User: CosMOs
 * Date: 6/18/2022
 * Time: 12:22 PM
 */



namespace Facebook\WebDriver;

use Facebook\WebDriver\Interactions\WebDriverActions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

require_once('vendor/autoload.php');

ini_set('max_execution_time',200);

// This is where Selenium server 2/3 listens by default. For Selenium 4, Chromedriver or Geckodriver, use http://localhost:4444/
$host = 'http://localhost:4444/wd/hub';
$qlimit =20;

$capabilities = DesiredCapabilities::chrome();

$driver = RemoteWebDriver::create($host, $capabilities);

// navigate to Selenium page on Wikipedia
$driver->get('https://www.google.com/');

$q = 'how to cook egg';

$driver->findElement(WebDriverBy::name('q')) // find search input element
->sendKeys($q) // fill the search box
->submit(); // submit the whole form

// wait until 'PHP' is shown in the page heading element
//$driver->wait()->until(WebDriverExpectedCondition::elementTextContains(WebDriverBy::id('hdtb-tlshdtb-tls'), 'Tools'));
echo "The title is '" . $driver->getTitle() . "'\n";

sleep(5);




sleep(5);

$questions = [];
$questions['main'] = [];
$questions['related'] = [];

if(1)
{
    $felems = $driver->findElement(WebDriverBy::cssSelector('div.wDYxhc'));
    $fanswer = $felems->getDomProperty('innerHTML');

    $questions['main'][md5($q)] = [$q,$fanswer];
    // related
    // $fanswer = $felems->getText();

}



for ($i =0;$i<3;$i++)
{
    $xelems = $driver->findElements(
    //  WebDriverBy::cssSelector('.Cpkphb')
        WebDriverBy::cssSelector('div[jsname="Cpkphb"]')
    );

    foreach ($xelems as $element)
    {
        if(count($questions['related'])> $qlimit)
        {
            break;
        }

        $ques  = $element->findElement(WebDriverBy::cssSelector('div[jsname="jIA8B"]'));
        $title = $ques->getText();
        $titlekey = md5($title);
        $clicked = 0;

        foreach ($questions['related'] as  $key => $val)
        {
            if($titlekey == $key)
            {
                $clicked = 1;
            }
        }
        if($clicked)
        {
            continue;
        }

        $action = $driver->action();
        $action->moveToElement($element)->perform();

        $nsource = '';
// 'window.scrollTo(200, 0)';
        //  $driver->executeScript('window.scrollTo(0,document.body.scrollHeight);');
        $element->click();
        $sources =  $element->getDomProperty('innerHTML');

        //echo $sources;$driver->quit();exit;
        sleep(1);

        if(strpos($sources,'RqBzHd')>0)
        {
            if(strpos($sources,'<ul')>0)
            {
                $nele =  $element->findElement(WebDriverBy::cssSelector('.RqBzHd ul'));
                $nsource = $nele->getDomProperty('innerHTML');
            }else{
                $nele =  $element->findElement(WebDriverBy::cssSelector('.RqBzHd ol'));
                $nsource = $nele->getDomProperty('innerHTML');
            }


        }

        if(strpos($sources,'ILfuVd')>0)
        {
            $nele =  $element->findElement(WebDriverBy::cssSelector('.ILfuVd'));
            $nsource = $nele->getDomProperty('innerHTML');
        }

        if(strpos($sources,'XdBtEc')>0)
        {
            $nele =  $element->findElement(WebDriverBy::cssSelector('.XdBtEc'));
            $nsource = $nele->getDomProperty('innerHTML');
        }

        $questions['related'][$titlekey] = [$title,$nsource];
    }
}


echo "<plaintext>";
print_r($questions);


// $driver->quit();