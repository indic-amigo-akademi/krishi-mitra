function searchFormSubmit(event) {
    event.preventDefault();
    console.log(event.target);
    $("#searchForm").submit();
}
(($) => {})(jQuery);

$(window).on("load resize", function () {
    if ($(window).width() < 768) $(".lower-navbar").attr("hidden", "");
    else $(".lower-navbar").removeAttr("hidden");
});
