<h3>Lista de Formularios</h3>
<hr class="border-primary">
<div class="col-md-12">
    <table id="forms-tbl" class="table table-stripped">
        <thead>
            <tr>
                <th>#</th>
                <th>Fecha y Hora</th>
                <th>Código</th>
                <th>Título</th>
                <th>URL</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $i = 1;
                $forms = $db->conn->query("SELECT * FROM `form_list` order by date(date_created) desc");
                while($row = $forms->fetch_assoc()):
            ?>
                <tr>
                    <td class="text-center"><?php echo $i++ ?></td>
                    <td><?php echo date("M d,Y h:i A",strtotime($row['date_created'])) ?></td>
                    <td><?php echo $row['form_code'] ?></td>
                    <td><?php echo $row['title'] ?></td>
                    <td><a href="./form.php?code=<?php echo $row['form_code'] ?>">form.php?code=<?php echo $row['form_code'] ?></a></td>
                    <td class='text-center'>
                        <a href="./index.php?p=view_form&code=<?php echo $row['form_code'] ?>" class="btn btn-default border">Ver</a>
                        <a href="./index.php?p=view_responses&code=<?php echo $row['form_code'] ?>" class="btn btn-default border">Respuestas</a>
                        <a href="javascript:void(0)" class="btn btn-default border rem_form" data-id='<?php echo $row['form_code'] ?>'><span class="fa fa-trash text-danger"></span></a>
                    </td>
                </tr>
            <?php endwhile;  ?>
        </tbody>
    </table>
</div>
<script>
    $(function(){
        $('#forms-tbl').dataTable();
        $('.rem_form').click(function(){
            start_loader();
            var _conf = confirm("Realmente deseas eliminar estos datos")
            if(_conf == true){
                $.ajax({
                    url:'classes/Forms.php?a=delete_form',
                    method:'POST',
                    data:{form_code: $(this).attr('data-id')},
                    dataType:'json',
                    error:err=>{
                        console.log(err)
                        alert("a ocurrido un error")
                    },
                    success:function(resp){
                        if(resp.status == 'success'){
                            alert("Datos eliminados correctamente");
                            location.reload()
                        }else{
                            console.log(resp)
                        alert("a ocurrido un error")
                        }
                    }
                })
            }
            end_loader()
        })
    })
</script>