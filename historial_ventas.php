<?php

require 'controlpanel.php';
require 'conexion.php';

$resultado = $mysqli->query("SELECT * FROM historial");

?>





<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>

<div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title" style="font-size: 40px;"><b>HISTORIAL DE VENTAS</b></h3>
                  
                    <div class="acciones" style="margin-right: 30px; display:flex; align-items:center; justify-content:right;">
                            <a href="generar_reportes.php?formato=pdf"><img src="pdf_icon.png" alt="PDF" style="width: 60px; height: 60px;"></a>
                            <a href="generar_reportes.php?formato=excel"><img src="excel_icon.png" alt="Excel" style="width: 60px; height: 60px;"></a>
                        </div>

                </div>

                <div class="card-body">
                    <table id="datatablesSimple" style="font-size: 25px;">
                        <thead>
                            <tr>
                                <th>FECHA</th>
                                <th>VENDEDOR</th>
                                <th>PRODUCTO</th>
                                <th>CANTIDAD</th>
                                <th>PRECIO UNIDAD</th>
                                <th>TOTAL</th>
                                <th>FORMA DE PAGO</th>    
                            </tr>
                        </thead>
                        <tbody style="font-size: 25px;">
                            <?php
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                
                                $total = $fila['cantidad'] * $fila['precio'];

                                echo "<tr>
                        <td>{$fila['fecha']}</td>
                        <td>{$fila['usuario']}</td>
                        <td>{$fila['producto']}</td>
                        <td>{$fila['cantidad']}</td>
                        <td>\${$fila['precio_unitario']}</td>
                        <td>\${$fila['precio_total']}</td>
                        <td>\${$fila['forma_pago']}</td>";
                                
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>

        </main>
    </div>
</div>


<?php


if ($resultado) {
    $resultado->close();
}

$mysqli->close();
?>