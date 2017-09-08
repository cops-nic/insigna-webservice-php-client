<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . 'InsignaClient.php');

class CfdiInfoWrapper extends InsignaClient
{
    private $cfdi;
    private $uuid;
    private $cfdiStatus;
    
    public function __construct($wsseuser, $wssepassword)
    {
        //Se construye el padre de la clase(InsignaClient)
        parent::__construct($wsseuser, $wssepassword);
    }
    //En este método ingresamos los parámetros y los headers,
    //al cliente soap y llamamos a la operación del web service
    //que deseamos, que en este caso es getCfdiInfo. 
    public function getCfdiInfo($uuid, $transactionId)
    {
          try {
            
            //Arreglo que se va a utilizar para ingresar el wrapper
            //específico de esta operación(cfdiInfoWrapper), a la
            //solicitud soap.
            $param = array();
             
            //Arreglo que se va a utilizar para ingresar los
            //parámetros que se necesitan para el web service
            $parametros = array();
			
            $parametros[] = new SoapVar($uuid, XSD_STRING, null, null, 'ns1:uuid');
			$parametros[] = new SoapVar($transactionId, XSD_STRING, null, null, 'ns1:transactionId');
            $param[] = new SoapVar($parametros, SOAP_ENC_OBJECT, null, null, 'ns1:cfdiInfoWrapper');
  
            //Agregamos el header wsse el se construye en la clase
            //padre una vez que llamamos a su constructor. 
            $this->soapClient->__setSoapHeaders($this->wsseHeader);
            
            //Realizamos la llamada soap
            $this->soapResult = $this->soapClient->getCfdiInfo(new SoapVar($param, SOAP_ENC_OBJECT));

            
            //Obtenemos cada una de las propiedades de la respuesta
            //enviada por el webservice.
            $this->responseCode = $this->soapResult->return->responseCode;
            
            $this->responseDescription = $this->soapResult->return->responseDescription;
            $this->transactionId = $this->soapResult->return-> transactionId;
            $this->serverTransactionId = $this->soapResult->return-> serverTransactionId;
            $this->requestDate = $this->soapResult->return-> requestDate;
            $this->responseDate = $this->soapResult->return-> responseDate;
            $this->executionTime = $this->soapResult->return-> executionTime;
            
            $this->cfdi = isset($this->soapResult->return->cfdi)  ? 
            $this->soapResult->return->cfdi : '';
            
            $this->uuid = isset($this->soapResult->return->uuid) ?
            $this->soapResult->return->uuid : '';
            
            $this->cfdiStatus = isset($this->soapResult->return->cfdiStatus) ?
            $this->soapResult->return->cfdiStatus : '';
        }
        catch (SoapFault $e) {
            //En esta parte se manejan las excepciones mandadas por
            //el web service. 
			if(isset($e->detail->OperationFailed))
			{
				echo('Codigo de Error:' . $e->detail->OperationFailed->errorCode."\n");
				echo('Descripcion de Error:' . $e->detail->OperationFailed->errorDescription."\n");
				echo('ID de Transaccion:' . $e->detail->OperationFailed->serverTransactionId."\n");
				echo('Fecha de Solicitud:' . $e->detail->OperationFailed->requestDate."\n");
				echo('Fecha de Respuesta:' . $e->detail->OperationFailed->responseDate."\n");
				echo('Tiempo de Ejecucion:' . $e->detail->OperationFailed->executionTime."\n");
			}
			else
			{
				echo('Codigo de Error:' . $e->getCode()."\n");
				echo('Descripcion de Error:' . $e->detail->getMessage()."\n");
			}
		} 
}
    //Métodos que retornan el valor de cada uno de los parámetros.
    //de respuesta enviados por el webservice.
    public function getCfdi()
    {
        return $this->cfdi;
    }
    public function getUuid()
    {
        return $this->uuid;
    }
    public function getCfdiStatus()
    {
        return $this->cfdiStatus;
    }
}
?>