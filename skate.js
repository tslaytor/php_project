$(document).ready(function(){
    var up = true;
    $(".nav-toggle-button").click(function(){
        if (up){
            $(".nav-list").slideDown()
            $(".nav-list").css('display', 'flex');
            up = false;
            $(".toggle-span:first-of-type").fadeTo('',0.0);
            $(".toggle-span:last-of-type").fadeTo('',0.0);
        }
        else {
            $(".nav-list").slideUp()
            up = true;
            $(".toggle-span:first-of-type").fadeTo('',1.0);
            $(".toggle-span:last-of-type").fadeTo('',1.0);
        }
    })

    var subUp = true;
    $(".nav-item").click(function(e){
        if (subUp){
            $(".nav-item_cover").css("display", "block");
            $(this).children(".nav-item_cover").css("display", "none")
            $(this).children(".sub-list").slideDown();
            $(this).children(".plus-minus").html("&minus;");
            subUp = false;
        }
        else {
            $(this).children(".sub-list").slideUp();
            $(this).children(".plus-minus").html("&plus;");
            $(".nav-item_cover").css("display", "none");
            subUp = true;
        }
        
    })

    $(".sub-list").click(e => e.stopPropagation());
    $(".nav-item_cover").click(e => e.stopPropagation());
  });