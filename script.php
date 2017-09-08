<?php

include_once(__DIR__ . DIRECTORY_SEPARATOR . 'CfdiInfoWrapper.php');

//Usuario y password de autenticacion en INSIGNA
$user='usuario';
$password='password';

$uuid='e08b6418-5f55-428a-b5eb-d469531ada1b';
$transactionId='tr01';

$cfdi_info= new CfdiInfoWrapper($user,$password);
$cfdi_info->getCfdiInfo($uuid, $transactionId);
echo ($cfdi_info->getResponseCode());  
echo ("\n");
echo ($cfdi_info->getResponseDescription());
echo ("\n");
echo ($cfdi_info->getTransactionId());
echo ("\n");
echo ($cfdi_info->getServerTransactionId());
echo ("\n");
echo ($cfdi_info->getRequestDate());
echo ("\n");
echo ($cfdi_info->getResponseDate());
echo ("\n");
echo ($cfdi_info->getExecutionTime());

?>