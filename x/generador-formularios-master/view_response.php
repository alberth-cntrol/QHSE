<?php 
extract($_GET);
?>
<script src="./js/form-builder.js"></script>
<div class="row">
    <div class="col-lg-12">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h3><b>Respuestas</b></h3>
            </div>
        </div>
    </div>
</div>
<hr class="border-dark">

<?php 
include "./forms/".$code.".html";
$responses = $db->conn->query("SELECT * FROM `responses` where rl_id = $id");
$data = array();
while($row = $responses->fetch_assoc()){
    $data[$row['meta_field']]['value'] = $row['meta_value'];
    $data[$row['meta_field']]['type'] = "text";
    if(is_file("./uploads/".$row['meta_value'])){
        $data[$row['meta_field']]['type'] = "file";
    }
}
?>
<script>
    $('#form-buidler-action').remove()
    $('.question-item .card-footer, .item-move,[name="choice"],.add_chk, .add_radio,.rem-on-display').remove()
    $('[contenteditable]').each(function() {
        $(this).removeAttr('contenteditable')
    })
    $('.question-item .choice-field').html('')
    var data = $.parseJSON('<?php echo json_encode($data) ?>');
    $(function(){
        $('.question-item').each(function(){
            var item = $(this).attr('data-item')
            if(!!data[item] && data[item]['type'] == 'file'){
                var el = $("<a download>")
                el.attr({
                    href:"./uploads/"+data[item]['value']
                })
                el.text(data[item]['value'])
                $(this).find('.choice-field').append(el)
            }else{
                $(this).find('.choice-field').append(data[item]['value'])
            }
        })
    })
</script>