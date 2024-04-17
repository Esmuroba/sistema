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
            url: "/clients/collaborators/search",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content}"),
            },
            datatype: "json",
            data: {
                data: searchInput.val().trim(),
            },
            success: function (response) {
                if (response.collaborators.length > 0) {
                    tableResults.html(`
                        ${response.collaborators.map(
                            (collaborator) =>
                                `<tr class="cursor-pointer collaborator">
                                <td class="d-none">${collaborator.id}</td>
                                <td class="text-third fw-bold">${
                                    collaborator.curp
                                }</td>
                                <td>${
                                    collaborator.first_name
                                        ? collaborator.first_name
                                        : ""
                                } ${
                                    collaborator.second_name
                                        ? collaborator.second_name
                                        : ""
                                } ${
                                    collaborator.first_surname
                                        ? collaborator.first_surname
                                        : ""
                                } ${
                                    collaborator.last_surname
                                        ? collaborator.last_surname
                                        : ""
                                }</td>
                                <td>
                                    <div class="avatar avatar-sm" title="${
                                        collaborator.enterprise_name
                                    }">
                                        <img src="${
                                            collaborator.enterprise_logo
                                                ? "../img/logos/" +
                                                  collaborator.enterprise_logo
                                                : "../img/icon-enterprise.jpg"
                                        }"
                                            alt="${
                                                collaborator.enterprise_name
                                            }"
                                            class="rounded-circle">
                                    </div>
                                </td>
                                <td>${
                                    collaborator.date_admission
                                        ? collaborator.date_admission
                                        : "Sin datos"
                                }</td>
                                <td>
                                    <span class="badge bg-label-primary me-1">
                                        ${
                                            collaborator.status
                                                ? collaborator.status
                                                : "Sin datos"
                                        }
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
                console.log("Ah ocurrido un error " + response.collaborators);
            },
        });
    });

    $("table").delegate("tr.collaborator", "click", function () {
        var data = $(this)
            .children()
            .map(function () {
                return $(this).text();
            });

        $("#collaboratorId").val(data[0]);
        searchInput.val(data[2]);
        containerResults.addClass("d-none");
    });
});
