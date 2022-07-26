/* 
This Simple Form Builder was Developed by 
Carlo Montero
Posted/Published in: www.sourcecodester.com
*/
$(function() {
    $('#form-field form').prepend("<input type='hidden' name='form_code' value='" + form_code + "'/>")
    $('#form-buidler-action').remove()
    $('.question-item .card-footer, .item-move,[name="choice"],.add_chk, .add_radio,.rem-on-display').remove()
    $('[contenteditable]').each(function() {
        $(this).removeAttr('contenteditable')
    })
    $('.form-check label').click(function() {
        if ($(this).siblings('input').is(":checked") == true) {
            $(this).siblings('input').prop("checked", false).trigger('change')
        } else {
            $(this).siblings('input').prop("checked", true).trigger('change')
        }
    })
    $('.choice-field input[type="checkbox"][required="required"]').each(function() {
        $(this).closest('.choice-field').attr("data-required", true)
    })
    $('.choice-field input[type="checkbox"]').change(function() {
        var _req = $(this).closest('.choice-field').attr("data-required")
        if (_req == "true") {
            if ($(this).closest('.choice-field').find('input[type="checkbox"]:checked').length > 0) {
                $(this).closest('.choice-field').find('input[type="checkbox"]').attr('required', false)
            } else {
                $(this).closest('.choice-field').find('input[type="checkbox"]').attr('required', true)
            }
        }
    })
    $('#save_response').click(function() {
        $('#form-field form').submit()
    })
    $('#form-field form').submit(function(e) {
        e.preventDefault()
        start_loader();
        $.ajax({
            url: "classes/Forms.php?a=save_response",
            method: 'POST',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            dataType: 'json',
            error: err => {
                console.log(err)
                alert("ha ocurrido un error")
            },
            success: function(resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    alert("Formulario entregado satisfactoriamente")
                    location.reload()
                } else {
                    console.log(resp)
                    alert("ha ocurrido un error")
                }
                end_loader()
            }
        })
    })

})