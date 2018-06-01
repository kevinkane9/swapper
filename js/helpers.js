// ver: 2017-05-22

;(function($){
    $(document).ready(function(){

        // validation
        $.fn.validate = function(){

            var that    = $(this),
                isCollectionValid = true,
                elms    = that.find('[data-validation]');

            elms.each(function(){
                var elm        = $(this),
                    isElmValid = true,
                    rules      = elm.attr('data-validation').split(',');

                for (i in rules) {
                    var rule = rules[i];

                    switch (rule) {
                        case 'not-empty':
                            if ('' == elm.val()) {
                                isElmValid = false;
                                isCollectionValid = false;
                            }
                            break;

                        case 'not-value':
                            if (elm.attr('data-value') == elm.val()) {
                                isElmValid = false;
                                isCollectionValid = false;
                            }
                            break;

                        case 'email':
                            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                            if (false == re.test(elm.val())) {
                                isElmValid = false;
                                isCollectionValid = false;
                            }
                            break;

                        case 'match-element':
                            var matchSelector = elm.attr('data-match-element');

                            if (elm.val() !== that.find(matchSelector).val()) {
                                isElmValid = false;
                                isCollectionValid = false;
                            }
                            break;

                        case 'atleast-1-checked':
                            if (0 == elm.find('input:checked').length) {
                                isElmValid = false;
                                isCollectionValid = false;
                            }
                            break;
                    }

                    if (false == isElmValid) {
                        if ('atleast-1-checked' == rule) {
                            elm.find('.data-validation-error-elm').addClass('error');
                        } else if (elm.hasClass('select2-hidden-accessible')) {
                            elm.addClass('error').siblings('.select2-container').find('.select2-selection').addClass('error');
                        } else {
                            elm.addClass('error');
                        }
                    }
                }
            });

            return isCollectionValid;
        }

        $('body').on('change', '.error[data-validation]', function(){
            var elm = $(this);
            if (elm.hasClass('select2-hidden-accessible')) {
                elm.siblings('.select2-container').find('.select2-selection').removeClass('error');
            } else {
                elm.removeClass('error');
            }
        });

        $('body').on('change', '[type="checkbox"]', function(){
            var that      = $(this);

            that.parents('[data-validation]')
                .find('[name="' + that.attr('name') + '"]')
                .parents('label')
                .removeClass('error')
            ;
        });

        // loader
        $.fn.loader = function(state) {
            var that        = $(this),
                childIcon   = that.find('i.fa'),
                siblingIcon = that.siblings('i.fa-spin'),
                isIcon      = that.hasClass('fa');

            if (1 == childIcon.length) {
                if (childIcon.hasClass('fa-spin') && undefined == childIcon.attr('data-prev-class')) {
                    switch (state) {
                        case 'on':
                            that.attr('disabled', true);
                            childIcon.removeClass('hidden');
                            break;

                        case 'off':
                            that.removeAttr('disabled');
                            childIcon.addClass('hidden');
                            break;
                    }
                } else {
                    switch (state) {
                        case 'on':
                            childIcon.attr('data-prev-class', childIcon.attr('class'));
                            childIcon.attr('class', 'fa fa-spin fa-spinner');
                            break;

                        case 'off':
                            childIcon.attr('class', childIcon.attr('data-prev-class'));
                            childIcon.removeAttr('data-prev-class');
                            break;
                    }
                }
            } else if (1 == siblingIcon.length) {
                switch (state) {
                    case 'on':
                        that.attr('disabled', true);
                        siblingIcon.removeClass('hidden');
                        break;

                    case 'off':
                        that.removeAttr('disabled');
                        siblingIcon.addClass('hidden');
                        break;
                }
            } else if (true == isIcon) {
                switch (state) {
                    case 'on':
                        that.attr('data-prev-class', that.attr('class'));
                        that.attr('class', 'fa fa-spin fa-spinner');
                        break;

                    case 'off':
                        that.attr('class', that.attr('data-prev-class'));
                        that.removeAttr('data-prev-class');
                        break;
                }
            }
        }
    });
})(jQuery);