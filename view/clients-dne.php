<div class="<?php include_once(APP_ROOT_PATH . '/view/_right-side-class.php'); ?>">
    <div class="row">
        <ol class="breadcrumb">
            <?php include_once(APP_ROOT_PATH . '/view/_toggle-sidebar.php'); ?>
            <li><a href="/"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li>Client Directory</li>
            <li><?php echo $client['name']; ?></li>
            <li class="active">DNE</li>
        </ol>
    </div><!--/.row-->

    <?php include_once(APP_ROOT_PATH . '/view/_flash-message.php'); ?>

    <?php /** Client DNE domains */ ?>
    <div class="row">
        <div class="col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <div class="back-to-clients">
                        <a href="/clients">
                            <i class="fa fa-arrow-circle-left"></i>
                            Back
                        </a>
                    </div>
                    <?php echo $client['name']; ?>
                </div>
                <div class="panel-body">
                    <div class="text-right">

                        <div class="add-on">
                            <a href="/clients/dne-export/<?php echo $client['id']; ?>" class="btn btn-primary">Export</a>
                        </div>
                        <hr />
                        <div class="add-on">
                            <form method="post" action="/clients/dne-add">
                                <input type="hidden" name="client_id" value="<?php echo $client['id']; ?>" />
                                <span><strong>Add Domain: </strong></span>
                                <input type="text" class="form-control" name="domain" value="@" data-validation="not-empty,not-value" data-value="@" />
                                <button type="submit" class="btn btn-primary btn-add">
                                    <i class="fa fa-spinner fa-spin hidden"></i>
                                    Add
                                </button>
                            </form>
                        </div>
                        <hr />
                        <div class="add-on">
                            <form method="post" action="/clients/dne-upload" enctype="multipart/form-data">
                                <input type="hidden" name="client_id" value="<?php echo $client['id']; ?>" />
                                <span>
                                    <select name="type">
                                        <option value="add" selected>Add</option>
                                        <option value="replace">Replace</option>
                                    </select>
                                    <strong>Domains: </strong>
                                </span>
                                <input type="file" class="form-control" name="file" data-validation="not-empty" />
                                <button type="submit" class="btn btn-primary btn-upload">
                                    <i class="fa fa-spinner fa-spin hidden"></i>
                                    Upload
                                </button>
                            </form>
                        </div>
                        <hr />
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dne-table">
                                <thead>
                                    <tr>
                                        <th class="text-center">Domain</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="text-left"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.col-->
    </div><!-- /.row -->
</div><!--/.main-->

<script>
    clientId = <?php echo $client['id']; ?>;
</script>