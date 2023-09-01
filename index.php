<?php

require __DIR__ . '/vendor/autoload.php';

use Symfony\Component\Dotenv\Dotenv;

$dotenv = new Dotenv();
$dotenv->load(__DIR__ . '/.env');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require __DIR__ . '/src/mcv/controller/pollController.php';
} else {
	require __DIR__ . '/public/app.php';
}
