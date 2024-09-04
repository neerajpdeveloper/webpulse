$(function () {
      var stickyElement = $(".sticky"),
      stickyClass = "sticky-pin",
      stickyPos = 66, //Distance from the top of the window.
      stickyHeight;

  

  ///Create a negative margin to prevent content 'jumps':
  stickyElement.after('<div class="jumps-prevent"></div>');
  function jumpsPrevent() {
    stickyHeight = stickyElement.innerHeight();
    stickyElement.css({"margin-bottom":"-" + stickyHeight + "px"});
    stickyElement.next().css({"padding-top": + stickyHeight + "px"}); 
  };
  jumpsPrevent(); //Run.

  //Function trigger:
  $(window).resize(function(){
    jumpsPrevent();
  });

  //Sticker function:
  function stickerFn() {
    var winTop = $(this).scrollTop();
    //Check element position:
    winTop >= stickyPos ?
      stickyElement.addClass(stickyClass):
      stickyElement.removeClass(stickyClass) //Boolean class switcher.
  };
  stickerFn(); //Run.

  //Function trigger:
  $(window).scroll(function(){
    stickerFn();
  });

// sidemenu
$(document).ready(function(){
  $('.app-sidebar').scroll(function() {
   var s = $(".app-sidebar .ps__rail-y");
   if(s[0]?.style.top.split('px')[0] <= 60){
     $('.app-sidebar').removeClass('sidebar-scroll')      
   } 
   else{
     $('.app-sidebar').addClass('sidebar-scroll')
   }
  })
});

    var $inputfield = $(".input_label");
    $inputfield.length && $inputfield.each(function () {
        var $this = $(this),
            $input = $this.find(".form_input"),
            placeholderTxt = $input.attr("placeholder"),
            $placeholder;

        $input.after('<span class="placeholder">' + placeholderTxt + "</span>"),
            $input.attr("placeholder", ""),
            $placeholder = $this.find(".placeholder"),

            $input.val().length ? $this.addClass("active") : $this.removeClass("active"),

            $input.on("focusout", function () {
                $input.val().length ? $this.addClass("active") : $this.removeClass("active");
            }).on("focus", function () {
                $this.addClass("active");
            });
    });

    $(".password_visable").click(function () {
        $(this).toggleClass("eye_slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });


    // This template is mobile first so active menu in navbar
    // has submenu displayed by default but not in desktop
    // so the code below will hide the active menu if it's in desktop




    // ______________ BACK TO TOP BUTTON
    $(window).on("scroll", function (e) {
        if ($(this).scrollTop() > 0) {
            $('#back-to-top').fadeIn('slow');
        } else {
            $('#back-to-top').fadeOut('slow');
        }
    });
    $(document).on("click", "#back-to-top", function (e) {
        $("html").animate({
            scrollTop: 0
        }, 0);
        return false;
    });

    /* Headerfixed */
    $(window).on("scroll", function (e) {
        if ($(window).scrollTop() >= 66) {
            $('main-header').addClass('fixed-header');
        } else {
            $('.main-header').removeClass('fixed-header');
        }
    });

    // ______________Search
    $('body, .main-header form[role="search"] button[type="reset"]').on('click keyup', function (event) {
        if (event.which == 27 && $('.main-header form[role="search"]').hasClass('active') ||
            $(event.currentTarget).attr('type') == 'reset') {
            closeSearch();
        }
    });

    function closeSearch() {
        var $form = $(' form[role="search"].active')
        $form.find('input').val('');
        $form.removeClass('active');
        $('body').removeClass('search-open');
    }
    // Show Search if form is not active // event.preventDefault() is important, this prevents the form from submitting
    $(document).on('click', ' form[role="search"]:not(.active) button[type="submit"]', function (event) {
        event.preventDefault();
        var $form = $(this).closest('form'),
            $input = $form.find('input');
        $form.addClass('active');
        $input.focus();
        $('body').addClass('search-open');
    });
    // if your form is ajax remember to call `closeSearch()` to close the search container
    $(document).on('click', ' form[role="search"].active button[type="submit"]', function (event) {
        event.preventDefault();
        var $form = $(this).closest('form'),
            $input = $form.find('input');
        $('#showSearchTerm').text($input.val());
        closeSearch()
        $('body').addClass('search-open');
    });

    // if your form is ajax remember to call `closeSearch()` to close the search container
    $(document).on('click', ' form[role="search"].active button[type="reset"]', function (event) {
        event.preventDefault();
        $('body').removeClass('search-open');
        var $form = $(this).closest('form'),
            $input = $form.find('input');
        $('#showSearchTerm').text($input.val());
        closeSearch()
    });


    const DIV_CARD = 'div.card';

    // ______________ Function for remove card
    $(document).on('click', '[data-bs-toggle="card-remove"]', function (e) {
        let $card = $(this).closest(DIV_CARD);
        $card.remove();
        e.preventDefault();
        return false;
    });
    // ______________ Functions for collapsed card
    $(document).on('click', '[data-bs-toggle="card-collapse"]', function (e) {
        let $card = $(this).closest(DIV_CARD);
        $card.toggleClass('card-collapsed');
        e.preventDefault();
        return false;
    });

    // ______________ Card full screen
    $(document).on('click', '[data-bs-toggle="card-fullscreen"]', function (e) {
        let $card = $(this).closest(DIV_CARD);
        $card.toggleClass('card-fullscreen').removeClass('card-collapsed');
        e.preventDefault();
        return false;
    });
    /* ----------------------------------- */

    // Showing submenu in navbar while hiding previous open submenu
    $('.main-navbar .with-sub').on('click', function (e) {
        e.preventDefault();
        $(this).parent().toggleClass('show');
        $(this).parent().siblings().removeClass('show');
    });
    // this will hide dropdown menu from open in mobile
    $('.dropdown-menu .main-header-arrow').on('click', function (e) {
        e.preventDefault();
        $(this).closest('.dropdown').removeClass('show');
    });
    // this will show navbar in left for mobile only
    $('#mainNavShow, #azNavbarShow').on('click', function (e) {
        e.preventDefault();
        $('body').addClass('main-navbar-show');
    });
    // this will hide currently open content of page
    // only works for mobile
    $('#mainContentLeftShow').on('click touch', function (e) {
        e.preventDefault();
        $('body').addClass('main-content-left-show');
    });
    // This will hide left content from showing up in mobile only
    $('#mainContentLeftHide').on('click touch', function (e) {
        e.preventDefault();
        $('body').removeClass('main-content-left-show');
    });
    // this will hide content body from showing up in mobile only
    $('#mainContentBodyHide').on('click touch', function (e) {
        e.preventDefault();
        $('body').removeClass('main-content-body-show');
    })
    // navbar backdrop for mobile only
    $('body').append('<div class="main-navbar-backdrop"></div>');
    $('.main-navbar-backdrop').on('click touchstart', function () {
        $('body').removeClass('main-navbar-show');
    });
    // Close dropdown menu of header menu
    $(document).on('click touchstart', function (e) {
        e.stopPropagation();
        // closing of dropdown menu in header when clicking outside of it
        var dropTarg = $(e.target).closest('.main-header .dropdown').length;
        if (!dropTarg) {
            $('.main-header .dropdown').removeClass('show');
        }
        // closing nav sub menu of header when clicking outside of it
        if (window.matchMedia('(min-width: 992px)').matches) {
            // Navbar
            var navTarg = $(e.target).closest('.main-navbar .nav-item').length;
            if (!navTarg) {
                $('.main-navbar .show').removeClass('show');
            }
            // Header Menu
            var menuTarg = $(e.target).closest('.main-header-menu .nav-item').length;
            if (!menuTarg) {
                $('.main-header-menu .show').removeClass('show');
            }
            if ($(e.target).hasClass('main-menu-sub-mega')) {
                $('.main-header-menu .show').removeClass('show');
            }
        } else {
            //
            if (!$(e.target).closest('#mainMenuShow').length) {
                var hm = $(e.target).closest('.main-header-menu').length;
                if (!hm) {
                    $('body').removeClass('main-header-menu-show');
                }
            }
        }
    });
    $('#mainMenuShow').on('click', function (e) {
        e.preventDefault();
        $('body').toggleClass('main-header-menu-show');
    })
    $('.main-header-menu .with-sub').on('click', function (e) {
        e.preventDefault();
        $(this).parent().toggleClass('show');
        $(this).parent().siblings().removeClass('show');
    })
    $('.main-header-menu-header .close').on('click', function (e) {
        e.preventDefault();
        $('body').removeClass('main-header-menu-show');
    })

    $(".card-header-right .card-option .fe fe-chevron-left").on("click", function () {
        var a = $(this);
        if (a.hasClass("icofont-simple-right")) {
            a.parents(".card-option").animate({
                width: "35px",
            })
        } else {
            a.parents(".card-option").animate({
                width: "180px",
            })
        }
        $(this).toggleClass("fe fe-chevron-right").fadeIn("slow")
    });



    // ______________horizontal-menu Active Class
    $(".horizontalMenu-list li a").each(function () {
        var pageUrl = window.location.href.split(/[?#]/)[0];
        if (this.href == pageUrl) {
            $(this).addClass("active");
            $(this).parent().addClass("active"); // add active to li of the current link
            $(this).parent().parent().prev().addClass("active"); // add active class to an anchor
            $(this).parent().parent().prev().click(); // click the item to make it drop
        }
    });
    $(".horizontalMenu-list li a").each(function () {
        var pageUrl = window.location.href.split(/[?#]/)[0];
        if (this.href == pageUrl) {
            $(this).addClass("active");
            $(this).parent().addClass("active"); // add active to li of the current link
            $(this).parent().parent().prev().addClass("active"); // add active class to an anchor
            $(this).parent().parent().prev().click(); // click the item to make it drop
        }
    });
    $(".horizontal-megamenu li a").each(function () {
        var pageUrl = window.location.href.split(/[?#]/)[0];
        if (this.href == pageUrl) {
            $(this).addClass("active");
            $(this).parent().addClass("active"); // add active to li of the current link
            $(this).parent().parent().parent().parent().parent().parent().parent().prev().addClass("active"); // add active class to an anchor
            $(this).parent().parent().prev().click(); // click the item to make it drop
        }
    });
    $(".horizontalMenu-list .sub-menu .sub-menu li a").each(function () {
        var pageUrl = window.location.href.split(/[?#]/)[0];
        if (this.href == pageUrl) {
            $(this).addClass("active");
            $(this).parent().addClass("active"); // add active to li of the current link
            $(this).parent().parent().parent().parent().prev().addClass("active"); // add active class to an anchor
            $(this).parent().parent().prev().click(); // click the item to make it drop
        }
    });



    $('.default-menu').on('click', function () {
        var ww = document.body.clientWidth;
        if (ww >= 992) {
            $('body').removeClass('sidenav-toggled');
        }
    });


});


 // Replace all textareas with class name "editor"
 var editors = CKEDITOR.replaceAll('editor', {
    extraAllowedContent: 'div',
    height: 460,
    removeButtons: 'PasteFromWord'
  });

  // Loop through all editors and customize as needed
  for (var i = 0; i < editors.length; i++) {
    var editor = editors[i];
    editor.on('instanceReady', function() {
      // Output self-closing tags the HTML4 way, like <br>.
      this.dataProcessor.writer.selfClosingEnd = '>';

      // Use line breaks for block elements, tables, and lists.
      var dtd = CKEDITOR.dtd;
      for (var e in CKEDITOR.tools.extend({}, dtd.$nonBodyContent, dtd.$block, dtd.$listItem, dtd.$tableContent)) {
        this.dataProcessor.writer.setRules(e, {
          indent: true,
          breakBeforeOpen: true,
          breakAfterOpen: true,
          breakBeforeClose: true,
          breakAfterClose: true
        });
      }
      // Start in source mode.
      this.setMode('source');
    });
  }


  function validcheckstatus(name, action, text, formId) {
    var chObj = document.getElementsByName(name);
    var result = false;
    for (var i = 0; i < chObj.length; i++) {
  
      if (chObj[i].checked) {
        result = true;
        break;
      }
    }
    if (!result) {
      swal({
        title: "Please select atleast one " + text + " to " + action + ".",
        padding: '2em'
      });
      return false;
    } else if (action == 'Delete' || action == 'Deactivate' || action == 'Deactivate Membership') {
      swal({
        title: 'Are you sure?',
        text: "You want to " + action + "!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: action,
        padding: '2em'
      }).then(function (result) {
        if (result.value) {
          $('#actionInput').val(action);
          $('#' + formId).submit();
        }
      });
      return false;
    } else {
      $('#actionInput').val(action);
      $('#' + formId).submit();
      return true;
    }
  }