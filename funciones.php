<?php
require_once("BiciElectrica.php");

// Leer el fichero csv y devuelve una tabla de bicicletas
function cargarbicis(): array
{
    $fich = @fopen("Bicis.csv", "r");
    if ($fich == false) {
        die("Error al abrir el fichero");
    }
    $tabla = [];

    while ($valor = fgetcsv($fich)) {
        list($id, $cx, $cy, $bat, $op) = $valor;
        $bici = new BiciElectrica($id, $cx, $cy, $bat, $op);
        $tabla[] = $bici;
    }

    return $tabla;
}
// Devuelve una cadena con la tabla html de bicis operativas
function mostrartablabicis($tabla): string
{
    $cadena = "<table><tr><th>Id</th><th>Coord X</th><th>Cood Y</th><th>Bateria</th></tr>";
   foreach($tabla as $bici) {
   $cadena.= $bici -> id. $bici -> coordx. $bici -> coordy. $bici -> bateria. $bici -> operativa;
   if ($bici->operativa) {
    $cadena .= "<tr><td>{$bici->id}</td><td>{$bici->coordx}</td><td>{$bici->coordy}</td><td>{$bici->bateria} %</td></tr>";
     }
   }
    $cadena .="</table>";

    return $cadena;
}


/**
 * Devuelve la bici con menor distancia a las coordenadas de usuario. 
 * @param $tabla - tabla de bicicletas
 * @param $x - Coordenada x de usuario
 * @param $y - Coordenada x de usuario
 * @return $bicicleta más cercana o null
 */
function bicimascercana($tabla, $x, $y)
{
    $bicicerca = null;
    $menor = null;

    foreach ($tabla as $bici) {
        if (!$bici->operativa) {
            continue; // solo bicis disponibles
        }
        $d = $bici->distancia($x, $y);
        if ($menor === null || $d < $menor) {
            $menor = $d;
            $bicicerca = $bici;
        }
    }

    return $bicicerca;
}

