<?php

$_user = $view->getObject('user');

?>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
            <h2>User Registration - Confirmation</h2>
            <p>Success! We have added the new user to the field. Please use the <a href="/hwa/admin">admin panel</a> to view all users added thus far.</p>
            <address><strong><?php echo $_user->getData('firstname').' '.$_user->getData('lastname'); ?></strong><br/>
                <?php echo $_user->getData('address1'); ?><br/>
                <?php if($_user->getData('address2')){ echo $_user->getData('address2'); } ?><br/>
                <?php echo $_user->getData('city').', '.$_user->getData('state').' '.$_user->getData('zipcode'); ?>
            </address>
        </div>
    </div>
</div>