<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alquilar Peliculas</title>
</head>
<body>
<?php require 'views/header.php' ?>
    <div id="main">
        <h1 class="center"> Esta en Alquiler</h1>

        <div class="center">
            <div><?php echo $this->message;?></div>
        
        <form action="<?php echo constant('URL');?>alquiler/registrar-alquiler" method="post">
            <p>
                <label for="codigo">CODIGO</label> <br>
                <input type="text" name="codigo" id="codigo" required>
            </p>
            <p>
                <label for="fecha">Fecha</label><br>
                <input type="datetime-local" step="1"  name="fecha" id="fecha" required>
            </p>
            <p>
                <label for="monto">Monto</label><br>
                <input type="float" name="monto" id="monto" required>
            </p>
            <p>
                <label for="peliculas">Eliga las Peliculas</label> <br>
                <?php 
                    $index = 2;
                    
                    foreach($this->peliculas as $codigo => $nombre){ 
                        $index = $index +1;                
                ?>
                    <input type="checkbox" name="<?php echo $index;?>" id="<?php echo $codigo;?>" value="<?php echo $codigo;?>">
                    <label for="<?php echo $index;?>"><?php echo $nombre; ?></label>
                    
                <?php
                   
                    }
                ?>
            </p>
            <br>
        
            <input id="submit" type="submit" value="Registrar Alquiler">
            <input id="edit" type="button" value="Editar Alquiler" disabled>
            <input id="limpiar" type="button" value="Limpiar">
        </form>  
        </div>
        <br>
        
        <table>
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Fecha</th>
                        <th>Monto</th>
                        <th>Peliculas</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($this->alquileres as $alquiler){        
                    ?>
                    <tr>
                        <td><?php echo $alquiler->codigo;?></td>
                        <td><?php echo $alquiler->fecha;?></td>
                        <td><?php echo $alquiler->monto;?></td>
                        <td><?php 
                            foreach($alquiler->detalles as $detalle){
                                echo $this->peliculas[$detalle->pelicula_codigo] . ", ";
                            }
                        ?></td>
                        <td><button class="editar" 
                                    data-codigo="<?php echo $alquiler->codigo;?>"
                                    data-fecha ="<?php echo $alquiler->fecha;?>"
                                    data-monto ="<?php echo $alquiler->monto;?>"
                                    data-detalles= <?php echo json_encode($alquiler->detalles);?>>Editar
                            </button>
                        </td>
                        <td><a href="<?php echo constant('URL') .'alquiler/eliminar-alquiler/'.$alquiler->codigo ;?>">Eliminar</a></td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
        </table>

    </div>

<?php require 'views/footer.php' ?>
</body>
</html>

<script>

    document.getElementById("limpiar").addEventListener("click",function(){
        <?php 
             foreach($this->peliculas as $codigo => $nombre){
            ?>
              document.getElementById(<?php echo $codigo;?>).checked = false;
            <?php } ?>
            document.getElementById("codigo").value = '';
            document.getElementById("codigo").disabled = false;
            document.getElementById("fecha").value = '';
            document.getElementById("monto").value = '';
            document.getElementById("edit").disabled = true;    
    });


    const botonsEdit = document.querySelectorAll(".editar");
    botonsEdit.forEach(boton =>{
        boton.addEventListener("click",function(){
            const codigo = this.dataset.codigo;
            const fecha = this.dataset.fecha;
            const monto = this.dataset.monto;
            const detalles = JSON.parse(this.dataset.detalles);
            
            <?php 
             foreach($this->peliculas as $codigo => $nombre){
            ?>
              document.getElementById(<?php echo $codigo;?>).checked = false;
            <?php } ?>
           // console.log(detalles);
            detalles.forEach(detalle =>{   
                document.getElementById(detalle.pelicula_codigo).checked = true;  
            });
            document.getElementById("codigo").value = codigo;
            document.getElementById("codigo").disabled =true;
            document.getElementById("fecha").value = fecha.replace(" ","T");
            document.getElementById("monto").value = monto;

            document.getElementById("edit").disabled = false;
        });
    });


    document.getElementById("edit").addEventListener("click",function(){

        const form = document.createElement('form');
        form.hidden = true;
        form.method = 'post';
        form.action = "<?php echo constant('URL');?>" + "alquiler/editar-alquiler";
        document.body.appendChild(form);

        const formField1 = document.createElement('input');
        formField1.name = 'codigo';
        formField1.value = document.getElementById("codigo").value;

        const formField2 = document.createElement('input');
        formField2.name = 'fecha';
        formField2.type = "datetime-local";
        formField2.step = '1';
        formField2.value = document.getElementById("fecha").value;

        const formField3 = document.createElement('input');
        formField3.name = 'monto';
        formField3.type = 'float';
        formField3.value = document.getElementById("monto").value;

        form.appendChild(formField1);
        form.appendChild(formField2);
        form.appendChild(formField3);

        for(let index = 3; index<= <?php echo $index;?>; index++){
            if(document.querySelector(`input[name="${index}"]`).checked){
                let formField = document.createElement('input');
                formField.name = index;
                formField.type = 'checkbox';
                formField.checked = true;
                formField.value = document.querySelector(`input[name="${index}"]`).value;
                form.appendChild(formField);
            }
        }
        form.submit();

    });
</script>