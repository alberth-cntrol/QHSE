<?php 
extract($_GET);
?>
<script src="./js/form-builder.js"></script>
<div class="row">
    <div class="col-lg-12">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h3><b><?php echo isset($_GET['code']) ? "Editar" : "Crear Nuevo" ?> Formulario</b></h3>
            </div>
        </div>
    </div>
</div>
<hr class="border-dark">
<?php include "./forms/".$code.".html" ?>
<script>
       $('#form-field form').prepend("<input type='hidden' name='form_code' value='<?php echo $code ?>'/>")
</script>
<div class=" d-none" id = "q-item-clone">
<div class="card mt-3 mb-3 col-md-12 question-item ui-state-default" data-item="0">
    <span class="item-move"><i class="fa fa-braille"></i></span>
    <div class="card-body">
        <div class="row align-items-center d-flex">
            <div class="col-sm-8">
                <p class="question-text m-0" contenteditable="true" title="Write you question here">Escribe tu pregunta aquí</p>
            </div>
            <div class="col-sm-4">
                <select title="question choice type" name="choice" class='form-control choice-option'>
                    <option value="p">Párrafo</option>
                    <option value="checkbox">Multiples Opciones y Respuestas</option>
                    <option value="radio">Mupliples Opciones 1 Respuesta</option>
                    <option value="file">Subir archivo</option>
                </select>
            </div>
        </div>
        <hr class="border-dark">
        <div class="row ">
            <div class="form-group choice-field col-md-12">
                <textarea name="q[]" class="form-control col-sm-12" cols="30" rows="5" placeholder="Escribe tu respuesta aquí"></textarea>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="w-100 d-flex justify-content-between align-items-center">
            <div class="form-check">
                <input class="form-check-input req-item" type="checkbox" value="" >
                <label class="form-check-label req-chk" for="">
                    * Requerido
                </label>
            </div>
            <button class="btn btn-default border rem-q-item" type="button"><i class="fa fa-trash"></i></button>
        </div>
    </div>
</div>
</div>