;(function($){
    $(document).ready(function(){
        $('.select').select2();

        $('.client_id').change(function(){
            $.ajax({
                url: '/targeting-request/ajax-load-targeting-profile',
                method: 'post',
                dataType: 'json',
                data: {client_id: $(this).val()}, 
                success: function(response){
                    $('[name="title"]').val(response.data.listRequestTitle);                    
                    if (response.status === 'success') {
                        location.reload(true);
                    }
                }
            });
        });        

        $('.title-select').select2({
            placeholder: "None",
            allowClear: true,
            tags: true,
            minimumResultsForSearch: Infinity
        });
        $('.title-keyword-select').select2({
            placeholder: "None",
            allowClear: true,
            tags: true,
            minimumResultsForSearch: Infinity
        });

        $('.industry-select').select2({
            placeholder: "None",
            allowClear: true,
            tags: true,
            minimumResultsForSearch: Infinity
        });

        $('.naics-select').select2({
            placeholder: "None",
            allowClear: true,
            tags: true,
            minimumResultsForSearch: Infinity
        });

        $('.department-select').select2({
            placeholder: "None",
            allowClear: true,
            tags: true,
            minimumResultsForSearch: Infinity
        });

        
        $('#company_attr').change(function () {
            if ($(this).val() == 'Yes') {
                $('#company_attr_txt').show();
            } else {
                $('#company_attr_txt').hide();
            }
        });
        
        $('#company_attr').trigger('change');
    });
})(jQuery);