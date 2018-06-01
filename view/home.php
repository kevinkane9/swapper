<div class="<?php include_once(APP_ROOT_PATH . '/view/_right-side-class.php'); ?>">
    <div class="row">
        <ol class="breadcrumb">
            <?php include_once(APP_ROOT_PATH . '/view/_toggle-sidebar.php'); ?>
            <li class="active"><a href="/"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
        </ol>
    </div><!--/.row-->

    <div class="row dashboard-stats" style="margin-top: 80px;">
        <div class="col-xs-12 col-md-6 col-lg-4">
            <div class="panel panel-blue panel-widget ">
                <div class="row no-padding">
                    <div class="col-sm-3 col-lg-5 widget-left">
                        <i class="fa fa-sitemap"></i>
                    </div>
                    <div class="col-sm-9 col-lg-7 widget-right">
                        <div class="large"><?php echo number_format($stats['clients'], 0); ?></div>
                        <div class="text-muted">Clients</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-4">
            <div class="panel panel-orange panel-widget">
                <div class="row no-padding">
                    <div class="col-sm-3 col-lg-5 widget-left">
                        <i class="fa fa-refresh"></i>
                    </div>
                    <div class="col-sm-9 col-lg-7 widget-right">
                        <div class="large"><?php echo number_format($stats['accounts_syncing'], 0); ?></div>
                        <div class="text-muted">Accounts Syncing</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-4">
            <div class="panel panel-teal panel-widget">
                <div class="row no-padding">
                    <div class="col-sm-3 col-lg-5 widget-left">
                        <i class="fa fa-address-card-o"></i>
                    </div>
                    <div class="col-sm-9 col-lg-7 widget-right">
                        <div class="large"><?php echo number_format($stats['prospects'], 0); ?></div>
                        <div class="text-muted">Prospects</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6 col-lg-4">
            <div class="panel panel-red panel-widget">
                <div class="row no-padding">
                    <div class="col-sm-3 col-lg-5 widget-left">
                        <i class="fa fa-exchange"></i>
                    </div>
                    <div class="col-sm-9 col-lg-7 widget-right">
                        <div class="large"><?php echo number_format($stats['prospect_events'], 1); ?>mm</div>
                        <div class="text-muted">Prospect Events</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div><!--/.main-->