<?php

use app\assets\AppAsset;

AppAsset::register($this);

?>
<p id="notice" style="color: red"></p>

    <div id="container">
        <div class="dragElement ui-widget ui-corner-all ui-state-error">
            <div id="username"><?php echo Yii::$app->user->identity->username; ?></div>
        </div>
    </div>