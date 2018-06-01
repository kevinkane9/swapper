<?php $formData = Sapper\Route::getFlashPostData(); ?>

<div class="<?php include_once(APP_ROOT_PATH . '/view/_right-side-class.php'); ?>">
    <div class="row">
        <ol class="breadcrumb">
            <?php include_once(APP_ROOT_PATH . '/view/_toggle-sidebar.php'); ?>
            <li><a href="/"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li>Manage Users</li>
            <li class="active">User Roles</li>
        </ol>
    </div><!--/.row-->

    <?php include_once(APP_ROOT_PATH . '/view/_flash-message.php'); ?>

    <?php /** Roles */ ?>
    <div class="row">
        <div class="col-sm-12 col-sm-offset-0 col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">User Roles</div>
                <div class="panel-body">
                    <div class="text-center">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">Role</th>
                                    <th class="text-center"># of Users</th>
                                    <th class="text-center" width="140">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($roles as $role): ?>
                                    <tr>
                                        <td class="name text-left"><?php echo $role['name']; ?></td>
                                        <td class="text-left"><?php echo $role['countOfUsers']; ?></td>
                                        <td class="actions text-center" width="140">
                                            <a href="/roles/edit/<?php echo $role['id']; ?>" class="fa fa-pencil"></a>
                                            <?php if (0 == $role['countOfUsers']): ?>
                                                <a href="/roles/delete/<?php echo $role['id']; ?>" class="delete fa fa-times sweet-confirm-href"></a>
                                            <?php else: ?>
                                                <a class="fa fa-times not-allowed"></a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.col-->
    </div><!-- /.row -->


    <?php /** Create role */ ?>
    <div class="row">
        <div class="col-sm-12 col-sm-offset-0 col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">Create User Role</div>
                <div class="panel-body">
                    <form role="form" method="post" action="/roles/create">
                        <div class="text-center">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="create-suppression-list-table">
                                    <tbody>
                                    <tr>
                                        <th>Name:</th>
                                        <td><input type="text" class="form-control" name="name" value="<?php echo $formData ? $formData['name'] : ''; ?>" data-validation="not-empty" /></td>
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
                                                Create
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