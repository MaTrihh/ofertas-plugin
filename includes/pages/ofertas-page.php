<?php

function ofertas_plugin_tabla_page(){
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
    <h2>Cupones creados</h2>
        <div class="containerDiv">
            <table>
                <thead>
                    <tr>
                        <th>Nombre Comercio</th>
                        <th>Titulo</th>
                        <th>Descripción</th>
                        <th>Unidades</th>
                        <th>Foto</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $resultados_por_pagina = 10;

                    // Página actual
                    $pagina_actual = isset ($_GET['pagina']) ? $_GET['pagina'] : 1;

                    // Calcular el offset
                    $offset = ($pagina_actual - 1) * $resultados_por_pagina;

                    $cupones = getOfertas($offset, $resultados_por_pagina);

                    $total_resultados = count(getOfertas());

                    $total_paginas = ceil($total_resultados / $resultados_por_pagina);

                    // Obtener la URL base de WordPress
                    $base_url = home_url();

                    // Obtener la parte de la URL después del nombre de dominio
                    $path = $_SERVER['REQUEST_URI'];

                    // Combinar la URL base con el resto de la URL
                    $url = $base_url . $path;

                    foreach ($cupones as $cupon) {
                        ?>
                        <tr>
                            <td>
                                <?php echo get_userdata($cupon->getIdAsociado())->first_name; ?>
                            </td>
                            <td>
                                <?php echo $cupon->getTitulo(); ?>
                            </td>
                            <td>
                                <?php echo $cupon->getDescripcion(); ?>
                            </td>
                            
                            <td>
                                <?php echo ($cupon->getUnidades() != -1) ? $cupon->getUnidades() : "Ilimitado"; ?>
                            </td>

                            <td>
                                <?php echo ($cupon->getFoto() != null) ? "<a href=". $cupon->getFoto() .">Ver Foto</a>" : ""; ?>
                            </td>
                                
                            <td>
                                <?php echo $cupon->getFechaInicio(); ?>
                            </td>

                            <td>
                                <?php echo $cupon->getFechaFin(); ?>
                            </td>

                            <td>
                                <button type="button" class="editar-cupon-btn">Editar</button>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- Paginación -->
        <div class="pagination">
            <?php if ($total_paginas > 1): ?>
                <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                    <a href=<?php echo $url . '&pagina=' . $i; ?>                 <?php echo ($pagina_actual == $i) ? 'class="active"' : ''; ?>><?php echo $i; ?></a>
                <?php endfor; ?>
            <?php endif; ?>
        </div>
        <?php
}

