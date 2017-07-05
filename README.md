The code include two parts, one is index.php which is responsible to list the top20 topics and provide vote functions, another one is post.php that provide write data into topic list

There are two data model, topic and topicList. Both of them define the basic getter, setter and sorting method to the object.

Due to the restriction, the data will be stored in php session. Once user open the page, the old data will be loaded into session first and transformed to corresponding data object.

Example URL: https://fast-badlands-53908.herokuapp.com/web/index.php
