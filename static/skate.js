$(document).ready(function(){
    var up = true;
    $(".nav-toggle-button").click(function(){
        if (up){
            $(this).siblings(".nav-list").slideDown()
            $(this).siblings(".nav-list").css('display', 'flex');
            up = false;
            $(".toggle-span:first-of-type").fadeTo('',0.0);
            $(".toggle-span:last-of-type").fadeTo('',0.0);
        }
        else {
            $(this).siblings(".nav-list").slideUp()
            up = true;
            $(".toggle-span:first-of-type").fadeTo('',1.0);
            $(".toggle-span:last-of-type").fadeTo('',1.0);
        }
    })

    var listIsUp = true;
    var currentGroup;
    $(".nav-item").click(function(){
        if(listIsUp){
            currentGroup = $(this);
        }
        listIsUp = subListToggler(listIsUp, currentGroup);
        if(listIsUp){
            $(this).children(".plus-minus").html("&plus;");
        }
        else {
            $(this).children(".plus-minus").html("&minus;");
        }
    });

    $(".profile-wrapper").click(function(){
        if(listIsUp){
            currentGroup = $(this);
        }
        listIsUp = subListToggler(listIsUp, currentGroup);
    })

    $(document).click(function(){
        if(!listIsUp){
            listIsUp = subListToggler(listIsUp, currentGroup);
        }
    });



    $(".sub-list").click(e => e.stopPropagation());
    $(".nav-item").click(e => e.stopPropagation());
    $(".profile-wrapper").click(e=> e.stopPropagation());

    productItemHeight();
    brandIconHeight();
    $(window).resize(productItemHeight);
    $(window).resize(brandIconHeight);

    
});

function brandIconHeight(){
    $item = $(".brand-homepage_logo");
    $width = $item.width();
    $item.css("max-height", $width * 1.82 );
}

function productItemHeight(){
    $item = $(".products-item")
    $width = $item.width();
    $item.css("min-height", $width * 1.82 );

    $image = $(".products-item_image-wrapper")
    $imageWidth = $image.width();
    $image.css("height", $imageWidth * 1.16)

}

function subListToggler(listIsUp, group){
    if (listIsUp){
        group.children(".sub-list").slideDown();
        listIsUp = false;
    }
    else {
        group.children(".sub-list").slideUp();
        listIsUp = true;
    }
    return listIsUp;
}

