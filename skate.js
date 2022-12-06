$(document).ready(function(){
    var listHidden = true;
    $(".nav-toggle").click(function(){
        if (listHidden){
            $(".nav-item-list").slideDown()
            $(".nav-item-list").css('display', 'flex');
            listHidden = false;
            $(".toggle-span:first-of-type").fadeTo('',0.0);
            $(".toggle-span:last-of-type").fadeTo('',0.0);
        }
        else {
            $(".nav-item-list").slideUp()
            listHidden = true;
            $(".toggle-span:first-of-type").fadeTo('',1.0);
            $(".toggle-span:last-of-type").fadeTo('',1.0);
        }
    })

    var subHidden = true;
    $(".nav-li").click(function(){
        if (subHidden){
            $(this).children('.sub-drop').slideDown();
            $(this).children('.sub-drop').css('display', 'flex');
            subHidden = false;
        }
        else {
            $(this).children('.sub-drop').slideUp();
            subHidden = true;
        }
        
    })
  });