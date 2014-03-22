<?php
//объект, соответствующий структуре данных, отправляемых для метода getAdvertisements
//http://developer.lumesse.com/docs/read/career_portal/FoAdvert
class Advertisements {
    public $firstResult;
    public $maxResult;
}

//объект, соответствующий структуре данных, отправляемых для метода getAdvertisementById
//http://developer.lumesse.com/docs/read/career_portal/FoAdvert
class Advertisement {
    public $postingTargetId;
    public $langCode;
    
    public function __construct($postingTargetId, $langCode) {
        $this->postingTargetId = $postingTargetId;
        $this->langCode = $langCode;
    }
}

/**
 * Класс для получения вакансий от веб-сервиса http://www.lumesse.com/
 */
class TLK_SOAP
{
	public $ws = null; // указатель для сохранения соединения с веб-сервисом
	
        //конфигурация соединения с сервисом http://www.lumesse.com/
        //для отправки SOAP запросов.
        //Все основные параметры собраны в классе настроек Сonfig
	function __construct($wsUsername)
	{
                include_once 'config.php';
                
                $config = Config::get_config();
                
		$soap_Username = new SoapVar($wsUsername, XSD_STRING, NULL, $config['security_ns'], NULL, $config['security_ns']);
		
		$soap_Password = new SoapVar($config['password'], XSD_STRING, NULL, $config['security_ns'], NULL, $config['security_ns']); 

		$soap_Auth = new WSSEAuth($soap_Username, $soap_Password);
		$soapVar_Auth = new SoapVar($soap_Auth, SOAP_ENC_OBJECT, NULL, $config['security_ns'], 'UsernameToken', $config['security_ns']); 
		$soap_Auth_Token = new WSSEToken($soapVar_Auth);
		$soapVar_Auth_Token = new SoapVar($soap_Auth_Token, SOAP_ENC_OBJECT, NULL, $config['security_ns'], 'UsernameToken', $config['security_ns']);
		$soapVar_Security = new SoapVar($soapVar_Auth_Token, SOAP_ENC_OBJECT, NULL, $config['security_ns'], 'Security', $config['security_ns']);  
		$soapVar_Header = new SoapHeader($config['security_ns'], 'Security', $soapVar_Security, true, "TlkPrincipal");
		try 
		{
			$this->ws = @new SoapClient($config['end_point'] . '?wsdl');
 			$this->ws->__setSoapHeaders(array($soapVar_Header));
                        $this->ws->__setLocation($config['end_point'] . '?api_key=' . $config['api_key']);
 		}
		catch (Exception $e) 
		{ 
			
			echo $e->getMessage();
		} 
	}
        
        public function getAdvertisements($params)
        {
            return $this->ws->getAdvertisements($params);
        }
        
        public function getAdvertisementById($object)
        {
            return $this->ws->getAdvertisementById($object);
        }
}

//Дополнительные классы, чтобы облегчить WSSE дополнение к стандартным SOAP запросам
class WSSEAuth 
{
	private $Username;
	private $Password;
	
	function __construct($username, $password) 
	{	
		$this->Username = $username;
		$this->Password = $password;
	}
}

class WSSEToken 
{
    private $UsernameToken;
    
	function __construct ($token)
	{
		$this->UsernameToken = $token;
    }
}

