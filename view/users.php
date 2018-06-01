<?php $formData = Sapper\Route::getFlashPostData(); ?>

<div class="<?php include_once(APP_ROOT_PATH . '/view/_right-side-class.php'); ?>">
    <div class="row">
        <ol class="breadcrumb">
            <?php include_once(APP_ROOT_PATH . '/view/_toggle-sidebar.php'); ?>
            <li><a href="/"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li>Manage Users</li>
            <li class="active">Users</li>
        </ol>
    </div><!--/.row-->

    <?php include_once(APP_ROOT_PATH . '/view/_flash-message.php'); ?>

    <?php /** Users */ ?>
    <div class="row" id="users-row">
        <div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Users</div>
                <div class="panel-body">
                    <div class="text-center">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="suppression-lists-table">
                                <thead>
                                    <tr>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Email</th>
                                        <th class="text-center">Role</th>
                                        <th class="text-center">CSM of Pod</th>
                                        <th class="text-center">Last Login</th>
                                        <th class="text-center" width="140">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td class="name text-left"><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></td>
                                        <td class="text-left"><?php echo $user['email']; ?></td>
                                        <td class="text-left"><?php echo $user['role']; ?></td>
                                        <td class="text-left"><?php echo $user['pod']; ?></td>
                                        <td class="text-left">
                                            <?php echo (!empty($user['last_login_at'])) ? date('F j, Y H:i:s', strtotime($user['last_login_at'])) : ''; ?>
                                        </td>
                                        <td class="actions text-center" width="140">
                                            <a href="/users/edit/<?php echo $user['id']; ?>" class="fa fa-pencil"></a>
                                            <a href="/users/delete/<?php echo $user['id']; ?>" class="sweet-confirm-href delete fa fa-times"></a>
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

</div><!--/.main-->