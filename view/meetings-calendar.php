<div class="<?php include_once(APP_ROOT_PATH . '/view/_right-side-class.php'); ?>">
    <div class="row">
        <ol class="breadcrumb">
            <?php include_once(APP_ROOT_PATH . '/view/_toggle-sidebar.php'); ?>
            <li><a href="/"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li class="active">Meeting Scoreboard</li>
        </ol>
    </div><!--/.row-->

    <?php /** Meetings Calendar */ ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <input id="month" value="<?php echo $month; ?>" type="hidden">
                <input id="year" value="<?php echo $year; ?>" type="hidden">
                <div class="panel-heading">Meetings Calendar</div>
                <div class="panel-body">
                    <div id="meetings-calendar" data-source-url="/meeting-scoreboard/meetings-calendar-data/">
                        
                    </div>
                </div>
            </div>
        </div><!-- /.col-->
    </div><!-- /.row -->

</div><!--/.main-->