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
        if(values['user_id'] === 'guest'){
            alert('You must be logged in to add to basket');
            return false;
        }
        if(parseInt(values['stock']) <= parseInt(values['quant_in_basket'])){
            alert("We don't have enough in stock to add more to your basket")
            return false
        }
       
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
        var user_id = ($('.user-id').val());
        if(user_id === 'guest'){
            alert('You must be logged in to add to basket');
            return false;
        }
        var product_id = ($(this).siblings('.item-id').val());
        var quantBox = $(this).siblings('.hb-item_quantity');
        var quant = parseInt(quantBox.val());
        var totalItems = $('.total-items')
        var totalItemsVal = parseInt(totalItems.val());

        var stock = parseInt($(this).siblings('.product-stock').val());

        var productPrice = Math.round(parseFloat($(this).siblings('.product-price').val()) * 100) / 100
       
        var totalItemPrice = $(this).siblings('.total-item-price');
        var totalPriceDisplay = $(this).parent().parent().siblings().children('.total-price-display')
        console.log

        if (quant >= stock){
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

            var totalCostDisplay = $(".total-cost");
            var totalCostValue = $('.total-cost_value');
            var newCost =   (Math.round((parseFloat(totalCostValue.val()) + productPrice) * 100) / 100).toFixed(2);
            totalCostDisplay.html(newCost);
            totalCostValue.attr('value', newCost);

            var x = quant + 1.0
            quantBox.val(x);
            quantBox.attr('value', x)

            totalItems.val(totalItemsVal + 1.0)
            totalItems.attr('value', totalItemsVal + 1.0)

            totalItemPrice.val((Math.round((parseFloat(totalItemPrice.val()) + productPrice) * 100) / 100).toFixed(2)) ;
            totalPriceDisplay.html(totalItemPrice.val());
            
            var basketCount = $('.basket-count');
            var basketCountValue = $('.basket-count_value')
            var newBasketCount = parseInt(basketCountValue.val()) + 1
            basketCount.html(newBasketCount);
            basketCountValue.val(newBasketCount);
                
        });
        return false
    })

    $('.minustobasket').click(function(){
        var user_id = ($('.user-id').val());
        if(user_id === 'guest'){
            alert('You must be logged in to add to basket');
            return false;
        }

        var item = $(this).parent().parent().parent();
        var product_id = ($(this).siblings('.item-id').val());
        var quantBox = $(this).siblings('.hb-item_quantity');
        var quant = $(this).siblings('.hb-item_quantity').val();
        var totalItems = $('.total-items')
        var totalItemsVal = parseInt(totalItems.val());
        // var stock = $(this).siblings('.product-stock').val();
        var productPrice = Math.round((parseFloat($(this).siblings('.product-price').val())) * 100) / 100
        var totalItemPrice = $(this).siblings('.total-item-price');
        var totalPriceDisplay = $(this).parent().parent().siblings().children('.total-price-display')

        $.ajax({
            method: "post",
            url: "../minustobasket.php",
            data: { 'user_id': user_id, 'product_id': product_id }
        })
        .done(function() {

            var totalCostDisplay = $(".total-cost");
            var totalCostValue = $('.total-cost_value');
            var newCost =   (Math.round((parseFloat(totalCostValue.val()) - productPrice) * 100) / 100).toFixed(2);
            totalCostDisplay.html(newCost);
            totalCostValue.attr('value', newCost);

            if(quant > 1){
                var x = quant - 1
                quantBox.val(x);
                quantBox.attr('value', x)

                totalItems.val(totalItemsVal - 1)
                totalItems.attr('value', totalItemsVal - 1)

                totalItemPrice.val((Math.round((parseFloat(totalItemPrice.val()) - productPrice) * 100) / 100).toFixed(2)) ;
                totalPriceDisplay.html(totalItemPrice.val());

            }
            else{
                item.css("display", "none");
                totalItems.val(totalItemsVal - 1)
                totalItems.attr('value', totalItemsVal - 1)
                if(totalItemsVal - 1 <= 0){
                    $('.basket-message').css('display', 'block');
                }
            }
            var basketCount = $('.basket-count');
            var basketCountValue = $('.basket-count_value')
            var newBasketCount = parseInt(basketCountValue.val()) - 1
            basketCount.html(newBasketCount);
            basketCountValue.val(newBasketCount);
            if(newBasketCount <= 0){
                basketCount.css('display', 'none');
            }
            
        });
        return false
    })


    $('.trash-svg').click(function(){
        var product_id = $(this).parents().siblings().children().children('.item-id').val();
        var user_id = ($('.user-id').val());
        var item = $(this).parents().parents('.delete-item');

        var totalItems = $('.total-items')
        var totalItemsVal = parseInt(totalItems.val());

        var totalItemPrice = $(this).parents().siblings().children().children('.total-item-price');

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
            var totalCostDisplay = $(".total-cost");
            var totalCostValue = $('.total-cost_value');
            var newCost =   Math.round((parseFloat(totalCostValue.val()) - totalItemPrice.val()) * 100) / 100;
            totalCostDisplay.html(newCost);
            totalCostValue.attr('value', newCost);

            if(totalItemsVal - quant <= 0){
                $('.basket-message').css('display', 'block');
            }

            var basketCount = $('.basket-count');
            var basketCountValue = $('.basket-count_value')
            var newBasketCount = parseInt(basketCountValue.val()) - quant;
            basketCount.html(newBasketCount);
            basketCountValue.val(newBasketCount);
            if(newBasketCount <= 0){
                basketCount.css('display', 'none');
            }
        }
        )
    })

    $('.confirm-purchase').click(function(){
        var user_id = ($('.user-id').val());
        console.log(user_id);
        $.ajax({
            method: "post",
            url: "../confirm_purchase.php",
        })
        .done(function(){
            window.location.replace("../views/order_history.php");
            alert('Purchase Successful');
        });
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