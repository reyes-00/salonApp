<?php
namespace Controllers;

use Clases\Email;
use MVC\Router;
use Model\Usuario;

class LoginController{

  public static function index(Router $router){
    $alertas = [];
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $auth =  new Usuario($_POST);

      // debuguear($usuario);s
      $alertas = $auth->validaLogin();

      if(empty($alertas)){
        // comprobar que existeUsuario
        $usuario = Usuario::where('email', $auth->email);
        // debuguear($usuario);
        if($usuario){
          /* verificar el password */
          if($usuario->comprobarPasswordAndVerificado($auth->password)){

            // Autenticar
             if(!isset($_SESSION)) {
             session_start();
             }
              $_SESSION['id'] = $usuario->id;
              $_SESSION['nombre'] = $usuario->nombre;
              $_SESSION['email'] = $usuario->email;
              $_SESSION['login'] = true;

             if($usuario->admin === "1"){
              $_SESSION['admin'] = $usuario->admin ?? null;
              header("Location: /admin"); 
            }else{
              header("Location: /cita"); 
            }
          }

        }else{
          Usuario::setAlerta('errores','Usuario no encontrado');
        }
      }
    }
    $alertas = Usuario::getAlertas();

    $router->render("auth/login", [
      'alertas' => $alertas
    ]);
  }
  public static function logout(){
    echo "wasddw";
  }
  public static function olvide(Router $router){
    $alertas = [];
    
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
      $auth = new Usuario($_POST);
      $alertas = $auth->validaEmail();
      
      if(empty($alertas)){
        $usuario = Usuario::where('email',$auth->email);
        if($usuario && $usuario->confirmado=== '1'){
          $usuario->crearToken();
          $usuario->guardar();
          // debuguear($usuario);
          
          // Enviar eemail
          $email = new Email( $usuario->email,$usuario->nombre, $usuario->token);
          $email->enviarInstrucciones();
          // Alerta de exito
          Usuario::setAlerta('exito', 'Revisa tu email');
         
        }else{
          Usuario::setAlerta('errores','El usuario no esta confirmado o no existe');
          
        }

      }
    }
    $alertas = Usuario::getAlertas();
    $router->render("auth/olvide",[
      'alertas' => $alertas
    ]);
  }
  public static function recuperar(Router $router){
    $alertas = [];
    $error = false;
    $token = s($_GET['token']);
    $usuario = Usuario::where('token', $token);

    if(empty($usuario)){
      Usuario::setAlerta('errores','El usuario no exite');
      $error = true;
    }
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $password = new Usuario($_POST);
      $alertas = $password->validarPassword();
      // debuguear($password);
      if(empty($alertas)){
        $usuario->password = null;
        $usuario->password = $password->password;
        $usuario->hashPassword();
        $usuario->token = null;
        $resultado = $usuario->guardar();

        if($resultado){
          header('location: / ');
        }

        debuguear($usuario);
      }

    }

    $alertas = Usuario::getAlertas();
    $router->render("auth/recuperar-password",[
      'alertas' => $alertas,
      'error'=> $error
    ]);
  }
  public static function confirmarCuenta(Router $router){
    $alertas = [];

    $token = s($_GET ['token']);
    $usuario = Usuario::where('token',$token);
    
    if(empty($usuario) || $token === ''){
      // Mostrar mensaje de error
      Usuario::setAlerta('errores', 'Token no valido');
    }else{
      // Modificar a usuario confirmado
      $usuario->confirmado = 1;
      $usuario->token = '';
      $usuario->guardar();
      Usuario::setAlerta('exito', 'Cuenta comprobada correctamente');
    }
    $alertas = Usuario::getAlertas();
    $router->render("auth/confirma_cuenta",[
      'alertas'=>$alertas
    ]);
  }
  public static function mensaje(Router $router){
    $router->render("auth/mensaje");
  }


  public static function crearCuenta(Router $router){
    $usuario =  new Usuario($_POST);
    $alertas = [];
    
    if($_SERVER['REQUEST_METHOD']==='POST'){
      
      $usuario->sincronizar($_POST);
      
      $alertas = $usuario->validarNuevaCuenta();
     
      if(empty($alertas)){        
        $resultado = $usuario->existeUsuario();

        if($resultado->num_rows){
          $alertas = Usuario::getAlertas();
        }else{
          $usuario->hashPassword();
          $usuario->crearToken();

          $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
          $email->enviarConfirmacion();
          // debuguear($usuario);
          $resultado = $usuario->guardar();

          if($resultado){
            header('Location: /mensaje');
          }
          
        }
      }

    }
    $router->render("auth/crear-cuenta",[
      'usuario' => $usuario,
      'alertas' => $alertas,
    ]);
  }
}