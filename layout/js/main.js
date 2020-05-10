$(function () {
    'use strict';

     // Calls the selectBoxIt method on your HTML select box
  /*$("select").selectBoxIt({
      autoWidth : false
  }); */


    $('input[placeholder]').focus(function () {
        
        $(this).attr('data-text', $(this).attr('placeholder'));

        $(this).attr('placeholder','');

    }).blur(function(){
        $(this).attr('placeholder',$(this).attr('data-text'));
    });

    $('input').each(function (){
       if($(this).attr('required') === 'required') {
           $(this).after('<span class="asterisk">*</span>');
       }
    });

    /* show password in members regster  */
    $('.showpass').hover(function () {
        $('.password').attr('type','text')

    },function (){
        $('.password').attr('type','password')
    });

    $('.confirm').click(function () {

        return confirm('Are You Sure?');
    });

    /* categories -view and hidden  */
  
   $('.cat h3').click(function (){

    $(this).next('.full-view').fadeToggle(200);
   });

   $('.sort span').click(function () {

    $(this).addClass('Activate').siblings('span').removeClass('Activate');

    if($(this).data('view') === 'full'){

        $('.cat .full-view').fadeIn(200);
        
    }else{

        $('.cat .full-view').fadeOut(200);
    }

   });

   /* Latest DashBord*/
   
   $('.toggle-info').click(function () {
       $(this).toggleClass('select').parent().next('.card-body').fadeToggle()

       if($(this).hasClass('select')){
           $(this).html('<i class="fa fa-minus"></i>');
       }
       else {
        $(this).html('<i class="fa fa-plus"></i>');
       }
   }); 

   /* Login | signin  */

   $('.login-page h1 span').click(function () {

    $(this).addClass('active').siblings().removeClass('active');
    $('.login-page form').hide();
    $('.'+$(this).data('class')).fadeIn();
    

   });

   $('.live').keyup(function (){

    $($(this).data('class')).text($(this).val());

   });

   $('.dropdown').click(function(){

    $('.dropdown-menu').toggleClass('show');

});

});