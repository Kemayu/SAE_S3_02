<?php
require_once 'vendor/autoload.php';
use iutnc\nrv\objets as objets;
use iutnc\nrv\render as render;
$s = new objets\Spectacle("nrv","spectacle origine","image.png","extrait.mp3","12/04/24","16h",2,"rap",34);
$r = new render\RenderSpectacle($s);
echo $r->render();