
$("#preloader").show()


//register start
$(document).ready(function () {
   
   $("#registerbutton").click(function (e) { 
      e.preventDefault();

      Form = $("#registerForm").serialize();
      $(this).attr("hidden","hidden")
      $("#register_loading").removeAttr("hidden")

$.ajax({
    type: "post",
    url: registerUrl,
    data: Form, // Directly pass the serialized form data
    dataType: 'json', // Specify the expected response data type
    beforeSend: function(xhr) {
        xhr.setRequestHeader('X-CSRF-TOKEN', csrftoken); // Set CSRF token header
    },
    success: function(response) {
      if(response)
      {
        
         $("#register_loading").attr("hidden","hidden")
         $("#registerbutton").removeAttr("hidden")
         $("#report_div").removeAttr("hidden");
         $("#register_report").text("Registration successful. Check Your Mailbox for your verification email");
         console.log(response);
      }
    },
    error: function(xhr, status, error) {
      $("#register_loading").attr("hidden","hidden")
      $("#registerbutton").removeAttr("hidden")
      $("#report_div").removeAttr("hidden");
      $("#register_report").html(xhr.responseText.message);
      console.log(xhr.responseText); // Log any errors
    }
});

      

   });

});
// regsiter end


$(document).ready(function () {
   $("#preloader").hide()
    $("#see_password").mouseenter(function () { 
       $("#password").prop("type", "text");
    });
    $("#see_password").mouseleave(function () { 
        $("#password").prop("type", "password");
     });

    var totalsum = 0;
    $(".sums").each(function(){
      var value = parseFloat($(this).val());
      totalsum += value;
    });
    
    var formatted = "&#8358; " + totalsum.toLocaleString();

    $("#price_total").html(formatted);


    $(".delete_this_item").click(function (e) { 
      e.preventDefault();

      var item = $(this).val();

      $.ajax({
         type: "delete",
         url: deletecartUrl,
         data: {
            item: item,
            _token: csrftoken,
         },
         success: function (data) {
            if(data.success)
            {
               $("#item_row" + item).hide();
               var destroyed_item_count = $(item).text();

               var destroyed_item_total = $("#items_totalled").text();
               
               $deducted = Number(destroyed_item_total) - Number(destroyed_item_count);
                
               $("#items_totalled").text($deducted);

               cart_item_count = $(".cart_counter").text();
               
               $minused = Number(cart_item_count) - Number(destroyed_item_count);

               $(".cart_counter").text($minused);

              

               $deleted_item_amount = $("#sums"+item).text();

               money_minused = Number(totalsum) - Number($deleted_item_amount);

               var formatted = "&#8358; " + money_minused.toLocaleString();

               $("#price_total").html(formatted);
            }
         }
      });
      
    });



    // order modals


    //conclude

    $(".conclude_modal_trigger").click(function (e) { 
      e.preventDefault();

      $id = $(this).val();

      $conclude = $("#conclude_button" + $id).val($id);

      $("#conclude_button" + $id).click(function (e) { 
         e.preventDefault();

         var targetted_order = $(this).val();

         $.ajax({
            type: "post",
            url: conclude_url,
            data: {
               targetted_order: targetted_order,
               _token: csrftoken,
            },
            success: function (data) {
               if(data.success)
               {
                  $("#order" + $id).removeClass("table-primary");
                  $("#order" + $id).addClass("table-success");

                  $("#order_body" + $id).removeClass("table-primary");
                  $("#order_body" + $id).addClass("table-success");

                  $("#conclude_modal_button" + $id).text("Pend");
                  $("#conclude_modal_button" + $id).removeClass("btn-success");
                  $("#conclude_modal_button" + $id).addClass("btn-primary");
                  
               }else{
                  alert("Something went wrong");
               }
            }
         });
         
      });
      
      
    });

    //conclude


    //pend


    $(".pend_modal_trigger").click(function (e) { 
      e.preventDefault();

      $id = $(this).val();

      $pend = $("#pend_button" + $id).val($id);

      $("#pend_button" + $id).click(function (e) { 
         e.preventDefault();

         var targetted_order = $(this).val();

         $.ajax({
            type: "post",
            url: pend_url,
            data: {
               targetted_order: targetted_order,
               _token: csrftoken,
            },
            success: function (data) {
               if(data.success)
               {
                  $("#order" + $id).removeClass("table-success");
                  $("#order" + $id).addClass("table-primary");

                  $("#order_body" + $id).removeClass("table-success");
                  $("#order_body" + $id).addClass("table-primary");

                  $("#pend_modal_button" + $id).text("Conclude");
                  $("#pend_modal_button" + $id).removeClass("btn-primary");
                  $("#pend_modal_button" + $id).addClass("btn-success");
                  
               }else{
                  alert("Something went wrong");
               }
            }
         });
         
      });
      
      
    });


    //pend


    // order modals

    

// $("#product_detail_increment").keyDown(function (e) { 
//    e.preventDefault();

//    $customer_count = $(this).val();
//    $product_count = $("#product_count").val();

//    if($customer_count < $product_count)
//    {
//       alert("You've exceeded the amout of products available");
//    }
   
// });


$("#add_to_cart_advanced").click(function (e) { 
   e.preventDefault();

   product_id = $(this).val();
   quantity = $("#product_detail_increment").val();
   shop_id = $("#shop_id").val();


   $.ajax({
      type: 'POST',
      url: addtocartUrl,
      data: {
          product_id: product_id,
          quantity: quantity,
          shop_id: shop_id,
          _token: csrftoken,
      },
      success: function (data) {
         if(data.success)
         {
           $my_cart = $(".cart_counter").html();
           $adder = Number($my_cart) + Number(1);
           $my_cart = $(".cart_counter").html($adder);
         }
      }
  });

   
   
});



//remove from carts single clickk start

$(".minus_cart_item_quantity").click(function (e) { 
   e.preventDefault();
   
   var delete_product_id = $(this).val();
   
   $.ajax({
      type: "delete",
      url: removecartUrl,
      data: {
         delete_product_id: delete_product_id,
         _token: csrftoken,
      },
      success: function (data) {
         if(data.success)
         {
            $my_cart = $(".cart_counter").html();
            $minuser = Number($my_cart) - Number(1);
            $my_cart = $(".cart_counter").html($minuser);

            $dops = $("#" + delete_product_id).text();
            $item_decrease = Number($dops) - Number(1);
            $dops = $("#" + delete_product_id).text($item_decrease);

            $items_total_hold = $("#items_totalled").text()
            $items_total_decrease = Number($items_total_hold) - Number(1);
            
            $items_total_hold = $("#items_totalled").text($items_total_decrease)

            $this_cart_item_price = $("#" + "cart_item_price" + delete_product_id).val();

            var totalsum_minus = 0;
            $(".sums").each(function(){
               var value = parseFloat($(this).val());
               totalsum_minus += value;
            });

            $updated_total_price = totalsum_minus - $this_cart_item_price;

            var formatted = "&#8358; " + $updated_total_price.toLocaleString();

            $("#price_total").html(formatted);
         }
      }
   });
});

//remove from carts single clickk end


//add to carts single clickk start


$('.all_products_cart_add').click(function (e) {
   e.preventDefault();

   var product_id = $(this).val();
   var quantity = 1;
   var shop_id = $("#cart_shop_id").val();

   $.ajax({
       type: 'POST',
       url: addtocartUrl,
       data: {
           product_id: product_id,
           quantity: quantity,
           shop_id: shop_id,
           _token: csrftoken,
       },
       success: function (data) {
          if(data.success)
          {
            $my_cart = $(".cart_counter").html();
            $adder = Number($my_cart) + Number(1);
            $my_cart = $(".cart_counter").html($adder);

            $dops = $("#" + product_id).text();
            $item_increase = Number($dops) + Number(1);
            $dops = $("#" + product_id).text($item_increase);

            $items_total_hold = $("#items_totalled").text()
            $items_total_increase = Number($items_total_hold) + Number(1);
            $items_total_hold = $("#items_totalled").text($items_total_increase)

            var totalsum_add = 0;
            $(".sums").each(function(){
               var value = parseFloat($(this).val());
               totalsum_add += value;
            });

            $this_cart_item_price = $("#" + "cart_item_price" + product_id).val();

            $updated_total_price = Number(totalsum_add) + Number($this_cart_item_price);

            var formatted = "&#8358; " + $updated_total_price.toLocaleString();

            $("#price_total").html(formatted);
          }
       }
   });
});

$(".placeorder").click(function () { 
   
   $n = $("#naira").val();

  
});


//add to carts single clickk end


$('.product_detail_cart_add').click(function (e) {
   e.preventDefault();

   var product_id = $(this).val();
   var quantity = $("#product_detail_increment").val();
   
   $.ajax({
       type: 'POST',
       url: addtocartUrl,
       data: {
           product_id: product_id,
           quantity: quantity,
           _token: csrftoken,
       },
       success: function (data) {
          if(data.success)
          {
            $my_cart = $(".cart_counter").html();
            $adder = Number($my_cart) + Number(quantity);
            $my_cart = $(".cart_counter").html($adder);
          }
       }
   });
});

   // $("#cart_counter").html(Number($carts) + Number(1));
   
});

// $(".add_cart_item_quantity").click(function (e) { 
//    e.preventDefault();

//    $button_value = $(this).val();


//    console.log($da)
   
// });
   


$("#reviewstar1").click(function(){

   $data = $(this).closest("div").find("i").hasClass("fas filled");

   if($data == true)
   {
   $(this).closest("div").find("i").removeClass("fas filled");
   $(this).closest("div").find("i").addClass("far");
   $(this).addClass("fas filled");
   
   }else{
   $(this).removeClass("far");
   $(this).addClass("fas filled");
   }

})

$("#reviewstar2").click(function(){

   $data = $(this).closest("div").find("i").hasClass("fas filled");

   if($data == true)
   {
   $(this).prevAll("i").removeClass("fas filled");
   $(this).prevAll("i").addClass("far");
   $(this).removeClass("fas filled");
   $(this).addClass("far");
   }else{
   $(this).prevAll("i").removeClass("far");
   $(this).prevAll("i").addClass("fas filled");
   $(this).removeClass("far");
   $(this).addClass("fas filled");
   }

})

$("#reviewstar3").click(function(){

   $data = $(this).closest("div").find("i").hasClass("fas filled");

   if($data == true)
   {
   $(this).prevAll("i").removeClass("fas filled");
   $(this).prevAll("i").addClass("far");
   $(this).removeClass("fas filled");
   $(this).addClass("far");
   }else{
   $(this).prevAll("i").removeClass("far");
   $(this).prevAll("i").addClass("fas filled");
   $(this).removeClass("far");
   $(this).addClass("fas filled");
   }

})

$("#reviewstar4").click(function(){

   $data = $(this).closest("div").find("i").hasClass("fas filled");

   if($data == true)
   {
   $(this).prevAll("i").removeClass("fas filled");
   $(this).prevAll("i").addClass("far");
   $(this).removeClass("fas filled");
   $(this).addClass("far");
   }else{
   $(this).prevAll("i").removeClass("far");
   $(this).prevAll("i").addClass("fas filled");
   $(this).removeClass("far");
   $(this).addClass("fas filled");
   }

})

$("#reviewstar5").click(function(){

   $data = $(this).closest("div").find("i").hasClass("fas filled");

   if($data == true)
   {
   $(this).prevAll("i").removeClass("fas filled");
   $(this).prevAll("i").addClass("far");
   $(this).removeClass("fas filled");
   $(this).addClass("far");
   }else{
   $(this).prevAll("i").removeClass("far");
   $(this).prevAll("i").addClass("fas filled");
   $(this).removeClass("far");
   $(this).addClass("fas filled");
   }

})


     
$("#review_rating").keyup(function (e) { 
   e.preventDefault();
   
   $rating = $(this).val();
   $error = $("#rating_error").html();

   if($rating > '5' || $rating < '0')
   {
   $("#leavereview").attr("disabled","disabled");
   $("#rating_error").html("Should be between 1 and 5")
   }else{
   $("#leavereview").removeAttr("disabled");
   $("#rating_error").html("")
   }

});



// $(document).ready(function () {
//    $("#profileupdatebutton").click(function (e) { 
//       e.preventDefault();
      
//    });
// });


$(document).ready(function () {
   $("#navbar-toggler").click(function (e) { 
      e.preventDefault();
      

   ($("#navbarCollapse").hasClass("collapse")) ? $("#navbarCollapse").removeClass("collapse") : $("#navbarCollapse").addClass("collapse") 
   });
});



// admin actions start

$(document).ready(function () {
   

$(".block_user").click(function (e) { 
   e.preventDefault();
   
   var id = $(this).val();



   $.ajax({
      type: "post",
      url: BlockUserUrl,
      data: {
         id: id,
         _token: csrftoken
      },
      success: function (response) {
         if(response.success)
         {
            $("#userblockbtn"+id).hide();
            $("#userunblockbtn"+id).removeAttr("hidden");
         }else
         {
            alert("Something went wrong");
         }
      }
   });
});

$(".unblock_user").click(function (e) { 
   e.preventDefault();
   
   var id = $(this).val();



   $.ajax({
      type: "post",
      url: unBlockUserUrl,
      data: {
         id: id,
         _token: csrftoken
      },
      success: function (response) {
         if(response.success)
         {
            $("#userunblock"+id).removeClass("fa-play");
            $("#userunblock"+id).addClass("fa-stop");
            $("#userunblockbtn"+id).removeClass("text-success");
            $("#userunblockbtn"+id).addClass("text-danger");
         }else
         {
            alert("Something went wrong");
         }
      }
   });
});

$(".block_shop").click(function (e) { 
   e.preventDefault();
   
   var id = $(this).val();



   $.ajax({
      type: "post",
      url: BlockShopUrl,
      data: {
         id: id,
         _token: csrftoken
      },
      success: function (response) {
         if(response.success)
         {
            $("#shopblock"+id).removeClass("fa-stop");
            $("#shopblock"+id).addClass("fa-play");
            $("#shopblockbtn"+id).removeClass("text-danger");
            $("#shopblockbtn"+id).addClass("text-success");
         }else
         {
            alert("Something went wrong");
         }
      }
   });
});

$(".unblock_shop").click(function (e) { 
   e.preventDefault();
   
   var id = $(this).val();



   $.ajax({
      type: "post",
      url: unBlockShopUrl,
      data: {
         id: id,
         _token: csrftoken
      },
      success: function (response) {
         if(response.success)
         {
            $("#shopunblock"+id).removeClass("fa-play");
            $("#shopunblock"+id).addClass("fa-stop");
            $("#shopunblockbtn"+id).removeClass("text-success");
            $("#shopunblockbtn"+id).addClass("text-danger");
         }else
         {
            alert("Something went wrong");
         }
      }
   });
});

$(".block_product").click(function (e) { 
   e.preventDefault();
   
   var id = $(this).val();



   $.ajax({
      type: "post",
      url: BlockProductUrl,
      data: {
         id: id,
         _token: csrftoken
      },
      success: function (response) {
         if(response.success)
         {
            $("#productblock"+id).removeClass("fa-stop");
            $("#productblock"+id).addClass("fa-play");
            $("#productblockbtn"+id).removeClass("text-danger");
            $("#productblockbtn"+id).addClass("text-success");
         }else
         {
            alert("Something went wrong");
         }
      }
   });
});

$(".unblock_product").click(function (e) { 
   e.preventDefault();
   
   var id = $(this).val();



   $.ajax({
      type: "post",
      url: unBlockProductUrl,
      data: {
         id: id,
         _token: csrftoken
      },
      success: function (response) {
         if(response.success)
         {
            $("#productunblock"+id).removeClass("fa-play");
            $("#productunblock"+id).addClass("fa-stop");
            $("#productunblockbtn"+id).removeClass("text-success");
            $("#productunblockbtn"+id).addClass("text-danger");
         }else
         {
            alert("Something went wrong. Refresh page and try again");
         }
      }
   });
});

});










// admin actions end



// // lga ajajx start

// $("#state").change(function(){
//    var selectedStateId = $("#state").val(); 
 
   
//    $.ajax({
//        url: LgaUrl, 
//        method: 'POST',
//        data: { 
//          stateId: selectedStateId,
//          _token: csrftoken
//       }, 
//        success: function (data) {
           
//            if(data.success)
//            {
//             $('#lgas').empty();

           
//            $.each(data, function (index, item) {
//                $('#lgas').append('<option value="' + item.lga_id + '">' + item.lga_name + '</option>');
//            });
//            }else{
//             alert("Something went wrong");
//            }
//        },
//        error: function (xhr, status, error) {
//            console.error(error);
//        }
//    });

//  });

// // lga ajax end


// search start

// setInterval(() => {
//    alert("Hello")
// }, 5000);

// $("#search_allProducts_button").click(function (e) { 
//    e.preventDefault();
   

// });

// search end


// delete image start

$(".delete_image").click(function (e) { 
   e.preventDefault();
   
   image_id = $(this).val();

   $.ajax({
      type: "delete",
      url: imageDelete,
      data: {
         image_id: image_id,
         _token: csrftoken,
      },
      success: function (data) {
         if(data.success)
         {
            $("#image_col"+image_id).hide();
         }else
         {
            alert("Something went wrong");
         }
      }
   });

});

// delete image end


// resend reg ver email start

// $("#resend_email").click(function (e) { 
//    e.preventDefault();
   
//    $email = $("#resend_to_email").val();

//    $.ajax({
//       type: "post",
//       url: resendMail,
//       data: {
//          email: $email,
//          _token: csrftoken,
//       },
//       dataType: "dataType",
//       success: function (data) {
//          if(data.success)
//          {

//          }
//       }
//    });
// });

// resend reg ver email end




$(".checkcookie").click(function () { 
   
   $(".checkcookie").attr('checked', 'checked')
});