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

    var listIsUp = true;
    var currentGroup;
    $(".nav-item").click(function(){
        if(listIsUp){
            currentGroup = $(this);
        }
        listIsUp = subListToggler(listIsUp, currentGroup);
    });

    $(document).click(function(){
        if(!listIsUp){
            listIsUp = subListToggler(listIsUp, currentGroup);
        }
    });
    $(".sub-list").click(e => e.stopPropagation());
    $(".nav-item").click(e => e.stopPropagation());

    gridRowHeight();
    $(window).resize(gridRowHeight);

    
});


function gridRowHeight(){
    $item = $(".products-container_item")
    $width = $item.width();
    $item.css("height", $width * 1.82 );

    $image = $(".product-image_wrapper")
    $imageWidth = $image.width();
    $image.css("height", $imageWidth * 1.16)

}



function subListToggler(listIsUp, group){
    if (listIsUp){
        group.children(".sub-list").slideDown();
        group.children(".plus-minus").html("&minus;");
        listIsUp = false;
    }
    else {
        group.children(".sub-list").slideUp();
        group.children(".plus-minus").html("&plus;");
        listIsUp = true;
    }
    return listIsUp;
}

