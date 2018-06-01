<div class="<?php include_once(APP_ROOT_PATH . '/view/_right-side-class.php'); ?>">
    <div class="row">
        <ol class="breadcrumb">
            <?php include_once(APP_ROOT_PATH . '/view/_toggle-sidebar.php'); ?>
            <li><a href="/"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li class="active">Settings</li>
        </ol>
    </div><!--/.row-->

    <?php include_once(APP_ROOT_PATH . '/view/_flash-message.php'); ?>

    <?php /** Settings */ ?>
    <div class="row">
        <div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">PR Tools</div>
                <div class="panel-body">

                    <div class="text-center m-b-10">
                        <a href="/pr-tools/send-survey-invitations" class="btn btn-primary">Send Survey Invitations</a>
                    </div>

                    <div class="text-center m-b-10">
                        <a href="/pr-tools/process-job-queue" class="btn btn-primary">Process Job Queue</a>
                    </div>
                </div>
            </div>
        </div><!-- /.col-->
    </div><!-- /.row -->

</div><!--/.main-->