var loader_script = '<div id="pre-loader">' +
    '<div class="spinner-border text-primary" role="status">' +
    '<span class="sr-only">Loading...</span>' +
    '</div>' +
    '</div>';
window.start_loader = function() {
    if ($('body>#pre-loader').length <= 0) {
        $('body').append(loader_script)
    }
}
window.end_loader = function() {
    var loader = $('body>#pre-loader')
    if (loader.length > 0) {
        loader.remove()
    }
}
var _loader = '<div class="tbl_loader"><div class="spinner-grow" style="width: 3rem; height: 3rem;" role="status"><span class="sr-only">Loading...</span></div><small>Please Wait..</small></div>'

$(function() {
    $('.dataTables_wrapper').each(function() {
        if ($(this).find('.tbl_loader').length <= 0)
            $(this).prepend(_loader)
    })
})

function tbl_loader(tbl_id, show) {
    $('#' + tbl_id + "_wrapper").find('.tbl_loader').toggle(show)
    $('#' + tbl_id + "_wrapper").removeClass('blur')
    if (show == true) {
        $('#' + tbl_id + "_wrapper").find('.tbl_loader').css('display', "inline-flex")
        $('#' + tbl_id + "_wrapper").addClass('blur')
    }
}