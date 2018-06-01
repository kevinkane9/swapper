<div class="<?php include_once(APP_ROOT_PATH . '/view/_right-side-class.php'); ?>">
    <div class="row">
        <ol class="breadcrumb">
            <?php include_once(APP_ROOT_PATH . '/view/_toggle-sidebar.php'); ?>
            <li><a href="/"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li>Manage Filters</li>
            <li class="active">Departments</li>
        </ol>
    </div><!--/.row-->

    <div class="row page-filter-departments">
        <div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form role="form" method="post" action="/filter-departments/save">
                        <div class="text-center">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="departments-table">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Department</th>
                                        <th class="text-center">Keyword</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td id="cell-department">
                                            <ul data-entity="department">
                                            <?php foreach ($departments as $department): ?>
                                                <li data-id="<?php echo $department['id']; ?>">
                                                    <input class="form-control" type="text" name="departments[<?php echo $department['id']; ?>]" value="<?php echo $department['department']; ?>" />
                                                    <a class="fa fa-times delete sweet-confirm-ajax"></a>
                                                    <i class="fa fa-spinner fa-spin hidden"></i>
                                                    <a class="fa fa-chevron-right view"></a>
                                                </li>
                                            <?php endforeach; ?>
                                            </ul>
                                            <button type="button" id="add-department" class="btn btn-default"><i class="fa fa-plus"></i> Add Department</button>
                                        </td>
                                        <td id="cell-keyword">
                                            <button type="button" id="add-keyword" class="btn btn-default"><i class="fa fa-plus"></i> Add Keyword</button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- /.col-->
    </div><!-- /.row -->

</div><!--/.main-->