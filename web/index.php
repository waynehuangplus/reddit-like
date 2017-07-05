<?php
session_start();
require_once ("./inc/Topic.inc");
require_once ("./inc/TopicList.inc");
require('../vendor/autoload.php');
$topicList = new TopicList();


echo "<a href=\"post.php\" target=\"_blank\">post a topic</a>";

echo <<< EOF
<script src="vote-js/js/jquery-3.1.0.min.js"></script>
<script src="vote-js/lib/jquery.upvote.js"></script>
<link rel="stylesheet" href="vote-js/lib/jquery.upvote.css">
<script type="text/javascript">
    var callback = function(data) {
    $.ajax({
        url: 'index.php',
        type: 'post',
        data: { id: data.id, up: data.upvoted, down: data.downvoted, star: data.starred },
        
    }).done(function() {
        location.reload()
    });
};
 </script>
EOF;

// Restore data from storage
if (isset($_SESSION['topicList'])) {
    restoreData($_SESSION['topicList'], $topicList);
}

generateTemplate($topicList);

// vote
if (isset($_POST['id'])) {
vote($_POST['id'], $topicList);
}


/**
 * Generate vote template.
 * @param $topicList
 */
function generateTemplate($topicList) {
    $topicArray = $topicList->getTop20();
    foreach ($topicArray as $key => $value) {
        $count = $value->getTotalCount();
        $topicName = $value->getTopicName();
        $topicId = "topic-".$key;
        echo "<div style=\"position: relative; border: solid 0px red; width: 500px; text-align: center;\">";
        echo "<p>".$topicName."</p>";
        echo "</br></br>";
        echo "<div id = $topicId class = \"upvote\" style=\"position: absolute;left: 0px;top: -10px;\">";
        echo "<a class=\"upvote\"></a>";
        echo "<span class=\"count\">".$count."</span>";
        echo "<a class=\"downvote\"></a>";
        echo "<script type=\"text/javascript\">";
        echo "$('#$topicId').upvote({id: \"$key\", callback: callback});";
        echo "</script>";
        echo "</div>";
        echo "</div>";
    }

}

/**
 * Restore data from json.
 * @param $data
 * @param $topicList
 */
function restoreData($data, $topicList) {
        $obj = json_decode($data, true);
        foreach ($obj['topicArray'] as $key => $value) {
            $topic = Topic::restoreTopic($value['topicName'], $value['totalThumbCount']);
            $topicList->addTopic($topic, $key);
        }
}


/**
 * Vote function
 * @param $topicId
 * @param $topicList
 */
function vote($topicId, $topicList) {
    $topic = $topicList->getTopicArray();
    if ($_POST['up'] == true) {
        $topic[$topicId]->thumbUp();
    } elseif ($_POST['down'] == true) {
        $topic[$topicId]->thumbDown();
    }
}

// Write to storage
$_SESSION['topicList'] = json_encode($topicList);

//session_destroy();
?>
