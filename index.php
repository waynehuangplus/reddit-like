<?php
session_start();
//require_once ("./inc/Topic.inc");
//require_once ("./inc/TopicList.inc");
$topicList = $_SESSION['topicList'];
$obj = json_decode($topicList, true);
echo "<pre>" . json_encode($obj, JSON_PRETTY_PRINT) . "</pre>";
foreach ($obj['topicArray'] as $key => $value) {
    echo $key." : ".  $value['topicName']."</br>";
}

//foreach ()
//var_dump($topicList);
//session_destroy();
?>