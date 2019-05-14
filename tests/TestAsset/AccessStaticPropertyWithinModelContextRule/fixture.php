<?php

namespace SlamPhpStan\Tests\TestAsset\AccessStaticPropertyWithinModelContextRule;

class ModelAccessingYiiAppSingletons implements YiiAlikeActiveRecordInterface {
    public function foo() {
        // \BaseYii::$app
        YiiAlikeBaseYii::$app;
        // Yii::$app
        AnyOtherClassExtendingBaseYii::$app;
        AnyOtherClass::$app;
        $var = 'app';
        AnyOtherClass::$$var;
        NonExistingClass::$app;
    }
}

class AnyOtherClass {
    public static $app;

    public function foo() {
        // \BaseYii::$app
        YiiAlikeBaseYii::$app;
        // Yii::$app
        AnyOtherClassExtendingBaseYii::$app;
        self::$app;
    }
}

trait YiiAppSingletonCallRuleTrait {
    public function foo() {
        // \BaseYii::$app
        YiiAlikeBaseYii::$app;
        // Yii::$app
        AnyOtherClassExtendingBaseYii::$app;
        AnyOtherClass::$app;
    }
}

function YiiAppSingletonCallRuleFunction() {
    // \BaseYii::$app
    YiiAlikeBaseYii::$app;
    // Yii::$app
    AnyOtherClassExtendingBaseYii::$app;
    AnyOtherClass::$app;
}

// \BaseYii::$app
YiiAlikeBaseYii::$app;
// Yii::$app
AnyOtherClassExtendingBaseYii::$app;
AnyOtherClass::$app;

interface YiiAlikeActiveRecordInterface {}

class YiiAlikeBaseYii {
    public static $app;
}

class AnyOtherClassExtendingBaseYii extends YiiAlikeBaseYii {}