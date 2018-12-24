<?php

use app\assets\AppAsset;

AppAsset::register($this);

?>
    <div id="container">
        <div class="dragElement ui-widget ui-corner-all ui-state-error">
            <?php echo Yii::$app->user->identity->username; ?>
        </div>
    </div>

<div id="start">Start: Left: - Top: -</div>
<div id="stop">Stop: Left: - Top: -</div>