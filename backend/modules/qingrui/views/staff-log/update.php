<?php
use backend\assets\LayuiAsset;
LayuiAsset::register($this);
?>
<div class="staff-log-update">
    <?=
    $this->render('_form', [
        'model' => $model,
    ])
    ?>

</div>
