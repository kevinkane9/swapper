<?php $formData = ($postData = Sapper\Route::getFlashPostData()) ? $postData : $role; ?>

<div class="<?php include_once(APP_ROOT_PATH . '/view/_right-side-class.php'); ?>">
    <div class="row">
        <ol class="breadcrumb">
            <?php include_once(APP_ROOT_PATH . '/view/_toggle-sidebar.php'); ?>
            <li><a href="/"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li>Manage Users</li>
            <li>User Roles</li>
            <li class="active">Edit Role</li>
        </ol>
    </div><!--/.row-->

    <?php include_once(APP_ROOT_PATH . '/view/_flash-message.php'); ?>

    <?php /** Edit role */ ?>
    <div class="row">
        <div class="col-sm-12 col-sm-offset-0 col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">Edit User Role</div>
                <div class="panel-body">
                    <form role="form" method="post" action="/roles/edit/<?php echo $role['id']; ?>">
                        <div class="text-center">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <th>Name:</th>
                                        <td><input type="text" class="form-control" name="name" value="<?php echo $formData['name']; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <th style="vertical-align: top !important;">Permissions:</th>
                                        <td>
                                            <ul class="permissions">
                                                <?php foreach (Sapper\Model::get('permissions') as $label => $key): ?>

                                                    <li>
                                                        <?php if ('string' == gettype($key)): ?>
                                                            <div class="form-group checkbox">
                                                                <label for="<?php echo $key; ?>">
                                                                    <?php printf(
                                                                        '<input type="checkbox" name="permissions[]" value="%s" id="%s" %s /> %s',
                                                                        $key, $key, (in_array($key, $formData['permissions'])) ? 'checked' : '', $label
                                                                    ); ?>
                                                                </label>
                                                            </div>
                                                        <?php else: ?>
                                                            <span><?php echo $label; ?></span>
                                                            <ul>
                                                                <?php foreach ($key as $subLabel => $subKey): ?>
                                                                    <li>
                                                                        <div class="form-group checkbox">
                                                                            <label for="<?php echo $subKey; ?>">

                                                                                <?php printf(
                                                                                    '<input type="checkbox" name="permissions[]" value="%s" id="%s" %s /> %s',
                                                                                    $subKey,
                                                                                    $subKey,
                                                                                    (isset($formData['permissions']) && in_array($subKey, $formData['permissions'])) ? 'checked' : '',
                                                                                    $subLabel
                                                                                ); ?>
                                                                            </label>
                                                                        </div>
                                                                    </li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        <?php endif; ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-spin fa-spinner hidden"></i>
                                                Save
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.col-->
    </div><!-- /.row -->

</div><!--/.main-->