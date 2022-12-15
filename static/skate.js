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

    $(".basket").click(function(){
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
    $(".basket").click(e=> e.stopPropagation());

    productItemHeight();
    brandIconHeight();
    $(window).resize(productItemHeight);
    $(window).resize(brandIconHeight);



    $(".product_add-to-basket").click(function(){
        var values = {};
        $.each($('.product-form').serializeArray(), function(i, field) {
        values[field.name] = field.value;
        });

        // if(values['quant_in_basket']){
            if(parseInt(values['stock']) <= parseInt(values['quant_in_basket'])){
                alert("We don't have enough in stock to add more to your basket")
                return false
            }
        // }
       
        $.ajax({
            method: "post",
            url: "../addtobasket.php",
            data: { 'user_id': values['user_id'], 'product_id': values['product_id'] }
          })
            .done(function() {

                location.reload();
            });

        
        return false

    })

    $('.plustobasket').click(function(){
        var product_id = ($(this).siblings('.item-id').val());
        var user_id = ($('.user-id').val());
        var quantBox = $(this).siblings('.hb-item_quantity');
        var quant = parseInt(quantBox.val());
        var totalItems = $('.total-items')
        var totalItemsVal = parseInt(totalItems.val());

        var stock = parseInt($(this).siblings('.product-stock').val());

        var productPrice = Math.round(parseFloat($(this).siblings('.product-price').val()) * 100) / 100
        // var totalItemPrice = Math.round(parseFloat($(this).siblings('.total-item-price').val()) * 100) / 100
        // console.log(`productPrice: ${productPrice}`)
        // console.log(`totalItemPrice: ${totalItemPrice}`)
        // ;
        // var totalPriceDispay = $(this).parent().parent().siblings().children('.total-price-display')

        var totalItemPrice = $(this).siblings('.total-item-price');
        var totalPriceDispay = $(this).parent().parent().siblings().children('.total-price-display')

        console.log(quant)
        console.log(stock);
        if (quant >= stock){
            console.log(`apparently ${quant} is bigger or eaqual to ${stock}`)
            alert("We don't have enough in stock to add more to your basket")
            return false
        }

        $.ajax({
            method: "post",
            url: "../addtobasket.php",
            data: { 'user_id': user_id, 'product_id': product_id }
        })
        .done(function(e) {
            var x = quant + 1;
            // quantBox.val(x);
            // quantBox.attr('value', x);

            // totalItems.val(totalItemsVal + 1) ********** HERE DOSE NOTHING
            // totalItems.attr('value', totalItemsVal + 1)

            var totalCostDisplay = $(".total-cost");
            var totalCostValue = $('.total-cost_value');
            var newCost =   Math.round((parseFloat(totalCostValue.val()) + productPrice) * 100) / 100;
            totalCostDisplay.html(newCost);
            totalCostValue.attr('value', newCost);

            var x = quant + 1
                quantBox.val(x);
                quantBox.attr('value', x)

                totalItems.val(totalItemsVal + 1)
                totalItems.attr('value', totalItemsVal + 1)

                totalItemPrice.val((Math.round((parseFloat(totalItemPrice.val()) + productPrice) * 100) / 100).toFixed(2)) ;
                totalPriceDispay.html(totalItemPrice.val());



            // totalItemPrice += productPrice;
            // console.log(`totalItemPrice: ${totalItemPrice}`)
            // totalPriceDispay.html(totalItemPrice);

            // var totalCostDisplay = $(".total-cost");
            // var totalCostValue = $('.total-cost_value');
            // var newCost =  Math.round((parseFloat(totalCostValue.val()) + productPrice) * 100) / 100;
            // totalCostDisplay.html(newCost);
            // totalCostValue.attr('value', newCost);


            
        });
        return false
    })

    $('.minustobasket').click(function(){
        var item = $(this).parent().parent().parent();
        var product_id = ($(this).siblings('.item-id').val());
        var user_id = ($('.user-id').val());
        var quantBox = $(this).siblings('.hb-item_quantity');
        var quant = $(this).siblings('.hb-item_quantity').val();
        var totalItems = $('.total-items')
        var totalItemsVal = parseInt(totalItems.val());
        // var stock = $(this).siblings('.product-stock').val();
        var productPrice = Math.round((parseFloat($(this).siblings('.product-price').val())) * 100) / 100
        var totalItemPrice = $(this).siblings('.total-item-price');
        var totalPriceDispay = $(this).parent().parent().siblings().children('.total-price-display')

        $.ajax({
            method: "post",
            url: "../minustobasket.php",
            data: { 'user_id': user_id, 'product_id': product_id }
        })
        .done(function() {

            var totalCostDisplay = $(".total-cost");
            var totalCostValue = $('.total-cost_value');
            var newCost =   Math.round((parseFloat(totalCostValue.val()) - productPrice) * 100) / 100;
            totalCostDisplay.html(newCost);
            totalCostValue.attr('value', newCost);

            if(quant > 1){
                var x = quant - 1
                quantBox.val(x);
                quantBox.attr('value', x)

                totalItems.val(totalItemsVal - 1)
                totalItems.attr('value', totalItemsVal - 1)

                totalItemPrice.val((Math.round((parseFloat(totalItemPrice.val()) - productPrice) * 100) / 100).toFixed(2)) ;
                totalPriceDispay.html(totalItemPrice.val());

            }
            else{
                item.css("display", "none");
                totalItems.val(totalItemsVal - 1)
                totalItems.attr('value', totalItemsVal - 1)
                if(totalItemsVal - 1 <= 0){
                    $('.basket-message').css('display', 'block');
                }
            }
            
        });
        return false
    })


    $('.trash-svg').click(function(){
        var product_id = $(this).parents().siblings().children().children('.item-id').val();
        var user_id = ($('.user-id').val());
        var item = $(this).parents().parents('.hb-item');

        var totalItems = $('.total-items')
        var totalItemsVal = parseInt(totalItems.val());

        var quant = $(this).parents().siblings().children().children('.hb-item_quantity').val();
        $.ajax(
        {
            method: "post",
            url: "../deletefrombasket.php",
            data: { 'user_id': user_id, 'product_id': product_id }
        })
        .done(function(){
            item.css('display', 'none');

            
            totalItems.val(totalItemsVal - quant)
            totalItems.attr('value', totalItemsVal - quant)

            console.log(totalItemsVal);
            console.log(quant)

            if(totalItemsVal - quant <= 0){
                $('.basket-message').css('display', 'block');
            }
        }
        )
    })

   
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

