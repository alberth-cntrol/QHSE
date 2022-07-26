<script src="./js/form-builder.js"></script>
<div class="row">
    <div class="col-lg-12">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h3><b><?php echo isset($_GET['code']) ? "Editar" : "Crear nuevo" ?> Formulario</b></h3>
            </div>
        </div>
    </div>
</div>
<hr class="border-dark">
<div class="container" id="form-field">
    <form id="form-data">
        <div class="row">
            <div class="card col-md-12 border border-primary">
                <div class="card-body">
                    <h3 contenteditable="true" title="Enter Title" class="text-center" id="form-title">Ingresa el título del formulario aquí</h3>
                    <hr class="border-primary">
                    <p contenteditable="true"  id="form-description" title="Enter Description" class="form-description text-center">Ingresa tu descripción aquí</p>
                </div>
                
            </div>
        </div>
        <div>
            <div id="question-field" class='row ml-2 mr-2'>
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
                                    <option value="radio">Multiples Opciones 1 Respuesta</option>
                                    <option value="file">Subir archivo</option>
                                </select>
                            </div>
                        </div>
                        <hr class="border-dark">
                        <div class="row ">
                            <div class="form-group choice-field col-md-12">
                                <textarea name="q[0]" class="form-control col-sm-12" cols="30" rows="5" placeholder="Encuentra tu respuesta aquí"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="w-100 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input req-item" type="checkbox" value="" >
                                <label class="form-check-label req-chk" for="">
                                    *Requerido
                                </label>
                            </div>
                            <button class="btn btn-default border rem-q-item" type="button"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex w-100 justify-content-center" id="form-buidler-action">
            <button class="btn btn-default border mr-1" type="button" id="add_q-item"><i class="fa fa-plus"></i> Agregar Campo</button>
            <button class="btn btn-default border ml-1" type="button" id="save_form"><i class="fa fa-save"></i> Guardar Formulario</button>
        </div>
    </form>
</div>
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
                    <option value="radio">Multiples Opciones 1 Respuesta</option>
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
                    *Requerido
                </label>
            </div>
            <button class="btn btn-default border rem-q-item" type="button"><i class="fa fa-trash"></i></button>
        </div>
    </div>
</div>
</div>