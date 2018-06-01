<?php if (array_key_exists('sidebar_collapsed', $_SESSION) && true == $_SESSION['sidebar_collapsed']): ?>
    <li><a id="toggle-sidebar" data-state="closed">&rarr;</a></li>
<?php else: ?>
    <li><a id="toggle-sidebar" data-state="open">&larr;</a></li>
<?php endif; ?>