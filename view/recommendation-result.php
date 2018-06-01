<div class="<?php include_once(APP_ROOT_PATH . '/view/_right-side-class.php'); ?>">
    <div class="row">
        <ol class="breadcrumb">
            <?php include_once(APP_ROOT_PATH . '/view/_toggle-sidebar.php'); ?>
            <li><a href="/"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li><a href="/recommendation"></a>Client Profile Recommendation</li>
            <li class="active">Results</li>
        </ol>
    </div><!--/.row-->

    <?php include_once(APP_ROOT_PATH . '/view/_flash-message.php'); ?>

    <div>
        <div class="panel panel-default">
            <div class="panel-heading text-center">
                Recommendation Results

                <div class="panel-actions">
                    <a class="btn print-page hidden-xs"><i class="fa fa-print"></i></a>
                </div>
            </div>
            <div class="panel-body">

                <img src="/images/client-profile-recommendation/watermark.png" class="visible-print watermark">

                <div id="generation-stats" class="hidden-print">
                    <i class="fa fa-info-circle" data-toggle="dropdown"></i>
                    <div class="dropdown-menu">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>Similar Companies</th>
                                <td><?php echo number_format($generationStats['similarCompanies'], 0); ?></td>
                            </tr>
                            <tr>
                                <th>Converted Prospects</th>
                                <td><?php echo number_format($generationStats['convertedProspects'], 0); ?></td>
                            </tr>
                            <tr>
                                <th>Confidence</th>
                                <td><?php echo $generationStats['confidence']; ?>%</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row p-15">
                    <div class="col-lg-4">
                        <img src="/images/client-profile-recommendation/<?php echo rand(1,5); ?>.jpg" class="pic img-responsive">

                        <div class="stats m-t-25">

                            <div class="row">
                                <div class="col-xs-7 text-right">Average Response Time</div>
                                <div class="col-xs-5">
                                    <?php echo $avgResponseTime, ' ', $avgResponseTime <= 1 ? 'day' : 'days'; ?>
                                </div>
                            </div>

                            <!--div class="row">
                                <div class="col-xs-7 text-right">Average Cycle Time</div>
                                <div class="col-xs-5">
                                    <?php echo $avgCycleTime, ' ', $avgCycleTime <= 1 ? 'day' : 'days'; ?>
                                </div>
                            </div-->

                            <div class="row">
                                <div class="col-xs-7 text-right">Average Monthly Meetings</div>
                                <div class="col-xs-5"><?php echo $avgMonthlyMeetings; ?></div>
                            </div>

                            <div class="row">
                                <div class="col-xs-7 text-right">Ideal Company Size</div>
                                <div class="col-xs-5"><?php echo $idealCompanySize; ?></div>
                            </div>

                            <div class="row">
                                <div class="col-xs-7 text-right">Ideal Company Revenue</div>
                                <div class="col-xs-5"><?php echo $idealCompanyRevenue; ?></div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-8">

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="title-bar">Top Titles</div>

                                <div class="distribution m-b-25">

                                    <?php foreach ($topTitles as $title => $percentData): ?>
                                    <div class="row m-y-10">
                                        <div class="col-xs-7 text-right"><?php echo $title; ?></div>
                                        <div class="col-xs-5">
                                            <div class="sap-progress-bar">
                                                <div class="percent-complete" title="<?php echo $percentData['display_percent']; ?>%"
                                                     style="width: <?php echo $percentData['fill_percent']; ?>%">
                                                    <span class="<?php echo $percentData['fill_percent'] < 25 ? 'hidden' : ''; ?>">
                                                        <?php echo $percentData['display_percent'].'%'; ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.row -->
                                    <?php endforeach; ?>
                                </div><!-- /.title-distributions -->
                            </div>
                            <div class="col-lg-6">
                                <div class="title-bar">Top Email Template</div>

                                <div class="subject-line">
                                    <?php if (array_key_exists('subject', $topEmailTemplate)): ?>
                                        <?php echo $topEmailTemplate['subject']; ?>
                                    <?php endif; ?>
                                </div>
                                <div class="m-t-15" id="subject1">
                                    <div class="well">
                                        <?php echo nl2br(substr($topEmailTemplate['body_text'], 0, 150)); ?>
                                        <span class="read-more" data-toggle="modal" data-target="#email-template">... read more</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="title-bar">Top Industries</div>

                                <div class="distribution industries">

                                    <?php foreach ($topIndustries as $industry => $percentData): ?>
                                        <div class="row m-y-10">
                                            <div class="col-xs-7 text-right"><?php echo $industry; ?></div>
                                            <div class="col-xs-5">
                                                <div class="sap-progress-bar">
                                                    <div class="percent-complete" title="<?php echo $percentData['display_percent']; ?>%"
                                                         style="width: <?php echo $percentData['fill_percent']; ?>%">
                                                        <span class="<?php echo $percentData['fill_percent'] < 25 ? 'hidden' : ''; ?>">
                                                            <?php echo $percentData['display_percent'].'%'; ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- /.row -->
                                    <?php endforeach; ?>

                                </div><!-- /.industry-distributions -->
                            </div>
                            <div class="col-lg-6">
                                <div class="title-bar m-b-0">Top Locations</div>

                                <div id="map">

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center text-muted">
                        Results are based on data from 2018
                    </div>
                    <div class="visible-print">
                        <hr>

                        <div class="text-center m-b-10">
                            Recommendation prepared by <strong><?php echo Sapper\Auth::token('firstName'), ' ', Sapper\Auth::token('lastName'); ?></strong>
                        </div>

                        <p class="visible-print">
                            This document is proprietary and confidential. No part of this document may be copied,
                            distributed or reproduced in any manner, nor passed to any third party without prior written
                            consent of Sapper Consulting.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div><!--/.main-->

<div class="modal fade" tabindex="-1" role="dialog" id="email-template">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $topEmailTemplate['subject']; ?></h4>
            </div>
            <div class="modal-body">
                <?php echo $topEmailTemplate['body_html']; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    var mapData = JSON.parse('<?php echo json_encode($locations); ?>');
</script>

<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/maps/modules/data.js"></script>
<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
<script src="https://code.highcharts.com/maps/modules/offline-exporting.js"></script>
<script src="https://code.highcharts.com/mapdata/countries/us/us-all.js"></script>