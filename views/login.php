<?php

use app\core\form\Form;

?>

<h1>SignIn</h1>

<?php $form = Form::begin('', 'post'); ?>

<?= $form->field($model, 'email') ?>
<?= $form->field($model, 'password')->passwordField() ?>

<button type="submit" class="btn btn-primary">Sign In</button>

<?php Form::end(); ?>