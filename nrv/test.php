<?php
require_once 'vendor/autoload.php';

use iutnc\nrv\render as render;
\iutnc\nrv\repository\NrvRepository::setConfig(__DIR__ . '/config/nrv.db.ini');
$s = \iutnc\nrv\repository\NrvRepository::getInstance();
$spec = $s-> getSpectacleById(1);
$r = new render\RenderSpectacle($spec);
echo $r->render();