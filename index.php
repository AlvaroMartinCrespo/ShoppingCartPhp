<?php
session_start();


require_once('./productos.php');
require_once('./funciones.php');

//Aquí puedes inicializar, si procede, la variable de sesión de la cesta
//La estructura de la cesta puede ser simplemente un array cuyas claves se correspondan a los 
//identificadores de los productos y cuyo valor sea el número de unidades de ese producto en la cesta
//Puedes sacar el resto de la información cruzando la información de la cesta con el array producto 


//Creación de la session cesta, sino esta creada.
if (!isset($_SESSION['cesta'])) {

  $_SESSION['cesta'] = [
    'producto' => [
      'nombre' => [],
      'precio' => [],
      'urlImg' => [],
      'cantidad' => [],
      'urlImgMiniatura' => [],
    ],
    'precioTotal' => 0,
    'cantidadTotal' => 0,
  ];
}

//Aquí puedes gestionar los post. Hay varias funcionalidades en la página (dos formularios): 
//incluir en cesta, subir un determinado producto en una unidad y bajar un determinado producto 
//de la cesta en una unidad. La manera de sacar los productos de la cesta es poner a 0 el número 
//de unidades que hay en la cesta

//Si se quiere modificar algun producto de la cesta
if (isset($_POST['modificarProd'])) {

  //Se obtiene el nombre y dependiendo de si es el simbolo - o +, le suma uno o le resta uno a la cantidad del producto
  $nombreProd = array_keys($_POST['modificarProd'])[0];
  if (array_values($_POST['modificarProd'])[0] === '-') {
    updateCesta($nombreProd, 'resta');
  } else if (array_values($_POST['modificarProd'])[0] === '+') {
    updateCesta($nombreProd, 'suma');
  }
}

//Gestión del POST
if (comprobarProdPOST($productos)) {

  $nombreProd = array_keys($_POST)[0];
  //Buscamos el índice del productos.
  $indiceProd = comprobarIndiceProd($nombreProd, $productos);
  //Una vez obtenido el índice el producto, insertarmos sus datos en la session cesta
  insertarProdEnCesta($indiceProd, $productos);
}

//Obtenemos el precio total y la cantidad total de los productos
precioTotal();
cantidadTotal();

$the_basket = getBasketMarkup();
$the_products = getProductosMarkup();
include('./home.tpl.php');
