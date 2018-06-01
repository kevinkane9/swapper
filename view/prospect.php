<div class="<?php include_once(APP_ROOT_PATH . '/view/_right-side-class.php'); ?>">
    <div class="row">
        <ol class="breadcrumb">
            <?php include_once(APP_ROOT_PATH . '/view/_toggle-sidebar.php'); ?>
            <li><a href="/"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li>Prospects</li>
            <li class="active">Edit</li>
        </ol>
    </div><!--/.row-->

    <?php include_once(APP_ROOT_PATH . '/view/_flash-message.php'); ?>

    <?php /** Edit user */ ?>
    <div class="row">
        <div class="col-sm-12 col-sm-offset-0 col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">Edit Prospect</div>
                <div class="panel-body">
                    <form role="form" method="post" action="/prospect/save/<?php echo $prospect['id']; ?>">
                        <div class="text-center">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <th>First Name:</th>
                                        <td><input type="text" class="form-control" name="first_name" value="<?php echo $prospect['first_name']; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <th>Last Name:</th>
                                        <td><input type="text" class="form-control" name="last_name" value="<?php echo $prospect['last_name']; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <th>Email:</th>
                                        <td><input type="text" class="form-control" name="email" value="<?php echo $prospect['email']; ?>" data-validation="email" /></td>
                                    </tr>
                                    <tr>
                                        <th>Title:</th>
                                        <td><input type="text" class="form-control" name="title" value="<?php echo $prospect['title']; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <th>Industry:</th>
                                        <td><input type="text" class="form-control" name="industry" value="<?php echo $prospect['industry']; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <th>Company:</th>
                                        <td><input type="text" class="form-control" name="company" value="<?php echo $prospect['company']; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <th>Company Employees:</th>
                                        <td><input type="text" class="form-control" name="company_employees" value="<?php echo $prospect['company_employees']; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <th>Company Revenue:</th>
                                        <td><input type="text" class="form-control" name="company_revenue" value="<?php echo $prospect['company_revenue']; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <th>Address:</th>
                                        <td><input type="text" class="form-control" name="address" value="<?php echo $prospect['address']; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <th>Address2:</th>
                                        <td><input type="text" class="form-control" name="address2" value="<?php echo $prospect['address2']; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <th>City:</th>
                                        <td><input type="text" class="form-control" name="city" value="<?php echo $prospect['city']; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <th>State:</th>
                                        <td>
                                            <select name="state" class="form-control">
                                                <option value=""></option>
                                                <?php foreach (Sapper\Model::get('states') as $stateCode => $state):
                                                    printf(
                                                        '<option value="%s" %s>%s</option>',
                                                        $stateCode,
                                                        $prospect['state'] == $stateCode ? 'selected' : '',
                                                        $state
                                                    );
                                                endforeach; ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Zip:</th>
                                        <td><input type="text" class="form-control" name="zip" value="<?php echo $prospect['zip']; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <th>Phone - Work:</th>
                                        <td><input type="text" class="form-control" name="phone_work" value="<?php echo $prospect['phone_work']; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <th>Phone - Personal:</th>
                                        <td><input type="text" class="form-control" name="phone_personal" value="<?php echo $prospect['phone_personal']; ?>" /></td>
                                    </tr>
                                    <tr>
                                        <th>Source:</th>
                                        <td>
                                            <select name="source_id" class="form-control">
                                                <option value=""></option>
                                                <?php foreach ($sources as $source):
                                                    printf(
                                                        '<option value="%s" %s>%s</option>',
                                                        $source['id'],
                                                        $prospect['source_id'] == $source['id'] ? 'selected' : '',
                                                        $source['name']
                                                    );
                                                endforeach; ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div>
                                                <!-- Nav tabs -->
                                                <ul class="nav nav-tabs" role="tablist">
                                                    <?php
                                                    foreach ($outreachProspects as $i => $outreachProspect) {
                                                        printf(
                                                            '<li role="presentation" %s><a href="#%s" aria-controls="home" role="tab" data-toggle="tab"><strong>%s</strong><br/>%s</a></li>',
                                                            0 == $i ? 'class="active"' : '',
                                                            'outreachProspect_' . $i,
                                                            $outreachProspect['client_name'],
                                                            $outreachProspect['outreach_account_email']
                                                        );
                                                    }
                                                    ?>
                                                </ul>

                                                <!-- Tab panes -->
                                                <div class="tab-content">
                                                    <?php foreach ($outreachProspects as $i => $outreachProspect): ?>
                                                        <div role="tabpanel" class="tab-pane <?php echo 0 == $i ? 'active' : ''; ?>" id="outreachProspect_<?php echo $i; ?>" data-outreach-account-id="<?php echo $outreachProspect['outreach_account_id']; ?>">
                                                            <div class="table-responsive">
                                                                <table class="table table-bordered">
                                                                    <tbody>
                                                                        <tr>
                                                                            <th width="210">Tags:</th>
                                                                            <td>
                                                                                <select name="outreachProspect[<?php echo $outreachProspect['outreach_account_id']; ?>][tagIds][]" class="form-control tag-ids" multiple="multiple">
                                                                                    <?php foreach ($outreachProspect['tags'] as $tag):
                                                                                        printf(
                                                                                            '<option value="%s" selected>%s</option>',
                                                                                            $tag['tag_id'],
                                                                                            $tag['name']
                                                                                        );
                                                                                    endforeach; ?>
                                                                                </select>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div><!-- /.tab-pane -->
                                                    <?php endforeach; ?>
                                                </div><!-- /.tab-content -->
                                            </div>
                                        </td>
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