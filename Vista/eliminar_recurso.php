<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" type="text/css" href="../Publico/css/bootstrap.css"/>
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <a href="panel.php" class="btn btn-primary">Volver</a>
    </div>
</nav>
<div class="container">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6 well">
            <h3 class="text-primary">Eliminar Video</h3>
            <hr style="border-top:1px dotted #ccc;"/>
            <?php
            include_once '../Config/conexion.php';

            // Verificar si se ha enviado el formulario de selección de video a eliminar
            if(isset($_POST['video_select'])){
                $selected_video_id = $_POST['video_select'];

                // Realizar una nueva consulta para obtener el video seleccionado
                $selected_query = mysqli_query($con, "SELECT * FROM `recursos` WHERE `id_recurso` = '$selected_video_id'") or die(mysqli_error($con));
                $selected_video = mysqli_fetch_array($selected_query);

                // Mostrar el video seleccionado a eliminar
                if($selected_video){
                    echo '<div class="row">';
                    echo '    <div class="col-md-4" style="word-wrap:break-word;">';
                    echo '        <br />';
                    echo '        <h4>Nombre del Video:</h4>';
                    echo '        <h5 class="text-primary">'.$selected_video['recurso_name'].'</h5>';
                    echo '        <br />';
                    echo '        <h4>Descripción:</h4>';
                    echo '        <h5 class="text-primary">'.$selected_video['descripcion'].'</h5>';
                    echo '    </div>';
                    echo '    <div class="col-md-8">';
                    echo '        <video width="100%" height="240" controls>';
                    echo '            <source src="'.$selected_video['location'].'">';
                    echo '        </video>';
                    echo '    </div>';
                    echo '</div>';
                    echo '<br>';
                    echo '<hr style="border-top:1px groovy #000;"/>';
                    echo '<form action="" method="POST">';
                    echo '    <input type="hidden" name="delete_video_id" value="'.$selected_video_id.'">';
                    echo '    <button type="submit" class="btn btn-danger">Eliminar Video</button>';
                    echo '</form>';
                }
            }

            // Verificar si se ha enviado el formulario de eliminación de video
            if(isset($_POST['delete_video_id'])){
                $delete_video_id = $_POST['delete_video_id'];

                // Eliminar el video de la base de datos
                $delete_query = mysqli_query($con, "DELETE FROM `recursos` WHERE `id_recurso` = '$delete_video_id'") or die(mysqli_error($con));

                if($delete_query){
                    echo '<div class="alert alert-success">El video se ha eliminado correctamente.</div>';
                } else {
                    echo '<div class="alert alert-danger">Error al eliminar el video.</div>';
                }
            }
            ?>

            <!-- Mostrar la lista de videos disponibles -->
            <?php
            // Realizar consulta para obtener los videos de la base de datos
            $query = mysqli_query($con, "SELECT * FROM `recursos` ORDER BY `id_recurso` ASC") or die(mysqli_error($con));
            ?>

            <div class="col-md-12">
                
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="video_select">Seleccionar video:</label>
                        <select class="form-control" name="video_select" id="video_select">
                            <?php
                             while($fetch = mysqli_fetch_array($query)){
                                echo '<option value="'.$fetch['id_recurso'].'">'.$fetch['recurso_name'].'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Mostrar video a eliminar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>

