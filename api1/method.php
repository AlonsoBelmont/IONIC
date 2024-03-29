<?php
require "config/Conexion.php";

  //print_r($_SERVER['REQUEST_METHOD']);
  switch($_SERVER['REQUEST_METHOD']) {
    case 'GET':
      // Consulta SQL para seleccionar datos de la tabla
$sql = "SELECT nombre, apellidos, tel, foto FROM usuarios";

$query = $conexion->query($sql);

if ($query->num_rows > 0) {
    $data = array();
    while ($row = $query->fetch_assoc()) {
        $data[] = $row;
    }
    // Devolver los resultados en formato JSON
    header('Content-Type: application/json');
    echo json_encode($data);
} else {
    echo "No se encontraron registros en la tabla.";
}

$conexion->close();
      break;


    case 'POST':
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Recibir los datos del formulario HTML
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $tel = $_POST['tel'];
        $foto = $_POST['foto'];
     
    
        // Insertar los datos en la tabla
        $sql = "INSERT INTO usuarios (nombre, apellidos, tel, foto ) VALUES ('$nombre', '$apellidos','$tel', '$foto')"; // Reemplaza con el nombre de tu tabla
    
        if ($conexion->query($sql) === TRUE) {
            echo "Datos insertados con éxito.";
        } else {
            echo "Error al insertar datos: " . $conexion->error;
        }
    } else {
        echo "Esta API solo admite solicitudes POST.";
    }
    
    $conexion->close();
      break;
      case 'PATCH':
        if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
          parse_str(file_get_contents("php://input"), $datos);
      
          $id_mae = $datos['id_mae'];
          $apellidos = $datos['apellidos'];
          $foto = $datos['foto'];
          $tel = $datos['tel'];
      
          if ($_SERVER['REQUEST_METHOD'] === 'PATCH') { // Método PATCH
              $actualizaciones = array();
              if (!empty($apellidos)) {
                  $actualizaciones[] = "apellidos = '$apellidos'";
              }
              if (!empty($foto)) {
                  $actualizaciones[] = "foto = '$foto'";
              }
              if (!empty($tel)) {
                  $actualizaciones[] = "tel = '$tel'";
              }
      
              $actualizaciones_str = implode(', ', $actualizaciones);
              $sql = "UPDATE usuarios SET $actualizaciones_str WHERE id_mae = $id_mae";
          }
      
          if ($conexion->query($sql) === TRUE) {
              echo "Registro actualizado con éxito.";
          } else {
              echo "Error al actualizar registro: " . $conexion->error;
          }
      } else {
          echo "Método de solicitud no válido.";
      }
      
      $conexion->close();
       break;

    case 'PUT':
      if ($_SERVER['REQUEST_METHOD'] === 'PUT' || $_SERVER['REQUEST_METHOD'] === 'PATCH') {
        parse_str(file_get_contents("php://input"), $datos);
    
        $id_mae = $datos['id_mae'];
        $apellidos = $datos['apellidos'];
        $foto = $datos['foto'];
        $tel = $datos['tel'];
    
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $sql = "UPDATE usuarios SET apellidos = '$apellidos', foto = '$foto', tel = '$tel' WHERE id_mae = $id_mae";
        } else { // Método PATCH
            $actualizaciones = array();
            if (!empty($apellidos)) {
                $actualizaciones[] = "apellidos = '$apellidos'";
            }
            if (!empty($foto)) {
                $actualizaciones[] = "foto = '$foto'";
            }
            if (!empty($tel)) {
                $actualizaciones[] = "tel = '$tel'";
            }
    
            $actualizaciones_str = implode(', ', $actualizaciones);
            $sql = "UPDATE usuarios SET $actualizaciones_str WHERE id_mae = $id_mae";
        }
    
        if ($conexion->query($sql) === TRUE) {
            echo "Registro actualizado con éxito.";
        } else {
            echo "Error al actualizar registro: " . $conexion->error;
        }
    } else {
        echo "Método de solicitud no válido.";
    }
    
    $conexion->close();

      break;
  
      
    case 'DELETE':
      if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        // Procesar solicitud DELETE
        $id_mae = $_GET['id_mae'];
        $sql = "DELETE FROM usuarios WHERE id_mae = $id_mae";
    
        if ($conexion->query($sql) === TRUE) {
            echo "Registro eliminado con éxito.";
        } else {
            echo "Error al eliminar registro: " . $conexion->error;
        }
    } else {
        echo "Método de solicitud no válido.";
    }
    $conexion->close();
      break;


     default:
       echo 'undefined request type!';
  }
?>