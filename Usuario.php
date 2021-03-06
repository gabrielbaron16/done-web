<?php
class Usuario{
//atributos
  private $id;
  private $edad;
  private $contrasena; private $contrasena_2;
  private $email;
  private $nacimiento;
  private $genero;
  private $nombrep;
  private $apellido;
//constructor
 function Usuario($nombrep, $apellido, $id,$contrasena,$contrasena2,$email,$nacimiento){
     $this->nombrep = $nombrep;
     $this->apellido = $apellido;
     $this->id = $id; // $post es una variable superglobal de psp (array)
     $this->contrasena= $contrasena;
     $this->contrasena_2= $contrasena2;
     $this->email = $email;
     $this->nacimiento= $nacimiento;
     /*con las dos lineas de codigo anteriores lo que estamos haciendo es
      *asignarle a una variable local de php lo que el usuario introdujo
      *en el nombre_usuario, que es almacenado automaticamente en el
      *$POST_*/
}
//metodos
function ImprimirDatosUsuario(){
  echo "<br><br>Lo que se registro:";
  echo "<br> Nombre del usuario: ". $this->id."<br>";
  echo "<br> Constraseña del usuario: ".$this->contrasena."<br>";
  echo "<br> Contrasena del usuario (intento 2): ".$this->contrasena_2."<br>";
  echo "<br> Email: ".$this->email."<br>";
  echo "<br> Nacimiento: ".$this->nacimiento."<br>";
}
        function getnombre(){
          return $this->nombre;
        }
        function getcontrasena(){
          return $this->contrasena;
        }
        function getcontrasena_2(){
          return $this->contrasena_2;
        }
        function getemail(){
          return $this->email;
        }
        function getnacimiento(){
          return $this->nacimiento;
        }

        function transformToJson(){
          $data = array(
            'email' => $this->email,
            'username' => $this->id,
            'password' => $this->contrasena,
            'nombre' => $this->nombrep,
            'apellido' => $this->apellido,
            'fechaDeNacimiento' => $this->nacimiento,
            'formaDeRegistro' => 'Web'
          );
          $json = json_encode($data);
          $url = 'https://intense-lake-39874.herokuapp.com/usuarios';
          //Iniciar cURL
          $ch = curl_init($url);

          //Decir a curl que se quiere mandar un POST
          curl_setopt($ch, CURLOPT_POST, 1);
          //Adjuntar el json string al POST
          curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
          //Configurar el content type a application/json
          curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

          curl_exec($ch);

          if (!curl_errno($ch)) {
            switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
              case 200: #OK
                break;
              case 400: echo 'Bad request';
                break;
              case 404: echo 'Not found';
                break;
              case 412: echo 'Usuario ya existe';
                break;
              default: echo 'Código http inesperado: ', $http_code, "\n";
            }
          }
          curl_getinfo($ch, CURLINFO_HTTP_CODE);

          curl_close($ch);
        }
}
?>
