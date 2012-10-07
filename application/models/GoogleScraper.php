<?php

class Application_Model_GoogleScraper
{

	protected $_searchTerm;
	
	function __construct($searchtxt) {
		$searchtxt = str_replace(' ', '+', $searchtxt);
		$this->_searchTerm = $searchtxt;
	}
	
	public function get_googleapi_results(){
		$url = "http://ajax.googleapis.com/ajax/services/search/web?v=1.0&rsz=8&"
				."q=".$this->_searchTerm;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_REFERER, 'http://www.google.com');
		$body = curl_exec($ch);
		curl_close($ch);
		$json = json_decode($body, true);
		$i = 1;
		$gpapir = "";
		foreach($json["responseData"]["results"] as $results){
			$gpapir .= $url;
			$i++;
		}
		return $gpapir;
	}#function get_googleapi_results
	
	/*
	* from Yash Gupta's search.php http://thetechnofreak.com/technofreak/get-scrape-google-search-results-php/
	 * Slightly modified to work with this class and plugin
	 */
	 function get_google_results(){
	 ini_set("max_execution_time", 0); set_time_limit(0);    // no time-outs!
	 $query=$this->_searchTerm;
	 $npages=2;
	 $start=0;
	 $gg_url = 'http://www.google.com/search?hl=en&q=' . urlencode($query) . '&start=';
        $i=1;
        $size=0;
	        $options = array(
	        		CURLOPT_RETURNTRANSFER => true,     // return web page
	        		CURLOPT_HEADER         => false,    // don't return headers
	        		CURLOPT_FOLLOWLOCATION => true,     // follow redirects
	        		CURLOPT_ENCODING       => "",       // handle all encodings
	        		CURLOPT_AUTOREFERER    => true,     // set referer on redirect
	        		CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
	        		CURLOPT_TIMEOUT        => 120,      // timeout on response
	        		CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
	        		CURLOPT_COOKIEFILE  =>    "cookie.txt",
	        		CURLOPT_COOKIEJAR   =>    "cookie.txt",
	        		CURLOPT_USERAGENT   =>    "Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.0.3) Gecko/2008092417 Firefox/3.0.3",
	        		CURLOPT_REFERER =>       "http://www.google.com/",
            );
	
    
        $gpapir = "";
        for ($page = $start; $page < $npages; $page++){
	        $ch = curl_init($gg_url.$page.'0');
	        curl_setopt_array($ch,$options);
	        $scraped="";
	        $scraped.=curl_exec($ch);
	        curl_close( $ch );
	        $results = array();
	        preg_match_all('/<a href="([^"]+)" class=l.+?>.+?<\/a>/',$scraped,$results);
	        foreach ($results[1] as $url)
	        {
	        $gpapir .= $url;
	        $i++;
	        }#foreach
            $size+=strlen($scraped);
	 }#for loop
	 #return $gpapir;
	 return $results;
	 }# function get_google_results
	
	 function get_bing_results(){
	 $html = file_get_contents("http://www.bing.com/search?q=".$this->s."&qs=n&form=QBLH&filt=all&pq=".$this->s."&sc=0-0&sp=-1&sk=");
	 $doc = new DOMDocument();
	 @$doc->loadHtml($html);
	 $x = new DOMXpath($doc);
	 	$output = array();
	 	foreach ($x->query("//div[@class='sb_tlst']//a") as $node){
            $output[] = $node->getAttribute("href");
	 }#foreach
	 	for($count = 1;$count<=1;$count++){
	 	$first = ($count*10)+1;
	 	$html = file_get_contents("http://www.bing.com/search?q=".$this->s."&qs=n&filt=all&pq=".$this->s."&sc=0-0&sp=-1&sk=&first=".$first."&FORM=PORE");
	 	$doc = new DOMDocument();
	 	@$doc->loadHtml($html);
	 	$x = new DOMXpath($doc);
	 	foreach ($x->query("//div[@class='sb_tlst']//a") as $node)
	 	{
	 	$output[] = $node->getAttribute("href");
	 	}#foreach
	 	}#for count
    return $output;
	
    }#bing results
}

