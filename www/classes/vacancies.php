<?php
//Определяем константы для внешнего сайта и портала росатом
define('PUBLIC_TYPE', 1);
define('PORTAL_TYPE', 2);
/**
 * Класс обработки вакансий Росатом
 * 
 * @author Denis Lushchenko <denis.lushchenko@gmail.com>
 * @since 11-02-2014
 */
class Vacancies {
    
    private $config;
    
    public function __construct() {
        include_once 'soap.php';
        include_once 'config.php';
        include_once 'email.php';
        include_once 'view.php';
                
        $this->config = Config::get_config();
        
        //определяем в настройках нужно ли отображать предупреждения
        if($this->config['is_set_errors'] == true)
        {
            ini_set('display_errors', 1);
            error_reporting(E_ALL);
        }
    }

    /**
     * Запись существующих id вакансий в файлы 
     * advertisements_portal.txt -  для портала росатом
     * advertisements_public.txt -  для внешнего сайт,
     * для последующего сравнения этих значений при появлении новых вакансий
    */
    public function init_data()
    {
        $this->write_data($this->get_advertisements_as_array(PUBLIC_TYPE), PUBLIC_TYPE);
        $this->write_data($this->get_advertisements_as_array(PORTAL_TYPE), PORTAL_TYPE);
    }
    
    /**
     * Функция записи id вакансий в файлы
     *
     * @param   array  $advertisements массив id вакансий типа array(31, 32, 33)
     * Если массив пустой, записывается пустая строчка в файл
     * @param   int    $type константа типа сайта, внешний или портал
    */
    private function write_data($advertisements, $type)
    {
        if(empty($advertisements))
            $result = '';
        else
            $result = implode(',',  $advertisements);
        $file = fopen(dirname(__FILE__).'/'.$this->get_data_file($type),"w+");
        fwrite($file,$result);
        fclose($file);
    }
    
    /**
     * Возвращает данные о вакансиях в виде массива либо id, либо с
     * полной информаций о вакансии
     *
     * @param   int    $type константа типа сайта, внешний или портал
     * @param   bool   $all_data флаг, который определяет формат возвращаемых данных
     *                 id или все данные вакансии (по умолчанию id)
     * @return  mixed  массив данных вакансий.
    */
    private function get_advertisements_as_array($type, $all_data = false)
    {
        $result_advert = array();
        $res_advertisements = $this->get_advertisements($type);
        if(is_object($res_advertisements->advertisementResult->advertisements->advertisement))
        {
            foreach ($res_advertisements->advertisementResult->advertisements as $advertisement)
            {
                if($all_data)
                    $result_advert[] = $advertisement;
                else
                    $result_advert[] = $advertisement->id;
            }
        }
        else
        {
            foreach ($res_advertisements->advertisementResult->advertisements->advertisement as $advertisement)
            {
                if($all_data)
                    $result_advert[] = $advertisement;
                else
                    $result_advert[] = $advertisement->id;
            }
        }
        return $result_advert;
    }
    
    /**
     * Возвращает id вакансий записанных в файлы
     *
     * @param   int    $type константа типа сайта, внешний или портал
     * @return  array  возвращает массив id вакансий
    */
    public function read_data($type)
    {
        $file = file(dirname(__FILE__).'/'.$this->get_data_file($type));
        //если файл пусто, возвращает пустой массив
        if(isset($file[0]))
        {
            $str = $file[0];
            $array = explode(",",$str);
            return $array;
        }
        else
            return array();
    }
    
   /**
     * Функция очистки файлов, хранящих id вакансий
    */
    public function clean_data()
    {
        $this->write_data('', PUBLIC_TYPE);
        $this->write_data('', PORTAL_TYPE);
    }
      
    /**
     * Функция сравнивает id вакансий загруженных с сервиса
     * с id вакансий хранимых в файлах. В случае если id вакансии нет в файлы
     * отсылается уведомление с новыми вакансиями.
     *
     * @param   int    $type константа типа сайта, внешний или портал
    */
    public function check_advertisements($type)
    {
        $email_content = '';
        
        $advertisements_data = $this->read_data($type);
        
        foreach ($this->get_advertisements_as_array($type, true) as $advertisement)
        {
            if(! in_array($advertisement->id, $advertisements_data))
            {
                $_GET['portal'] = $type;
                $_GET['id'] = $advertisement->id;
                $subject = 'Новая вакансия на Росатом: '.$advertisement->jobTitle;
                $this->send_notification(View::factory('email_view.php')->render(), 
                        $subject);
            }
            else
                echo 'nothing to send!<br />';
                
        }
        
        //перезаписывает файл с новыми id вакансий
        $this->write_data($this->get_advertisements_as_array($type), $type);
        
        if(! empty($email_content))
        {
            $this->send_notification($email_content, $type);
        }
        else {
            echo 'nothing to send!<br />';
        }
    }
    
    /**
     * Отправка уведомлений с новыми вакансиями
     *
     * @param   string  $content текст письма 
     * @param   string  $suject заголовок письма
    */
    public function send_notification($content, $suject)
    {
        $email = new Email();
        
        $email->send(
            $this->config['email']['to'],
            $this->config['email']['from'],
            $suject,
            $content,
            true
        );
        echo 'send success!<br />';
    }

    /**
     * Функция возвращает объекты вакансии добавленные через
     * сервис lumesse.com
     * 
     *http://developer.lumesse.com/docs/read/career_portal/FoAdvert
     * функция getAdvertisements
     * 
     * @param   int    $type константа типа сайта, внешний или портал
     * @return  mixed  объект вакансий
    */
    public function get_advertisements($type)
    {
        $tlk_soap = new TLK_SOAP($this->get_username($type).':guest:FO');
        $advertisements = new Advertisements();
        $advertisements->firstResult = 0;
        $advertisements->maxResults = 100;

        //функция getAdvertisements принимает объект Advertisements соответствующий
        //структуре передоверяемых данных в запросе
        $res_advertisements = $tlk_soap->getAdvertisements($advertisements);
        return $res_advertisements;
    }
    
    /**
     * Функция возвращает данные по конкретной вакансии из
     * сервис lumesse.com
     * 
     *http://developer.lumesse.com/docs/read/career_portal/FoAdvert
     * функция getAdvertisementById
     * 
     * @param   int    $type константа типа сайта, внешний или портал
     * @param   int    $id   id вакансии
     * @return  mixed  объект вакансий
    */
    public function getAdvertisementById($type, $id)
    {
        $tlk_soap = new TLK_SOAP($this->get_username($type).':guest:FO');
        
        //функция getAdvertisementById принимает объект Advertisement соответствующий
        //структуре передоверяемых данных в запросе. При инициализации объекта Advertisement
        //передаётся id вакансии и язык, на котором должен прийти результат запроса
        $result_advertisement = $tlk_soap->getAdvertisementById(new Advertisement($id, 'RU'));
        $advertisement = $result_advertisement->advertisement;
        return $advertisement;
    }
    
    /**
     * Возвращает значение кода пользователя в зависимости от типа сайта
     *
     * @param   int     $type константа типа сайта, внешний или портал
     * @return  string  $username
    */
    private function get_username($type)
    {
        $username = '';
        switch ($type) {
            case PUBLIC_TYPE:
                $username = $this->config['username']['public'];
                break;
            case PORTAL_TYPE:
                $username = $this->config['username']['portal']; 
                break;
        }
        
        return $username;
    }
    
    /**
     * Возвращает имя файла, куда будет записываться
     * id вакансий в зависимости от типа сайта
     *
     * @param   int     $type константа типа сайта, внешний или портал
     * @return  string  $username
    */
    private function get_data_file($type)
    {
        $file = '';
        switch ($type) {
            case PUBLIC_TYPE:
                $file = 'advertisements_public.txt';
                break;
            case PORTAL_TYPE:
                $file = 'advertisements_portal.txt'; 
                break;
        }
        
        return $file;
    }
}
