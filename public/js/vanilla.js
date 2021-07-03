// On Off Button
$(".on-off-btn").on("click", function (event) {
    event.preventDefault();
    if ($(event.target).data("on")) $($(event.target).data("on")).show();
    if ($(event.target).data("off")) $($(event.target).data("off")).hide();
});


// Modal Register Form
$("#modal-register-form .submit-btn").on("click", async function (event) {
    event.preventDefault();
    try {
        $(event.target).html(
            `<i class="ri-loader-4-line ri-spin"></i> Processing...`
        );
        const formData = new FormData($("#modal-register-form").get(0));
        const response = await fetch(states.routes["user.register.validate"], {
            method: "POST",
            body: formData,
        });
        const jsonData = await response.json();

        $("#modal-register-form .uk-text-danger strong").text("");

        $(event.target).text("Register");

        if (jsonData.success) {
            $("#modal-register-form").submit();
        } else {
            Object.keys(jsonData.errors).forEach((ele) => {
                $(
                    `#modal-register-form .uk-text-danger strong.error-${ele}`
                ).text(jsonData.errors[ele]);
            });

            if (
                Object.keys(jsonData.errors).includes("name") ||
                Object.keys(jsonData.errors).includes("username") ||
                Object.keys(jsonData.errors).includes("phone")
            ) {
                $("#modal-register-form .first-block").show();
                $("#modal-register-form .second-block").hide();
            }
        }
    } catch (err) {
        console.log("Cannot Connect to Server");
        $(event.target).text("Register");
    }
});

// Modal Login Form
$("#modal-login-form .submit-btn").on("click", async function (event) {
    event.preventDefault();
    try {
        $(event.target).html(
            `<i class="ri-loader-4-line ri-spin"></i> Processing...`
        );
        const formData = new FormData($("#modal-login-form").get(0));
        const response = await fetch(states.routes["user.login.validate"], {
            method: "POST",
            body: formData,
        });
        const jsonData = await response.json();

        $("#modal-login-form .uk-text-danger strong").text("");

        $(event.target).text("Login");

        if (jsonData.success) {
            $("#modal-login-form").submit();
        } else {
            Object.keys(jsonData.errors).forEach((ele) => {
                $(`#modal-login-form .uk-text-danger strong.error-${ele}`).text(
                    jsonData.errors[ele]
                );
            });
        }
    } catch (error) {
        console.log("Cannot Connect to Server");
        $(event.target).text("Login");
    }
});

function searchFormSubmit(event) {
    event.preventDefault();
    console.log(event.target);
    $("#searchForm").submit();
}

($ => {})(jQuery);

$(window).on("load resize", function() {
    if ($(window).width() < 768) $(".lower-navbar").attr("hidden", "");
    else $(".lower-navbar").removeAttr("hidden");
});
