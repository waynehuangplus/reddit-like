<?php

class TopicList implements \JsonSerializable {
    private $topicCount = 0;
    private $topicArray = array();
    /**
     * Add a single topic object into the list.
     * @param $singleTopic
     */
    public function addTopic($singleTopic, $topicId = null) {
        if ($topicId == null) {
            $topicId = uniqid();
        }
        $this->topicArray[$topicId] = $singleTopic;
        $this->topicCount = count($this->topicArray);
    }

    /**
     * @param int $topicCount
     */
    public function setTopicCount($topicCount)
    {
        $this->topicCount = $topicCount;
    }

    // FIXME: use max heap sort.
    private function sortList($a, $b) {
        if ($a->getTotalCount() == $b->getTotalCount()) {
            return 0;
        } elseif ($a->getTotalCount() > $b->getTotalCount()) {
            return -1;
        } elseif ($a->getTotalCount() < $b->getTotalCount()) {
            return 1;
        }
    }

    /**
     * @return array
     */
    public function getTopicArray()
    {
        return $this->topicArray;
    }


    public function getTop20() {
        uasort($this->topicArray, array($this, 'sortList'));
        if (count($this->topicArray) < 20) {
            return $this->topicArray;
        }
        $outputArray = array_slice($this->topicArray, 0, 20);
        return $outputArray;
    }

    /**
     * Use json format to store topic.
     * @return array
     */
    public function jsonSerialize()
    {
        $vars = get_object_vars($this);

        return $vars;
    }

}
?>