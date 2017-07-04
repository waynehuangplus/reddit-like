<?php
session_start();
require_once ("./inc/Topic.inc");
require_once ("./inc/TopicList.inc");
$topicList = new TopicList();


echo <<< EOF
    <script src="vote-js/js/jquery-3.1.0.min.js"></script>
    <script src="vote-js/lib/jquery.upvote.js"></script>
    <link rel="stylesheet" href="vote-js/lib/jquery.upvote.css">

<div id="topic-595b5996c347d" class="upvote">
    <a class="upvote"></a>
    <span class="count">0</span>
    <a class="downvote"></a>
    <a class="star"></a>
    
</div>

    <script>
    var callback = function(data) {
    $.ajax({
        url: 'http://d1.maximum.cc/~maximum/reddit/index.php',
        type: 'post',
        data: { id: data.id, up: data.upvoted, down: data.downvoted, star: data.starred }
    });
};
    $('#topic-595b5996c347d').upvote({id: "595b5996c347d", callback: callback});
    </script>
EOF;




// Restore data from storage
if (isset($_SESSION['topicList'])) {
    $obj = json_decode($_SESSION['topicList'], true);
    $topicList->setTopicCount($obj['topicCount']);
    foreach ($obj['topicArray'] as $key => $value) {
        $topic = Topic::restoreTopic($value['topicName'], $value['totalThumbCount']);
        $topicList->addTopic($topic, $key);
    }
}
var_dump($topicList);

// vote
if (isset($_POST['id'])) {
    $topicId = $_POST['id'];
error_log("1232323");
    $topic = $topicList->getTopicArray();
    if ($_POST['up'] == true) {
        error_log("upup");
        $topic[$topicId]->thumbUp();
    } elseif ($_POST['down'] == true) {
        $topic[$topicId]->thumbDown();
    }

}


//$obj = json_decode($topicList, true);
//echo "<pre>" . json_encode($obj, JSON_PRETTY_PRINT) . "</pre>";
//foreach ($obj['topicArray'] as $key => $value) {
//    echo $key." : ".  $value['topicName']."</br>";
//}

//foreach ()
//var_dump($topicList);
//session_destroy();

// Write to storage
$_SESSION['topicList'] = json_encode($topicList);
?>