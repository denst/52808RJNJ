<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
<link type="text/css" rel="stylesheet" media="screen" href="http://rosatom.ru/wps/wcm/connect/rosatom/rosatomsite/resources/559f2880435120c0b9efffc5687e4a83/style_site_bf.css">
</head>

<body>
<?php 
    include_once 'classes/vacancies.php';
    $vacancies = new Vacancies();
    // получаем данные объект вакансий для внешнего сайта росатом
    $res_advertisements = $vacancies->get_advertisements(PUBLIC_TYPE);
?>
<h1 id="title">Вакансии Госкорпорации</h1>
            <p style="MARGIN: 0px">В связи с реализацией масштабной программы развития атомной энергетики Госкорпорации "Росатом" требуется большое количество молодых перспективных специалистов. Работа в атомной отрасли – это не только широкие карьерные возможности, но и настоящий вызов для людей, которые хотели бы решать значимые для страны задачи. На предприятиях Госкорпорации "Росатом" Вы найдете интересную работу со стабильной заработной платой, перспективами профессионального и карьерного роста, гарантированным социальным пакетом. В свою очередь, мы хотели бы видеть в Вас инициативность, ответственность, высокую мотивацию, хорошие навыки общения и работы в команде.</p>
            <p style="MARGIN: 0px"><br>
            </p>
            <h4 style="MARGIN: 0px">Текущие вакансии<br>
            </h4>
            <?php if(is_object($res_advertisements->advertisementResult->advertisements->advertisement)):?>
                <?php foreach ($res_advertisements->advertisementResult->advertisements as $advertisement):?>
                    <p><?php echo date('d.m.Y', strtotime($advertisement->postingStartDate))?> 
                            <a href="description.php?id=<?php echo $advertisement->id?>&portal=1">
                                <?php echo $advertisement->jobTitle?>
                            </a>
                            <br>
                    </p>
                <?php endforeach;?>
            <?php else:?>
                <?php foreach ($res_advertisements->advertisementResult->advertisements->advertisement as $advertisement):?>
                    <p><?php echo date('d.m.Y', strtotime($advertisement->postingStartDate))?> 
                            <a href="description.php?id=<?php echo $advertisement->id?>&portal=1">
                                <?php echo $advertisement->jobTitle?>
                            </a>
                            <br>
                    </p>
                <?php endforeach;?>
            <?php endif?>
<p style="MARGIN: 0px"><br>
</p>
</body>
</html>
