
// Table CSV Exports
var table = document.querySelector('table.table.table-striped.table-bordered');

if (table) {
    function exportCsv()
    {
        var table = document.querySelector('table.table.table-striped.table-bordered');
        var today = new Date().toISOString().slice(0, 10);
        var xtable = new TableExport(table,
        {
            formats: ["csv"],
            filename: "payment-due-report_" + today,
            exportButtons: false,
        });
        var tableName;
        console.log(xtable.getExportData());
        for (x in xtable.getExportData()) { tableName = x; }
        var exportData = xtable.getExportData()[tableName]['csv'];
        xtable.export2file(exportData.data, exportData.mimeType, exportData.filename, exportData.fileExtension);
    }

    function printTable() {
        var table = document.querySelector('table.table.table-striped.table-bordered');
        table.classList.add('p-table-black');
        table.id = 'print-report';
        window.print();
    }
}