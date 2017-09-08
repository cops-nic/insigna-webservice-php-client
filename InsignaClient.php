<?php

class InsignaClient
{
    
    protected $soapClient;
    
    protected $responseCode;
    protected $responseDescription;
    protected $transactionId;
    protected $serverTransactionId;
    protected $requestDate;
    protected $responseDate;
    protected $executionTime;


    
    private $wsseUser;
    private $wssePassword;
    
    protected $wsseHeader;
    protected $soapResult;
    //Constructor que inicializa el objeto.
    public function __construct($wsseUser, $wssePassword)
    {
        
        $this->wsseUser     = $wsseUser;
        $this->wssePassword = $wssePassword;
        $this->initializeWsse();
        $this->initializeSoapClient();
    }
    //En este m�todo inicializamos el header para implementar wsse en 
    //el cliente.
    private function initializeWsse()
    {
       $this->wsseHeader = 
'<wsse:Security env:mustUnderstand="1"   xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" ' . ' xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" ' . ' xmlns:wsu="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-utility-1.0.xsd"' . ' xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"> ' . ' <wsse:UsernameToken><wsse:Username>' .
$this->wsseUser .
 '</wsse:Username> ' . ' <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-' . 'wss-username-token-profile-1.0#PasswordText">' . 
$this->wssePassword . 
'</wsse:Password></wsse:UsernameToken></wsse:Security>';
        
        
        $this->wsseHeader = new SoapVar($this->wsseHeader, XSD_ANYXML);
        //En esta parte dejamos listo el SoapHeader que vamos a utilizar 
        //cada vez que hagamos un request con el cliente Soap.            
        $this->wsseHeader = new SoapHeader('http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd', 'Security', $this->wsseHeader, true);
        
        
    }
    
    //En este m�todo inicializamos el cliente soap con sus respectivos 
    //par�metros:
    //Url del wsdl, versi�n de soap:1_2,
    //le especificamos que no ponga en cache el wsdl, 
    //y le indicamos que utilizar� ssl como m�todo de encryptamiento.

    private function initializeSoapClient()
    {
        $this->soapClient = new SoapClient('https://beta.ws.insigna.mx/services?wsdl', array(
            'soap_version' => SOAP_1_2,
            'cache_wsdl' => WSDL_CACHE_NONE,
            'ssl_method' => SOAP_SSL_METHOD_TLS
        ));
		
    }
    //M�todo que devuelve el c�digo de respuesta.
    public function getResponseCode()
    {
        return $this->responseCode;
    }
    //M�todo que devuelve la descripci�n de la respuesta.
    public function getResponseDescription()
    {
        return $this->responseDescription;
    }
        //M�todo que devuelve el transaction id.
    public function getTransactionId()
    {
        return $this->transactionId;
    }
    //M�todo que devuelve server transaction id.
    public function getServerTransactionId()
    {
        return $this->serverTransactionId;
    }
    //M�todo que devuelve el requestDate.
    public function getRequestDate()
    {
        return $this->requestDate;
    }
    //M�todo que devuelve el responseDate.
    public function getResponseDate()
    {
        return $this->responseDate;
    }
    //M�todo que devuelve el executionTime.
    public function getExecutionTime()
    {
        return $this->executionTime;
    }
}

?>