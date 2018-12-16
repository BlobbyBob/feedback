<?php

switch ($type) {
    case 'options':
        include 'evaluation/options.php';
        break;
    case 'numbers':
        include 'evaluation/numbers.php';
        break;
    case 'text':
        include 'evaluation/text.php';
        break;
}