<?php
if(!$pdo = $modx->getService("pdoFetch")){
    return "Не удалось загрузить сервис pdoFetch!";
}
require MODX_CORE_PATH.'/components/barcodegenerator/vendor/autoload.php';
$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
$ref = new ReflectionClass('Picqer\Barcode\BarcodeGeneratorPNG');
$png = $generator->getBarcode($code, $ref->getConstant($type_code));
//echo $tpl;
return $pdo->getChunk($tpl,['barcode_base64'=>base64_encode($png)]);