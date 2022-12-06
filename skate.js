$(document).ready(function(){
    var listHidden = true;
    $(".nav-toggle-button").click(function(){
        if (listHidden){
            $(".nav-list").slideDown()
            $(".nav-list").css('display', 'flex');
            listHidden = false;
            $(".toggle-span:first-of-type").fadeTo('',0.0);
            $(".toggle-span:last-of-type").fadeTo('',0.0);
        }
        else {
            $(".nav-list").slideUp()
            listHidden = true;
            $(".toggle-span:first-of-type").fadeTo('',1.0);
            $(".toggle-span:last-of-type").fadeTo('',1.0);
        }
    })

    var subHidden = true;
    $(".nav-item").click(function(){
        if (subHidden){
            $(this).children().children('.sub-list').slideDown();
            $(this).children().children('.sub-list').css('display', 'flex');
            $(this).children().children('.plus-minus').html("&minus;")
            subHidden = false;
        }
        else {
            $(this).children().children('.sub-list').slideUp();
            $(this).children().children('.plus-minus').html("&plus;")
            subHidden = true;
        }
        
    })
  });