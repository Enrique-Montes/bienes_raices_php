<?php

    //Base de Datos
    require '../../includes/config/database.php';
    $db = conectarDB();

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

        $titulo = $_POST['titulo'] ?? '';
        $precio = $_POST['precio'] ?? '';
        $descripcion = $_POST['descripcion'] ?? '';
        $habitaciones = $_POST['habitaciones'] ?? '';
        $wc = $_POST['wc'] ?? '';
        $estacionamiento = $_POST['estacionamiento'] ?? '';
        $vendedores_id = $_POST['vendedor'] ?? '';

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

        //echo "<pre>";
        //var_dump($errores);
        //echo "</pre>";

        // Revisar que el arreglo de errores este vacio
        if(empty($errores)) {
        //Insertar en la base de datos
        $query = " INSERT INTO propiedades (titulo, precio, descripcion, habitaciones, wc, estacionamiento, vendedores_id ) VALUES ( '$titulo', '$precio',
        '$descripcion', '$habitaciones', '$wc', '$estacionamiento', '$vendedores_id' ) ";

        //echo $query;

        $resultado = mysqli_query($db, $query);

            if($resultado) {
                echo "Insertado correctamente";
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

        <form class="formulario" method="POST" action="/admin/propiedades/crear.php">
            <fieldset>
                <legend>Información General</legend>

                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name = "titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo; ?>">

                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $precio; ?>">

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" accept="image/jpeg, img/png">

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
                    <option value="">-- Seleccione--</option>
                    <option value="1">Kike</option>
                    <option value="2">Karen</option>
                </select>
            </fieldset>

            <input type="submit" value="Crear Propiedad" class="boton boton-verde">
        </form>

    </main>

<?php
    incluirTemplate('footer'); 
 ?>