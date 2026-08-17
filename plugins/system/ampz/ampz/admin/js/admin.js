var rh_j = jQuery.noConflict();

rh_j(document).ready(function() {

    // Progress bars for the statistics
    if ( rh_j( ".skillbar" ).length ) {
        rh_j('.skillbar').each(function() {
            rh_j(this).find('.skillbar-bar').animate({
               width:jQuery(this).attr('data-percent')
	        },2000);
        });
     }

    // Enable fancy checkboxes
    rh_j(".labelauty").labelauty();
    rh_j(".labelauty_small").labelauty({ extra: true, label: false });
    rh_j(".labelauty_small_share_follow").labelauty({ label: true, icon: false, checked_label: "FOLLOW", unchecked_label: "SHARE" });
    rh_j(".labelauty_icon").labelauty({ label: false });

    // Change value after new ordering
    var sortable = rh_j('.sortable').nestable();
    rh_j('.sortable').on('change', function(e) {
        rh_j.each(sortable.nestable('serialize'), function(index, obj) {
            var network = 'btn_' + obj.id;
            rh_j('#' + network).val(network + '_' + index);
        });
    });

    // Remove some weird error in form.php that did not affect functionality
    rh_j('.span12').contents().filter(function()
    {
        return this.nodeType === 3;
    }).remove().end().filter('b').remove().end().filter('br').remove();

    // Menu functionality
    rh_j('.rh_tab-links a').on('click', function(e)
    {
        var currentAttrValue = rh_j(this).attr('href');

        // Show/Hide rh_tabs
        if (currentAttrValue.startsWith('#'))
        {
            rh_j('.rh_tab-content ' + currentAttrValue).fadeIn(1000).siblings().hide();

           // Change/remove current rh_tab to active
           rh_j('.rh_tab-links li').removeClass('active');
           rh_j(this).parent('li').addClass('active');

           e.preventDefault();
        }
    });

    // Scroll to placement settings of clicked location
    rh_j('.rh_list_locations a').on('click', function(e)
    {
        var currentAttrValue = rh_j(this).attr('href');

        rh_j('html,body').animate({scrollTop: rh_j(currentAttrValue).offset().top},'slow');

        e.preventDefault();
    });

    // User clicks a checkbox with a display location. Display or hide the settings for that location
    function toggleLocations()
    {
        var id = rh_j(this).attr('id');

        if (id.indexOf("AMPZ_LOCATION") != -1) {
            var location = '#location_'+ id.substr(id.length - 1);

            rh_j(location)[rh_j(this).is(':checked') ? 'slideDown' : 'slideUp']();
        }

    }

    // Scroll to placement settings of clicked social network
    rh_j('.sortable-list a').on('click', function(e)
    {
        var currentAttrValue = rh_j(this).attr('href');

        rh_j('html,body').animate({scrollTop: rh_j(currentAttrValue).offset().top},'slow');

        e.preventDefault();
    });

    // User clicks a checkbox with a display social network settings. Display or hide the settings for that button
    function toggleNetworks()
    {
        var id = rh_j(this).attr('id');

        if (id.indexOf("btn_") != -1) {
            var network = '#'+ id + '_settings';

            rh_j(network)[rh_j(this).is(':checked') ? 'slideDown' : 'slideUp']();
        }
    }

    // Show the changed button template
    rh_j('#jform_params_buttonTemplate').change(function(){
        rh_j('.rh_option_toggle').hide();
        rh_j('#' + rh_j(this).val()).show();
    });

    //force the button template to show the chosen template
    rh_j('#jform_params_buttonTemplate').trigger("change");

    // Force the admin to go to the last tab
    rh_j('.rh_tab-links a').trigger("click");

    rh_j('input:checkbox').each(toggleNetworks).click(toggleNetworks);
    rh_j('input:checkbox').each(toggleLocations).click(toggleLocations);

    rh_j(".btn-group-toggle").on('click',function(){

        rh_j(this).each( function() {
            let id      = rh_j(rh_j(this).find("input[type=radio]:checked")).attr('id')
            let name    = rh_j(rh_j(this).find("input[type=radio]:checked")).attr('name')
            let value   = rh_j(rh_j(this).find("input[type=radio]:checked")).attr('value')

            rh_j('[data-showon]').each(function(){
                let field = rh_j(this).data('showon')[0].field;
                if( field == name ){
                        if( value != "" && rh_j.inArray(value ,  rh_j(this).data('showon')[0].values ) >= 0 ){
                            console.log( " VISIBLE ");
                            rh_j(this).removeClass('hidden');
                    } else {
                            console.log( " HIDDEN ");
                            rh_j(this).addClass('hidden');
                    }
                }
            });

        });
    });

});
