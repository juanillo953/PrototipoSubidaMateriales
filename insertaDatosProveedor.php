<?php 
include("./conexion.php");
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (isset($_POST["import"])) {
    
    $fileName = $_FILES["file"]["name"];
    
    if ($_FILES["file"]["size"] > 0) {
        $target_dir  = "./csvs/Prueba_";
        $target_file = $target_dir . basename($fileName);
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        } else {
        }
        
        $file = fopen($target_file, "r");
        
        while (($column = fgetcsv($file, 10000, ";")) !== FALSE) {
            $sqlComprueba="SELECT * FROM materiales WHERE Material_ID = '$column[0]'";
            $resultado = $conn->query($sqlComprueba);
            if ($resultado->num_rows > 0) {
                $sqlUpdate = "UPDATE materiales SET Material_Nombre='$column[1]',Material_Precio='$column[2]',Material_Peso='$column[3]', Material_Dimensiones_alto='$column[4]', Material_Dimensiones_ancho='$column[5]', Material_Dimensiones_profundo='$column[6]', Material_Proveedor_ID='$column[7]', Material_Descripcion='$column[7]' where Material_ID = '$column[0]'";
                $result = mysqli_query($conn, $sqlUpdate);
             
             if (! empty($result)) {
                 $type = "success";
                 $message = "CSV Data Imported into the Database";
             } else {
                 $type = "error";
                 $message = "Problem in Importing CSV Data";
             }
            } else {
                $sqlInsert = "INSERT into materiales (Material_ID,Material_Nombre,Material_Precio,Material_Peso,Material_Dimensiones_alto,Material_Dimensiones_ancho,Material_Dimensiones_profundo,Material_Proveedor_ID,Material_Descripcion)
                values ('" . $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $column[3] . "','" . $column[4] . "','" . $column[5] . "','" . $column[6] . "','" . $column[7] . "','" . $column[8] . "')";
             $result = mysqli_query($conn, $sqlInsert);
             
             if (! empty($result)) {
                 $type = "success";
                 $message = "CSV Data Imported into the Database";
             } else {
                 $type = "error";
                 $message = "Problem in Importing CSV Data";
             }
            }

        }
    }
}
/*$nombreCsv = $_FILES['file']['name'];
if (empty($nombreCsv)) {

}else{
    $target_dir  = "csvs/Prueba_";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
    } else {
    }

    $file = fopen($target_file, "r");
    while (($column = fgetcsv($file, 10000, ";")) !== FALSE) {
        $sqlInsert = "INSERT into users (Material_ID,Material_Nombre,Material_Precio,Material_Peso,Material_Dimensiones_alto,Material_Dimensiones_ancho,Material_Dimensiones_profundo,Material_Proveedor_ID,Material_Descripcion)
               values ('" . $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $column[3] . "','" . $column[4] . "','" . $column[5] . "','" . $column[6] . "','" . $column[7] . "','" . $column[8] . "')";
        $result = mysqli_query($conn, $sqlInsert);
        
        if (! empty($result)) {
            $type = "success";
            $message = "CSV Data Imported into the Database";
            echo "acierto";

            header("Location:acierto.php");
        } else {
            $type = "error";
            $message = "Problem in Importing CSV Data";
            echo "fallo";
            header("Location:fallo.php");
        }
}*/
?>