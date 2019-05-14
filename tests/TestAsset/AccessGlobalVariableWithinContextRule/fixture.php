<?php

namespace SlamPhpStan\Tests\TestAsset\AccessGlobalVariableWithinContextRule;

class ModelAccessingGlobalVariable implements YiiAlikeActiveRecordInterface {
    public function foo() {
        // $bar0 = $_POST;
        $bar1 = $_POST;
        $bar2 = $GLOBALS;
        $argc = [];

        $baz1 = $POST ?? null;
        $baz2 = $argcount ?? null;

        $var = 'foo';
        $$var = 1;
        ${$var} = 2;
    }
}

class AnyOtherClass {
    public function foo() {
        // $bar0 = $_POST;
        $bar1 = $_POST;
        $bar2 = $GLOBALS;
        $argc = [];

        $baz1 = $POST ?? null;
        $baz2 = $argcount ?? null;

        $var = 'foo';
        $$var = 1;
        ${$var} = 2;
    }
}

trait YiiAppSingletonCallRuleTrait {
    public function foo() {
        // $bar0 = $_POST;
        $bar1 = $_POST;
        $bar2 = $GLOBALS;
        $argc = [];

        $baz1 = $POST ?? null;
        $baz2 = $argcount ?? null;

        $var = 'foo';
        $$var = 1;
        ${$var} = 2;
    }
}

function YiiAppSingletonCallRuleFunction() {
    // $bar0 = $_POST;
    $bar1 = $_POST;
    $bar2 = $GLOBALS;
    $argc = [];

    $baz1 = $POST ?? null;
    $baz2 = $argcount ?? null;

    $var = 'foo';
    $$var = 1;
    ${$var} = 2;
}

interface YiiAlikeActiveRecordInterface {}
