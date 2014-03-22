<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
<link type="text/css" rel="stylesheet" media="screen" href="http://rosatom.ru/wps/wcm/connect/rosatom/rosatomsite/resources/559f2880435120c0b9efffc5687e4a83/style_site_bf.css">
<style>
    .cutom-title{
        font-weight: bold;
        margin: 10px 0;
    }
</style>
</head>

<body>

<?php 
    include_once 'classes/vacancies.php';
    $vacancies = new Vacancies();
    // получаем данные об вакансии по id вакансии для конкретного типа сайта
    $advertisement = $vacancies->getAdvertisementById($_GET['portal'], $_GET['id']);
?>
<p>Просьба разместить вакансию на странице портала ГК Управление персоналом > Подбор персонала и карьера в атомной отрасли > Вакансии Госкорпорации</p>                            
<p>С заголовком: <?php echo $advertisement->jobTitle?></p>
<p>С текстом:</p>
            <?php if(! empty($advertisement->organizations->organization)):?>
                Подразделение:
                <?php if(is_object($advertisement->organizations->organization)):?>
                        <?php echo (isset($advertisement->organizations->organization->label))? 
                        '<span>'.$advertisement->organizations->organization->label.'</span><br/>': ''?>
                <?php else:?>
                        <span><?php echo $advertisement->organizations->organization[
                                    count($advertisement->organizations->organization) - 1
                                ]->label ?></span><br/>
                <?php endif?>
            <?php endif?>

                    
            <?php if(! empty($advertisement->customFields->customField)):?>
                <?php if(is_object($advertisement->customFields->customField)):?>
                    <?php if(! empty($advertisement->customFields->customField->value)):?>
                        <?php echo (isset($advertisement->customFields->customField->label))? 
                            '<p class="cutom-title">'.$advertisement->customFields->customField->label.'</p>': ''?>:
                        <?php echo (isset($advertisement->customFields->customField->value))? 
                            $advertisement->customFields->customField->value: ''?>
                    <?php endif?>    
                <?php else:?>
                    <?php foreach ($advertisement->customFields->customField as $customField):?>
                        <?php if(!empty($customField->value)):?>
                            <p class="cutom-title"><?php echo (isset($customField->label))? $customField->label: ''?>:</p>
                            <?php echo (isset($customField->value))? $customField->value: ''?>
                        <?php endif?>
                    <?php endforeach;?>
                <?php endif?>
            <?php endif?>
                        
            <!--<p class="cutom-title">Контакты:</p>-->
                        
            <?php // if(! empty($advertisement->configurableFields->configurableField)):?>
                <?php // if(is_object($advertisement->configurableFields->configurableField)):?>
                    <?php // echo (isset($advertisement->configurableFields->configurableField->label))? 
//                        $advertisement->configurableFields->configurableField->label: ''?>
                    <?php // if(! empty($advertisement->configurableFields->configurableField->criteria->criterion)):?>
                        <?php // if(is_object($advertisement->configurableFields->configurableField->criteria->criterion)):?>
                            <?php // echo (isset($advertisement->configurableFields->configurableField->criteria->criterion->label))?
//                                    $advertisement->configurableFields->configurableField->criteria->criterion->label: ''?>
                            <?php // echo (isset($advertisement->configurableFields->configurableField->criteria->criterion->value))?
//                                    $advertisement->configurableFields->configurableField->criteria->criterion->value: ''?><br/>                   
                        <?php // else:?>
                            <?php // foreach ($advertisement->configurableFields->configurableField->criteria->criterion as $criterion):?>
                                <?php // echo (isset($criterion->label))? $criterion->label: ''?>
                                <?php // echo (isset($criterion->value))? $criterion->value: ''?> 
                            <?php // endforeach;?>
                        <?php // endif?>
                    <?php // endif?>
                <?php // else:?>
                    <?php // foreach ($advertisement->configurableFields->configurableField as $configurableField):?>
                        <?php // echo (isset($advertisement->configurableFields->configurableField->label))? 
//                        $advertisement->configurableFields->configurableField->label: ''?>
                        <?php // if(! empty($configurableField->criteria->criterion)):?>
                            <?php // if(is_object($configurableField->criteria->criterion)):?>
                                <?php // echo (isset($configurableField->criteria->criterion->label))? 
//                                        $configurableField->criteria->criterion->label: ''?>
                                <?php // echo (isset($configurableField->criteria->criterion->value))?
//                                        $configurableField->criteria->criterion->value: ''?><br/>                    
                            <?php // else:?>
                                <?php // foreach ($configurableField->criteria->criterion as $criterion):?>
                                    <?php // echo (isset($criterion->label))? $criterion->label: ''?>
                                    <?php // echo (isset($criterion->value))? $criterion->value: ''?>                
                                <?php // endforeach;?>
                            <?php // endif?>
                        <?php // endif?>
                    <?php // endforeach;?>
                <?php // endif?>
                <!--</p>-->
            <?php // endif?>
                                           
            <?php if(isset($advertisement->applicationUrl)):?>
                <p>Принять вакансию: <a href="<?php echo $advertisement->applicationUrl?>"><?php echo $advertisement->jobTitle?></a></p>
            <?php endif?>         
                        
                        
                        
                        
                        
                        
                        
                        
                
            <?php //if(isset($advertisement->compensationMaxValue)):?>
                <!--<p>Максимальная заработная плата: <a href="<?php //echo $advertisement->compensationMaxValue?>"><?php // echo $advertisement->jobTitle?></a></p>-->
            <?php // endif?>
                
            <?php // if(isset($advertisement->compensationMinValue)):?>
                <!--<p>Минимальная заработная плата: <a href="<?php // echo $advertisement->compensationMinValue?>"><?php // echo $advertisement->jobTitle?></a></p>-->
            <?php // endif?>

            <?php // if(! empty($advertisement->customLovs->customLov)):?>
                <!--<p>-->
                <?php // if(is_object($advertisement->customLovs->customLov)):?>
                    <?php // echo (isset($advertisement->customLovs->customLov->label))? 
//                        $advertisement->customLovs->customLov->label: ''?>
                    <?php // if(! empty($advertisement->customLovs->customLov->criteria->criterion)):?>
                        <?php // if(is_object($advertisement->customLovs->customLov->criteria->criterion)):?>
                            <?php // echo (isset($advertisement->customLovs->customLov->criteria->criterion->label))?
//                                    $advertisement->customLovs->customLov->criteria->criterion->label: ''?>
                        <?php // else:?>
                            <?php // foreach ($advertisement->customLovs->customLov->criteria->criterion as $criterion):?>
                                <?php // echo (isset($criterion->label))? $criterion->label: ''?>
                            <?php // endforeach;?>
                        <?php // endif?>
                    <?php // endif?>
                <?php // else:?>
                    <?php // foreach ($advertisement->customLovs->customLov as $customLov):?>
                        <?php // echo (isset($customLov->label))? $customLov->label: ''?>
                        <?php // if(! empty($customLov->criteria->criterion)):?>
                            <?php // if(is_object($customLov->criteria->criterion)):?>
                                <?php // echo (isset($customLov->criteria->criterion->label))? 
//                                        $customLov->criteria->criterion->label: ''?>
                            <?php // else:?>
                                <?php // foreach ($customLov->criteria->criterion as $criterion):?>
                                    <?php // echo (isset($criterion->label))? $criterion->label: ''?>
                                <?php // endforeach;?>
                            <?php // endif?>
                        <?php // endif?>
                    <?php // endforeach;?>
                <?php // endif?>
                <!--</p>-->
            <?php // endif?>
                
            <?php // if(isset($advertisement->location)):?>
                <!--<p>Расположение: <?php // echo $advertisement->location?></p>-->
            <?php // endif?>
                
            <?php // if(isset($advertisement->postingStartDate)):?>
                <!--<p>Дата публикации вакансии: <?php // echo date('d.m.Y', strtotime($advertisement->postingStartDate))?></p>-->
            <?php // endif?>
                
            <?php // if(! empty($advertisement->standardLovs->standardLov)):?>
                <?php // if(is_object($advertisement->standardLovs->standardLov)):?>
                    <!--<p>-->
                        <?php // echo (isset($advertisement->standardLovs->standardLov->label))? 
//                            $advertisement->standardLovs->standardLov->label: ''?>
                        <?php // if(! empty($advertisement->standardLovs->standardLov->criteria->criterion)):?>
                            <?php // if(is_object($advertisement->standardLovs->standardLov->criteria->criterion)):?>
                                <?php // echo (isset($advertisement->standardLovs->standardLov->criteria->criterion->label))?
//                                        $advertisement->standardLovs->standardLov->criteria->criterion->label: ''?>
                            <?php // else:?>
                                <?php // foreach ($advertisement->standardLovs->standardLov->criteria->criterion as $criterion):?>
                                    <?php // echo (isset($criterion->label))? $criterion->label: ''?>
                                <?php // endforeach;?>
                            <?php // endif?>
                        <?php // endif?>
                    <!--</p>-->
                <?php // else:?>
                    <?php // foreach ($advertisement->standardLovs->standardLov as $standardLov):?>
                        <!--<p>-->
                            <?php // echo (isset($standardLov->label))? $standardLov->label: ''?>
                            <?php // if(! empty($standardLov->criteria->criterion)):?>
                                <?php // if(is_object($standardLov->criteria->criterion)):?>
                                    <?php // echo (isset($standardLov->criteria->criterion->label))? 
//                                            $standardLov->criteria->criterion->label: ''?>
                                <?php // else:?>
                                    <?php // foreach ($standardLov->criteria->criterion as $criterion):?>
                                        <?php // echo (isset($criterion->label))? $criterion->label: ''?>
                                    <?php // endforeach;?>
                                <?php // endif?>
                            <?php // endif?>
                        <!--</p>-->
                    <?php // endforeach;?>
                <?php // endif?>
                <!--</p>-->
            <?php // endif?>
     
<p style="MARGIN: 0px"><br>
</p>
</body>
</html>
