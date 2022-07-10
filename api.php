<?php
/**
 * Created by PhpStorm.
 * User: CosMOs
 * Date: 6/26/2022
 * Time: 7:24 AM
 */


namespace Facebook\WebDriver;

use Facebook\WebDriver\Interactions\WebDriverActions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;

require_once('vendor/autoload.php');

// This is where Selenium server 2/3 listens by default. For Selenium 4, Chromedriver or Geckodriver, use http://localhost:4444/





include_once 'config.php';
include_once 'functions.php';

// $mysqli = new \mysqli();
$action = 'Nothing';
$ret_html = '';

header('Content-Type: application/json; charset=utf-8');

$common_response =[
    'status' => 200,
    'msg'=>"What a nice day",
    'html' => ''
];

if(isset($_REQUEST['action']))
{
    $action = $_REQUEST['action'];
}
// sleep(3);

if($action == 'getlist')
{

    $ret_html_table = '';

    $query = $mysqli->query("SELECT * FROM `gb_sc` order by id desc limit 20");
    while ($row = mysqli_fetch_assoc($query))
    {
        $id = $row['id'];
        $q = $row['q'];
        $time_h = humanTiming( $row['time']);
        $done = $row['done'];
        $ret_html_table .= "<tr><th>{$id}</th><td>{$time_h}</td> <td>{$done}</td></tr>";
    }

    $common_response['html'] = "<table><tr><th>ID</th><th>TIME</th><th>Status</th></tr>{$ret_html_table}</table>";
}


if($action == 'get_single_data')
{

    if(isset($_REQUEST['q']))
    {
        $q = $_REQUEST['q'];
        $qhash = md5($q);
        $q = $mysqli->real_escape_string($q);

        $xquery = $mysqli->query("SELECT * FROM `gb_sc` where q = '{$q}' and done = '1'");
        if(mysqli_num_rows($xquery)>0)
        {
            while ($scdul = mysqli_fetch_assoc($xquery))
            {

                    $xxqu = $mysqli->query("SELECT * FROM `gb_bq` where que = '{$q}'");
                    while ($saved_data = mysqli_fetch_assoc($xxqu))
                    {
                        $questions = $saved_data['data'];
                        $common_response['data'] = $questions;
                    }
                $mysqli->query("UPDATE `gb_sc` SET `done`='1' WHERE id = '{$scdul['id']}'");
            }

        }else{
            // do this guys
            $questions =   get_single_data_by_q($q);
            $ans = $mysqli->real_escape_string($questions['main'][$qhash][1]);
            $e_q = $mysqli->real_escape_string($q);
            $data = $mysqli->real_escape_string(json_encode($questions));
            $time = time();
            $mysqli->query("INSERT INTO `gb_bq`(`qhash`, `que`, `ans`, `data`, `time`) VALUES 
('{$qhash}','{$e_q}','{$ans}','{$data}','{$time}')");

            $mysqli->query("INSERT INTO `gb_sc`(`q`, `time`, `done`) VALUES ('$e_q','{$time}','1')");
            $common_response['data'] = $questions;

        }

    }

}

// save q a log ?
function save_q_a_log($q,$a,$mainque)
{


    global $mysqli;
    $q = $mysqli->real_escape_string($q);
    $a = $mysqli->real_escape_string($a);
    $mainq = $mysqli->real_escape_string($mainque);
    $time = time();
    $mysqli->query("INSERT INTO `gb_sq`(`q`, `a`, `mainq`, `time`) VALUES ('{$q}','{$a}','{$mainq}','{$time}')");
}

function get_single_data_by_q($q)
{

    $host = 'http://localhost:4444/wd/hub';
    $qlimit =20;
    $capabilities = DesiredCapabilities::chrome();

    $driver = RemoteWebDriver::create($host, $capabilities);


// navigate to Selenium page on Wikipedia
    $driver->get('https://www.google.com/');

    $driver->findElement(WebDriverBy::name('q')) // find search input element
    ->sendKeys($q) // fill the search box
    ->submit(); // submit the whole form

// wait until 'PHP' is shown in the page heading element
//$driver->wait()->until(WebDriverExpectedCondition::elementTextContains(WebDriverBy::id('hdtb-tlshdtb-tls'), 'Tools'));
 //   echo "The title is '" . $driver->getTitle() . "'\n";

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
                    $nsource = "<ul>". $nele->getDomProperty('innerHTML') ."</ul>";
                }else{
                    $nele =  $element->findElement(WebDriverBy::cssSelector('.RqBzHd ol'));
                    $nsource = "<ol>". $nele->getDomProperty('innerHTML') . "</ol>";
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
            save_q_a_log($title,$nsource,$q);
        }
    }

   // echo "<plaintext>";
   // print_r($questions);



    return $questions;
}


function build_wp_post($questions)
{
    $main = $questions['main'];
    $related = $questions['related'];

    $related_html = '';

    foreach ($related as $key => $item)
    {
        $q = $item[0];
        $a = $item[1];
        $related_html .= <<<sdfoihdsfioudshfds
<div class="gb_related_items">
<h2 class="gb_related_item_q">{$q}</h2>
<p class="gb_related_item_a">{$a}</p>
</div>
sdfoihdsfioudshfds;

    }

    $main_html = '';
    $main_q = '';
    $main_a = '';
    if(count($questions['main'])>0)
    {
        $keys = array_keys($questions['main']);
        $values = array_values($questions['main']);
        $main_q = $keys[0];
        $main_a = $keys[1];
        $main_html = <<<sdfdsklfhgdsif
<div class="gb_main_item">
<h2 class="gb_main_item_q">{$main_q}</h2>
<p class="gb_main_item_a">{$main_a}</p>
</div>
sdfdsklfhgdsif;

    }

    $post = <<<sdlkfhdskfgdsfiudsgfiudsagfiusdiuy
<div class="gbuilder_content">
<div class="gb_main">
{$main_html}
</div>
<div class="gb_related">
{$related_html}
</div>

</div>
sdlkfhdskfgdsfiudsgfiudsagfiusdiuy;

    return $post;
}



echo json_encode($common_response);