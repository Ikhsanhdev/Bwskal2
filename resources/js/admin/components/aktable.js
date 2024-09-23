//  Handle datatables
window.AKTableConfig = {
    dom: "<'card-body pt-0'f<'row'<'col-sm-12'<'table-responsive'tr>>>><'card-footer d-flex align-items-center justify-content-between'<'info'i><'paging'p>>",
    domFit: `<'card-body p-0'f<'row'<'col-sm-12'<'table-responsive'tr>>>><'card-footer d-flex align-items-center justify-content-between'<'info'i><'paging'p>>`
};
if ($ && $.fn && $.fn.DataTable) {
    $.fn.DataTable.defaults.dom = window.AKTableConfig.dom;
    $.fn.DataTable.defaults.iDisplayLength = 20;
    $.fn.DataTable.defaults.oLanguage.sInfo = "Menampilkan _START_ - _END_ dari _TOTAL_ data";
    $.fn.DataTable.defaults.oLanguage.sInfoEmpty = "Menampilkan 0 - 0 dari 0 data";
    $.fn.DataTable.defaults.oLanguage.sInfoFiltered = "(difilter dari _MAX_ data)";
    $.fn.DataTable.defaults.oLanguage.sEmptyTable = "Data Kosong";
    $.fn.DataTable.defaults.oLanguage.sSearch = "";
    $.fn.DataTable.defaults.oLanguage.sSearchPlaceholder = "Pencarian";
    $.fn.DataTable.defaults.oLanguage.sZeroRecords = "Tidak ditemukan data yang cocok";
    $.fn.DataTable.defaults.oLanguage.oPaginate.sNext = "&gt;";
    $.fn.DataTable.defaults.oLanguage.oPaginate.sPrevious = "&lt;";

    //  Handle datatable error csrf token missmatch
    $.fn.DataTable.ext.errMode = function (setting, noteid, message) {
        let dtApi = new $.fn.dataTable.Api(setting);
        if (setting.jqXHR?.status == 419) {
            setTimeout(() => {
                dtApi.ajax.reload();
            }, 1000);
            return;
        }

        AKToast.error(setting?.jqXHR?.responseJSON?.message ?? message);
    };
}