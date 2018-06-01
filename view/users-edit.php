<?php $formData = ($postData = Sapper\Route::getFlashPostData()) ? $postData : $user; ?>

<div class="<?php include_once(APP_ROOT_PATH . '/view/_right-side-class.php'); ?>">
    <div class="row">
        <ol class="breadcrumb">
            <?php include_once(APP_ROOT_PATH . '/view/_toggle-sidebar.php'); ?>
            <li><a href="/"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li>Manage Users</li>
            <li>Users</li>
            <li class="active">Edit User</li>
        </ol>
    </div><!--/.row-->

    <?php include_once(APP_ROOT_PATH . '/view/_flash-message.php'); ?>

    <?php /** Edit user */ ?>
    <div class="row">
        <div class="col-sm-12 col-sm-offset-0 col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">Edit User</div>
                <div class="panel-body">
                    <form role="form" method="post" action="/users/edit/<?php echo $user['id']; ?>">
                        <div class="text-center">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <th>First Name:</th>
                                        <td><input type="text" class="form-control" name="first_name" value="<?php echo $formData['first_name']; ?>" data-validation="not-empty" /></td>
                                    </tr>
                                    <tr>
                                        <th>Last Name:</th>
                                        <td><input type="text" class="form-control" name="last_name" value="<?php echo $formData['last_name']; ?>" data-validation="not-empty" /></td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td><input type="text" class="form-control" name="email" value="<?php echo $formData['email']; ?>" data-validation="email" /></td>
                                    </tr>
                                    <tr>
                                        <th>Change Password:</th>
                                        <td><input type="text" class="form-control" name="userPassword" value="" id="userPassword" /></td>
                                    </tr>
                                    <tr>
                                        <th>Confirm Password:</th>
                                        <td><input type="text" class="form-control" name="password2" value="" data-validation="match-element" data-match-element="#userPassword" /></td>
                                    </tr>
                                    <tr>
                                        <th>CSM of Pod:</th>
                                        <td>
                                            <select name="pod_id" class="form-control">
                                                <option value=""></option>
                                                <?php foreach ($pods as $pod):
                                                    printf(
                                                        '<option value="%s" %s>%s</option>',
                                                        $pod['id'],
                                                        ($pod['id'] == $formData['pod_id']) ? 'selected' : '',
                                                        $pod['name']
                                                    );
                                                endforeach; ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Role:</th>
                                        <td>
                                            <select name="role_id" class="form-control" data-validation="not-empty">
                                                <option value=""></option>
                                                <?php foreach ($roles as $role):
                                                    printf(
                                                        '<option value="%s" %s>%s</option>',
                                                        $role['id'],
                                                        ($role['id'] == $formData['role_id']) ? 'selected' : '',
                                                        $role['name']
                                                    );
                                                endforeach; ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Status:</th>
                                        <td>
                                            <select class="form-control" name="status">
                                                <?php foreach (['active', 'suspended'] as $status):
                                                    printf(
                                                        '<option value="%s" %s>%s</option>',
                                                        $status,
                                                        ($formData['status'] == $status) ? 'selected' : '',
                                                        ucfirst($status)
                                                    );
                                                endforeach; ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="vertical-align: top !important;">Permissions:</th>
                                        <td>
                                            <ul class="permissions" data-validation="atleast-1-checked">
                                                <?php foreach (Sapper\Model::get('permissions') as $label => $key): ?>

                                                    <li>
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