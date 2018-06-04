<?php
    use Sapper\Util;
?>
<?php $formData = Sapper\Route::getFlashPostData(); ?>

<div class="<?php include_once(APP_ROOT_PATH . '/view/_right-side-class.php'); ?>">
    <div class="row">
        <ol class="breadcrumb">
            <?php include_once(APP_ROOT_PATH . '/view/_toggle-sidebar.php'); ?>
            <li><a href="/"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li class="active">Client Directory</li>
        </ol>
    </div><!--/.row-->

    <?php include_once(APP_ROOT_PATH . '/view/_flash-message.php'); ?>

    <?php /** Create client */ ?>
    <div class="row">
        <div class="col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create Client</div>
                <div class="panel-body">
                    <form role="form" method="post" action="/clients/create">
                        <div class="text-center">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <th>Name:</th>
                                        <td>
                                            <input type="text" class="form-control" name="name" value="<?php echo $formData ? $formData['name'] : ''; ?>" data-validation="not-empty" />
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>CSM:</th>
                                        <td>
                                            <select name="user_id" class="form-control" data-validation="not-empty">
                                                <option value=""></option>
                                                <?php foreach ($users as $user): ?>
                                                    <option value="<?php echo $user['value'];?>" <?php echo $formData['user_id'] == $user['value'] ? 'selected' : ''; ?>>
                                                        <?php echo $user['text']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>ProsperWorks</th>
                                        <td>
                                            <select name="prosperworks_id" class="selectpicker form-control" data-validation="not-empty" title="None" data-live-search="true" id="company-select">
                                                <?php foreach ($companies as $company) { ?>
                                                    <option value="<?php echo $company['id']; ?>" ><?php echo $company['name']; ?></option>
                                                <?php } ?>
                                            </select>
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

    <?php /** Clients */ ?>
    <div class="row">
        <div class="col-sm-12 col-sm-offset-0 col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Clients</div>
                <div class="panel-body">
                    <div class="text-center">

                        <div class="table-responsive">
                            <table id="clients-table" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">Client Name</th>
                                        <th class="text-center">CSM</th>
                                        <th class="text-center">Pod</th>
                                        <th class="text-center hide">Status</th>
                                        <th class="text-center" width="170">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($clients as $client): ?>
                                    <tr>
                                        <td class="text-left"><?php echo $client['name']; ?></td>
                                        <td class="text-left">
                                            <a href="#" id="csm_<?php echo $client['id']; ?>"
                                               class="editable_fields csm_user"
                                               data-type="select"
                                               data-pk="<?php echo $client['id']; ?>"
                                               data-url="/clients/csm/<?php echo $client['id']; ?>"
                                               data-name="csm_user_id"
                                               data-title="Choose CSM"
                                               data-source='<?php echo json_encode($users); ?>'
                                               data-value="<?php echo $client["user_id"]; ?>"
                                            >
                                                <?php echo $client['cms']; ?>
                                            </a>
                                        </td>
                                        <td class="text-left" id="pod_<?php echo $client['id']; ?>">
                                            <?php echo $client['pod']; ?>
                                        </td>
                                        <td class="text-left hide"><?php echo ucfirst($client['client_status']);?></td>
                                        <td class="actions text-center" width="170">
                                            <a href="/clients/edit/<?php echo $client['id']; ?>" class="fa fa-pencil"></a>
                                            <a href="/clients/stats/<?php echo $client['id']; ?>" class="fa fa-bar-chart-o"></a>
                                            <a href="/clients/dne/<?php echo $client['id']; ?>" class="fa fa-exclamation dne"> <span>DNE</span></a>
                                            <a href="/clients/ajax-update-status" data-client="<?php echo $client['id']; ?>" class="fa fa-<?php echo $client['client_status'] ?>-client status-toggle"></a>
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
