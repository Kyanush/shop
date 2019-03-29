@extends('layouts.site')

<?php $title = 'Гарантия';?>
@section('title', $title)
@section('description', $title)
@section('keywords', $title)

@section('content')

   <div class="container">

       <?php $breadcrumb = [
           [
               'title' => 'Главная',
               'link'  => '/'
           ],
           [
               'title' => $title,
               'link'  => ''
           ]
       ];?>
      @include('includes.breadcrumb', ['breadcrumb' => $breadcrumb])


           <div id="content" class="information_content" style="padding: 0;">
               <p><img class="kitbonus_image_banner" src="/site/images/banner_garanty.png"></p>

               <div class="garanty_information">
                   <h1>Гарантия «OnePoint» в три шага:</h1>

                   <div class="garanty_top">
                       <div class="garanty_step">
                           <div class="garanty_step_number">01</div>

                           <div class="garanty_step_text">На тестирование товара и обнаружение брака Вам предоставляется 14 дней.</div>
                       </div>

                       <div class="garanty_step">
                           <div class="garanty_step_number">02</div>

                           <div class="garanty_step_text">При обнаружение брака вы обращаетесь к нам, и мы вместе ищем причину проблемы.</div>
                       </div>

                       <div class="garanty_step">
                           <div class="garanty_step_number">03</div>

                           <div class="garanty_step_text">Если проблема на нашей стороне то мы заменяем товар на аналогичный или возвращаем вам деньги.</div>
                       </div>
                   </div>

                   <div class="garanty_danger">ВНИМАНИЕ! Просим обратить Вас внимание на то, что технически сложные товары надлежащего качества не подлежат обмену и возврату, если они не понравились.</div>

                   <div class="garanty_srok">
                       <div class="garanty_srok_header">Срок гарантии на следующие товары</div>

                       <div class="garanty_srok_blocks">
                           <div class="garanty_srok_one_block">
                               <div class="garanty_srok_one_block_header">1 года</div>

                               <div class="garanty_srok_one_block_inner">Смартфоны</div>
                           </div>

                           <div class="garanty_srok_one_block">
                               <div class="garanty_srok_one_block_header">1 год</div>

                               <div class="garanty_srok_one_block_inner">Ноутбуки<br>
                                   Планшеты<br>
                                   Транспорт<br>
                                   Телевизоры<br>
                                   Электрошвабры</div>
                           </div>

                           <div class="garanty_srok_one_block">
                               <div class="garanty_srok_one_block_header">6 месяцев</div>

                               <div class="garanty_srok_one_block_inner">Гаджеты<br>
                                   Колонки<br>
                                   «Умный дом»<br>
                                   Внешние аккумуляторы<br>
                                   Фото и видео</div>
                           </div>

                           <div class="garanty_srok_one_block">
                               <div class="garanty_srok_one_block_header">2 недели</div>

                               <div class="garanty_srok_one_block_inner">Наушники<br>
                                   Зарядные устройства<br>
                                   Аксессуары<br>
                                   Одежда и сумки</div>
                           </div>
                       </div>
                   </div>

                   <div class="garanty_danger">Сроки гарантийного обслуживания на следующие категории товаров устанавливаются в соответствии с гарантийным талоном: смартфоны, ноутбуки, планшеты, транспорт, телевизоры, пылесосы, электрошвабры. Информация на сайте носит ознакомительный характер</div>

                   <div class="garanty_bottom_header">Гарантийному обслуживанию не подлежат товары:</div>

                   <div class="garanty_list">
                       <div>имеющие механические повреждения;</div>

                       <div>на которых повреждены или удалены заводские серийные номера, стикеры или пломбы;</div>

                       <div>имеющие повреждения, возникшие вследствие несчастных случаев, пожаров или стихийных бедствий, а также действий непреодолимой силы;</div>

                       <div>имеющие следы вскрытия или несанкционированного доступа (ремонта);</div>

                       <div>имеющие дефекты, возникшие в результате ненадлежащих условий транспортировки и хранения (отсутствие оригинальной упаковки при перевозке, повышенная влажность, агрессивные среды, следы посторонних предметов, следы животных и насекомых, залитые жидкостями и.т.д.);</div>

                       <div>имеющие дефекты, возникшие в результате ненадлежащих условий эксплуатации (некачественная питающая сеть, короткое замыкание, перегрузки, наличие механических, тепловых и электрических повреждений, замятые контакты, трещины, сколы, следы ударов, полное или частичное изменение формы изделия и т.д.);</div>

                       <div>имеющие дефекты, возникшие в результате использования некачественных или выработавших свой ресурс принадлежностей;</div>

                       <div>оборудование, которому причинен ущерб в результате работы в сопряжении с данным изделием;</div>

                       <div>товары и их части, имеющие ограниченный срок службы (естественный ресурс и износ).</div>
                   </div>
                   <img class="garanty_logo_img" src="/site/images/service_logo.png">
                   <div class="garanty_service">
                       <div class="garanty_service_block1">
                           <div>
                               <span>Режим работы:</span> c 10:00 до 19:00 Без выходных!<br>
                               <span>Телефон:</span>
                               <a href="tel:+77782002000">+7 (778) 200 20 00</a>, <a href="tel:+77075511979">+7 (707) 551 1979</a>
                           </div>
                       </div>

                       <div class="garanty_service_block2">
                           <div>
                               <span>Адрес:</span> г. Алматы,<br>
                               ул. Жибек жолы 115, оф. 113 (Рядом Аэровокзала)
                           </div>
                       </div>

                       <div class="garanty_service_block3">
                           <div>
                               <span>E-mail:</span>
                               <a href="mailto:info@onepoint.kz">info@onepoint.kz</a>
                           </div>
                       </div>
                   </div>
               </div>
           </div>



   </div>

@endsection