<?php


namespace Model;

class Usuario extends ActiveRecord{
  protected static $tabla = 'usuarios';
  protected static $columnasDB = ['id', 'nombre', 'apellido','email','telefono','admin','confirmado','token','password'];

  public $id;
  public $nombre;
  public $apellido;
  public $email;
  public $telefono;
  public $admin;
  public $confirmado;
  public $token; 
  public $password;

  public function __construct($args = []) {
    $this->id = $args['id'] ?? null;
    $this->nombre = $args['nombre'] ?? '';
    $this->apellido = $args['apellido'] ?? '';
    $this->email = $args['email'] ?? '';
    $this->telefono = $args['telefono'] ?? '';
    $this->admin = $args['admin'] ?? '0';
    $this->confirmado = $args['confirmado'] ?? '0';
    $this->token = $args['token'] ?? '';
    $this->password = $args['password'] ?? '';
  }

  public function validarNuevaCuenta(){
    if(!$this->nombre){
      self::$alertas['errores'][] = 'EL nombre es requerido';
    }
    if(!$this->apellido){
      self::$alertas['errores'][] = 'EL apellido es requerido';
    }
    if(!$this->telefono){
      self::$alertas['errores'][] = 'EL telefono es requerido';
    }
    if(!$this->email){
      self::$alertas['errores'][] = 'EL email es requerido';
    }
    if(!$this->password){
      self::$alertas['errores'][] = 'EL password es requerido';
    }
    if(strlen($this->password)<6){
      self::$alertas['errores'][] = 'EL password debe ser mayor a 6 caracteres';
    }

    return self::$alertas;  
  }

  public function validaEmail(){
     if(!$this->email){
     self::$alertas['errores'][] = 'EL email es requerido';
     }
     return self::$alertas;
  }

  // valida login
   public function validaLogin() {
    if(!$this->email){
      self::$alertas['errores'][] = 'EL email es requerido';
    }
    if(!$this->password){
      self::$alertas['errores'][] = 'EL password es requerido';
    }

    return self::$alertas;
   }
   
   /* Validar password */
   public function validarPassword(){
     if(!$this->password){
       self::$alertas['errores'][] = 'El password es requerido';
      }
     if(strlen($this->password) < 6 ){
        self::$alertas['errores'][] = 'El password debe contener mas de 6 caracteres';
      }

      return self::$alertas;
   }


  // Revisa si el usuario existe
  public function existeUsuario() {
    $query = "SELECT * FROM " . static::$tabla . " WHERE email = '" . $this->email ."' LIMIT 1";
    
    $resultado = self::$db->query($query);

    if($resultado->num_rows){
      self::$alertas['errores'][] ='El usuario ya existe';
    }
    return $resultado;
  }

  public function hashPassword() {
    $this->password = password_hash($this->password, PASSWORD_BCRYPT);
  }

  public function crearToken() {
    $this->token = uniqid();
  }

  public function comprobarPasswordAndVerificado($password){
    $resultado = password_verify($password, $this->password);

    if(!$resultado || !$this->confirmado){
      self::$alertas['errores'][] = 'Password Incorrecto o Cuenta no confirmada';
    }else{
      return true;
    }
  }
 
}   