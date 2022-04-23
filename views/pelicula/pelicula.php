<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>GENERO</title>
</head>

<body>
    <?php require 'views/header.php' ?>
    <div id="main">
    <h1 class="center">esta en Pelicula</h1>
    <div class="center">
    <div id="message" class="center">
            <?php echo $this->message; ?>
        </div>
        
    <form action="<?php echo constant('URL');?>pelicula/registrar-pelicula" method="post">
            <p>
                <label for="codigo">Codigo</label><br>
                <input type="text" name="codigo" id="codigo" required>
            </p>
            <p>
                <label for="nombre">Nombre</label><br>
                <input type="text" name="nombre" id="nombre" required>
            </p>
          
            <p>
                <label for="duracion">Duración</label><br>
                <input type="time" name="duracion" id="duracion" step="1" required>
            </p>
            <p>
                <label for="genero">Seleccione genero</label><br>
                <select name="genero_id" id="genero_id" required>
                    <option name ="option" id="option" value="">seleccione</option>
                    <?php
                    $index = 0;
                        foreach($this->generos as $id => $nombre){
                    ?>
                        <option value="<?php echo $id;?>"> <?php echo $nombre; ?></option>
                    <?php
                    $index = $index +1;
                    echo $index;
                        }
                    ?>
                </select>
               
            </p>
           
            <input id="submit" type="submit" value="Registrar Pelicula">
            <input id="edit" type="button" value="Editar Pelicula" disabled>
            <input id="limpiar" type="button" value="Limpiar">
            
        </form>

    </div>
        <table>
            <thead>
                <tr>
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th>Duración</th>
                    <th>Genero</th>
                    <th></th>
                    <th></th>

                </tr>

            </thead>
            <tbody id="tbody-peliculas">
            <?php
                foreach ($this->peliculas as $pelicula){
            ?>
                <tr id="fila-<?php echo $pelicula->codigo;?>">
                    <td><?php echo $pelicula->codigo; ?></td>
                    <td ><?php echo $pelicula->nombre; ?></td>
                    <td ><?php echo $pelicula->duracion; ?></td>
                    <td ><?php echo $this->generos[$pelicula->genero_id]; ?></td>
                    <td><button class="editar" 
                                data-id="<?php echo $pelicula->codigo; ?>" 
                                data-nombre="<?php echo $pelicula->nombre; ?>"
                                data-duracion="<?php echo $pelicula->duracion; ?>"
                                data-genero_id="<?php echo $pelicula->genero_id; ?>"
                                data-genero_nombre="<?php echo $this->generos[$pelicula->genero_id]; ?>">
                            Editar
                        </button>
                    </td>
                    <td><a href="<?php  echo constant('URL') . 'pelicula/eliminar-pelicula/' . $pelicula->codigo ?>">Eliminar</a></td>
                </tr>
            <?php  }?>
            </tbody>
        </table>


    </div>
    <?php require 'views/footer.php' ?>
</body>

</html>

<script>

//manda los datos a editar
const edits = document.querySelectorAll(".editar");

edits.forEach(edit=>{
    edit.addEventListener("click",function(){ 

        const id = this.dataset.id;
        const nombre = this.dataset.nombre;
        const duracion = this.dataset.duracion;
        const genero_id = this.dataset.genero_id;
        const genero_nombre = this.dataset.genero_nombre;

        document.querySelector("#codigo").value = id;
        document.querySelector("#codigo").disabled= true;
        document.querySelector("#nombre").value = nombre;
        document.querySelector("#duracion").value = duracion;
        document.getElementById("option").value = genero_id;
        document.getElementById("option").textContent = genero_nombre;
        document.getElementById("edit").disabled = false;
        document.getElementById("submit").disabled = true;


    })
});
//limpia el formulario
document.getElementById("limpiar").addEventListener("click",function(){
    document.querySelector("#codigo").value = '';
    document.querySelector("#codigo").disabled= false;
    document.querySelector("#message").textContent = '';
    document.querySelector("#nombre").value = '';
    document.getElementById("duracion").value = '';
    document.getElementById("edit").disabled = true;
    document.getElementById("submit").disabled = false;
});
//genera formulario para editar tipo POST
document.getElementById("edit").addEventListener("click",function(){
   
    const form = document.createElement('form');
    form.hidden = true;
    form.method = 'post';
    form.action = "<?php echo constant('URL');?>" + "pelicula/editar-pelicula";
    document.body.appendChild(form);

    const formField1 = document.createElement('input');
    formField1.name = 'codigo';
    formField1.value = document.querySelector("#codigo").value;

    const formField2 = document.createElement('input');
    formField2.name = 'nombre';
    formField2.value = document.querySelector("#nombre").value;

    const formField3 = document.createElement('input');
    formField3.name = 'duracion';
    formField3.type = 'time';
    formField3.step = '1';
    formField3.value = document.querySelector("#duracion").value;

    const formField4 = document.createElement('input');
    formField4.name = 'genero_id';
    formField4.value = document.querySelector("#genero_id").value;
    
    form.appendChild(formField1);
    form.appendChild(formField2);
    form.appendChild(formField3);
    form.appendChild(formField4);

    form.submit();
})
</script>