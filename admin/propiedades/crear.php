<?php

    //Base de Datos
    require '../../includes/config/database.php';
    $db = conectarDB();

    // Consultar para obtener los vendedores
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);

    // Arreglo con mensajes de errores 
    $errores = [];

     $titulo = $_POST[''] ?? '';
        $precio = $_POST[''] ?? '';
        $descripcion = $_POST[''] ?? '';
        $habitaciones = $_POST[''] ?? '';
        $wc = $_POST[''] ?? '';
        $estacionamiento = $_POST[''] ?? '';
        $vendedores_id = $_POST[''] ?? '';

    // Ejecutar el codigo despues del que el ususario envia el formulario
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        //echo "<pre>";
        //var_dump($_POST);
        //echo "</pre>";
        //echo "<pre>";
        //var_dump($_FILES);
        //echo "</pre>"

        $titulo = mysqli_real_escape_string( $db, $_POST['titulo']) ?? '';
        $precio = mysqli_real_escape_string( $db, $_POST['precio']) ?? '';
        $descripcion = mysqli_real_escape_string( $db, $_POST['descripcion']) ?? '';
        $habitaciones = mysqli_real_escape_string( $db, $_POST['habitaciones']) ?? '';
        $wc = mysqli_real_escape_string( $db, $_POST['wc']) ?? '';
        $estacionamiento = mysqli_real_escape_string( $db, $_POST['estacionamiento']) ?? '';
        $vendedores_id = mysqli_real_escape_string( $db, $_POST['vendedor']) ?? '';
        $creado = date('Y/m/d');

        // Asignar files hacia una variable
        $imagen = $_FILES['imagen'];


        if(!$titulo) {
            $errores [] = "Debes añadir un titulo";
        }

        if(!$precio) {
            $errores [] = "Debes añadir un precio";
        }

        if( strlen ( $descripcion ) <50 ) {
            $errores [] = "La descripcion es obligatoria y debe tener al menos 50 caracteres";
        }

        if(!$wc) {
            $errores [] = "El numero de baños es obligatorio";
        }

        if(!$estacionamiento) {
            $errores [] = "El numero de lugares de estacionamiento es obligatorio";
        }

        if(!$vendedores_id) {
            $errores [] = "Elige un vendedor";
        }

        if(!$imagen['name']) {
            $errores[]= 'La imagen es obligatoria';
        }

        // Validar por tamaño (100kb maximo)
        $medida = 1000 * 100;

        if($imagen['size'] > $medida ) {
            $errores[] = 'La imagen es muy pesada';
        }


        //echo "<pre>";
        //var_dump($errores);
        //echo "</pre>";

        // Revisar que el arreglo de errores este vacio
        if(empty($errores)) {
        //Insertar en la base de datos
        $query = " INSERT INTO propiedades (titulo, precio, descripcion, habitaciones, wc, estacionamiento, creado, vendedores_id ) VALUES ( '$titulo', '$precio',
        '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$creado', '$vendedores_id' ) ";

        //echo $query;

        $resultado = mysqli_query($db, $query);

            if($resultado) {
                // Redireccionar al usuario
                header('Location: /admin');
            }
        }
    }

    require '../../includes/funciones.php';
    incluirTemplate('header');
 ?>

    <main class="contenedor seccion">
        <h1>Crear</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>

        <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
            <fieldset>
                <legend>Información General</legend>

                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name = "titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo; ?>">

                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $precio; ?>">

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" accept="image/jpeg, img/png" name="imagen">

                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>
            </fieldset>

            <fieldset>
                <legend>Información Propiedad</legend>

                <label for="imagen">Habitaciones:</label>
                <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo $habitaciones; ?>"> 

                <label for="imagen">Baños:</label>
                <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo $wc; ?>"> 

                <label for="imagen">Estacionamiento:</label>
                <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="<?php echo $estacionamiento; ?>"> 
            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>

                <select name="vendedor">
                    <option value="">-- Seleccione --</option>
                    <?php while($vendedor = mysqli_fetch_assoc($resultado) ): ?>
                        <option  <?php echo $vendedores_id === $vendedor['id'] ? 'selected' : ''; ?>  value="<?php echo $vendedor['id']; ?>">
                        <?php echo $vendedor['nombre'] . " " . $vendedor['apellido']; ?></option>
                    <?php endwhile; ?>
                </select>
            </fieldset>

            <input type="submit" value="Crear Propiedad" class="boton boton-verde">
        </form>

    </main>

<?php
    incluirTemplate('footer'); 
 ?>