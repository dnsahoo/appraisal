window.onload = function () {
    $('#datatable_clients').dataTable({
        "pagingType": "full_numbers",
        "iDisplayLength": 25,
        "aaSorting": [[0, 'desc']],
    });
}
$(document).ready(function()
{
});
