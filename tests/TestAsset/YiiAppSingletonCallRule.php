<?php

namespace {
    class BaseYii {
        public static $app;
    }

    final class Yii extends BaseYii {

    }
}

namespace SlamPhpStan\Tests\TestAsset\Ok {

    // \BaseYii::$app

    \BaseYii::$app;

    // Yii::$app

    \Yii::$app;
}

namespace SlamPhpStan\Tests\TestAsset\Ko {

    // \BaseYii::$app

    \BaseYii::$app;

    // Yii::$app

    \Yii::$app;
}
