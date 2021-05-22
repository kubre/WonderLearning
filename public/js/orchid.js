
function copyHelper(result) {
    var copyhelper = document.createElement("input");
    copyhelper.className = "copyhelper";
    document.body.appendChild(copyhelper);
    copyhelper.value = result;
    copyhelper.select();
    document.execCommand("copy");
    document.body.removeChild(copyhelper);
}

// Table CSV Exports
var table = document.querySelector('table.table.table-striped.table-bordered');

if (table) {
    function exportCsv()
    {
        var table = document.querySelector('table.table.table-striped.table-bordered');
        var today = new Date().toISOString().slice(0, 10);
        var title = document.getElementsByTagName('h1')[0].innerText.replaceAll(' ', '_');
        var xtable = new TableExport(table,
        {
            formats: ["csv"],
            filename: title + '_' + today,
            exportButtons: false,
        });
        var tableName;
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