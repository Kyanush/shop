@extends('layouts.site')

@section('title',       $seo['title'])
@section('description', $seo['description'])
@section('keywords',    $seo['keywords'])

@section('content')

   <div class="container">

       <?php $breadcrumbs = [
           [
               'title' => 'Главная',
               'link'  => '/'
           ],
           [
               'title' => $seo['title'],
               'link'  => ''
           ]
       ];?>
      @include('includes.breadcrumb', ['breadcrumbs' => $breadcrumbs])

      @php
           $address = config('shop.address');
           $number_phones = config('shop.number_phones');
      @endphp

           <div class="contact_page">

                   <div class="contact_page_left_header">Связаться с нами</div>

                   <div style="padding: 20px;font-size: 14px;line-height: 22px;">
                       Обсудить с нами возникшие вопросы или проконсультироваться звоните к нам по номеру:
                       <a style="font-size: 14px;text-decoration: none;" href="tel:{{ $number_phones[0]['number'] }}">
                           {{ $number_phones[0]['format'] }}
                       </a>
                       (ежедневно с 11-00 до 19-00).
                       Кроме того, Вы можете отправить любые запросы или вопросы нам на электронную почту
                       <a style="font-size: 14px;text-decoration: none;" href="mailto:{{ config('shop.site_email') }}">
                           {{ config('shop.site_email') }}
                       </a> ,
                       не забудьте указать Ваше имя и контактные номера телефонов. Если Вас не устраивают какие-либо наши товары или услуги,
                       мы с удовольствием выслушаем Вас. Мы всегда готовы решить проблему.
                   </div>

                   <div class="contact_page_blocks" itemscope itemtype="http://schema.org/Organization">
                       <div class="contact_page_block">
                           <div class="contact_page_block_header">Телефоны</div>
                           <div class="contact_page_block_list">
                               <div class="contact_page_block_list_top">Ежедневно, круглосуточно(телефон или WhatsApp)</div>
                               <div class="contact_page_block_list_bottom">
                                   <a href="tel:{{ $number_phones[0]['number'] }}">{{ $number_phones[0]['format'] }}</a>
                               </div>
                           </div>
                           <div class="contact_page_block_list">
                               <div class="contact_page_block_list_top">Время работы</div>
                               <div class="contact_page_block_list_bottom">{{ $address[0]['working_hours'] }}</div>
                           </div>
                           <div class="contact_page_block_list">
                               <div class="contact_page_block_list_top">Адрес</div>
                               <div class="contact_page_block_list_bottom">{{ $address[0]['addressLocality'] }}, {{ $address[0]['streetAddress'] }}</div>
                           </div>
                       </div>
                       <div class="contact_page_block">
                           <div class="contact_page_block_header">E-mail</div>
                           <div class="contact_page_block_list">
                               <div class="contact_page_block_list_top">Вопросы по розничным продажам и.д.</div>
                               <div class="contact_page_block_list_bottom">
                                   <a href="mailto:{{ config('shop.site_email') }}">
                                       {{ config('shop.site_email') }}
                                   </a>
                               </div>
                           </div>
                           <!--
                           <div class="contact_page_block_list">
                               <div class="contact_page_block_list_top">Для юридических лиц</div>
                               <div class="contact_page_block_list_bottom"><a href="mailto:corp@ru-mi.com">corp@ru-mi.com</a></div>
                           </div>
                           <div class="contact_page_block_list">
                               <div class="contact_page_block_list_top">Для жалоб, претензий и благодарностей</div>
                               <div class="contact_page_block_list_bottom"><a href="mailto:okk@ru-mi.com">okk@ru-mi.com</a></div>
                           </div>
                           <div class="contact_page_block_list">
                               <div class="contact_page_block_list_top">Для предложений по рекламе</div>
                               <div class="contact_page_block_list_bottom"><a href="mailto:reklama@ru-mi.com">reklama@ru-mi.com</a></div>
                           </div>--->
                       </div>


                       <div class="contact_page_block">
                           <div class="contact_page_block_header">Мы в соцсетях</div>
                           <div class="contact_block_social">
                               <a href="{{ config('shop.social_network.instagram') }}" class="contact_in1"  title="Вы в Instagram" target="_blank">
                                   <img src="/site/images/insta.png" width="30">
                               </a>
                           </div>
                           <div>
                               <?if(false):?>
                               <div id="vk_widget" style="width: 100%;"><div id="vk_groups" style="width: 292px; height: 204.4px; background: none;"><iframe name="fXD42cb8" frameborder="0" src="https://vk.com/widget_community.php?app=0&amp;width=292px&amp;_ver=1&amp;gid=100871931&amp;mode=3&amp;color1=&amp;color2=&amp;color3=&amp;class_name=&amp;url=https%3A%2F%2Fru-mi.com%2Fcontact%2F&amp;referrer=https%3A%2F%2Fru-mi.com%2Finfopage%2F&amp;title=%D0%9A%D0%BE%D0%BD%D1%82%D0%B0%D0%BA%D1%82%D1%8B%20%D1%84%D0%B8%D1%80%D0%BC%D0%B5%D0%BD%D0%BD%D0%BE%D0%B3%D0%BE%20%D0%B8%D0%BD%D1%82%D0%B5%D1%80%D0%BD%D0%B5%D1%82-%D0%BC%D0%B0%D0%B3%D0%B0%D0%B7%D0%B8%D0%BD%D0%B0%20%D0%A0%D1%83%D0%BC%D0%B8%D0%BA%D0%BE%D0%BC%20%D0%B2%20%D0%9C%D0%BE%D1%81%D0%BA%D0%B2%D0%B5&amp;1684d6d0067" width="292" height="185" scrolling="no" id="vkwidget2" style="overflow: hidden; height: 204.4px;"></iframe></div></div>
                               <!-- VK Widget -->
                               <script type="text/javascript" src="https://vk.com/js/api/openapi.js?156"></script>
                               <!-- VK Widget -->
                               <script !src="">
                                   function VK_Widget_Init(){
                                       var getWidth = document.getElementById("vk_widget").clientWidth;
                                       console.log(getWidth);
                                       document.getElementById('vk_widget').innerHTML = '<div id="vk_groups"></div>';
                                       VK.Widgets.Group("vk_groups", {
                                           mode: 3,
                                           width: getWidth,
                                       }, 100871931);
                                   };
                                   window.addEventListener('load', VK_Widget_Init, false);
                                   window.addEventListener('resize', VK_Widget_Init, false);
                               </script>
                               <?endif;?>
                           </div>
                       </div>
                   </div>


               <div style="width: 100%;height: 300px;display: table">
                   <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Ade9d92460f096fdbf3730e9f27c44faa41ee4502b84a6e3fb69e9d10da159565&amp;width=100%25&amp;height=400&amp;lang=ru_RU&amp;scroll=true"></script>
               </div>


           </div>

   </div>

@endsection