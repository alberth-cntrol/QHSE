<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<section class="h-100 gradient-form" style="background-color: #eee;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-xl-10">
        <div class="card rounded-3 text-black">
          <div class="row g-0">
            <div class="col-lg-6">
              <div class="card-body p-md-5 mx-md-4">

                <div class="text-center">
                  <img src="css\logo-transp-oracle.png"
                    style="width: 185px;" alt="logo">
                  <!--<h4 class="mt-1 mb-5 pb-1">We are The Lotus Team</h4>-->
                </div>

                <form action="validar.php" method="POST">
          
                  <div class="form-outline mb-4">
              <input type="text" id="typeEmailX-2" class="form-control form-control-lg" name="usuario"/>
              <label class="form-label" for="typeEmailX-2">Usuario</label>
            </div>

            <div class="form-outline mb-4">
              <input type="password" id="typePasswordX-2" class="form-control form-control-lg" name="password"/>
              <label class="form-label" for="typePasswordX-2">Password</label>
            </div>

                  <div class="text-center pt-1 mb-5 pb-1">
                    <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit">Iniciar Sesion</button>
                    <!--<a class="text-muted" href="#!">Olvidaste tu contraseña?</a>-->
                  </div>

                  <!--<div class="d-flex align-items-center justify-content-center pb-4">
                    <p class="mb-0 me-2">No tienes una cuenta?</p>
                    <button type="button" class="btn btn-outline-primary">Crear una cuenta</button>
                  </div>-->

                </form>

              </div>
            </div>
            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
              <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                <h4 class="mb-4">Acerca de la compañia</h4>
                <p class="small mb-0">Empresa Especializada en Brindar Servicios de Consultoría Empresarial, Soporte y Soluciones Profesionales de alta Calidad. Con Campos de Acción en las Diversas Áreas de Ingeniería, Salud Ocupacional, Medio Ambiente y de Recursos Humanos.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

</html>