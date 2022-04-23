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
    <h1 class="center">esta en genero</h1>
    <div class="center">
    <div id="message" class="center">
            <?php echo $this->message; ?>
        </div>
        
    <form action="<?php echo constant('URL');?>genero/registrar-genero" method="post">
            <p>
                <label for="codigo">Codigo</label><br>
                <input type="text" name="codigo" id="codigo" required>
            </p>
            <p>
                <label for="nombre">Nombre</label><br>
                <input type="text" name="nombre" id="nombre" required>
            </p>
           
            <input id="submit" type="submit" value="Registrar Genero">
            <input id="edit" type="button" value="Editar Genero" disabled>
            <input id="limpiar" type="button" value="Limpiar">
            
        </form>

       </div>
        <table>
            <thead>
                <tr>
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th></th>
                    <th></th>

                </tr>

            </thead>
            <tbody id="tbody-generos">
            <?php
                foreach ($this->generos as $genero){
            ?>
                <tr id="fila-<?php echo $genero->id;?>">
                    <td><?php echo $genero->id; ?></td>
                    <td ><?php echo $genero->nombre; ?></td>
                    <td><button class="editar" data-id="<?php echo $genero->id; ?>" data-nombre="<?php echo $genero->nombre; ?>"> Editar</button></td>
                <!--    <td><button class="eliminar" data-id="<?php echo $genero->id; ?>" data-nombre="<?php echo $genero->nombre; ?>"> Eliminar</button></td>
                -->
                    <td><a href="<?php  echo constant('URL') . 'genero/eliminar-genero/' . $genero->id ?>">Eliminar</a></td>
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
        document.querySelector("#codigo").value = id;
        document.querySelector("#codigo").disabled= true;
        document.querySelector("#nombre").value = nombre;
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
    document.getElementById("edit").disabled = true;
    document.getElementById("submit").disabled = false;
});

document.getElementById("edit").addEventListener("click",function(){
    console.log(document.querySelector("#codigo").value);
    console.log(document.querySelector("#nombre").value);
    const form = document.createElement('form');
    form.hidden = true;
    form.method = 'post';
    form.action = "<?php echo constant('URL');?>" + "genero/editar-genero";
    document.body.appendChild(form);

    const formField1 = document.createElement('input');
    formField1.name = 'codigo';
    formField1.value = document.querySelector("#codigo").value;

    const formField2 = document.createElement('input');
    formField2.name = 'nombre';
    formField2.value = document.querySelector("#nombre").value;
    
    form.appendChild(formField1);
    form.appendChild(formField2);
    
    form.submit();

})


const botones = document.querySelectorAll(".eliminar");
botones.forEach( boton=>{
    boton.addEventListener("click",function (){
        const id = this.dataset.id;
        const nombre = this.dataset.nombre;
        const confirm = window.confirm("¿Esta seguro de Eliminar al genero con nombre: " + nombre);
        if (confirm){
            //solicitud ajax
            httpRequest("<?php echo constant('URL');?>" + "genero/eliminar-genero/"+ id,function (){
                console.log(this.responseText);
                document.querySelector("#message").innerHTML = this.responseText;
                const tbody = document.querySelector("#tbody-generos");
                const fila = document.querySelector("#fila-"+ id);
                fila.remove();
            });
        }
    })
});

function httpRequest(url,callback){
    const http = new XMLHttpRequest();
    http.open("GET",url);
    http.send();
    http.onreadystatechange = function (){
        if(this.readyState == 4 && this.status == 200){
            callback.apply(http);
        }
    }
}
</script>

