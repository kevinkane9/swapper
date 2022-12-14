$(document).ready(function(){

    setTimeout(function(){ 
        $('#table-meeting-board').dataTable( {
            "scrollX": true,
            "scrollY": '500px',  
            fixedColumns: {
                leftColumns: 2
            },        
            "bPaginate": false
        });        

     }, 50);    

    //  setTimeout(function(){ 
    //     //$('table.DTFC_Cloned').remove();
    //     $('table.DTFC_Cloned').css('margin-top','0px !important');
    //     $('table.DTFC_Cloned').css('margin-bottom','0px !important');        
    //  }, 50);
     

    

    $('#meeting-year-select').on('change', function (e) {
        e.preventDefault();
        
        var year = $(this).val();

        console.log($(this).val());

        var form = $('<form method="post" action="/meeting-scoreboard"></form>')
        .append($('<input type="hidden" name="meeting_year_select" />').val(year));

        $('body').append(form);
        form.submit();
    });

    $('#status-select').on('hidden.bs.select', function () {
        var selected = $("#status-select").find("option:selected");
        var arrSelected = [];
        selected.each(function () {
            arrSelected.push($(this).val());
        });
        var form = $('<form method="post" action="/meeting-scoreboard"></form>')
            .append($('<input type="hidden" name="meeting_year_select" />').val( $('#meeting-year-select').val() ))
            .append($('<input type="hidden" name="client_status" />').val(arrSelected));

        $('body').append(form);
        form.submit();
    });

    client_status = client_status.split(",");
    $('#status-select').selectpicker('val',client_status);
    $('#status-select').selectpicker('refresh');
});