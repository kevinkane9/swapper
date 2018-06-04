<div class="<?php include_once(APP_ROOT_PATH . '/view/_right-side-class.php'); ?>">
    <div class="row">
        <ol class="breadcrumb">
            <?php include_once(APP_ROOT_PATH . '/view/_toggle-sidebar.php'); ?>
            <li><a href="/"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
            <li class="active">Meeting Scoreboard</li>
        </ol>
    </div><!--/.row-->

    <?php /** Gmail Inboxes */ ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">Meeting Scoreboard</div>
                <div class="panel-body">
                    <div class="text-center">
                        <div class="table-responsive">
                            <div class="row controls">
                                <div class="col-sm-2">
                                    <label>Meetings Year: </label>
                                </div>
                                <div class="col-sm-3">
                                    <select class="form-control" id="meeting-year-select" name="meeting_year">
                                        <?php foreach ($meeting_years as $meeting_year) { ?>
                                            <option value="<?php echo $meeting_year; ?>" <?php echo $meeting_year_select == $meeting_year? 'selected' : '' ?>><?php echo $meeting_year; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="col-sm-2 col-sm-offset-2"><label>Status</label></div>
                                <div class="col-sm-3">
                                    <select class="selectpicker" id="status-select" name="client_status" multiple>
                                    <?php foreach ($status as $st): ?>
                                        <?php echo "<option value='".$st."' ".(($st == $client_status)?" selected":"").">". ucfirst($st) ."</option>"; ?>
                                    <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <table id="table-meeting-board" class="table table-bordered gmail-inbox-counts">
                                <thead>
                                    <tr>
                                      <td class="tg-yw4l" style="text-align:center">Client Name</td>
                                      <td class="tg-yw4l" style="text-align:center">Inbox</td>
                                      <td class="tg-yw4l">Total Meetings</td>
                                      <td class="tg-yw4l">January<br>
                                      <a href="/meeting-scoreboard/meetings-calendar-sapper?month=1&year=<?php echo $meeting_year_select; ?>" target="blank">Sapper</a><br><a href="/meeting-scoreboard/meetings-calendar?month=1&year=<?php echo $meeting_year_select; ?>" target="blank">Client</a>
                                      </td>
                                      <td class="tg-yw4l">February<br>
                                      <a href="/meeting-scoreboard/meetings-calendar-sapper?month=2&year=<?php echo $meeting_year_select; ?>" target="blank">Sapper</a><br><a href="/meeting-scoreboard/meetings-calendar?month=2&year=<?php echo $meeting_year_select; ?>" target="blank">Client</a>
                                      </td>
                                      <td class="tg-yw4l">March<br>
                                      <a href="/meeting-scoreboard/meetings-calendar-sapper?month=3&year=<?php echo $meeting_year_select; ?>" target="blank">Sapper</a><br><a href="/meeting-scoreboard/meetings-calendar?month=3&year=<?php echo $meeting_year_select; ?>" target="blank">Client</a>
                                      </td>
                                      <td class="tg-yw4l">April<br>
                                      <a href="/meeting-scoreboard/meetings-calendar-sapper?month=4&year=<?php echo $meeting_year_select; ?>" target="blank">Sapper</a><br><a href="/meeting-scoreboard/meetings-calendar?month=4&year=<?php echo $meeting_year_select; ?>" target="blank">Client</a>
                                      </td>
                                      <td class="tg-yw4l">May<br>
                                      <a href="/meeting-scoreboard/meetings-calendar-sapper?month=5&year=<?php echo $meeting_year_select; ?>" target="blank">Sapper</a><br><a href="/meeting-scoreboard/meetings-calendar?month=5&year=<?php echo $meeting_year_select; ?>" target="blank">Client</a>
                                      </td>
                                      <td class="tg-yw4l">June<br>
                                      <a href="/meeting-scoreboard/meetings-calendar-sapper?month=6&year=<?php echo $meeting_year_select; ?>" target="blank">Sapper</a><br><a href="/meeting-scoreboard/meetings-calendar?month=6&year=<?php echo $meeting_year_select; ?>" target="blank">Client</a>
                                      </td>
                                      <td class="tg-yw4l">July<br>
                                      <a href="/meeting-scoreboard/meetings-calendar-sapper?month=7&year=<?php echo $meeting_year_select; ?>" target="blank">Sapper</a><br><a href="/meeting-scoreboard/meetings-calendar?month=7&year=<?php echo $meeting_year_select; ?>" target="blank">Client</a>
                                      </td>
                                      <td class="tg-yw4l">August<br>
                                      <a href="/meeting-scoreboard/meetings-calendar-sapper?month=8&year=<?php echo $meeting_year_select; ?>" target="blank">Sapper</a><br><a href="/meeting-scoreboard/meetings-calendar?month=8&year=<?php echo $meeting_year_select; ?>" target="blank">Client</a>
                                      </td>
                                      <td class="tg-yw4l">September<br>
                                      <a href="/meeting-scoreboard/meetings-calendar-sapper?month=9&year=<?php echo $meeting_year_select; ?>" target="blank">Sapper</a><br><a href="/meeting-scoreboard/meetings-calendar?month=9&year=<?php echo $meeting_year_select; ?>" target="blank">Client</a>
                                      </td>
                                      <td class="tg-yw4l">October<br>
                                      <a href="/meeting-scoreboard/meetings-calendar-sapper?month=10&year=<?php echo $meeting_year_select; ?>" target="blank">Sapper</a><br><a href="/meeting-scoreboard/meetings-calendar?month=10&year=<?php echo $meeting_year_select; ?>" target="blank">Client</a>
                                      </td>
                                      <td class="tg-yw4l">November<br>
                                      <a href="/meeting-scoreboard/meetings-calendar-sapper?month=11&year=<?php echo $meeting_year_select; ?>" target="blank">Sapper</a><br><a href="/meeting-scoreboard/meetings-calendar?month=11&year=<?php echo $meeting_year_select; ?>" target="blank">Client</a>
                                      </td>
                                      <td class="tg-yw4l">December<br>
                                      <a href="/meeting-scoreboard/meetings-calendar-sapper?month=12&year=<?php echo $meeting_year_select; ?>" target="blank">Sapper</a><br><a href="/meeting-scoreboard/meetings-calendar?month=12&year=<?php echo $meeting_year_select; ?>" target="blank">Client</a>
                                      </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($synced_accounts as $client_id=>$synced_account): ?>
                                        <?php
                                            $synced_account_inbox = '';
                                            $i=0;
                                            foreach ($synced_account as $account_id=>$synced_acc) {
                                                $synced_account_client = $synced_acc['client'];

                                                unset($synced_account[$account_id]['client']);
                                                unset($synced_account[$account_id]['client_id']);
                                                unset($synced_account[$account_id]['account_id']);
                                                unset($synced_account[$account_id]['gmail_status']);

                                                if ($i > 0) {
                                                    $synced_account_inbox .= '<br>';
                                                }
                                                $synced_account_inbox .= $synced_acc['inbox'];
                                                $i++;
                                            }
                                        ?>
                                        <tr>
                                            <td><?php echo $synced_account_client; ?></td>
                                            <td><?php echo $synced_account_inbox; ?></td>
                                            <td>
                                                <?php
                                                    $mc = 0;
                                                    unset($accounts[$client_id]['client'],$accounts[$client_id]['client_id'],$accounts[$client_id]['inbox'],$accounts[$client_id]['meetings_av'],$accounts[$client_id]['meeting_year']);
                                                    unset($meeting_per_months[$client_id]['client_id'], $meeting_per_months[$client_id]['year']);

                                                    if (!empty($accounts[$client_id])) {
                                                        $mc += !empty(array_sum($accounts[$client_id])) ? array_sum($accounts[$client_id]) : 0;
                                                    } else {
                                                        $mc += 0;
                                                    }

                                                    if (!empty($meeting_per_months[$client_id])) {
                                                        $mc += !empty(array_sum($meeting_per_months[$client_id])) ? array_sum($meeting_per_months[$client_id]) : 0;
                                                    } else {
                                                        $mc += 0;
                                                    }

                                                    echo !empty($mc) ? $mc : '-' ;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $mc = 0;
                                                    $mc += !empty($accounts[$client_id]['meeting_count_jan']) ? $accounts[$client_id]['meeting_count_jan'] : 0;
                                                    $mc += !empty($meeting_per_months[$client_id]['meetings_jan']) ? $meeting_per_months[$client_id]['meetings_jan'] : 0;

                                                    echo !empty($mc) ? $mc : '-' ;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $mc = 0;
                                                    $mc += !empty($accounts[$client_id]['meeting_count_feb']) ? $accounts[$client_id]['meeting_count_feb'] : 0;
                                                    $mc += !empty($meeting_per_months[$client_id]['meetings_feb']) ? $meeting_per_months[$client_id]['meetings_feb'] : 0;

                                                    echo !empty($mc) ? $mc : '-' ;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $mc = 0;
                                                    $mc += !empty($accounts[$client_id]['meeting_count_mar']) ? $accounts[$client_id]['meeting_count_mar'] : 0;
                                                    $mc += !empty($meeting_per_months[$client_id]['meetings_mar']) ? $meeting_per_months[$client_id]['meetings_mar'] : 0;

                                                    echo !empty($mc) ? $mc : '-' ;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $mc = 0;
                                                    $mc += !empty($accounts[$client_id]['meeting_count_apr']) ? $accounts[$client_id]['meeting_count_apr'] : 0;
                                                    $mc += !empty($meeting_per_months[$client_id]['meetings_apr']) ? $meeting_per_months[$client_id]['meetings_apr'] : 0;

                                                    echo !empty($mc) ? $mc : '-' ;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $mc = 0;
                                                    $mc += !empty($accounts[$client_id]['meeting_count_may']) ? $accounts[$client_id]['meeting_count_may'] : 0;
                                                    $mc += !empty($meeting_per_months[$client_id]['meetings_may']) ? $meeting_per_months[$client_id]['meetings_may'] : 0;

                                                    echo !empty($mc) ? $mc : '-' ;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $mc = 0;
                                                    $mc += !empty($accounts[$client_id]['meeting_count_jun']) ? $accounts[$client_id]['meeting_count_jun'] : 0;
                                                    $mc += !empty($meeting_per_months[$client_id]['meetings_jun']) ? $meeting_per_months[$client_id]['meetings_jun'] : 0;

                                                    echo !empty($mc) ? $mc : '-' ;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $mc = 0;
                                                    $mc += !empty($accounts[$client_id]['meeting_count_jul']) ? $accounts[$client_id]['meeting_count_jul'] : 0;
                                                    $mc += !empty($meeting_per_months[$client_id]['meetings_jul']) ? $meeting_per_months[$client_id]['meetings_jul'] : 0;

                                                    echo !empty($mc) ? $mc : '-' ;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $mc = 0;
                                                    $mc += !empty($accounts[$client_id]['meeting_count_aug']) ? $accounts[$client_id]['meeting_count_aug'] : 0;
                                                    $mc += !empty($meeting_per_months[$client_id]['meetings_aug']) ? $meeting_per_months[$client_id]['meetings_aug'] : 0;

                                                    echo !empty($mc) ? $mc : '-' ;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $mc = 0;
                                                    $mc += !empty($accounts[$client_id]['meeting_count_sep']) ? $accounts[$client_id]['meeting_count_sep'] : 0;
                                                    $mc += !empty($meeting_per_months[$client_id]['meetings_sep']) ? $meeting_per_months[$client_id]['meetings_sep'] : 0;

                                                    echo !empty($mc) ? $mc : '-' ;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $mc = 0;
                                                    $mc += !empty($accounts[$client_id]['meeting_count_oct']) ? $accounts[$client_id]['meeting_count_oct'] : 0;
                                                    $mc += !empty($meeting_per_months[$client_id]['meetings_oct']) ? $meeting_per_months[$client_id]['meetings_oct'] : 0;

                                                    echo !empty($mc) ? $mc : '-' ;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $mc = 0;
                                                    $mc += !empty($accounts[$client_id]['meeting_count_nov']) ? $accounts[$client_id]['meeting_count_nov'] : 0;
                                                    $mc += !empty($meeting_per_months[$client_id]['meetings_nov']) ? $meeting_per_months[$client_id]['meetings_nov'] : 0;

                                                    echo !empty($mc) ? $mc : '-' ;
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $mc = 0;
                                                    $mc += !empty($accounts[$client_id]['meeting_count_dec']) ? $accounts[$client_id]['meeting_count_dec'] : 0;
                                                    $mc += !empty($meeting_per_months[$client_id]['meetings_dec']) ? $meeting_per_months[$client_id]['meetings_dec'] : 0;

                                                    echo !empty($mc) ? $mc : '-' ;
                                                ?>
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

<script type="text/javascript">var client_status = '<?php echo $client_status;?>'</script>