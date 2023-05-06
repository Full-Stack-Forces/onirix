<?php

function checkCookie() {

    if (isset($_COOKIE['cookie']) && $_COOKIE['cookie'] == 'true') {
        return true;
    } else {
        return false;
    }
}