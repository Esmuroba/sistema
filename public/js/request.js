let outputAmount = document.querySelector("#outputAmount");
let rangeAmount = document.querySelector("#rangeAmount");
// let labelAmount = document.querySelector("#labelAmount");

const noticePrivacy = $("#noticePrivacy");
const salaryRetention = $("#salaryRetention");
const noticePrivacyInput = $("#noticePrivacyInput");
const salaryRetentionInput = $("#salaryRetentionInput");
const consentChecks = $(".consent-check");
const requestButton = $("#requestButton");

outputAmount.value = Math.round(
    (Number(rangeAmount.min) + Number(rangeAmount.max)) / 2
);

// labelAmount.value = new Intl.NumberFormat("es-MX").format(
//     labelAmount.value * rangeAmount.value
// );

// function requestModal(dailySalary) {
//     let amount = Number(rangeAmount.value) * dailySalary;

//     outputAmount.value = new Intl.NumberFormat('es-MX').format(rangeAmount.value);
//     labelAmount.value = new Intl.NumberFormat("es-MX").format(amount);
// }

$(document).ready(function () {
    $(".consent-check").on("change", function () {
        noticePrivacyInput.prop("checked", noticePrivacy.is(":checked"));
        salaryRetentionInput.prop("checked", salaryRetention.is(":checked"));

        requestButton.prop(
            "disabled",
            !($(".consent-check:checked").length == consentChecks.length)
        );
    });

    $("#btnRequestNext").on("click", function () {
        $.get({
            url: "/requests/calculate",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            datatype: "json",
            data: {
                request_amount: rangeAmount.value.trim(),
            },
            success: function (response) {
                // Request Summary Modal
                var tax = Number(response.comission);
                var commision = Number(response.tax);

                // $("#days").text(response.days);
                $("#salaryAmount").text(
                    "$" + new Intl.NumberFormat("es-MX").format(response.amount)
                );
                $("#comission").text(
                    "$" + new Intl.NumberFormat("es-MX").format(tax.toFixed(2))
                );
                $("#iva").text(
                    "$" +
                        new Intl.NumberFormat("es-MX").format(
                            commision.toFixed(2)
                        )
                );
                $("#totalAmount").text(
                    "$" +
                        new Intl.NumberFormat("es-MX").format(
                            response.totalAmount.toFixed(2)
                        )
                );

                // Request Confirm Modal
                // $("#requestDaysInput").val(response.days);
                $("#requestAmountInput").val(response.amount);
                $("#comissionInput").val(response.comission);
                $("#taxInput").val(response.tax);
                $("#totalAmountInput").val(response.totalAmount);
            },
            error: {
                function(response) {
                    console.log("error " + response);
                },
            },
        });
    });
});
