$(document).ready(function() {
    $("h2 .fa").on('click', function() {
        $(this).parent().next().slideToggle();

        if ($(this).hasClass("fa-angle-up")) {
          $(this).removeClass("fa-angle-up").addClass("fa-angle-down");
        } else {
          $(this).removeClass("fa-angle-down").addClass("fa-angle-up");
        }
    });
});
