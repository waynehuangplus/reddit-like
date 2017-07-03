<?php

class Topic implements \JsonSerializable {
    private $topicName;
    private $totalThumbCount = 0;
    const topicLength = 255;

    /**
     * Constructor.
     * @param $topicName
     * @return Topic
     */
    public static function newTopic($topicName) {
        $instance = new self();
        $instance->setTopicName($instance->userInputChecker($topicName));
        return $instance;
    }

//    /**
//     * Constructor.
//     * @param $topicName
//     * @param $serialNum
//     * @return Topic
//     */
//    public static function newTopicWithSerial($topicName, $serialNum) {
//        $instance = new self();
//        $instance->setTopicName($instance->userInputChecker($topicName));
//        $instance->setTopicSerial($serialNum);
//        return $instance;
//    }

    /**
     * Decrease total thumb count.
     */
    public function thumbUp()
    {
        $this->totalThumbCount++;
    }

    /**
     * Increase total thumb count/
     */
    public function thumbDown()
    {
        $this->totalThumbCount--;
    }

    /**
     * Return total thumb count.
     * @return int
     */
    public function getTotalCount()
    {
        return $this->totalThumbCount;
    }

    /**
     * @return string
     */
    public function getTopicSerial()
    {
        return $this->topicSerial;
    }

    /**
     * @return string
     */
    public function getTopicName()
    {
        return $this->topicName;
    }

    /**
     * @param mixed $topicName
     */
    public function setTopicName($topicName)
    {
        $this->topicName = $topicName;
    }

    /**
     * @param int $totalThumbCount
     */
    public function setTotalThumbCount($totalThumbCount)
    {
        $this->totalThumbCount = $totalThumbCount;
    }


    /**
     * Check input length and escape to avoid XSS.
     * @param $topicName
     */
    private function userInputChecker($topicName) {
        if (strlen($topicName) > self::topicLength) {
            throw new InvalidArgumentException("input length size is over limitation". strlen($topicName));
        }
        $esacpeTopic = htmlspecialchars($topicName);
        return $esacpeTopic;
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