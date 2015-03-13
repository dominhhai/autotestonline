<div>
    <?php
    if(isset($orgFirstName)) echo '団体担当者：'.$orgFirstName;
    if(isset($orgLastName)) { echo ' '; echo $orgLastName . '<br>';}
    if(isset($testTitle)) echo 'テストタイトル：'.$testTitle.'<br>';
    ?>
</div>
<div class="users form">
<?php echo $this->Session->flash('auth'); ?>
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('Please enter your username and password'); ?></legend>
    <?php
        echo $this->Form->input('username', array('label' => 'ユーザー名'));
        echo $this->Form->input('password', array('label' => 'パスワード'));
    ?>
    </fieldset>
<?php echo $this->Form->end(__('ログイン')); ?>
</div>