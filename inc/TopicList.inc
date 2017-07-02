<?php

class TopicList {
    private $topicCount = 0;
    private $topicArray = array();

    /**
     * Add a single topic object into the list.
     * @param $singleTopic
     */
    public function addTopic($singleTopic) {
        array_push($this->topicArray, $singleTopic);
        $this->topicCount++;
    }

    private function sortList($a, $b) {
        if ($a->getTotalThumbCount() == $b->getTotalThumbCount()) {
            return 0;
        } elseif ($a->getTotalThumbCount() > $b->getTotalThumbCount()) {
            return 1;
        } elseif ($a->getTotalThumbCount() < $b->getTotalThumbCount()) {
            return -1;
        }
    }

    public function getTop20() {
        usort($this->topicArray, $this->sortList());
        if (count($this->topicArray) < 20) {
            return $this->topicArray;
        }
        $outputArray = array_slice($this->topicArray, 0, 20);
        return $outputArray;
    }
}
?>