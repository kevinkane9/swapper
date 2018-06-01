;(function($){
    $(document).ready(function(){

        var parseValues = function (response) {
            return {
                results: $.map(response.data, function(item) {
                    var parser = new DOMParser;
                    var dom = parser.parseFromString(
                        '<!doctype html><body>' + item.text,
                        'text/html');
                    var string = dom.body.textContent;
                    return {
                        text: string,
                        id: item.id
                    }
                })
            };
        };

        $('select.tag-ids').each(function(){
            var that = $(this);

            that.select2({
                minimumInputLength: 1,
                ajax: {
                    url: '/prospect/find-tag',
                    method: 'post',
                    dataType: 'json',
                    delay: 250,
                    data: function (term) {
                        return {
                            term: term.term,
                            outreachAccountId: that.parents('.tab-pane').attr('data-outreach-account-id')
                        };
                    },
                    processResults: function (response, term) {
                        if (0 == response.data.length) {
                            return {results: [{
                                text: term.term + ' (unused)',
                                id: '!' + term.term
                            }]};
                        } else {
                            return parseValues(response);
                        }
                    }
                },
                templateSelection: function(item) {
                    return item.text.replace(' (unused)', '');
                }
            });
        });
    });
})(jQuery);