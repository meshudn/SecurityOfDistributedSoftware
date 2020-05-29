<?php
  $objDOM = new DOMDocument("1.0", "UTF-8");
  $olderrors = error_reporting();
  error_reporting(0);
  if (!$objDOM->load("gaestebuch.xml")) {
  	error_reporting($olderrors);
  	$topElement = $objDOM->createElement("buch");
  	$objDOM->appendChild($topElement);
  }
  else {
	$topElement = $objDOM->getElementsByTagName("buch")->item(0);
  }

  error_reporting($olderrors);
  $message_raw= $_REQUEST['message'];
  $message = $message_raw;

  if ($message) {

  	$message_node = $objDOM->createElement("message");
  	$topElement->appendChild($message_node);
  	$message_text_node = $objDOM->createTextNode($message);
  	$message_node->appendChild($message_text_node);
  	if(!$objDOM->save("gaestebuch.xml"))
  		die('Could not save DOM');
  	header('Location: guestbook.php');
  		
  } else if(isset($_REQUEST['delete'])) {
  	$index = intval($_REQUEST['delete']);
  	$message_to_delete = $topElement->childNodes->item($index);
  	$topElement->removeChild($message_to_delete);
  	if(!$objDOM->save("gaestebuch.xml"))
  		die('Could not save DOM');

  	header('Location: guestbook.php');
  }
  else {
        echo "<html><head></head><body><h1>Gaeste</h1><hr/>";
        echo "<h2>Meine Lieblings-Links</h2>";
        echo "<ul>";
        echo '<li><a href="http://www.tu-chemnitz.de">TU Chemnitz</a></li>';
        echo '<li><a href="http://vsr.informatik.tu-chemnitz.de">VSR</a></li>';
        echo "</ul>";
        echo "<h2>Meinung der G&auml;ste:</h2>";
        $message_list = $objDOM->getElementsByTagName("message");
        if ($message_list->length > 0) {
        	for ($i = 0; $i < $message_list->length; $i++) {
           		echo "<p>" . $i . ": ";
           		$msg_node = $message_list->item($i);
           		echo $msg_node->childNodes->item(0)->data;
           		echo "&nbsp;(<a href='?delete=$i'>Delete</a>)</p>";
        	}
        }
        echo '<form>';
        echo '<p>';
        echo '<textarea name="message" cols="140" rows="20"></textarea>';
        echo '</p>';
        echo '<p>';
        echo '<input type="submit" value="Abschicken"/>';
        echo '</p>';
        echo '</form></body></html>';
  }
?>
