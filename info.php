<?php

require(__DIR__.'/config.php');

if (isset($_GET['key']) && $apiKey == $_GET['key']) {
    phpinfo();
}