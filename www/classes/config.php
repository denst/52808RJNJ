<?php 

/**
 * Класс с настройками
 * 
 * @author Denis Lushchenko <denis.lushchenko@gmail.com>
 * @since 11-02-2014
 */
class Config {
    
    static function get_config()
    {
        return array(

            //api_key используется для установки SOAP соединения (класс Soap)
            'api_key' => '84nsgp4236afhcmre7q4enfk',

            //end_point используется для установки SOAP соединения (класс Soap)
            'end_point' => 'https://api3.lumesse-talenthub.com/CareerPortal/SOAP/FoAdvert',

            //security_ns используется для установки SOAP соединения (класс Soap)
            'security_ns' => 'http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd',
            
            //password используется для установки SOAP соединения (класс Soap)
            'password' => 'guest',
            
            // username используется для получения вакансий в зависимости
            // от типа сайта, внешний сайт или портал ростатом (класс Vacancies)
            'username' => array(
                'public' => 'PLHFK026203F3VBQBV768F6LP',
                'portal' => 'PCGFK026203F3VBQBV768F6M1'
            ),
            
            // ключ, отвечающий за отображения предупреждений об ошибках
            'is_set_errors' => true,

            // конфигурация для отправки email
            'email' => array(

                /* SwiftMailer драйвера
                *
                * поддерживаемые драйвера: native, sendmail, smtp
                */
                'driver' => 'smtp',

                /* Опции драйвера:
                * @param   null    native: нет опций
                * @param   string  sendmail: executable path, with -bs or equivalent attached
                * @param   array   smtp: hostname, (username), (password), (port), (encryption)
                */
                'options' => array(
                    'hostname' => 'smtp.gmail.com',
                    'username' => 'denst.work@gmail.com',
                    'password' => 'sap68422',
                    'port'     => '465',
                    'encryption' => 'ssl'
                ),
                'to'          => 'denis.lushchenko@gmail.com',
                'from'        => 'denst.work@gmail.com',
//                'subject'     => 'новые вакансии Росатом',
                // постоянный текст для каждого email
//                'static_text' => '
//                    <div>Это статический текст который можно вставить<div>
//                    <div>Если очень нужно<div>
//                ',
            )
        );
    }
}
?>