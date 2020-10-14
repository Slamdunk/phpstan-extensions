<?php

$config = new SlamCsFixer\Config();
$config->getFinder()
    ->in(__DIR__ . '/lib')
    ->in(__DIR__ . '/tests')
    ->notPath('TestAsset/')
    ->notPath('TmpAsset/')
;

return $config;
