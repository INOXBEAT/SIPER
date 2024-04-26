<?php
require 'controlpanel.php';

session_start();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

function agregarAlCarrito($producto)
{
    foreach ($_SESSION['carrito'] as $index => $item) {
        if ($item['id'] == $producto['id']) {
            $_SESSION['carrito'][$index]['cantidad'] += $producto['cantidad'];
            return;
        }
    }
    $_SESSION['carrito'][] = $producto;
}

function quitarDelCarrito($producto_id)
{
    foreach ($_SESSION['carrito'] as $index => $item) {
        if ($item['id'] == $producto_id) {
            unset($_SESSION['carrito'][$index]);
            break;
        }
    }
    $_SESSION['carrito'] = array_values($_SESSION['carrito']);
}

function actualizarCantidadEnCarrito($producto_id, $nueva_cantidad)
{
    foreach ($_SESSION['carrito'] as $index => $item) {
        if ($item['id'] == $producto_id) {
            $_SESSION['carrito'][$index]['cantidad'] = $nueva_cantidad;
            break;
        }
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['agregar'])) {
        $producto = [
            'id' => $_POST['id'],
            'nombre' => $_POST['nombre'],
            'precio' => $_POST['precio'],
            'cantidad' => $_POST['cantidad']
        ];
        agregarAlCarrito($producto);
    } elseif (isset($_POST['quitar'])) {
        $producto_id = $_POST['producto_id'];
        quitarDelCarrito($producto_id);
    } elseif (isset($_POST['actualizar_cantidad'])) {
        $producto_id = $_POST['producto_id'];
        $operacion = $_POST['operacion'];

        $cantidad_actual = 1;

        foreach ($_SESSION['carrito'] as $item) {
            if ($item['id'] == $producto_id) {
                $cantidad_actual = $item['cantidad'];
                break;
            }
        }

        if (!isset($cantidad_actual)) {
            $cantidad_actual = 1; 
        }

        if ($operacion == '+') {
            $nueva_cantidad = $cantidad_actual + 1;
        } elseif ($operacion == '-') {
            $nueva_cantidad = max(1, $cantidad_actual - 1);
        }

        actualizarCantidadEnCarrito($producto_id, $nueva_cantidad);
    } elseif (isset($_POST['confirmar_venta'])) {
        foreach ($_SESSION['carrito'] as $item) {
            $query = "UPDATE productos SET cantidad = cantidad - {$item['cantidad']} WHERE id = {$item['id']}";
            if (!mysqli_query($mysqli, $query)) {
                die("Error al actualizar inventario: " . mysqli_error($mysqli));
            }
        }
        $_SESSION['carrito'] = [];
        echo "<script>alert('Venta confirmada');</script>";
    }
}


$sql = "SELECT * FROM productos";
$resultado = mysqli_query($mysqli, $sql);

if (!$resultado) {
    die("Error al consultar la base de datos: " . mysqli_error($mysqli));
}

$productos = [];
while ($fila = mysqli_fetch_assoc($resultado)) {
    $productos[] = $fila;
}

$total = 0;
foreach ($_SESSION['carrito'] as $item) {
    $total += $item['precio'] * $item['cantidad'];
}
?>

<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>

            <div class="container" style="position: sticky;">
                <div class="container">
                    <div>
                        <h1>Total: $<?php echo $total; ?></h1>
                        <form method="post">
                            <button type="submit" name="confirmar_venta" class="btn btn-success btn-lg" style="font-size: 30px;">CONFIRMAR VENTA</button>
                        </form>
                    </div>
                </div>


                <div class="card" style="margin: 30px 20px;">

                    <div class="form-group">
                        <label for="buscar"></label>
                        <input type="text" class="form-control-lg" id="buscar" placeholder="Buscar producto..." style="font-size: 30px; padding: 10px 15px; width: 95%;">
                        <div id="resultados"></div>
                    </div>

                    <div class="card-body">
                        <table class="table" id="carrito" style="font-size: 25px;">
                            <thead>
                                <tr>
                                    <th>NOMBRE</th>
                                    <th>CANTIDAD</th>
                                    <th>PRECIO</th>
                                    <th>TOTAL</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 25px;">
                                <?php
                                foreach ($_SESSION['carrito'] as $item) {
                                    $producto_id = $item['id'];
                                    $producto_nombre = $item['nombre'];
                                    $producto_cantidad = $item['cantidad'];
                                    $producto_precio = $item['precio'];
                                    $precio_total = $producto_precio * $producto_cantidad;

                                    echo "<tr>
                    <td>{$producto_nombre}</td>
                        <td>
                            <form method='post' style='display:inline;'>
                                <input type='hidden' name='producto_id' value='{$producto_id}'>
                                <input type='hidden' name='operacion' value='-'>
                                <button type='submit' name='actualizar_cantidad' class='btn btn-secondary'>-</button>
                            </form>
                            {$producto_cantidad}
                            <form method='post' style='display:inline;'>
                                <input type='hidden' name='producto_id' value='{$producto_id}'>
                                <input type='hidden' name='operacion' value='+'>
                                <button type='submit' name='actualizar_cantidad' class='btn btn-secondary'>+</button>
                            </form>
                        </td>
                        <td>\${$producto_precio}</td>
                        <td>\${$precio_total}</td>
                        <td>
                            <form method='post' style='display:inline;'>
                                <input type='hidden' name='producto_id' value='{$producto_id}'>
                                <button type='submit' name='quitar' class='btn btn-danger' style='font-size: 25px;'>QUITAR</button>
                            </form>
                        </td>
                </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>



                </div>
        </main>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        var productos = <?php echo json_encode($productos); ?>;

        $('#buscar').on('input', function() {
            var query = $(this).val().toLowerCase();
            var resultados = '';

            if (query !== '') {
                resultados = productos
                    .filter(producto => producto.nombre.toLowerCase().includes(query))
                    .map(producto => `<div>
                                    ${producto.nombre} - ${producto.precio}
                                    <form method='post' style='display:inline; 'font-size: 30px;'>
                                        <input type='hidden' name='id' value='${producto.id}'>
                                        <input type='hidden' name='nombre' value='${producto.nombre}'>
                                        <input type='hidden' name='precio' value='${producto.precio}'>
                                        <input type='number' name='cantidad' min='1' value='1'>
                                        <button type='submit' name='agregar' class='btn btn-success'>Agregar</button>
                                    </form>
                                  </div>`)
                    .join('');
            }

            $('#resultados').html(resultados);
        });
    });



    $(document).ready(function() {
    var calcularTotal = function() {
        var total = 0;
        $('#carrito tbody tr').each(function() {
            var precio = parseFloat($(this).find('td:eq(2)').text().replace('$', ''));
            var cantidad = parseInt($(this).find('.cantidad').text()); 
            total += precio * cantidad;
        });
        $('#total').text("Total: $" + total.toFixed(2));
    };

    calcularTotal(); 

    $('#carrito tbody').on('click', 'button', function(e) {
        var form = $(this).closest('form'); 
        var cantidad_actual = parseInt($(this).closest('td').text().trim(), 10); 

        if ($(this).text() === '+') {
            cantidad_actual++;
        } else if ($(this).text() === '-') {
            cantidad_actual = Math.max(1, cantidad_actual - 1);
        }

        form.siblings('.cantidad').text(cantidad_actual); 
        calcularTotal(); 

    });
});



</script>