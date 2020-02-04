<?php 
include("./conexion.php");
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (isset($_POST["import"])) {
    
    $fileName = $_FILES["file"]["name"];
    
    if ($_FILES["file"]["size"] > 0) {
        $target_dir  = "./csvsBorrado/Borrado_";
        $target_file = $target_dir . basename($fileName);
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        } else {
        }
        
        $file = fopen($target_file, "r");
        
        while (($column = fgetcsv($file, 10000, ";")) !== FALSE) {
            $sqlComprueba="SELECT * FROM materiales WHERE Material_ID = '$column[0]'";
            $resultado = $conn->query($sqlComprueba);
            if ($resultado->num_rows > 0) {
                $sqlUpdate = "UPDATE materiales SET Material_Borrado=1";
                $result = mysqli_query($conn, $sqlUpdate);
             
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
?>