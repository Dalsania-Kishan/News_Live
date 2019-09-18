<?php
include('includes/config.php');
$feed_url='https://www.news18.com/rss/movies.xml';
try
{
	echo "Starting to work with feed URL '" . $feed_url . "'";

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
		$item_category = "Movies";
		$html = new DOMDocument();
	    $html->loadHTML( $item_desc);
   		$src = $html->getElementsByTagName( 'img' )->item(0)->getAttribute('src');
		
		$item_desc=preg_replace("/<img[^>]+\>/i", " ", $item_desc);
		$item_exists_sql = "SELECT item_id FROM news_movies where item_id = '" . $item_id . "'";
		$item_exists = mysqli_query($con,$item_exists_sql);
		//$total_rows = mysqli_fetch_array($item_exists)[0];
		if(mysqli_num_rows($item_exists)<1)
		{
			echo "<font color=green>Inserting new item..</font><br/>";
			$item_insert_sql = "INSERT INTO news_movies(item_id,  item_title,feed_url, item_date, item_url,item_desc,fetch_date, item_category,image) VALUES ('  $item_id ', ' $item_title ',' $feed_url', ' $item_date', ' $item_url', ' $item_desc', ' $fetch_date ' ,' $item_category 	','$src')";
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