<?php $formData = ($postData = Sapper\Route::getFlashPostData()) ? $postData : $user; ?>

<div class="<?php include_once(APP_ROOT_PATH . '/view/_right-side-class.php'); ?>">
    <div class="row">
        <ol class="breadcrumb">
            <?php include_once(APP_ROOT_PATH . '/view/_toggle-sidebar.php'); ?>
            <li><a href="/"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li class="active">My Profile</li>
        </ol>
    </div><!--/.row-->

    <?php include_once(APP_ROOT_PATH . '/view/_flash-message.php'); ?>

    <?php /** My Profile */ ?>
    <div class="row">
        <div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Profile</div>
                <div class="panel-body">
                    <form role="form" method="post" action="/my-profile">
                        <input type="hidden" name="action" value="save" />
                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>" />
                        <div class="text-center">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>First Name:</th>
                                            <td>
                                                <input type="text" class="form-control" name="first_name" value="<?php echo $formData['first_name']; ?>" data-validation="not-empty" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Last Name:</th>
                                            <td>
                                                <input type="text" class="form-control" name="last_name" value="<?php echo $formData['last_name']; ?>" data-validation="not-empty" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Email:</th>
                                            <td>
                                                <input type="text" class="form-control" name="email" value="<?php echo $formData['email']; ?>" data-validation="not-empty,email" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Change Password:</th>
                                            <td><input type="password" class="form-control" name="userPassword" value="" id="userPassword" /></td>
                                        </tr>
                                        <tr>
                                            <th>Confirm Password:</th>
                                            <td><input type="password" class="form-control" value="" data-validation="match-element" data-match-element="#userPassword" /></td>
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