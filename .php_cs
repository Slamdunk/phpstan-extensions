<?php

$config = new SlamCsFixer\Config(SlamCsFixer\Config::LIB);
$config->getFinder()
    ->in(__DIR__ . '/lib')
    ->in(__DIR__ . '/tests')
;

return $config;
