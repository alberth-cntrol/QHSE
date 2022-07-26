<h3>Responses of Form <?php echo $_GET['code'] ?></h3>
<hr class="border-primary">
<div class="col-md-12">
    <table id="forms-tbl" class="table table-stripped">
        <thead>
            <tr>
                <th>#</th>
                <th>Fecha y Hora</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $i = 1;
                $forms = $db->conn->query("SELECT * FROM `response_list` where form_code = '".$_GET['code']."' order by date(date_created)");
                while($row = $forms->fetch_assoc()):
            ?>
                <tr>
                    <td class="text-center"><?php echo $i++ ?></td>
                    <td><?php echo date("M d,Y h:i A",strtotime($row['date_created'])) ?></td>
                    <td class='text-center'>
                        <a href="./index.php?p=view_response&code=<?php echo $row['form_code'] ?>&id=<?php echo $row['id'] ?>" class="btn btn-default border">Ver</a>
                    </td>
                </tr>
            <?php endwhile;  ?>
        </tbody>
    </table>
</div>
<script>
    $(function(){
        $('#forms-tbl').dataTable();
    })
</script>