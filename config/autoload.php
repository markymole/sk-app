<?php

session_start();

include(__DIR__ . '\database.php');

// classes
include(dirname(__DIR__)  . '/classes/post.php');
include(dirname(__DIR__)  . '/classes/users.php');
include(dirname(__DIR__)  . '/classes/image.php');
include(dirname(__DIR__)  . '/classes/functions.php');
include(dirname(__DIR__)  . '/classes/uploads.php');
include(dirname(__DIR__)  . '/classes/comments.php');
include(dirname(__DIR__)  . '/classes/likes.php');
