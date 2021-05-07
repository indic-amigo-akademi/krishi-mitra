(($) => {})(jQuery);

$(window).on("load resize", function () {
    if ($(window).width() < 768) $(".lower-navbar").attr("hidden", "");
    else $(".lower-navbar").removeAttr("hidden");
});
