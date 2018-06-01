;(function($){
    $(document).ready(function(){
        setTimeout(function(){ 
            $('#requests-table').dataTable( {
                "scrollX": true,
                "scrollY": '400px', 
                columnDefs: [
                    { width: 100, targets: 0 },
                ],  
                fixedColumns: {
                    leftColumns: 2,
                    rightColumns: 1
                },                 
                "bPaginate": false
            });        
    
         }, 50);        
        
    });
})(jQuery);