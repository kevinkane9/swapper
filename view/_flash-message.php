<?php
    if ($flashMessage = Sapper\Route::getFlash()):

        if (!array_key_exists('type', $flashMessage)) {
            $arr = array_values($flashMessage);
            $flashMessage = $arr[0];
        }
        ?>
        <div class="row" style="margin-top: 30px;">
            <div class="col-sm-4 col-sm-offset-4">
                <div class="alert bg-<?php echo $flashMessage['type']; ?>" role="alert">
                    <?php if ('success' == $flashMessage['type']): ?>
                        <svg class="glyph stroked checkmark"><use xlink:href="#stroked-checkmark"/></svg>
                    <?php else: ?>
                        <svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg>
                    <?php endif; ?>

                    <?php echo $flashMessage['message']; ?>
                </div>
            </div>
        </div>
<?php endif; ?>