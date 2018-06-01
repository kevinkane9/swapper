<div class="<?php include_once(APP_ROOT_PATH . '/view/_right-side-class.php'); ?>">
    <div class="row">
        <ol class="breadcrumb">
            <?php include_once(APP_ROOT_PATH . '/view/_toggle-sidebar.php'); ?>
            <li><a href="/"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li class="active">Co-Star Converter</li>
        </ol>
    </div><!--/.row-->

    <div class="row page-costar-converter">
        <div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Convert Co-Star File</div>
                <div class="panel-body">
                    <form role="form" method="post" enctype="multipart/form-data">

                        <!-- XLSX file -->
                        <div class="row">
                            <div class="col-md-3 text-right column">
                                <strong>XLSX File:</strong>
                            </div>
                            <div class="col-md-8">
                                <input type="file" name="file" class="form-control" data-validation="not-empty" />
                            </div>
                        </div>

                        <!-- Submit -->
                        <div class="row text-center">
                            <button class="btn btn-primary" type="submit">Convert File</button>
                            <i class="fa fa-spinner fa-spin hidden"></i>
                        </div>

                    </form>
                </div>
            </div>
        </div><!-- /.col-->
    </div><!-- /.row -->
</div><!--/.main-->