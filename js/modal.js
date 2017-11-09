jQuery(document).ready(function($) {
    let $modal = $(".modal");
    let $btn = jQuery(".registration");
    let $close = jQuery(".close");

    $btn.click(function() {
        $modal.css("display","block");
    });

    $close.click(function() {
        $modal.css("display", "none");
    });

    $(window).click(function(e) {
        if( $(e.target).is($modal)) {
            $modal.css("display", "none");
            
        }
    });
});