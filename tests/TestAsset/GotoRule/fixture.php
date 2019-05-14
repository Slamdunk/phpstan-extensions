<?php

namespace SlamPhpStan\Tests\TestAsset\GotoRule;

$var = 1;
goto a;

a:
++$var;
