<?php

/** La siguiente función debe generar el código HTML de la cesta, y su formulario asociado
 * Ten presente los ámbitos de las variables y los modificadores que puedes utilizar para cambiarlo
 */
function getBasketMarkup()
{
  $basket_markup = '<form action="./index.php" method="post">
  <p><strong>Número de items:</strong> ' . $_SESSION['cesta']['cantidadTotal'] . '</p>
  <p><strong>Precio total:</strong> $ ' . $_SESSION['cesta']['precioTotal'] . '</p>
  <hr />
';
  for ($i = 0; $i < count($_SESSION['cesta']['producto']['nombre']); $i++) {
    if ($_SESSION['cesta']['producto']['cantidad'][$i] != 0) {
      $basket_markup .= '  <div class="cItemContainer">
    <div class="cFoto"><img src="' . $_SESSION['cesta']['producto']['urlImgMiniatura'][$i] . '" /></div>
    <div class="cNombreProducto"><h3>' . $_SESSION['cesta']['producto']['nombre'][$i] . '</h3></div>
    <input type="submit" value="-" name="modificarProd[' . $_SESSION['cesta']['producto']['nombre'][$i] . ']"/> ' . $_SESSION['cesta']['producto']['cantidad'][$i] . ' <input type="submit" value="+" name="modificarProd[' . $_SESSION['cesta']['producto']['nombre'][$i] . ']"/>
    <strong>Precio:</strong> $ ' . intval($_SESSION['cesta']['producto']['precio'][$i]) * intval($_SESSION['cesta']['producto']['cantidad'][$i]) . '
  </div>';
    }
  }

  return $basket_markup;
}

/** La siguiente función debe generar el código HTML de los productos, con sus botones de 'add to cart' cesta
 * Ten presente los ámbitos de las variables y los modificadores que puedes utilizar para cambiarlo
 */
function getProductosMarkup()
{
  $productos_markup = '<!-- Producto-->
<form action="./index.php" method="post">
  <div class="cProductoContainer">
    <img src="./images/product-5-270x280.png" alt="" width="270" height="280" />
    <input type="submit" value="Incluir en cesta" name="Avocados" />
    <h4>Avocados</h4>
    <p><strong>$ 28.00</strong></p>
  </div>
  <!-- Producto-->
  <div class="cProductoContainer">
    <img src="./images/product-5-270x280.png" alt="" width="270" height="280" />
    <input type="submit" value="Incluir en cesta" name="Corn" />
    <h4>Corn</h4>
    <p><strong>$ 27.00</strong></p>
  </div>
  <!-- Producto-->
  <div class="cProductoContainer">
    <img src="./images/product-5-270x280.png" alt="" width="270" height="280" />
    <input type="submit" value="Incluir en cesta" name="Artichokes" />
    <h4>Artichokes</h4>
    <p><strong>$ 23.00</strong></p>
  </div>
  <!-- Producto-->
  <div class="cProductoContainer">
    <img src="./images/product-5-270x280.png" alt="" width="270" height="280" />
    <input type="submit" value="Incluir en cesta" name="Broccoli" />
    <h4>Broccoli</h4>
    <p><strong>$ 25.00</strong></p>
  </div>
</form>

';

  return $productos_markup;
}

/**
 * Esta función suma uno a uno los precios y los multiplica por la cantdad del producto obteniendo
 * el precio total de todos los productos
 */
function precioTotal()
{
  $precioTotal = 0;
  for ($i = 0; $i < count($_SESSION['cesta']['producto']['nombre']); $i++) {
    $precioTotal += intval($_SESSION['cesta']['producto']['cantidad'][$i]) * intval($_SESSION['cesta']['producto']['precio'][$i]);
  }
  $_SESSION['cesta']['precioTotal'] = $precioTotal;
}

/**
 * Esta función suma las cantidades de cada producto obteniendo la cantidad total de todos 
 * los productos
 */
function cantidadTotal()
{
  $cantidadTotal = 0;
  for ($i = 0; $i < count($_SESSION['cesta']['producto']['nombre']); $i++) {
    $cantidadTotal += intval($_SESSION['cesta']['producto']['cantidad'][$i]);
  }
  $_SESSION['cesta']['cantidadTotal'] = $cantidadTotal;
}

/**
 * Esta función comprueba que un producto esta en la cesta, devuelve true si esta, y false sino esta.
 */
function comprobarProductoCesta($nombreProd)
{
  $encontrado = false;
  for ($i = 0; $i < count($_SESSION['cesta']['producto']['nombre']); $i++) {
    if ($_SESSION['cesta']['producto']['nombre'][$i] === $nombreProd) {
      $_SESSION['cesta']['producto']['cantidad'][$i] = intval($_SESSION['cesta']['producto']['cantidad'][$i]) + 1;
      $encontrado = true;
    }
  }
  return $encontrado;
}

/**
 * Esta función obtiene el índice de un producto para poder usar sus datos
 */
function comprobarIndiceProd($nombreProd, $productos)
{
  for ($i = 0; $i < count($productos); $i++) {
    if ($productos[$i]['nombre'] === $nombreProd) {
      return $i;
    }
  }
}

/**
 * Esta función inserta un producto y sus caracteristicas en la sessino de la cesta
 */
function insertarProdEnCesta($indiceProd, $productos)
{
  //Si el produco no se encuentra en la cesta, se añade, si se encuentra se le suma uno a a la cantidad
  if (!comprobarProductoCesta($productos[$indiceProd]['nombre'])) {
    array_push($_SESSION['cesta']['producto']['nombre'], $productos[$indiceProd]['nombre']);
    array_push($_SESSION['cesta']['producto']['precio'], $productos[$indiceProd]['precio']);
    array_push($_SESSION['cesta']['producto']['urlImg'], $productos[$indiceProd]['img_url']);
    array_push($_SESSION['cesta']['producto']['cantidad'], 1);
    array_push($_SESSION['cesta']['producto']['urlImgMiniatura'], $productos[$indiceProd]['img_miniatura']);
  }
}

/**
 * Esta función recibe como parámetro el nombre del producto a modificar y la 
 * operación, en esta caso suma o resta.
 */
function updateCesta($nombreProd, $operacion)
{
  for ($i = 0; $i < count($_SESSION['cesta']['producto']['nombre']); $i++) {
    if ($_SESSION['cesta']['producto']['nombre'][$i] === $nombreProd) {
      if ($operacion === 'suma') {
        $_SESSION['cesta']['producto']['cantidad'][$i] = intval($_SESSION['cesta']['producto']['cantidad'][$i]) + 1;
      } else if ($operacion === 'resta') {
        $_SESSION['cesta']['producto']['cantidad'][$i] = intval($_SESSION['cesta']['producto']['cantidad'][$i]) - 1;
      }
    }
  }
}

/**
 * Esta función comprueba que se pasa un producto existente por el POST
 */
function comprobarProdPOST($productos)
{
  $encontrado = false;
  for ($i = 0; $i < count($productos); $i++) {
    if (array_keys($_POST)[0] === $productos[$i]['nombre']) {
      $encontrado = true;
    }
  }
  return $encontrado;
}
