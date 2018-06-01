<div class="<?php include_once(APP_ROOT_PATH . '/view/_right-side-class.php'); ?>">
    <div class="row">
        <ol class="breadcrumb">
            <?php include_once(APP_ROOT_PATH . '/view/_toggle-sidebar.php'); ?>
            <li><a href="/"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li>Manage Filters</li>
            <li class="active">Titles</li>
        </ol>
    </div><!--/.row-->

    <div class="row page-filter-titles">
        <div class="col-sm-12 col-sm-offset-0 col-md-12 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-body">
                    <form role="form" method="post" action="/filter-titles/save">
                        <div class="text-center">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="titles-table">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Group</th>
                                        <th class="text-center">Title</th>
                                        <th class="text-center">Variation</th>
                                        <th class="text-center">Negative Keywords</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td id="cell-group">
                                            <ul class="sortable" data-entity="group">
                                            <?php foreach ($groups as $group): ?>
                                                <li data-id="<?php echo $group['id']; ?>">
                                                    <i class="fa fa-arrows"></i>
                                                    <input class="form-control" type="text" name="groups[<?php echo $group['id']; ?>]" value="<?php echo $group['name']; ?>" />
                                                    <a class="fa fa-times delete sweet-confirm-ajax"></a>
                                                    <i class="fa fa-spinner fa-spin hidden"></i>
                                                    <a class="fa fa-chevron-right view"></a>
                                                </li>
                                            <?php endforeach; ?>
                                            </ul>
                                            <button type="button" id="add-group" class="btn btn-default"><i class="fa fa-plus"></i> Add Group</button>
                                        </td>
                                        <td id="cell-title">
                                            <button type="button" id="add-title" class="btn btn-default"><i class="fa fa-plus"></i> Add Title</button>
                                        </td>
                                        <td id="cell-variation">
                                            <button type="button" id="add-variation" class="btn btn-default"><i class="fa fa-plus"></i> Add Variation</button>
                                        </td>
                                        <td id="cell-negative">
                                            <button type="button" id="add-negative" class="btn btn-default"><i class="fa fa-plus"></i> Add Keyword</button>
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