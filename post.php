<?php
session_start();
require_once ("./inc/Topic.inc");
require_once ("./inc/TopicList.inc");

echo <<< EOF
<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<form action="post.php" method="post">
    <p>Please input you topic (less than 255 words): </p>
    <input type="text" name="topic">
    <input type="submit">
</form>

</html>
EOF;

// Processing request
if (isset($_POST['topic'])) {

    $topicList = new TopicList();
    // Restore data from storage
    if (isset($_SESSION['topicList'])) {
        $obj = json_decode($_SESSION['topicList'], true);
//        $topicList->setTopicCount($obj['topicCount']);
        foreach ($obj['topicArray'] as $key => $value) {
            $topic = Topic::restoreTopic($value['topicName'], $value['totalThumbCount']);
            $topicList->addTopic($topic, $key);
        }
    }

    // Build new topic object
    $topic = null;
    try {
        $topic = Topic::newTopic($_POST["topic"]);
    } catch (Exception $ex) {
        echo "Input is over the length limitation";
    }
    $topicList->addTopic($topic);
    $_SESSION['topicList'] = json_encode($topicList);
    $output = $_SESSION['topicList'];
}
?>