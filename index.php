<?php
//Läser in filen top-cache.php
require_once('top-cache.php'); 

//Sätter ini_set till att inte tima ut efter 30 sek utan 8,5 timmar.
ini_set('max_execution_time', 30000);

//Läser in sidan som ska börjas skrapas
$data = curl_get_request("http://coursepress.lnu.se/kurser/");

//DOMDocument är en representation av ett dokument innehållande XML noder som är arrangerat som ett träd.
$dom = new DOMDocument();
$array = array();

getAllCourses($dom, $data, $array);

function getAllCourses($dom, $data, $array)
{
	$urlArray = $array;
	$reg = "/kurs/";
	//Kontroll så HTMLsidan är korrekt och ej null.
	if($dom->loadHTML($data))
	{
	  //Xpath är en syntax för att kunna navigera sig igenom en DOM struktur och lokalisera en eller flera noder.
	  $xpath = new DOMXpath($dom);
	  //Beordrar DOM att leta efter specifika element
	  $items = $xpath->query('//ul[@id="blogs-list"]//div[@class="item-title"]/a');
	  
	  
		foreach($items as $item)
		{
			$links = $item->getAttribute('href');
		
			if(preg_match($reg, $links))
			{
				//Hämtar kurskod
				$courseCode = getCourseCode($dom, $item->getAttribute("href"));
				//Hämtar kursplan
				$coursePlan = getCoursePlan($dom, $item->getAttribute("href"));
				//Hämtar introduktionstexten
				$courseEntryText = getCourseEntryText($dom, $item->getAttribute("href"));
				//Hämtar senaste inlägget med namn och rubrik
				$latestPost = getLatestPost($dom, $item->getAttribute("href"));
				
				$urlArray[] = array("CourseName " => $item->nodeValue , "Link" => $item->getAttribute('href') , "CourseCode" => $courseCode, "Kursplan" => $coursePlan , "Course Entry Text:" => $courseEntryText , "Latest Post:" => $latestPost);
			}
		}
	}
   echo "Antal kurser: ".count($urlArray)." stycken";
   json_encode($urlArray, JSON_PRETTY_PRINT);
   echo $urlArray;
   require_once('bottom-cache.php');	
   //Kommenterar bort koden under då vi bara ska skrapa första sidan pga webbhotellets begränsning.
   //getNextPage($dom, $data, $urlArray);
}

//Hämtar ut introduktionstext om det finns annars skrivs "No entry text" ut.
function getCourseEntryText($dom, $courseURL){
    $courseURL = curl_get_request($courseURL);
    libxml_use_internal_errors(true);
    if($dom->loadHTML($courseURL)){
        libxml_use_internal_errors(false);
        $xpath = new DOMXPath($dom);

        $courseEntryText = $xpath->query('//div[@class="entry-content"]/p/text()')->item(0);

        if($courseEntryText != null){
            return trim($courseEntryText->textContent);
        }
        else{
            return "No entry text";
        }
    }
}
//Hämtar ut kurskoden om det finns annars skrivs "No course code" ut.
function getCourseCode($dom, $courseURL){
    $courseURL = curl_get_request($courseURL);
    libxml_use_internal_errors(true);
    if($dom->loadHTML($courseURL)){
        libxml_use_internal_errors(false);
        $xpath = new DOMXPath($dom);
        $courseCode = $xpath->query('//div[@id = "header-wrapper"]/ul/li[last()]/a/text()')->item(0);

        if($courseCode != null){
            return trim($courseCode->textContent);
        }
        else{
            return "No course code";
        }
    }
}
//Hämtar ut kursplan om det finns annars skrivs "No course plan" ut.
function getCoursePlan($dom, $courseURL){
    $courseURL = curl_get_request($courseURL);
    libxml_use_internal_errors(true);
    if($dom->loadHTML($courseURL)){
        libxml_use_internal_errors(false);
        $xpath = new DOMXPath($dom);
        $coursePlan = $xpath->query('//ul[@class = "sub-menu"]/li/a/text()[contains(., "Kursplan")]')->item(0);

		if($coursePlan != null)
		{
			$href = $coursePlan->parentNode;
			if($href != null)
			{
				return trim($href->getAttribute("href"));
			}
			else
			{
				return "No course plan";
			}
		}
    }
}
//Hämtar ut text på nästa sida.
function getNextPage($dom, $data , $urlArray){
    if($dom->loadHTML($data)){

        $xpath = new DOMXPath($dom);
        $nextPageUrl = $xpath->query("//div[@id='pag-bottom']/div[@class='pagination-links']/a[@class='next page-numbers']");
        foreach($nextPageUrl as $href)
		{
            $nextPageUrl =  $href->getAttribute('href') . "<br/>";
        }
		if($nextPageUrl == 1)
		{
		   echo "Antal kurser: ".count($urlArray)." stycken <br/>";
		   var_dump($urlArray);
		   require_once('bottom-cache.php');		   
        }		
        $nextPageUrl = curl_get_request("http://coursepress.lnu.se" . $nextPageUrl);
		if(strlen($nextPageUrl) > 0)
		{
			getAllCourses($dom,$nextPageUrl,$urlArray);
		}
    }
	
}
//Hämtar ut senast skivna inlägget på sidan annars skrivs "Information saknas.." ut.
function getLatestPost($dom, $courseURL)
{
	libxml_use_internal_errors(true);
    if($dom->loadHTML($courseURL))
	{
        libxml_use_internal_errors(false);
        $xpath = new DOMXPath($dom);

		$latestPostHeader = $xpath->query('//header[@class="entry-header"]/h1[class="entry-title"]')->item(0);
		$latestPostTime = $xpath->query('//header[@class="entry-header"]/p[class="entry-title"]')->item(0);

		if($latestPostHeader != null && $latestPostTime != null)
		{
			$latestPostValue = trim($latestPost->nodeValue);
			$hej = trim($latestPostTime->nodeValue);
			return $latestPostValue.$hej;
		}
		else
		{
			return "Information saknas..";
		}
	}
}
//Tar emot en URL
function curl_get_request($url){
    $agent = 'myemail@hotmail.com';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, $agent);
	
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}