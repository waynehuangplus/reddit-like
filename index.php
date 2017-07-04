<?php
session_start();
require_once ("./inc/Topic.inc");
require_once ("./inc/TopicList.inc");
$topicList = new TopicList();

echo <<< EOF
<script src="vote-js/js/jquery-3.1.0.min.js"></script>
<script src="vote-js/lib/jquery.upvote.js"></script>
<link rel="stylesheet" href="vote-js/lib/jquery.upvote.css">
<script type="text/javascript">
    var callback = function(data) {
    $.ajax({
        url: 'http://d1.maximum.cc/~maximum/reddit/index.php',
        type: 'post',
        data: { id: data.id, up: data.upvoted, down: data.downvoted, star: data.starred },
        success: location.reload();

    });
};
 </script>
EOF;


//echo <<< EOF
//    <script src="vote-js/js/jquery-3.1.0.min.js"></script>
//    <script src="vote-js/lib/jquery.upvote.js"></script>
//    <link rel="stylesheet" href="vote-js/lib/jquery.upvote.css">
//
//<div id="topic-595b5996c347d" class="upvote">
//    <a class="upvote"></a>
//    <span class="count">0</span>
//    <a class="downvote"></a>
//    <a class="star"></a>
//
//</div>
//
//    <script>
//    var callback = function(data) {
//    $.ajax({
//        url: 'http://d1.maximum.cc/~maximum/reddit/index.php',
//        type: 'post',
//        data: { id: data.id, up: data.upvoted, down: data.downvoted, star: data.starred }
//    });
//};
//    $('#topic-595b5996c347d').upvote({id: "595b5996c347d", callback: callback});
//    </script>
//EOF;




// Restore data from storage
if (isset($_SESSION['topicList'])) {
    restoreData($_SESSION['topicList'], $topicList);
}

generateTemplate($topicList);

// vote
if (isset($_POST['id'])) {
vote($_POST['id'], $topicList);
}



function generateTemplate($topicList) {
    $topicArray = $topicList->getTop20();
    foreach ($topicArray as $key => $value) {
        $count = $value->getTotalCount();
        $topicName = $value->getTopicName();
        $topicId = "topic-".$key;
        echo "<div id = $topicId class = \"upvote\">";
        echo "<p>".$topicName."</p>";
        echo "<a class=\"upvote\"></a>";
        echo "<span class=\"count\">".$count."</span>";
        echo "<a class=\"downvote\"></a>";
        echo "<script type=\"text/javascript\">";
        echo "$('#$topicId').upvote({id: \"$key\", callback: callback});";
        echo "</script>";
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