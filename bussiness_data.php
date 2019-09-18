<?php

include('includes/config.php');
//$db_hostname="localhost";
//$db_username="root";
//$db_password="";

$private_access_key="youraccesskey";
$feed_url='https://www.news18.com/rss/business.xml';
try
{
	/*  query the database */
	// $db = getCon();

	
	echo "Starting to work with feed URL '" . $feed_url . "'";

	/* Parse XML from  http://www.instapaper.com/starred/rss/580483/qU7TKdkHYNmcjNJQSMH1QODLc */
	//$RSS_DOC = simpleXML_load_file('http://www.instapaper.com/starred/rss/580483/qU7TKdkHYNmcjNJQSMH1QODLc');

	libxml_use_internal_errors(true);
	$RSS_DOC = simpleXML_load_file($feed_url);
	if (!$RSS_DOC) {
		echo "Failed loading XML\n";
		foreach(libxml_get_errors() as $error) {
			echo "\t", $error->message;
		}
	}


	/* Get title, link, managing editor, and copyright from the document  */
	$rss_title = $RSS_DOC->channel->title;
	$rss_link = $RSS_DOC->channel->link;
	$rss_desc = $RSS_DOC->channel->description;
	$rss_editor = $RSS_DOC->channel->managingEditor;
	$rss_copyright = $RSS_DOC->channel->copyright;
	$rss_date = $RSS_DOC->channel->pubDate;

	//Loop through each item in the RSS document

	foreach($RSS_DOC->channel->item as $RSSitem)
	{

		$item_id 	= md5($RSSitem->title);
		$fetch_date = date("Y-m-j G:i:s"); //NOTE: we don't use a DB SQL function so its database independant
		$item_title = $RSSitem->title;
		$item_date  = date("Y-m-j G:i:s", strtotime($RSSitem->pubDate));
		$item_url	= $RSSitem->link;
		$item_desc  =   $RSSitem->description;
		$item_category = "bussiness";
		$html = new DOMDocument();
	    $html->loadHTML( $item_desc);
   		$src = $html->getElementsByTagName( 'img' )->item(0)->getAttribute('src');
		
		$item_desc=preg_replace("/<img[^>]+\>/i", " ", $item_desc);
		
		/*echo "Processing item '" , $item_id , "' on " , $fetch_date 	, "<br/>";
		echo $item_title, " - ";
		echo $item_date, "<br/>";
		echo $item_url, "<br/>";
*/
		// Does record already exist? Only insert if new item...

		$item_exists_sql = "SELECT item_id FROM news_bussiness where item_id = '" . $item_id . "'";
		$item_exists = mysqli_query($con,$item_exists_sql);
		if(mysqli_num_rows($item_exists)<1)
		{
			echo "<font color=green>Inserting new item..</font><br/>";
			$item_insert_sql = "INSERT INTO news_bussiness(item_id, feed_url, item_title, item_date, item_url,item_desc,fetch_date, item_category,image) VALUES ('" . $item_id . "', '" . $feed_url . "', '" . $item_title . "', '" . $item_date . "', '" . $item_url . "', '" . $item_desc . "', '" . $fetch_date . "' ,'" . $item_category . "','" . $src . "')";
			$insert_item = mysqli_query($con,$item_insert_sql);
		}
		else
		{
			echo "<font color=blue>Not inserting existing item..</font><br/>";
		}

		echo "<br/>";
	}

	// End of form //
} catch (Exception $e)
{
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
?>