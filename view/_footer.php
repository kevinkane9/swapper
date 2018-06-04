
<script src="/js/jquery-1.11.1.min.js"></script>
<script src="/js/jquery-ui.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/bootstrap-datepicker.js"></script>
<script src="/js/jquery.dataTables.min.js"></script>
<script src="/js/dataTables.fixedHeader.min.js"></script>
<script src="/js/bootstrap-select.min.js"></script>
<script src="/js/toastr.min.js"></script>
<script src="/js/sweetalert.min.js"></script>
<script src="/js/select2.min.js"></script>


<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>
<script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.2.4/js/dataTables.fixedColumns.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" language="javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script type="text/javascript" language="javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
<script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" language="javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js"></script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>

<?php
if (file_exists(APP_ROOT_PATH . '/js/view/' . $view . '.js')) {
    echo '<script src="/js/view/' . $view . '.js?' . $GLOBALS['sapper-env']['ASSETS_VERSION'] . '"></script>', "\n";
}
?>
<script src="/js/helpers.js?<?php echo $GLOBALS['sapper-env']['ASSETS_VERSION']; ?>"></script>
<script src="/js/app.js?<?php echo $GLOBALS['sapper-env']['ASSETS_VERSION']; ?>"></script>
<script type="text/javascript">
    $(document).ready(function(){
            $('.editable_fields').editable({
                    emptytext: 'Click to Add',
                    validate: function(value) {
                            if($.trim(value) == '') {
                                return 'This field is required';
                            }				

                            /*
                            if(isNaN(value)) {
                                    return 'Incorrect value, only numbers allowed.';
                            }
                            */
                    },
                    success: function(value) {
                            /*
                            console.log($(this)[0]);
                            $.ajax({
                            url: 'clients/ajax-get-healthscore/',
                            data: { client_id: 1 },
                            error: function() {
                               $('#info').html('<p>An error has occurred</p>');
                            },
                            dataType: 'json',
                            success: function(data) {
                                //
                            },
                            type: 'POST'
                         });
                         */
                    }
            });

            var cTable = $('#clients-table').DataTable({
                    "bPaginate": false,
                    dom: 'B<"clientWrapper">frtip',
                    buttons: [
                            {
                                    extend:    'csvHtml5',
                                    text:      '<i class="fa fa-file-text-o"></i>',
                                    titleAttr: 'CSV',
                                    exportOptions: {
                                            columns: [ 0, 1, 2 ]
                                    }
                            },
                            {
                                    extend:    'print',
                                    text:      '<i class="fa fa-print"></i>',
                                    titleAttr: 'Print',
                                    exportOptions: {
                                            columns: [ 0, 1, 2 ]
                                    }
                            }
                    ]
            });

            let cStatusData = {
                'active': 'Active',
                'paused': 'Paused',
                'archived': 'Archived'
            }

            let cStatusSelect = $('<select multiple class="selectpicker clients-select" />');

            for(var val in cStatusData) {
                $('<option />', {value: val, text: cStatusData[val]}).appendTo(cStatusSelect);
            }

            $('<label>Status: </label>').appendTo('.clientWrapper');
            cStatusSelect.appendTo('.clientWrapper');

            $('select.clients-select').change( function() {
                var status = [];
                $('select.clients-select :selected').each(function(j, selected){
                  status[j] = $(selected).val();
                });
                var st = status.join("|");
                $("#clients-table").dataTable().fnFilter(st, 3, true, false, true, true)
            } );


            $('.data-table').DataTable();
            $('.data-table-comments').DataTable( {
                "bFilter": false,
                "bLengthChange": false
            });

    });

    $(document).ready(function() {
        var month = $('#month').val();
        var year = $('#year').val();
        var sourceUrl = $('#meetings-calendar').attr('data-source-url');
        
        $('#meetings-calendar').fullCalendar({
            timeZone: 'local',
            eventLimit: true, // for all non-agenda views
            views: {
                agenda: {
                    eventLimit: 6 // adjust to 6 only for agendaWeek/agendaDay
                }
            },            
            allDayDefault: false,
            eventRender: function (event, element, view) { 
                $(element).each(function () { 
                    $(this).attr('date-num', event.start.format('YYYY-MM-DD')); 
                });
            },
            eventAfterAllRender: function(view){
                for( cDay = view.start.clone(); cDay.isBefore(view.end) ; cDay.add(1, 'day') ){
                    var dateNum = cDay.format('YYYY-MM-DD');
                    var dayEl = $('.fc-day[data-date="' + dateNum + '"]');
                    var eventCount = $('.fc-event[date-num="' + dateNum + '"]').length;
                    if(eventCount){
                        var meetingTxt =  eventCount > 1 ? ' Meetings' : ' Meeting';
                        var html = '<span class="event-count">' + 
                                    '<a href="#">' +
                                    '<strong>' +
                                    eventCount + 
                                    '</strong>' +
                                    meetingTxt +
                                    '</a>' +
                                    '</span>';

                        dayEl.append(html);
                        dayEl.find('.event-count').not(':first').remove();
                    }
                }
            },           
            eventSources: [
                {
                    url: sourceUrl,
                    type: 'POST',
                    data: {
                        month: month,
                        year: year
                    },
                    error: function() {
                        alert('there was an error while fetching events!');
                    }
                }
            ]            
        });

        var modifiedMonth = (parseInt(month) - 1);
        jQuery('#meetings-calendar').fullCalendar('gotoDate', new Date(year, modifiedMonth));
        
        $('.show-meetings-modal').on('click', function () {
            $('#modal-month-meetings').modal('show');
        });
        
        $('#save-month-meetings').on('click', function (e) {
            e.preventDefault();
            
            $.ajax({
                url: '<?php echo APP_ROOT_URL ?>/clients/ajax-update-month-meetings/',
                data: $('#form-month-meetings').serialize(),
                error: function() {
                    //
                },
                dataType: 'json',
                success: function(data) {
                    var total_meetings_count = $('#total_meetings').val(); 
                    
                    if (isNaN(total_meetings_count)) {
                        total_meetings_count = 0;
                    }
                    
                    if (isNaN(data.total_meetings_av)) {
                        data.total_meetings_av = 0;
                    }
                    
                    total_meetings_count = (parseInt(data.total_meetings_av) + parseInt(total_meetings_count));

                    $('#total_meetings_av').val(parseInt(data.total_meetings_av));
                    $('#total_meetings_total').val(total_meetings_count);
                    
                    $('#modal-month-meetings').modal('hide');
                    console.log('Monthly meeting numbers changed, please click submit button to save it.');
					return false;
                    toastr["success"]("Monthly meeting numbers changed, please click submit button to save it.", "Success")
                },
                type: 'POST'
             });            
        });
    });   
</script>
</body>

</html>
