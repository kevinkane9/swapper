<?php $formData = Sapper\Route::getFlashPostData(); ?>

<div class="<?php include_once(APP_ROOT_PATH . '/view/_right-side-class.php'); ?>">
    <div class="row">
        <ol class="breadcrumb">
            <?php include_once(APP_ROOT_PATH . '/view/_toggle-sidebar.php'); ?>
            <li><a href="/"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li class="active">Background Jobs</li>
        </ol>
    </div><!--/.row-->

    <?php include_once(APP_ROOT_PATH . '/view/_flash-message.php'); ?>

    <div class="row" id="users-row">
        <div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Background Jobs</div>
                <div class="panel-body">
                    <div class="text-center">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="suppression-lists-table">
                                <thead>
                                <tr>
                                    <th class="text-center">Pid</th>
                                    <th class="text-center">Creation Date</th>
                                    <th class="text-center">Type</th>
                                    <th class="text-center">Title</th>
                                    <th class="text-center">Filename</th>
                                    <th class="text-center">Client</th>
                                    <th class="text-center" width="100">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($jobs as $job): ?>
                                    <tr>
                                        <td class="name text-left"><?php echo $job['pid']; ?></td>
                                        <td class="text-left"><?php echo (!empty($job['created_at'])) ? date('F j, Y H:i:s', strtotime($job['created_at'])) : ''; ?></td>
                                        <td class="text-left"><?php echo $job['type']; ?></td>
                                        <td class="text-left"><?php echo $job['title']; ?></td>
                                        <td class="text-left"><?php echo $job['filename']; ?></td>
                                        <td class="text-left"><?php echo $job['client']; ?></td>
                                        <td class="actions text-center" width="100">
                                            <a href="/background-jobs/kill/<?php echo $job['id']; ?>" class="sweet-confirm-href delete fa fa-times"></a>
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
