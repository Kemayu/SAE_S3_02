<?php
declare(strict_types=1);

require_once 'vendor/autoload.php';
session_start();
\iutnc\nrv\repository\NrvRepository::setConfig(__DIR__ . '/config/nrv.db.ini');

$d = new \iutnc\nrv\dispatch\Dispatcher();
$d->run();
