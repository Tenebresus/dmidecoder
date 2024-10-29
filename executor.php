<?php

require 'vendor/autoload.php';

use Tenebresus\Dmidecoder\Parser;

$dmidecode = file_get_contents('example');

$parser = new Parser($dmidecode);
