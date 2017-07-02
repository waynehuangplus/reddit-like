<?php

class Topic {
    private $topicSerial;
    private $topicName;
    private $thumbUpCount = 0;
    private $thumbDownCount = 0;
    private $totalThumbCount = 0;
    const topicLength = 255;

    public function __construct($topicName)
    {
        $this->topicName = $this->userInputChecker($topicName);
        $this->topicSerial = uniqid("topic_");
    }

    /**
     * @return int
     */
    public function getThumbUpCount()
    {
        return $this->thumbUpCount;
    }

    /**
     * @param int $thumbUpCount
     */
    public function setThumbUpCount($thumbUpCount)
    {
        $this->thumbUpCount = $thumbUpCount;
        $this->totalThumbCount++;
    }

    /**
     * @return int
     */
    public function getThumbDownCount()
    {
        return $this->thumbDownCount;
    }

    /**
     * @param int $thumbDownCount
     */
    public function setThumbDownCount($thumbDownCount)
    {
        $this->thumbDownCount = $thumbDownCount;
        $this->totalThumbCount--;
    }

    /**
     * @return int
     */
    public function getTotalThumbCount()
    {
        return $this->totalThumbCount;
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




}


?>