@extends('layouts.site')

<?php $title = 'Учетная запись';?>
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



      @include('includes.menu_left_my_account')

          <div id="content" style="padding: 0px;background: none;overflow: visible;">
             <h1>{{ $title }}</h1>
             <div class="simple-content">

                <form action="" method="post" enctype="multipart/form-data" id="simplepage_form">
                   @csrf
                   <div class="simpleregister" id="simpleedit">
                      <div class="simpleregister-block-content" style="width: 100%; float: left; box-sizing: border-box; padding: 0px;">
                         <table class="simplecheckout-table-form">
                            <tbody>
                               <tr class="row-name">
                                  <td class="simplecheckout-table-form-left">
                                     <span class="simplecheckout-required">*</span>
                                     Имя
                                  </td>
                                  <td class="simplecheckout-table-form-right">
                                     <input type="text" name="account[name]" id="edit_name" value="{{ $user->name }}" placeholder="Имя *">
                                  </td>
                               </tr>
                               <tr class="row-surname">
                                  <td class="simplecheckout-table-form-left">
                                     Фамилия
                                  </td>
                                  <td class="simplecheckout-table-form-right">
                                     <input type="text" name="account[surname]" id="edit_surname" value="{{ $user->surname }}" placeholder="Фамилия">
                                  </td>
                               </tr>
                               <tr class="row-edit_email">
                                  <td class="simplecheckout-table-form-left">
                                     <span class="simplecheckout-required">*</span>
                                     Email
                                  </td>
                                  <td class="simplecheckout-table-form-right">
                                     <input type="email" name="account[email]" id="edit_email" value="{{ $user->email }}" placeholder="Электронная почта *">
                                  </td>
                               </tr>

                               <tr class="row-edit_phone">
                                  <td class="simplecheckout-table-form-left">
                                     <span class="simplecheckout-required">*</span>
                                     Телефон
                                  </td>
                                  <td class="simplecheckout-table-form-right">
                                     <input class="phone-mask" type="tel" name="account[phone]" id="edit_phone" value="{{ $user->phone }}" placeholder="Мобильный телефон *">
                                  </td>
                               </tr>

                            </tbody>
                         </table>
                      </div>
                      <div class="simpleregister-button-block buttons">
                         <div class="simpleregister-button-left">
                            <a href="/my-account" class="button">
                               <span>Назад</span>
                            </a>
                         </div>
                         <div class="simpleregister-button-right">
                            <input type="submit" value="Продолжить" class="button" id="simpleregister_button_confirm">
                         </div>
                      </div>
                   </div>
                </form>
             </div>


            </div>

   </div>

@endsection