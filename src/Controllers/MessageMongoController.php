<?php

use Models\MessageMongo;

$messageModel = new MessageMongo();

$messageModel->create([
    'from' => 'test',
    'content' => 'hello'
]);