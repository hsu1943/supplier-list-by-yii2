let all_page = false
let all = false
let grid = $('#grid')
$('.site-customer').on('click', '.export-confirm', function () {
    let ids = grid.yiiGridView('getSelectedRows');
    console.log(ids)
    // search params
    let params_str = window.location.search.substr(1);
    console.log(params_str)
    doExport(ids, params_str)
}).on('change', "input[name='selection_all']", function () {
    all = grid.find("input[name='selection_all']").is(':checked')
    let select_all_page = $('#select-all-page')
    let clear_selection = $('#clear-selection')
    consoleAll()
    if (all) {
        if (all_page) {
            clear_selection.show()
        } else {
            select_all_page.show()
        }
    } else {
        all_page = false
        select_all_page.hide()
        clear_selection.hide()
    }
    consoleAll()
}).on('click', '#do-clear-selection', function (){
    grid.find("input[name='selection_all']").click()
}).on('click', '#do-select-all-page', function () {
    all_page = true
    $('#select-all-page').hide()
    $('#clear-selection').show()
    consoleAll()
    return false
})

function consoleAll()
{
    console.log('all_page: ' + all_page)
    console.log('all: ' + all)
}

$(document).ready(function () {
    $('#export-confirm').on('show.bs.modal', function() {
        let ids = grid.yiiGridView('getSelectedRows');
        if (ids.length === 0) {
            $('#select-none').show()
            return false
        } else {
            $('#export-confirm').show()
        }
    })
});

function doExport(ids, params_str) {
    let url = params_str === '' ? "/supplier/export" : "/supplier/export?" + params_str ;
    let columns = []
    $(".checkbox-input-row").each(function (){
        if ($(this).is(':checked')) {
            columns.push($(this).attr('name'))
        }
    })
    let data = {
        all_page: all_page ? 1 : 0,
        ids: ids,
        columns: columns
    }
    $.ajax({
        url: url,
        type: 'post',
        dataType: 'json',
        data: data,
        success: function (res) {
            console.log(res);
        }
    })
}