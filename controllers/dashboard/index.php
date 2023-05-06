<?php

use Webcup\UserService;

$users = UserService::getAll();
$average = 0;
$count = 0;

foreach ($users as $user) {
    $dreams = $user->dreams();

    foreach ($dreams as $dream) {
        
        if ($dream->isGood()) {
            $average += 1;
        }

        $count++;
    }
}

$average = $average / $count;