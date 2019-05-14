<?php

namespace SlamPhpStan\Tests\TestAsset;

class ModelAccessingGlobalVariable implements YiiAlikeActiveRecordInterface {
    public function foo() {
        // $bar0 = $_POST;
        $bar1 = $_POST;
        $bar2 = $GLOBALS;
        $argc = [];

        $baz1 = $POST ?? null;
        $baz2 = $argcount ?? null;
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
    }
}

function YiiAppSingletonCallRuleFunction() {
    // $bar0 = $_POST;
    $bar1 = $_POST;
    $bar2 = $GLOBALS;
    $argc = [];

    $baz1 = $POST ?? null;
    $baz2 = $argcount ?? null;
}

interface YiiAlikeActiveRecordInterface {}
