// Call the dataTables jQuery plugin
$(document).ready(function () {
    $("#dataTable").DataTable();

    const table = $("#collapsibleDataTable").DataTable({
        columnDefs: [
            {
                targets: 0,
                orderable: false,
                className: "details-control",
            },
        ],
        order: [[1, "asc"]],
    });

    function format(tr) {
        const scores = $(tr).data("scores");
        if (!scores || scores.length === 0) {
            return '<div class="p-3">No scores available.</div>';
        }

        let html = `
      <table class="table table-sm table-bordered mt-2 mb-0">
        <thead>
          <tr>
            <th>Batas Bawah</th>
            <th>Score</th>
          </tr>
        </thead>
        <tbody>
    `;

        function formatNumber(val) {
            // If val is not a number, return "-"
            if (val === null || val === undefined || val === "") return "-";
            return parseFloat(val).toString(); // removes .00 if it's whole number
        }

        scores.forEach((score) => {
            html += `
          <tr>
            <td>${formatNumber(score.batas_bawah)}</td>
            <td>${formatNumber(score.score)}</td>
          </tr>
        `;
        });

        html += `</tbody></table>`;
        return html;
    }

    $("#collapsibleDataTable tbody").on(
        "click",
        "td.details-control",
        function () {
            const tr = $(this).closest("tr");
            const row = table.row(tr);

            if (row.child.isShown()) {
                // Close
                row.child.hide();
                tr.removeClass("shown");
            } else {
                // Open
                row.child(format(tr)).show();
                tr.addClass("shown");
            }
        }
    );
});
