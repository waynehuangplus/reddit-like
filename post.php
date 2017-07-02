<?php
session_start();
require_once ("./inc/Topic.inc");
require_once ("./inc/TopicList.inc");

$topicList = new TopicList();
try {
    $topic = new Topic($_POST["topic"]);
} catch (Exception $ex) {
    echo "Input is over the length limitation";
}
echo "123\n";
$topicList->addTopic($topic);
$_SESSION['topicList'] = $topicList;

?>