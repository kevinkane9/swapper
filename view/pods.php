<?php $formData = Sapper\Route::getFlashPostData(); ?>

<div class="<?php include_once(APP_ROOT_PATH . '/view/_right-side-class.php'); ?>">
    <div class="row">
        <ol class="breadcrumb">
            <?php include_once(APP_ROOT_PATH . '/view/_toggle-sidebar.php'); ?>
            <li><a href="/"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li>Manage Pods</li>
            <li class="active">Pods</li>
        </ol>
    </div><!--/.row-->

    <?php include_once(APP_ROOT_PATH . '/view/_flash-message.php'); ?>

    <div class="row">
        <div class="col-sm-12 col-sm-offset-0 col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading">Add A New Pod</div>
                <div class="panel-body">
                    <form role="form" method="post" action="/pods/add">
                        <div class="text-center">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="create-suppression-list-table">
                                    <tbody>
                                    <tr>
                                        <th>Name:</th>
                                        <td><input type="text" class="form-control" name="name" value="<?php echo $formData ? $formData['name'] : ''; ?>" data-validation="not-empty" /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" align="center">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-spin fa-spinner hidden"></i>
                                                Add
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

    <?php /** Users */ ?>
    <div class="row" id="users-row">
        <div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Pods</div>
                <div class="panel-body">
                    <div class="text-center">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="suppression-lists-table">
                                <thead>
                                    <tr>
                                        <th class="text-center">Name</th>
                                        <th class="text-center" width="140">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($pods as $pod): ?>
                                    <tr>
                                        <td class="name text-left"><?php echo $pod['name']; ?></td>
                                        <td class="actions text-center" width="140">
                                            <a href="/pods/edit/<?php echo $pod['id']; ?>" class="fa fa-pencil"></a>
                                            <a href="/pods/delete/<?php echo $pod['id']; ?>" class="sweet-confirm-href delete fa fa-times"></a>
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
