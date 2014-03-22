<?php

/**
 * Класс отправки email через php библиотеку swift
 */
class Email {
    
    private $mailer;

    public function __construct() 
    {
        include_once 'library/swift/lib/swift_required.php';
        include_once 'config.php';

        $config = Config::get_config();

        switch ($config['email']['driver'])
        {
            case 'smtp':
                    // устанавливаем порт
                    $port = empty($config['email']['options']['port']) ? 25 : (int) $config['email']['options']['port'];

                    // создаём SMTP Transport
                    $transport = Swift_SmtpTransport::newInstance($config['email']['options']['hostname'], $port);

                    if ( ! empty($config['email']['options']['encryption']))
                    {
                            // устанавливаем шифрование
                            $transport->setEncryption($config['email']['options']['encryption']);
                    }

                    // далаем аутентификацию, если это необходимо для DSN
                    empty($config['email']['options']['username']) or $transport->setUsername($config['email']['options']['username']);
                    empty($config['email']['options']['password']) or $transport->setPassword($config['email']['options']['password']);

                    // устанавливаем таймаут на 5 секунд
                    $transport->setTimeout(empty($config['email']['options']['timeout']) ? 5 : (int) $config['email']['options']['timeout']);
            break;
            case 'sendmail':
                    // устанавливаем sendmail соединение
                    $transport = Swift_SendmailTransport::newInstance(empty($config['email']['options']) ? "/usr/sbin/sendmail -bs" : $config['email']['options']);

            break;
            default:
                    // используем стандартное соединение
                    $transport = Swift_MailTransport::newInstance($config['email']['options']);
            break;
        }

        return $this->mailer = Swift_Mailer::newInstance($transport);
    }
    
    /**
     * Функция отправки email
     *
     * @param   string $to   кому отправляется email
     * @param   string $from от кого отправляется email
     * @param   string $subject заголовок email
     * @param   string $message текст письма
     * @param   bool   $html использовать html разметку
    */
    public function send($to, $from, $subject, $message, $html = FALSE)
    {
            $html = ($html === TRUE) ? 'text/html' : 'text/plain';

            $message = Swift_Message::newInstance($subject, $message, $html, 'utf-8');

            if (is_string($to))
            {
                    $message->setTo($to);
            }
            elseif (is_array($to))
            {
                    if (isset($to[0]) AND isset($to[1]))
                    {
                            $to = array('to' => $to);
                    }

                    foreach ($to as $method => $set)
                    {
                            if ( ! in_array($method, array('to', 'cc', 'bcc'), true))
                            {
                                    $method = 'to';
                            }

                            $method = 'add'.ucfirst($method);

                            if (is_array($set))
                            {
                                    $message->$method($set[0], $set[1]);
                            }
                            else
                            {
                                    $message->$method($set);
                            }
                    }
            }

            if (is_string($from))
            {
                    $message->setFrom($from);
            }
            elseif (is_array($from))
            {
                    $message->setFrom($from[0], $from[1]);
            }

            return $this->mailer->send($message);
    }
}