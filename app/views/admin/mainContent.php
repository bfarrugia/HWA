<?php

$_users = $view->getObject('users');

?>
<div class="container">
    <table class="table">
        <thead>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Address 1</th>
            <th>Address 2</th>
            <th>City</th>
            <th>State</th>
            <th>ZIP Code</th>
            <th>Created</th>
        </thead>
        <tbody>
            <?php if($_users): ?>
                <?php foreach($_users as $user): ?>
                    <tr>
                        <td><?php echo $user->getData('firstname'); ?></td>
                        <td><?php echo $user->getData('lastname'); ?></td>
                        <td><?php echo $user->getData('address1'); ?></td>
                        <td><?php echo $user->getData('address2'); ?></td>
                        <td><?php echo $user->getData('city'); ?></td>
                        <td><?php echo $user->getData('state'); ?></td>
                        <td><?php echo $user->getData('zipcode'); ?></td>
                        <td><?php echo $user->getData('created'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td>No entries available.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>