jQuery(function($) {

  //dropdown hover menu Area rischio
  $(".dropdown").on( "click", function(){
    console.log("dropdown")
    var dropdownMenu = $(this).children(".dropdown-menu");
    if(dropdownMenu.is(":visible")){
      dropdownMenu.parent().toggleClass("open");
    }
  });


//Swiper Home page
  const swiperT = new Swiper('.swiper', {
    // Default parameters
      spaceBetween: 0,
      slidesPerView: 3,
      direction: 'horizontal',
      autoplay: {
          delay: 2500,
          disableOnInteraction: false,
      },
      loop: true,
      pagination: {
          el: '.swiper-pagination',
          clickable: true,
      },
      navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev"
      },
      // Responsive breakpoints
      breakpoints: {
          // when window width is >= 320px
          320: {
              slidesPerView: 1,
              spaceBetween: 20,
          },
          480: {
              slidesPerView: 1,
              spaceBetween: 30,
          },
          640: {
              slidesPerView: 3,
              spaceBetween: 40,
          }
      },
      initialSlide: 0,
  })



  //TESTIMO
  var swiper = new Swiper(".swiper-testimo", {
    autoplay: {
      delay: 2500,
      disableOnInteraction: false,
    },
    pagination: {
      el: ".swiper-pagination",
      type: "progressbar"
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev"
    }
  });

  //panel  show/hide course with animation
  $(".open-panel").click(function () 
  {
      let target = $(this).data("target");
      let $childPanel = $(this).closest(".childPanel");
      let idChildPanel = $childPanel.attr("id");
      let currentTarget = $childPanel.attr("data-current-target");
      $childPanel.attr("data-current-target", target);
      let currentChild = $childPanel.attr("data-current-child");
      $childPanel.attr("data-current-child", idChildPanel);
      let $panel = $childPanel.find(".panel");

      if (currentChild === undefined) {
          $(".panel.active").each(function () {
              $(this).removeClass('active');
          });
      }
      if (target == currentTarget) {
          $childPanel.attr("data-current-target", "");
          $panel.removeClass("active");
      } else {
          $panel.addClass("active");
      }

      $(".panel-target:not(" + target + ")").fadeOut(300, function () {
          $(target).fadeIn(300, function () {
              let activePanel = $(this).closest('.panel.active');
              if (activePanel.length > 0) {
                  activePanel[0].scrollIntoView({ behavior: 'smooth', block: 'start' });
              }
          });
      });
  });

  //FAQ COLLAPSED
  jQuery("#accordion .a").click(function(){
    let ariaExpanded =  this.attr("aria-expanded");
    console.log("test collapsed")
    if(ariaExpanded == true){
      this.find("span.isCollapsed").text("-");
    }else{
      this.find("span.isCollapsed").text("+");
    }
  });
//openChildPostType
  jQuery(".openChildPostType").click(function($){
    console.log("click display child parent post");
    let idCourse = jQuery(this).attr("data-idposttype");
    let childPanel = jQuery(this).closest(".childPanel");
    childPanel.siblings('.idParent-'+idCourse).toggle();
    let activePanel = childPanel.siblings('.idParent-'+idCourse);
    console.log(activePanel);
    if (activePanel.length > 0) {
          activePanel[0].scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  });
  
  $('#switchInfo').change(function() { 
    if($(this).prop('checked')) {
      $(this).prop('checked', 'checked');
      $('.infoAttesta').show();
      $("#isAcceptCondition").attr("required");
      $("#isAcceptCondition").prop("required", "required");
    }
    else {
      $(this).removeAttr('checked');
      $('.infoAttesta').hide();
      $("#isAcceptCondition").removeAttr("required");
    }
  });


  $('.btnNext').click(function (e) {
    let $this = jQuery(this);
    let $carousel_item = $this.closest(".carousel-item");
    let valid = true;
    $carousel_item.find("input, select").each(function () {
        let input = jQuery(this).get(0);
        if(jQuery(this).is(':visible') && !input.checkValidity() ) {
           console.log("error input");
           input.reportValidity();
            valid = false;
            return false;
        }
    });
    if(!valid) {
        e.preventDefault();
        e.stopPropagation();
    }
  })

  //Send form Inscription
  $(".btn-send").on( 'click', function(event) {
    event.preventDefault();
    var checkbox = $('#isAcceptCondition');
    var errorMessage = $('#error-message');

    if (!checkbox.is(':checked')) {
      errorMessage.text("Non hai accettato le condizioni di privacy");
      event.preventDefault();
      event.stopPropagation();
      return ;
    } else {
      errorMessage.text("");
    }
      $('.btn-send').attr('disabled',true);


    var form= $("#form-inscription");
    var ajaxurl = form.data("url");
    var form_data = form.serialize();
    $.ajax({
      method: 'POST',
      url: ajaxurl, // Replace with your server-side script
      data: form_data,
      success: function(response) {
        $('#myCarousel').carousel('next');
          $('.btn-send').attr('disabled',false);
      },
      error: function(error) {
          $('.error-send').text('Spiacente, verifica i tuoi dati!');
          $('.btn-send').attr('disabled',false);
      }
    });
    return false;
  });

  //On click button inscription course
  $(".inscriptionCourse").on('click',function (){
    var getDate = this.closest('.dates');
    selectedDate = getDate.find('.firstCourse')
    $('.firstCourse').value();

    if (selectedDate) {
      var url = '/form.php?date=' + encodeURIComponent(selectedDate.value);
      window.location.href = url;
    } else {
      alert("Please select an option.");
    }
    event.preventDefault();

  });

  //DONATION
  $('#donation').submit(function(event) {
    // Prevent the default form submission
    event.preventDefault();
    $('.btn-send-donation').attr('disabled',true);
    console.log("click btn send donation");
    //Data Body API
    var orderID  = $('#orderID').val();

    //Data form
    var firstName  = $('#firstName').val();
    var lastName   = $('#lastName').val();
    var email      = $('#email').val();
    var phone      = $('#phone').val();
    var donation   = $('#imposto').val();
    var pagamento  = $('#pagamento').val();

    console.log(orderID);
    $.ajax({
      url: proxyInfo.proxyUrl,
      data: {
        'amount': donation,
        'orderID': orderID
      },
      method: 'POST',
      success: function (data) {
        var hostedPage            = data['hostedPage'];
        var securityToken         = data['securityToken'];
        var form                  = $("#donation");
        var ajaxurl   = form.data("url");
        $.noConflict();
        $.ajax({
          type: 'POST',
          url: ajaxurl, // Replace with your server-side script
          data:{
            hostedPage      : hostedPage,
            securityToken   : securityToken,
            firstName       : firstName,
            orderID         : orderID,
            lastName        : lastName,
            email           : email,
            phone           : phone,
            imposto         : donation,
            pagamento       : pagamento,
            action          : "add_donation"
          },
          success: function(response) {
            console.log('Success:', response);
            console.log("insert data donation");
            location.href = hostedPage;
            $('.btn-send-donation').removeAttr('disabled');
            //redirect to hostedPage
          },
          error: function(error) {
            $('.btn-send-donation').removeAttr('disabled');
            console.error('Error:', error);
          }
        });

      }
    });
  });

  //SLIDE THANKS IMAGE SOSTIENICI
  var swiper = new Swiper('.swiper-sostienici', {
    slidesPerView: 3,
   // spaceBetween: 5,
   // direction: 'vertical',
   autoplay: {
    delay: 2500,
    disableOnInteraction: false,
  }, 
   loop: true,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev"
    },
    // Responsive breakpoints
    breakpoints: {
      // when window width is >= 320px
      320: {
          slidesPerView: 1,
          //spaceBetween: 20
      },
      480: {
          slidesPerView: 1,
          //spaceBetween: 30
      },
      640: {
          slidesPerView: 3,
          //spaceBetween: 40
      }
    },
    initialSlide: 0,

  });
  /*input donation accept only integer */
  $('#imposto').on('keydown', function(event) {
    // Allow: backspace, delete, tab, escape, enter
    if ($.inArray(event.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
        (event.keyCode == 65 && event.ctrlKey === true) ||
        (event.keyCode == 67 && event.ctrlKey === true) ||
        (event.keyCode == 86 && event.ctrlKey === true) ||
        (event.keyCode == 88 && event.ctrlKey === true) ||
        // Allow: home, end, left, right, up, down
        (event.keyCode >= 35 && event.keyCode <= 40)) {
      return;
    }
    // Ensure that it is a number and stop the keypress if it isn't
    if ((event.shiftKey || (event.keyCode < 48 || event.keyCode > 57)) &&
        (event.keyCode < 96 || event.keyCode > 105)) {
      event.preventDefault();
    }
  });

  //Status payement failed
  let statusPayement = $('.statusPayement').val();
  if(statusPayement == "failed") {
    console.log("popup finish payment");
    $("#status_message").modal("show");
  }

    $('.date-tooltip').tooltip('hide');

    jQuery("input[name='typeInscription']").on('change', function(){
        valore = jQuery(this).val();
        // /alert(valore);
        row_checkin = jQuery('#step4 .row_dati_checkin');
        if(valore=='Pacchetto completo'){
            row_checkin.show();
            row_checkin.find('input').each(function(){
                jQuery(this).attr('required');
                jQuery(this).prop('required', 'required');
            });
            jQuery("#step4 h2 span").show();
        }
        else{
            row_checkin.hide();
            row_checkin.find('input').each(function(){
                jQuery(this).removeAttr('required');
                jQuery(this).prop('required', false);
            });
            jQuery("#step4 h2 span").hide();
        }
    });

    jQuery(".form-type-5 select[name='numberSons']").on('change', function(){
        numberSons = parseInt(jQuery(this).val());

        row_figli = jQuery('.row-figli');
        if(numberSons > 0){
            row_figli.show();
            jQuery('.row-dati-figli').find('input, select').each(function(){
                jQuery(this).attr('required', 'required');
                jQuery(this).prop('required', 'required');
            });

            var animazione = 0;
            if($('.cnt-toggle-animazione .toggle-container input').prop('checked')) {
                animazione = 1;
            }

            document.getElementById("modulo-figli").innerHTML = "";

            for(var i= 1; i<(numberSons+1);i++){
                var html = create_module_son(i, animazione);
                document.getElementById("modulo-figli").innerHTML += html;
            }
        }
        else{
            row_figli.hide();
            jQuery('.row-dati-figli').find('input, select').each(function(){
                jQuery(this).removeProp('required');
            });
        }
    });

    $('.cnt-toggle-animazione .toggle-container input').change(function() {
        id_div_to_show = jQuery(this).attr("data-show-id");
        div_to_show = jQuery("#"+id_div_to_show);
        if($(this).prop('checked')) {
            $(this).prop('checked', 'checked');
            div_to_show.removeClass('d-none');

            div_to_show.find('input, select').each(function(){
                jQuery(this).attr('required');
                jQuery(this).prop('required', 'required');
            });

        }
        else {
            $(this).removeAttr('checked');
            div_to_show.addClass('d-none');
            div_to_show.find('input, select').each(function(){
                jQuery(this).removeProp('required');
            });
        }

        jQuery("select[name='numberSons']").trigger('change');
    });

    /*change color card in step 3 inscription course*/

    $('.card-type-inscription').click(function() {
        var cardClasse = $(this).data('typecourse');
        var color = '';
        switch (cardClasse) {
            case 'coppie-di-fidanzati':
                color ='#f9e9e8' ;
                break;
            case 'coppie-di-sposi':
                color ='#e5ebf0' ;
                break;
            case 'altre-iniziative':
                color ='#fff9f3' ;
                break;
            default:
                break;
        }
        // Remove background color from all cards
        $('.card-type-inscription').css('background-color', '');
        // Add background color to the clicked card
        $(this).css('background-color', color);

             // Find the radio button inside the clicked card and select it
        $(this).find('input[type="radio"]').prop('checked', true);
        $(this).find('input[type="radio"]').trigger('change');
    });

    //Pass Params in the form Inscription
    $('.sendRequest').on('click', function(event) {
        event.preventDefault();
        console.log("course form");
        var form = $(this).siblings( "form" );
        var formData = form.serialize(); // Get form data as a string
        console.log(formData);
        var currentUrl = window.location.href;
        var cleanUrl = currentUrl.replace('/#', '');
        var url = cleanUrl.split('?')[0] + '/form';

        // Redirect to the constructed URL with form data
        window.location.href = url + '?' + formData;
    });


});
function create_module_son(n, animazione = 0){
    var html_module_son = "";
    html_module_son += "<div id='son@@NUM' class='row-container-dati-figli'>" +
        "<div class='h6'>Dati figlio/a</div>" +
        "<div class='container-dati-figli'>";

    if(animazione == 1){
        html_module_son += jQuery(".row-mockup-figli-animazione").html();
    }

    html_module_son += jQuery(".row-mockup-figli").html();

    html_module_son += "</div></div>";
    html_module_son = html_module_son.replace(/@@NUM/gi, n);
    return html_module_son;
}
//Datepicker Inscription
jQuery(document).on('focus', '.birth', function() {
    console.log("onfocus");
    jQuery(this).datepicker({
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true,
        yearRange: '1900:2050',
        // Set the language to Italian
        dayNamesMin: ['Dom', 'Lun', 'Mar', 'Mer', 'Gio', 'Ven', 'Sab'],
        monthNames: ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'],
        monthNamesShort: ['Gen', 'Feb', 'Mar', 'Apr', 'Mag', 'Giu', 'Lug', 'Ago', 'Set', 'Ott', 'Nov', 'Dic'],
        firstDay: 1
    });
});
