<?php

require 'controlpanel.php';

?>

<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>


<h1>Módulo - Historial Ventas</h1>

<div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title" style="font-size: 40px;"><b>HISTORIAL DE VENTAS</b></h3>
                  
                </div>

                <div class="card-body">
                    <table id="datatablesSimple" style="font-size: 25px;">
                        <thead>
                            <tr>
                                <th>FECHA</th>
                                <th>HORA</th>
                                <th>PRODUCTO</th>
                                <th>CANTIDAD</th>
                                <th>PRECIO</th>
                                <th>TOTAL</th>   
                            </tr>
                        </thead>
                        <tbody style="font-size: 25px;">
                            <?php
                            while ($fila = mysqli_fetch_assoc($resultado)) {
                                
                                $total = $fila['cantidad'] * $fila['precio'];

                                echo "<tr>
                        <td>{$fila['fecha']}</td>
                        <td>{$fila['hora']}</td>
                        <td>{$fila['producto']}</td>
                        <td>{$fila['cantidad']}</td>
                        <td>\${$fila['precio']}</td>
                        <td>\${$fila['total']}</td>";
                                
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
