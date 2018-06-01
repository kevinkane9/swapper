<?php if (array_key_exists('sidebar_collapsed', $_SESSION) && true == $_SESSION['sidebar_collapsed']): ?>
    <?php echo 'col-sm-12 main right-side-content'; ?>
<?php else: ?>
    <?php echo 'col-sm-9 main right-side-content'; ?>
<?php endif; ?>