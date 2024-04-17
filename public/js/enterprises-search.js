$(document).ready(function () {
    var searchInput = $("#searchInput");
    var containerResults = $("#searchContainerResults");
    var cardResults = $("#searchCardResults");
    var tableResults = $("#tableResults");

    searchInput.on("focus", function () {
        containerResults.removeClass("d-none");
        cardResults.removeClass("collapse");
    });

    $("#searchContainerBtnClose").on("click", function () {
        cardResults.addClass("collapse");
        containerResults.addClass("d-none");
    });

    searchInput.on("input", function () {
        $.get({
            url: "/clients/enterprises/search",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content}"),
            },
            datatype: "json",
            data: {
                data: searchInput.val().trim(),
            },
            success: function (response) {
                if (response.enterprises.length > 0) {
                    tableResults.html(`
                        ${response.enterprises.map(
                            (enterprise) =>
                            `<tr class="cursor-pointer enterprise">
                                <td class="d-none">${enterprise.id}</td>
                                <td class="d-flex justify-content-center align-items-center pe-0">
                                    <div class="avatar avatar-sm">
                                        <img class="rounded-circle"
                                            src="${enterprise.logo
                                            ? "../img/logos/" + enterprise.logo
                                            : "../img/icon-enterprise.jpg"}"
                                        >
                                    </div>
                                </td>
                                <td class="text-third fw-bold ps-0">
                                    ${enterprise.name}
                                </td>
                                <td>
                                    ${enterprise.first_name} ${
                                    enterprise.second_name
                                        ? enterprise.second_name
                                        : ""
                                    } ${enterprise.first_surname} ${
                                    enterprise.last_surname}
                                </td>
                                <td>
                                    <span class="badge bg-label-primary me-1">
                                        ${enterprise.status
                                            ? enterprise.status
                                            : "Sin datos"}
                                    </span>
                                </td>
                            </tr>`
                        )}
                    `);
                } else {
                    tableResults.html(`
                        <tr>
                            <td colspan="5" class="text-primary">
                                <i class='bx bx-file-find'></i>
                                Sin resultados, verifica tu búsqueda.
                            </td>
                        </tr>
                    `);
                }

                if (searchInput.val().length == 0) {
                    tableResults.empty();
                }
            },
            error: function (response) {
                console.log("Ah ocurrido un error " + response.enterprise);
            },
        });
    });

    $("table").delegate("tr.enterprise", "click", function () {
        var data = $(this).children()
            .map(function () {
                return $(this).text().trim();
            });

        $("#enterpriseId").val(data[0]);
        searchInput.val(data[2]);
        containerResults.addClass("d-none");
    });
});
