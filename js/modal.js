jQuery(document).ready(function($) {
    let $modal = $(".modal");
    let $btn = jQuery(".registration");
    let $close = jQuery(".modal-close");
    let $regBtn = jQuery(".registrationBtn");


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

    $regBtn.click(function(){
      let $modalHeaderRight = jQuery(".modal-header-right");
      let $modalHeaderLeft = jQuery(".modal-header-left");
      let $modalLoginBody = jQuery(".login-body");
      let $modalRegisterBody = jQuery(".register-body");
      $modalHeaderRight.replaceWith($(""));
      $modalHeaderLeft.html("Account registration");
      $modalLoginBody.css("display", "none")
      $modalRegisterBody.css("display", "block")


    });


});
