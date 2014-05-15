<fieldset>
<?php
  /**
   * component for app/View/User/login.ctp
   */

  // insert CSS for register / login screen

  echo $this->Form->create('User', array(
    'inputDefaults' => array(
      'div' => 'form-group',
      'wrapInput' => false,
      'class' => 'form-control'),
    'class' => 'well'));


  ?>
    <legend><?php echo __('Sign in'); ?></legend>

    <?php

      // username :: inputs
      echo $this->Form->input('username',array(
        'placeholder' => 'Username'));

      // password :: inputs
      echo $this->Form->input('password', array(
        'placeholder' => 'Password'));

      // Remember Checkbox
      echo $this->Form->input('rememberMe', array(
        'type' => 'checkbox',
        'label' => 'Remember login',
        'class' => false));

      // sign in button
      echo $this->Form->submit('Sign in', array(
        'div' => 'form-group',
        'class' => 'btn btn-default'));

      echo $this->Form->end();
?>
</fieldset>
