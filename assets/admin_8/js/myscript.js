(function($) {
    "use strict";

  $(document).ready(function() {


function disablekey()
{
 document.onkeydown = function (e)
 {
  return false;
 }
}

function enablekey()
{
 document.onkeydown = function (e)
 {
	 
  return true;
 }
}

// **************************************  AJAX REQUESTS SECTION *****************************************

  // Status Start
      $(document).on('click','.status',function () {
        var link = $(this).attr('data-href');
            $.get( link, function(data) {
              }).done(function(data) {
                  table.ajax.reload();
                  $('.alert-danger').hide();
                  $('.alert-success').show();
                  $('.alert-success p').html(data);
            })
          });
  // Status Ends


  // Display Subcategories & attributes
      $(document).on('change','#cat',function () {
        var link = $(this).find(':selected').attr('data-href');
        if(link != "")
        {
          $('#subcat').load(link);
          $('#subcat').prop('disabled',false);
        }
        $.get(getattrUrl + '?id=' + this.value + '&type=category', function(data) {
          console.log(data);
          let attrHtml = '';
          for (var i = 0; i < data.length; i++) {
            attrHtml += `
            <div class="row">
              <div class="col-lg-4">
                <div class="left-area">
                    <h4 class="heading">${data[i].attribute.name} *</h4>
                </div>
              </div>
              <div class="col-lg-7">
            `;

            for (var j = 0; j < data[i].options.length; j++) {
              let priceClass = '';
              if (data[i].attribute.price_status == 0) {
                priceClass = 'd-none';
              }
              attrHtml += `
                <div class="row mb-0 option-row">
                  <div class="col-lg-5">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" id="${data[i].attribute.input_name}${data[i].options[j].id}" name="${data[i].attribute.input_name}[]" value="${data[i].options[j].name}" class="custom-control-input attr-checkbox">
                      <label class="custom-control-label" for="${data[i].attribute.input_name}${data[i].options[j].id}">${data[i].options[j].name}</label>
                    </div>
                  </div>
                  <div class="col-lg-7 ${priceClass}">
                    <div class="row">
                      <div class="col-2">
                        +
                      </div>
                      <div class="col-10">
                        <div class="price-container">
                          <span class="price-curr">${curr.sign}</span>
                          <input type="text" class="input-field price-input" id="${data[i].attribute.input_name}${data[i].options[j].id}_price" data-name="${data[i].attribute.input_name}_price[]" placeholder="0.00 (Additional Price)" value="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              `;
            }

            attrHtml +=  `
              </div>
            </div>
            `;
          }

          $("#catAttributes").html(attrHtml);
          $("#subcatAttributes").html('');
          $("#childcatAttributes").html('');
        });
      });
  // Display Subcategories Ends

  // Display Childcategories & Attributes
      $(document).on('change','#subcat',function () {
        var link = $(this).find(':selected').attr('data-href');
        if(link != "")
        {
          $('#childcat').load(link);
          $('#childcat').prop('disabled',false);
        }

        $.get(getattrUrl + '?id=' + this.value + '&type=subcategory', function(data) {
          console.log(data);
          let attrHtml = '';
          for (var i = 0; i < data.length; i++) {
            attrHtml += `
            <div class="row">
              <div class="col-lg-4">
                <div class="left-area">
                    <h4 class="heading">${data[i].attribute.name} *</h4>
                </div>
              </div>
              <div class="col-lg-7">
            `;

            for (var j = 0; j < data[i].options.length; j++) {
              let priceClass = '';
              if (data[i].attribute.price_status == 0) {
                priceClass = 'd-none';
              }
              attrHtml += `
                  <div class="row option-row">
                    <div class="col-lg-5">
                      <div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" id="${data[i].attribute.input_name}${data[i].options[j].id}" name="${data[i].attribute.input_name}[]" value="${data[i].options[j].name}" class="custom-control-input attr-checkbox">
                        <label class="custom-control-label" for="${data[i].attribute.input_name}${data[i].options[j].id}">${data[i].options[j].name}</label>
                      </div>
                    </div>
                    <div class="col-lg-7 ${priceClass}">
                      <div class="row">
                        <div class="col-2">
                          +
                        </div>
                        <div class="col-10">
                          <div class="price-container">
                            <span class="price-curr">${curr.sign}</span>
                            <input type="text" class="input-field price-input" id="${data[i].attribute.input_name}${data[i].options[j].id}_price" data-name="${data[i].attribute.input_name}_price[]" placeholder="0.00 (Additional Price)" value="">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              `;
            }

            attrHtml +=  `
              </div>
            </div>
            `;
          }

          $("#subcatAttributes").html(attrHtml);
          $("#childcatAttributes").html('');
        });
      });
  // Display Childcateogries & Attributes Ends


  // Display Attributes for Selected Childcategory Starts
      $(document).on('change','#childcat',function () {

        $.get(getattrUrl + '?id=' + this.value + '&type=childcategory', function(data) {
          console.log(data);
          let attrHtml = '';
          for (var i = 0; i < data.length; i++) {
            attrHtml += `
            <div class="row">
              <div class="col-lg-4">
                <div class="left-area">
                    <h4 class="heading">${data[i].attribute.name} *</h4>
                </div>
              </div>
              <div class="col-lg-7">
            `;

            for (var j = 0; j < data[i].options.length; j++) {
              let priceClass = '';
              if (data[i].attribute.price_status == 0) {
                priceClass = 'd-none';
              }
              attrHtml += `
                  <div class="row option-row">
                    <div class="col-lg-5">
                      <div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" id="${data[i].attribute.input_name}${data[i].options[j].id}" name="${data[i].attribute.input_name}[]" value="${data[i].options[j].name}" class="custom-control-input attr-checkbox">
                        <label class="custom-control-label" for="${data[i].attribute.input_name}${data[i].options[j].id}">${data[i].options[j].name}</label>
                      </div>
                    </div>
                    <div class="col-lg-7 ${priceClass}">
                      <div class="row">
                        <div class="col-2">
                          +
                        </div>
                        <div class="col-10">
                          <div class="price-container">
                            <span class="price-curr">${curr.sign}</span>
                            <input type="text" id="${data[i].attribute.input_name}${data[i].options[j].id}_price" class="input-field price-input" data-name="${data[i].attribute.input_name}_price[]" placeholder="0.00 (Additional Price)" value="">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

              `;
            }

            attrHtml +=  `
              </div>
            </div>
            `;
          }

          $("#childcatAttributes").html(attrHtml);
        });
      });
  // Display Attributes for Selected Childcategory Ends



  // Droplinks Start
      $(document).on('change','.droplinks',function () {

        var link = $(this).val();
        var data = $(this).find(':selected').attr('data-val');
        if(data == 0)
        {
          $(this).next(".nice-select.process.select.droplinks").removeClass("drop-success").addClass("drop-danger");
        }
        else{
          $(this).next(".nice-select.process.select.droplinks").removeClass("drop-danger").addClass("drop-success");
        }
        $.get(link);
        $.notify("Status Updated Successfully.","success");
      });


      $(document).on('change','.vdroplinks',function () {

        var link = $(this).val();
        var data = $(this).find(':selected').attr('data-val');
        if(data == 0)
        {
          $(this).next(".nice-select.process.select1.vdroplinks").removeClass("drop-success").addClass("drop-danger");
        }
        else{
          $(this).next(".nice-select.process.select1.vdroplinks").removeClass("drop-danger").addClass("drop-success");
        }
        $.get(link);
        $.notify("Status Updated Successfully.","success");
      });

      $(document).on('change','.data-droplinks',function (e) {
          $('#confirm-delete1').modal('show');
          $('#confirm-delete1').find('.btn-ok').attr('href', $(this).val());
          table.ajax.reload();
          var data = $(this).children("option:selected").html();
          if(data == 'Pending') {
            $('#t-txt').addClass('d-none');
            $('#t-txt').val('');
          }
          else {
            $('#t-txt').removeClass('d-none');
          }
          $('#t-id').val($(this).data('id'));
          $('#t-title').val(data);
        });

      $(document).on('change','.vendor-droplinks',function (e) {
          $('#confirm-delete1').modal('show');
          $('#confirm-delete1').find('.btn-ok').attr('href', $(this).val());
          table.ajax.reload();
        });
         $(document).on('click','.order-refund',function (e) {
          $('#refundpopup').modal('show');
          $('#refundpopup').find('.btn-ok').attr('href', $(this).data('href'));
          table.ajax.reload();
        });

    $(document).on('change','.order-droplinks',function (e) {
        $('#confirm-delete2').modal('show');
        $('#confirm-delete2').find('.btn-ok').attr('href', $(this).val());
      });


  // Droplinks Ends



// ADD OPERATION

$(document).on('click','#add-data',function(){
if(admin_loader == 1)
  {
  $('.submit-loader').show();
}
  $('#modal1').find('.modal-title').html('ADD NEW '+$('#headerdata').val());
  $('#modal1 .modal-content .modal-body').html('').load($(this).attr('data-href'),function(response, status, xhr){
      if(status == "success")
      {
        if(admin_loader == 1)
          {
            $('.submit-loader').hide();
          }
      }

    });
});

// ADD OPERATION END


// Attribute Modal

$(document).on('click','.attribute',function(){
if(admin_loader == 1)
  {
  $('.submit-loader').show();
}
  $('#attribute').find('.modal-title').html($('#attribute_data').val());
  $('#attribute .modal-content .modal-body').html('').load($(this).attr('data-href'),function(response, status, xhr){
      if(status == "success")
      {
        if(admin_loader == 1)
          {
            $('.submit-loader').hide();
          }
      }

    });
});



// Attribute Modal Ends


// EDIT OPERATION

$(document).on('click','.edit',function(){
if(admin_loader == 1)
  {
  $('.submit-loader').show();
}
  $('#modal1').find('.modal-title').html('EDIT '+$('#headerdata').val());
  $('#modal1 .modal-content .modal-body').html('').load($(this).attr('data-href'),function(response, status, xhr){
      if(status == "success")
      {
        if(admin_loader == 1)
          {
            $('.submit-loader').hide();
          }
      }
    });
});


// EDIT OPERATION END


// FEATURE OPERATION

$(document).on('click','.feature',function(){
if(admin_loader == 1)
  {
  $('.submit-loader').show();
}
  $('#modal2').find('.modal-title').html($('#headerdata').val()+' Highlight');
  $('#modal2 .modal-content .modal-body').html('').load($(this).attr('data-href'),function(response, status, xhr){
      if(status == "success")
      {
        if(admin_loader == 1)
          {
            $('.submit-loader').hide();
          }

          var dateToday = new Date();
          $( "#discount_date" ).datepicker({
              changeMonth: true,
              changeYear: true,
              minDate: dateToday,
          });

      }
    });
});

// FEATURE OPERATION

$(document).on('click','.quickeditl',function(){
  if(admin_loader == 1){$('.submit-loader').show();}
  $('#modal3').find('.modal-title').html($('#headerdata').val()+' QuickEdit');
  $('#modal3 .modal-content .modal-body').html('').load($(this).attr('data-href'),function(response, status, xhr){
      if(status == "success"){
        if(admin_loader == 1){
          $('.submit-loader').hide();
        }
      }
    });
});
$(document).on('click','.addnote',function(){
  if(admin_loader == 1){$('.submit-loader').show();}
  $('#modal3').find('.modal-title').html($('#headerdata').val()+' Refund');
  $('#modal3 .modal-content .modal-body').html('').load($(this).attr('data-href'),function(response, status, xhr){
      if(status == "success"){
        if(admin_loader == 1){
          $('.submit-loader').hide();
        }
      }
    });
});


// EDIT OPERATION END


// SHOW OPERATION

$(document).on('click','.view',function(){
if(admin_loader == 1)
  {
  $('.submit-loader').show();
}
  $('#modal1').find('.modal-title').html($('#headerdata').val()+' DETAILS');
  $('#modal1 .modal-content .modal-body').html('').load($(this).attr('data-href'),function(response, status, xhr){
      if(status == "success")
      {
        if(admin_loader == 1)
          {
            $('.submit-loader').hide();
          }
      }

    });
});


// SHOW OPERATION END


// TRACK OPERATION

$(document).on('click','.track',function(){
if(admin_loader == 1)
  {
  $('.submit-loader').show();
}
  $('#modal1').find('.modal-title').html('Shipping Details');
  $('#modal1 .modal-content .modal-body').html('').load($(this).attr('data-href'),function(response, status, xhr){
      if(status == "success")
      {
        if(admin_loader == 1)
          {
            $('.submit-loader').hide();
          }
      }

    });
});


// TRACK OPERATION END


// DELIVERY OPERATION

$(document).on('click','.delivery',function(){
if(admin_loader == 1)
  {
  $('.submit-loader').show();
}
  $('#modal1').find('.modal-title').html('DELIVERY STATUS');
  $('#modal1 .modal-content .modal-body').html('').load($(this).attr('data-href'),function(response, status, xhr){
      if(status == "success")
      {
        if(admin_loader == 1)
          {
            $('.submit-loader').hide();
          }
      }

    });
});

$(document).on('click','.exchange-accept',function(){
if(admin_loader == 1)
  {
  $('.submit-loader').show();
}
  $('#modalaccept').find('.modal-title').html('Accept');
  $('#modalaccept .modal-content .modal-body').html('').load($(this).attr('data-href'),function(response, status, xhr){
      if(status == "success")
      {
        if(admin_loader == 1)
          {
            $('.submit-loader').hide();
          }
      }

    });
});

$(document).on('click','.rto-accept',function(){
if(admin_loader == 1)
  {
  $('.submit-loader').show();
}
  $('#modalaccept').find('.modal-title').html('Accept');
  $('#modalaccept .modal-content .modal-body').html('').load($(this).attr('data-href'),function(response, status, xhr){
      if(status == "success")
      {
        if(admin_loader == 1)
          {
            $('.submit-loader').hide();
          }
      }

    });
});

$(document).on('click','.exchange-del',function(){
if(admin_loader == 1)
  {
  $('.submit-loader').show();
}
  $('#modaldel').find('.modal-title').html('Not Delivered');
  $('#modaldel .modal-content .modal-body').html('').load($(this).attr('data-href'),function(response, status, xhr){
      if(status == "success")
      {
        if(admin_loader == 1)
          {
            $('.submit-loader').hide();
          }
      }

    });
});

$(document).on('click','.rto-del',function(){
if(admin_loader == 1)
  {
  $('.submit-loader').show();
}
  $('#modaldel').find('.modal-title').html('Not Delivered');
  $('#modaldel .modal-content .modal-body').html('').load($(this).attr('data-href'),function(response, status, xhr){
      if(status == "success")
      {
        if(admin_loader == 1)
          {
            $('.submit-loader').hide();
          }
      }

    });
});

$(document).on('click','.approval-accept',function(){
if(admin_loader == 1)
  {
  $('.submit-loader').show();
}
  $('#modalapprove').find('.modal-title').html('Accept');
  $('#modalapprove .modal-content .modal-body').html('').load($(this).attr('data-href'),function(response, status, xhr){
      if(status == "success")
      {
        if(admin_loader == 1)
          {
            $('.submit-loader').hide();
          }
      }

    });
});

$(document).on('click','.approval-reject',function(){
if(admin_loader == 1)
  {
  $('.submit-loader').show();
}
  $('#modalreject').find('.modal-title').html('Reject');
  $('#modalreject .modal-content .modal-body').html('').load($(this).attr('data-href'),function(response, status, xhr){
      if(status == "success")
      {
        if(admin_loader == 1)
          {
            $('.submit-loader').hide();
          }
      }

    });
});


$(document).on('click','.refundorderd',function(){
if(admin_loader == 1)
  {
  $('.submit-loader').show();
}
  $('#modal1').find('.modal-title').html('REFUND');
  $('#modal1 .modal-content .modal-body').html('').load($(this).attr('data-href'),function(response, status, xhr){
      if(status == "success")
      {
        if(admin_loader == 1)
          {
            $('.submit-loader').hide();
          }
      }

    });
});


$(document).on('click','.updatedata',function(){
if(admin_loader == 1)
  {
  $('.submit-loader').show();
}
  $('#modal1').find('.modal-title').html('Update Data');
  $('#modal1 .modal-content .modal-body').html('').load($(this).attr('data-href'),function(response, status, xhr){
      if(status == "success")
      {
        if(admin_loader == 1)
          {
            $('.submit-loader').hide();
          }
      }

    });
});

$(document).on('click','.rejectwithdraw',function(){
if(admin_loader == 1)
  {
  $('.submit-loader').show();
}
  $('#modal1').find('.modal-title').html('Reject Withdraw');
  $('#modal1 .modal-content .modal-body').html('').load($(this).attr('data-href'),function(response, status, xhr){
      if(status == "success")
      {
        if(admin_loader == 1)
          {
            $('.submit-loader').hide();
          }
      }

    });
});


// DELIVERY OPERATION END



// ADD / EDIT FORM SUBMIT FOR DATA TABLE


$(document).on('submit','#geniusformdata',function(e){
  e.preventDefault();
if(admin_loader == 1)
  {
  $('.submit-loader').show();
}
  $('button.addProductSubmit-btn').prop('disabled',true);
  disablekey();
      $.ajax({
       method:"POST",
       url:$(this).prop('action'),
       data:new FormData(this),
       dataType:'JSON',
       contentType: false,
       cache: false,
       processData: false,
       success:function(data)
       {
          console.log(data);
          if ((data.errors)) {
          $('.alert-danger').show();
          $('.alert-danger ul').html('');
            for(var error in data.errors)
            {
              $('.alert-danger ul').append('<li>'+ data.errors[error] +'</li>');
            }
            
        if(admin_loader == 1)
          {
            $('.submit-loader').hide();
          }
            $("#modal1 .modal-content .modal-body .alert-danger").focus();
            $('button.addProductSubmit-btn').prop('disabled',false);
            $('#geniusformdata input , #geniusformdata select , #geniusformdata textarea').eq(1).focus();
          }
          else
          {
            
            var url = $(location).attr('href'),
    parts = url.split("/"),
    last_part = parts[parts.length-1];
    //console.log(last_part);
    if(last_part!='show'){
      table.ajax.reload();  
    }
    
            $('.alert-success').show();
            $('.alert-success p').html(data);
        if(admin_loader == 1)
          {
            $('.submit-loader').hide();
          }
            $('button.addProductSubmit-btn').prop('disabled',false);
            $('#modal1,#modal2,#modal3,#verify-modal,#verify-modal,#cpassword-modal').modal('hide');
            table.ajax.reload();

           }
          enablekey();
       }

      });

});


// ADD / EDIT FORM SUBMIT FOR DATA TABLE ENDS

// CATALOG OPTION

      $('#catalog-modal').on('show.bs.modal', function(e) {
          $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
      });

      $('#catalog-modal .btn-ok').on('click', function(e) {

if(admin_loader == 1)
  {
  $('.submit-loader').show();
}

        $.ajax({
         type:"GET",
         url:$(this).attr('href'),
         success:function(data)
         {
              $('#catalog-modal').modal('toggle');
              table.ajax.reload();
              $('.alert-danger').hide();
              $('.alert-success').show();
              $('.alert-success p').html(data);


        if(admin_loader == 1)
          {
            $('.submit-loader').hide();
          }


         }
        });
        return false;
      });


 // CATALOG OPTION ENDS

      $('#confirm-delete').on('show.bs.modal', function(e) {
          $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
      });

      $('#confirm-delete .btn-ok').on('click', function(e) {

if(admin_loader == 1)
  {
  $('.submit-loader').show();
}

        $.ajax({
         type:"GET",
         url:$(this).attr('href'),
         success:function(data)
         {
              $('#confirm-delete').modal('toggle');
              table.ajax.reload();
              $('.alert-danger').hide();
              $('.alert-success').show();
              $('.alert-success p').html(data);


        if(admin_loader == 1)
          {
            $('.submit-loader').hide();
          }


         }
        });
        return false;
      });

      $('#confirm-delete1 .btn-ok').on('click', function(e) {

      if(admin_loader == 1)
        {
        $('.submit-loader').show();
      }

        $.ajax({
         type:"GET",
         url:$(this).attr('href'),
         success:function(data)
         {
              $('#confirm-delete1').modal('toggle');
              table.ajax.reload();
              $('.alert-danger').hide();
              $('.alert-success').show();
              $('.alert-success p').html(data[0]);

        if(admin_loader == 1)
          {
            $('.submit-loader').hide();
          }


         }
        });

        if($('#t-txt').length > 0)
{

      var tdata =  $('#t-txt').val();

      if(tdata.length > 0) {

        var id = $('#t-id').val();
        var title = $('#t-title').val();
        var text = $('#t-txt').val();
        $.ajax({
          url: $('#t-add').val(),
          method: "GET",
          data: { id : id, title: title, text : text }
        });

      }

}




        return false;
      });


    $('#confirm-delete2 .btn-ok').on('click', function(e) {

if(admin_loader == 1)
  {
  $('.submit-loader').show();
}

      $.ajax({
       type:"GET",
       url:$(this).attr('href'),
       success:function(data)
       {

        if(admin_loader == 1)
          {
            $('.submit-loader').hide();
          }

            $('#confirm-delete2').modal('toggle');
            $('.alert-danger').hide();
            $('.alert-success').show();
            $('.alert-success p').html(data[0]);
            $(".nice-select.process.select.order-droplinks").attr('class','nice-select process select order-droplinks '+data[1]);
       }
      });

      return false;
    });

 $('#refundpopup .btn-ok').on('click', function(e) {

if(admin_loader == 1)
  {
  $('.submit-loader').show();
}

      $.ajax({
       type:"GET",
       url:$(this).attr('href'),
       success:function(data)
       {

        if(admin_loader == 1)
          {
            $('.submit-loader').hide();
          }

            $('#refundpopup').modal('toggle');
            $('.alert-danger').hide();
            $('.alert-success').show();
            $('.alert-success p').html(data[0]);
            $(".nice-select.process.select.order-droplinks").attr('class','nice-select process select order-droplinks '+data[1]);
       }
      });

      return false;
    });

// DELETE OPERATION END

  });
  
  
   $(document).ready(function() {
    $("form#adddebitnoteform, form#settlementform, form#addcreditnoteform, form#raisedisputeform, form#declineform, form#redonform, form#redoffform,form#createcouponform, form#couponapproveform, form#couponrejectform , form#geniusformdata, form#geniusform, form#vendorform, form#resolvedform, form#exchangedform, form#exxchangedform, form#rtodform, form#rrtodforms, form#disputesforms, form#disputedform, form#exxchangedform, form#currencyform , form#acceptsform, form#editformdata, form#rejectdata, form#trackform, form#refundform, form#shippingform, form#messageform").submit(function() {
        $('button[type=submit], input[type=submit]').prop('disabled',true);
        return true;
    });
});
  
  



// NORMAL FORM

$(document).on('submit','#geniusform',function(e){
e.preventDefault();
if(admin_loader == 1)
  {
$('.gocover').show();
  }

  var fd = new FormData(this);

  if ($('.attr-checkbox').length > 0) {
    $('.attr-checkbox').each(function() {

      // if checkbox checked then take the value of corresponsig price input (if price input exists)
      if($(this).prop('checked') == true) {

        if ($("#"+$(this).attr('id')+'_price').val().length > 0) {
          // if price value is given
          fd.append($("#"+$(this).attr('id')+'_price').data('name'), $("#"+$(this).attr('id')+'_price').val());
        } else {
          // if price value is not given then take 0
          fd.append($("#"+$(this).attr('id')+'_price').data('name'), 0.00);
        }

        // $("#"+$(this).attr('id')+'_price').val(0.00);
      }
    });
  }

var geniusform = $(this);
$('button.addProductSubmit-btn').prop('disabled',true);
    $.ajax({
     method:"POST",
     url:$(this).prop('action'),
     data:fd,
     contentType: false,
     cache: false,
     processData: false,
     success:function(data)
     {
         
        console.log(data);
        if ((data.errors)) {
        geniusform.parent().find('.alert-success').hide();
        geniusform.parent().find('.alert-danger').show();
        geniusform.parent().find('.alert-danger ul').html('');
          for(var error in data.errors)
          {
            $('.alert-danger ul').append('<li>'+ data.errors[error] +'</li>')
          }
          geniusform.find('input , select , textarea').eq(1).focus();
        }
        else if ((data.redirect_url)) {
       window.location.href = data.redirect_url;
        
        }
        else
        {
          geniusform.parent().find('.alert-danger').hide();
          geniusform.parent().find('.alert-success').show();
          geniusform.parent().find('.alert-success p').html(data);
          geniusform.find('input , select , textarea').eq(1).focus();
          setTimeout(function(){
                  location.reload(true);
                }, 1000);
        }
          if(admin_loader == 1){
        $('.gocover').hide();
          }

        $('button.addProductSubmit-btn').prop('disabled',false);


        $(window).scrollTop(0);

     }

    });

});

// NORMAL FORM ENDS


// NORMAL FORM

$(document).on('submit','#vendorform',function(e){
e.preventDefault();
if(admin_loader == 1)
  {
$('.gocover').show();
  }

var fd = new FormData(this);
var vendorform = $(this);
$('button.addVendorRegister-btn').prop('disabled',true);
    $.ajax({
     method:"POST",
     url:$(this).prop('action'),
     data:fd,
     contentType: false,
     cache: false,
     processData: false,
     success:function(data)
     {
        
        if ((data.errors)) {
        vendorform.parent().find('.alert-success').hide();
        vendorform.parent().find('.alert-danger').show();
        vendorform.parent().find('.alert-danger ul').html('');
          for(var error in data.errors)
          {
            $('.alert-danger ul').append('<li>'+ data.errors[error] +'</li>')
          }
          vendorform.find('input , select , textarea').eq(1).focus();
        }
        else
        {
          vendorform.parent().find('.alert-danger').hide();
          vendorform.parent().find('.alert-success').show();
          vendorform.parent().find('.alert-success p').html(data);
          vendorform.find('input , select , textarea').eq(1).focus();
        }
          if(admin_loader == 1){
        $('.gocover').hide();
          }

        $('button.addVendorRegister-btn').prop('disabled',false);


        $(window).scrollTop(0);

     }

    });

});

// NORMAL FORM ENDS

// NORMAL FORM
$(document).on('submit','#documentform',function(e){
e.preventDefault();
if(admin_loader == 1)
  {
$('.gocover').show();
  }

var fd = new FormData(this);
var documentform = $(this);
$('button.addocument-btn').prop('disabled',true);
    $.ajax({
     method:"POST",
     url:$(this).prop('action'),
     data:fd,
     contentType: false,
     cache: false,
     processData: false,
     success:function(data)
     {
        
        if ((data.errors)) {
        documentform.parent().find('.alert-success').hide();
        documentform.parent().find('.alert-danger').show();
        documentform.parent().find('.alert-danger ul').html('');
          for(var error in data.errors)
          {
            $('.alert-danger ul').append('<li>'+ data.errors[error] +'</li>')
          }
          documentform.find('input , select , textarea').eq(1).focus();
        }else if ((data.redirect_url)) {
       window.location.href = data.redirect_url;
        
        }
        else
        {
          documentform.parent().find('.alert-danger').hide();
          documentform.parent().find('.alert-success').show();
          documentform.parent().find('.alert-success p').html(data);
          documentform.find('input , select , textarea').eq(1).focus();
        }
          if(admin_loader == 1){
        $('.gocover').hide();
          }

        $('button.addocument-btn').prop('disabled',false);


        $(window).scrollTop(0);

     }

    });

});

// NORMAL FORM ENDS

// NORMAL FORM

$(document).on('submit','#raisedisputeform',function(e){
e.preventDefault();
if(admin_loader == 1)
  {
$('.gocover').show();
  }

var fd = new FormData(this);
var raisedisputeform = $(this);
$('button.addraisedispute-btn').prop('disabled',true);
    $.ajax({
     method:"POST",
     url:$(this).prop('action'),
     data:fd,
     contentType: false,
     cache: false,
     processData: false,
     success:function(data)
     {
        
        if ((data.errors)) {
        raisedisputeform.parent().find('.alert-success').hide();
        raisedisputeform.parent().find('.alert-danger').show();
        raisedisputeform.parent().find('.alert-danger ul').html('');
          for(var error in data.errors)
          {
            $('.alert-danger ul').append('<li>'+ data.errors[error] +'</li>')
          }
          raisedisputeform.find('input , select , textarea').eq(1).focus();
        }else if ((data.redirect_url)) {
       window.location.href = data.redirect_url;
        
        }
        else
        {
          raisedisputeform.parent().find('.alert-danger').hide();
          raisedisputeform.parent().find('.alert-success').show();
          raisedisputeform.parent().find('.alert-success p').html(data);
          raisedisputeform.find('input , select , textarea').eq(1).focus();
        }
          if(admin_loader == 1){
        $('.gocover').hide();
          }

        $('button.addraisedispute-btn').prop('disabled',false);


        $(window).scrollTop(0);

     }

    });

});

// NORMAL FORM ENDS

// NORMAL FORM

$(document).on('submit','#resolvedform',function(e){
e.preventDefault();
if(admin_loader == 1)
  {
$('.gocover').show();
  }

var fd = new FormData(this);
var resolvedform = $(this);
$('button.resolved-btn').prop('disabled',true);
    $.ajax({
     method:"POST",
     url:$(this).prop('action'),
     data:fd,
     contentType: false,
     cache: false,
     processData: false,
     success:function(data)
     {
        
        if ((data.errors)) {
        resolvedform.parent().find('.alert-success').hide();
        resolvedform.parent().find('.alert-danger').show();
        resolvedform.parent().find('.alert-danger ul').html('');
          for(var error in data.errors)
          {
            $('.alert-danger ul').append('<li>'+ data.errors[error] +'</li>')
          }
          resolvedform.find('input , select , textarea').eq(1).focus();
        } else if ((data.redirect_url)) {
       window.location.href = data.redirect_url;
        
        }
        else
        {
          resolvedform.parent().find('.alert-danger').hide();
          resolvedform.parent().find('.alert-success').show();
          resolvedform.parent().find('.alert-success p').html(data);
          resolvedform.find('input , select , textarea').eq(1).focus();
        }
          if(admin_loader == 1){
        $('.gocover').hide();
          }

        $('button.resolved-btn').prop('disabled',false);


        $(window).scrollTop(0);

     }

    });

});

// NORMAL FORM ENDS

// NORMAL FORM

$(document).on('submit','#declineform',function(e){
e.preventDefault();
if(admin_loader == 1)
  {
$('.gocover').show();
  }

var fd = new FormData(this);
var declineform = $(this);
$('button.decline-btn').prop('disabled',true);
    $.ajax({
     method:"POST",
     url:$(this).prop('action'),
     data:fd,
     contentType: false,
     cache: false,
     processData: false,
     success:function(data)
     {
        
        if ((data.errors)) {
        declineform.parent().find('.alert-success').hide();
        declineform.parent().find('.alert-danger').show();
        declineform.parent().find('.alert-danger ul').html('');
          for(var error in data.errors)
          {
            $('.alert-danger ul').append('<li>'+ data.errors[error] +'</li>')
          }
          declineform.find('input , select , textarea').eq(1).focus();
        } else if ((data.redirect_url)) {
       window.location.href = data.redirect_url;
        
        }
        else
        {
          declineform.parent().find('.alert-danger').hide();
          declineform.parent().find('.alert-success').show();
          declineform.parent().find('.alert-success p').html(data);
          declineform.find('input , select , textarea').eq(1).focus();
        }
          if(admin_loader == 1){
        $('.gocover').hide();
          }

        $('button.decline-btn').prop('disabled',false);


        $(window).scrollTop(0);

     }

    });

});

// NORMAL FORM ENDS


// NORMAL FORM

$(document).on('submit','#redoffform',function(e){
e.preventDefault();
if(admin_loader == 1)
  {
$('.gocover').show();
  }

var fd = new FormData(this);
var redoffform = $(this);
$('button.redoffform-btn').prop('disabled',true);
    $.ajax({
     method:"POST",
     url:$(this).prop('action'),
     data:fd,
     contentType: false,
     cache: false,
     processData: false,
     success:function(data)
     {
        
        if ((data.errors)) {
        redoffform.parent().find('.alert-success').hide();
        redoffform.parent().find('.alert-danger').show();
        redoffform.parent().find('.alert-danger ul').html('');
          for(var error in data.errors)
          {
            $('.alert-danger ul').append('<li>'+ data.errors[error] +'</li>')
          }
          redoffform.find('input , select , textarea').eq(1).focus();
        }else if ((data.redirect_url)) {
       window.location.href = data.redirect_url;
        
        }
        else
        {
          redoffform.parent().find('.alert-danger').hide();
          redoffform.parent().find('.alert-success').show();
          redoffform.parent().find('.alert-success p').html(data);
          redoffform.find('input , select , textarea').eq(1).focus();
		  setTimeout(function(){
                  location.reload(true);
                }, 1000);
        }
          if(admin_loader == 1){
        $('.gocover').hide();
          }

        $('button.redoffform-btn').prop('disabled',false);


        $(window).scrollTop(0);

     }

    });

});

// NORMAL FORM ENDS




// NORMAL FORM

$(document).on('submit','#redonform',function(e){
e.preventDefault();
if(admin_loader == 1)
  {
$('.gocover').show();
  }

var fd = new FormData(this);
var redonform = $(this);
$('button.redonform-btn').prop('disabled',true);
    $.ajax({
     method:"POST",
     url:$(this).prop('action'),
     data:fd,
     contentType: false,
     cache: false,
     processData: false,
     success:function(data)
     {
        
        if ((data.errors)) {
        redonform.parent().find('.alert-success').hide();
        redonform.parent().find('.alert-danger').show();
        redonform.parent().find('.alert-danger ul').html('');
          for(var error in data.errors)
          {
            $('.alert-danger ul').append('<li>'+ data.errors[error] +'</li>')
          }
          redonform.find('input , select , textarea').eq(1).focus();
        }else if ((data.redirect_url)) {
       window.location.href = data.redirect_url;
        
        }
        else
        {
          redonform.parent().find('.alert-danger').hide();
          redonform.parent().find('.alert-success').show();
          redonform.parent().find('.alert-success p').html(data);
          redonform.find('input , select , textarea').eq(1).focus();
		  setTimeout(function(){
                  location.reload(true);
                }, 1000);
        }
          if(admin_loader == 1){
        $('.gocover').hide();
          }

        $('button.redonform-btn').prop('disabled',false);


        $(window).scrollTop(0);

     }

    });

});

// NORMAL FORM ENDS

// NORMAL FORM

$(document).on('submit','#adddebitnoteform',function(e){
e.preventDefault();
if(admin_loader == 1)
  {
$('.gocover').show();
  }

var fd = new FormData(this);
var adddebitnoteform = $(this);
$('button.adddebitnoteform-btn').prop('disabled',true);
    $.ajax({
     method:"POST",
     url:$(this).prop('action'),
     data:fd,
     contentType: false,
     cache: false,
     processData: false,
     success:function(data)
     {
        
        if ((data.errors)) {
        adddebitnoteform.parent().find('.alert-success').hide();
        adddebitnoteform.parent().find('.alert-danger').show();
        adddebitnoteform.parent().find('.alert-danger ul').html('');
          for(var error in data.errors)
          {
            $('.alert-danger ul').append('<li>'+ data.errors[error] +'</li>')
          }
          adddebitnoteform.find('input , select , textarea').eq(1).focus();
        }else if ((data.redirect_url)) {
       window.location.href = data.redirect_url;
        
        }
        else
        {
          adddebitnoteform.parent().find('.alert-danger').hide();
          adddebitnoteform.parent().find('.alert-success').show();
          adddebitnoteform.parent().find('.alert-success p').html(data);
          adddebitnoteform.find('input , select , textarea').eq(1).focus();
        }
          if(admin_loader == 1){
        $('.gocover').hide();
          }

        $('button.adddebitnoteform-btn').prop('disabled',false);


        $(window).scrollTop(0);

     }

    });

});

// NORMAL FORM ENDS

// NORMAL FORM

$(document).on('submit','#addcreditnoteform',function(e){
e.preventDefault();
if(admin_loader == 1)
  {
$('.gocover').show();
  }

var fd = new FormData(this);
var addcreditnoteform = $(this);
$('button.addcreditnoteform-btn').prop('disabled',true);
    $.ajax({
     method:"POST",
     url:$(this).prop('action'),
     data:fd,
     contentType: false,
     cache: false,
     processData: false,
     success:function(data)
     {
        
        if ((data.errors)) {
        addcreditnoteform.parent().find('.alert-success').hide();
        addcreditnoteform.parent().find('.alert-danger').show();
        addcreditnoteform.parent().find('.alert-danger ul').html('');
          for(var error in data.errors)
          {
            $('.alert-danger ul').append('<li>'+ data.errors[error] +'</li>')
          }
          addcreditnoteform.find('input , select , textarea').eq(1).focus();
        }else if ((data.redirect_url)) {
       window.location.href = data.redirect_url;
        
        }
        else
        {
          addcreditnoteform.parent().find('.alert-danger').hide();
          addcreditnoteform.parent().find('.alert-success').show();
          addcreditnoteform.parent().find('.alert-success p').html(data);
          addcreditnoteform.find('input , select , textarea').eq(1).focus();
        }
          if(admin_loader == 1){
        $('.gocover').hide();
          }

        $('button.addcreditnoteform-btn').prop('disabled',false);


        $(window).scrollTop(0);

     }

    });

});

// NORMAL FORM ENDS

// NORMAL FORM

$(document).on('submit','#settlementform',function(e){
e.preventDefault();
if(admin_loader == 1)
  {
$('.gocover').show();
  }

var fd = new FormData(this);
var settlementform = $(this);
$('button.settlementform-btn').prop('disabled',true);
    $.ajax({
     method:"POST",
     url:$(this).prop('action'),
     data:fd,
     contentType: false,
     cache: false,
     processData: false,
     success:function(data)
     {
        
        if ((data.errors)) {
        settlementform.parent().find('.alert-success').hide();
        settlementform.parent().find('.alert-danger').show();
        settlementform.parent().find('.alert-danger ul').html('');
          for(var error in data.errors)
          {
            $('.alert-danger ul').append('<li>'+ data.errors[error] +'</li>')
          }
          settlementform.find('input , select , textarea').eq(1).focus();
        }
        else
        {
          settlementform.parent().find('.alert-danger').hide();
          settlementform.parent().find('.alert-success').show();
          settlementform.parent().find('.alert-success p').html(data);
          settlementform.find('input , select , textarea').eq(1).focus();
        }
          if(admin_loader == 1){
        $('.gocover').hide();
          }

        $('button.settlementform-btn').prop('disabled',false);


        $(window).scrollTop(0);

     }

    });

});

// NORMAL FORM ENDS

// NORMAL FORM

$(document).on('submit','#exchangedform',function(e){
e.preventDefault();
if(admin_loader == 1)
  {
$('.gocover').show();
  }

var fd = new FormData(this);
var exchangedform = $(this);
$('button.exchangedform-btn').prop('disabled',true);
    $.ajax({
     method:"POST",
     url:$(this).prop('action'),
     data:fd,
     contentType: false,
     cache: false,
     processData: false,
     success:function(data)
     {
        
        if ((data.errors)) {
        exchangedform.parent().find('.alert-success').hide();
        exchangedform.parent().find('.alert-danger').show();
        exchangedform.parent().find('.alert-danger ul').html('');
          for(var error in data.errors)
          {
            $('.alert-danger ul').append('<li>'+ data.errors[error] +'</li>')
          }
          exchangedform.find('input , select , textarea').eq(1).focus();
        }
        else
        {
          exchangedform.parent().find('.alert-danger').hide();
          exchangedform.parent().find('.alert-success').show();
          exchangedform.parent().find('.alert-success p').html(data);
          exchangedform.find('input , select , textarea').eq(1).focus();
		  setTimeout(function(){
                  location.reload(true);
                }, 1000);
        }
          if(admin_loader == 1){
        $('.gocover').hide();
          }

        $('button.exchangedform-btn').prop('disabled',false);


        $(window).scrollTop(0);

     }

    });

});

// NORMAL FORM ENDS

// NORMAL FORM

$(document).on('submit','#exxchangedform',function(e){
e.preventDefault();
if(admin_loader == 1)
  {
$('.gocover').show();
  }

var fd = new FormData(this);
var exxchangedform = $(this);
$('button.addexchanges-btn').prop('disabled',true);
    $.ajax({
     method:"POST",
     url:$(this).prop('action'),
     data:fd,
     contentType: false,
     cache: false,
     processData: false,
     success:function(data)
     {
        
        if ((data.errors)) {
        exxchangedform.parent().find('.alert-success').hide();
        exxchangedform.parent().find('.alert-danger').show();
        exxchangedform.parent().find('.alert-danger ul').html('');
          for(var error in data.errors)
          {
            $('.alert-danger ul').append('<li>'+ data.errors[error] +'</li>')
          }
          exxchangedform.find('input , select , textarea').eq(1).focus();
        }else if ((data.redirect_url)) {
			$('#exchangemod').hide();
       window.location.href = data.redirect_url;
        
        }
        else
        {
		  $('#exchangemod').hide();
          exxchangedform.parent().find('.alert-danger').hide();
          exxchangedform.parent().find('.alert-success').show();
          exxchangedform.parent().find('.alert-success p').html(data);
          exxchangedform.find('input , select , textarea').eq(1).focus();
        }
          if(admin_loader == 1){
        $('.gocover').hide();
          }

        $('button.addexchanges-btn').prop('disabled',false);


        $(window).scrollTop(0);

     }

    });

});

// NORMAL FORM ENDS

// NORMAL FORM

$(document).on('submit','#rtodforms',function(e){
e.preventDefault();
if(admin_loader == 1)
  {
$('.gocover').show();
  }

var fd = new FormData(this);
var rtodforms = $(this);
$('button.rtodforms-btn').prop('disabled',true);
    $.ajax({
     method:"POST",
     url:$(this).prop('action'),
     data:fd,
     contentType: false,
     cache: false,
     processData: false,
     success:function(data)
     {
        
        if ((data.errors)) {
        rtodforms.parent().find('.alert-success').hide();
        rtodforms.parent().find('.alert-danger').show();
        rtodforms.parent().find('.alert-danger ul').html('');
          for(var error in data.errors)
          {
            $('.alert-danger ul').append('<li>'+ data.errors[error] +'</li>')
          }
          rtodforms.find('input , select , textarea').eq(1).focus();
        }
        else
        {
          rtodforms.parent().find('.alert-danger').hide();
          rtodforms.parent().find('.alert-success').show();
          rtodforms.parent().find('.alert-success p').html(data);
          rtodforms.find('input , select , textarea').eq(1).focus();
		  setTimeout(function(){
                  location.reload(true);
                }, 1000);
        }
          if(admin_loader == 1){
        $('.gocover').hide();
          }

        $('button.rtodforms-btn').prop('disabled',false);


        $(window).scrollTop(0);

     }

    });

});

// NORMAL FORM ENDS

// NORMAL FORM

$(document).on('submit','#rrtodforms',function(e){
e.preventDefault();
if(admin_loader == 1)
  {
$('.gocover').show();
  }

var fd = new FormData(this);
var rrtodforms = $(this);
$('button.addrtos-btn').prop('disabled',true);
    $.ajax({
     method:"POST",
     url:$(this).prop('action'),
     data:fd,
     contentType: false,
     cache: false,
     processData: false,
     success:function(data)
     {
        
        if ((data.errors)) {
        rrtodforms.parent().find('.alert-success').hide();
        rrtodforms.parent().find('.alert-danger').show();
        rrtodforms.parent().find('.alert-danger ul').html('');
          for(var error in data.errors)
          {
            $('.alert-danger ul').append('<li>'+ data.errors[error] +'</li>')
          }
          rrtodforms.find('input , select , textarea').eq(1).focus();
        }else if ((data.redirect_url)) {
			$('#rtomod').hide();
       window.location.href = data.redirect_url;
        
        }
        else
        {
		  $('#rtomod').hide();
          rrtodforms.parent().find('.alert-danger').hide();
          rrtodforms.parent().find('.alert-success').show();
          rrtodforms.parent().find('.alert-success p').html(data);
          rrtodforms.find('input , select , textarea').eq(1).focus();
        }
          if(admin_loader == 1){
        $('.gocover').hide();
          }

        $('button.addrtos-btn').prop('disabled',false);


        $(window).scrollTop(0);

     }

    });

});

// NORMAL FORM ENDS

// NORMAL FORM

$(document).on('submit','#disputesforms',function(e){
e.preventDefault();
if(admin_loader == 1)
  {
$('.gocover').show();
  }

var fd = new FormData(this);
var disputesforms = $(this);
$('button.adddisputes-btn').prop('disabled',true);
    $.ajax({
     method:"POST",
     url:$(this).prop('action'),
     data:fd,
     contentType: false,
     cache: false,
     processData: false,
     success:function(data)
     {
        
        if ((data.errors)) {
        disputesforms.parent().find('.alert-success').hide();
        disputesforms.parent().find('.alert-danger').show();
        disputesforms.parent().find('.alert-danger ul').html('');
          for(var error in data.errors)
          {
            $('.alert-danger ul').append('<li>'+ data.errors[error] +'</li>')
          }
          disputesforms.find('input , select , textarea').eq(1).focus();
        }else if ((data.redirect_url)) {
			$('#rtomod').hide();
       window.location.href = data.redirect_url;
        
        }
        else
        {
		  $('#rtomod').hide();
          disputesforms.parent().find('.alert-danger').hide();
          disputesforms.parent().find('.alert-success').show();
          disputesforms.parent().find('.alert-success p').html(data);
          disputesforms.find('input , select , textarea').eq(1).focus();
        }
          if(admin_loader == 1){
        $('.gocover').hide();
          }

        $('button.adddisputes-btn').prop('disabled',false);


        $(window).scrollTop(0);

     }

    });

});

// NORMAL FORM ENDS

// NORMAL FORM

$(document).on('submit','#disputedform',function(e){
e.preventDefault();
if(admin_loader == 1)
  {
$('.gocover').show();
  }

var fd = new FormData(this);
var disputedform = $(this);
$('button.disputedform-btn').prop('disabled',true);
    $.ajax({
     method:"POST",
     url:$(this).prop('action'),
     data:fd,
     contentType: false,
     cache: false,
     processData: false,
     success:function(data)
     {
        
        if ((data.errors)) {
        disputedform.parent().find('.alert-success').hide();
        disputedform.parent().find('.alert-danger').show();
        disputedform.parent().find('.alert-danger ul').html('');
          for(var error in data.errors)
          {
            $('.alert-danger ul').append('<li>'+ data.errors[error] +'</li>')
          }
          disputedform.find('input , select , textarea').eq(1).focus();
        }
        else
        {
          disputedform.parent().find('.alert-danger').hide();
          disputedform.parent().find('.alert-success').show();
          disputedform.parent().find('.alert-success p').html(data);
          disputedform.find('input , select , textarea').eq(1).focus();
		  setTimeout(function(){
                  location.reload(true);
                }, 1000);
        }
          if(admin_loader == 1){
        $('.gocover').hide();
          }

        $('button.disputedform-btn').prop('disabled',false);


        $(window).scrollTop(0);

     }

    });

});

// NORMAL FORM ENDS


// NORMAL FORM

$(document).on('submit','#currencyform',function(e){
e.preventDefault();
if(admin_loader == 1)
  {
$('.gocover').show();
  }

var fd = new FormData(this);
var currencyform = $(this);
$('button.btn-success').prop('disabled',true);
    $.ajax({
     method:"POST",
     url:$(this).prop('action'),
     data:fd,
     contentType: false,
     cache: false,
     processData: false,
     success:function(data)
     {
        console.log(data);
        if ((data.errors)) {
        currencyform.parent().find('.alert-success').hide();
        currencyform.parent().find('.alert-danger').show();
        currencyform.parent().find('.alert-danger ul').html('');
          for(var error in data.errors)
          {
            $('.alert-danger ul').append('<li>'+ data.errors[error] +'</li>')
          }
          currencyform.find('input , select , textarea').eq(1).focus();
        }
        else
        {
          currencyform.parent().find('.alert-danger').hide();
          currencyform.parent().find('.alert-success').show();
          currencyform.parent().find('.alert-success p').html(data);
          currencyform.find('input , select , textarea').eq(1).focus();
        }
          if(admin_loader == 1){
        $('.gocover').hide();
          }

        $('button.btn-success').prop('disabled',false);


        $(window).scrollTop(0);

     }

    });

});

// NORMAL FORM ENDS

// NORMAL FORM

$(document).on('submit','#couponapproveform',function(e){
e.preventDefault();
if(admin_loader == 1)
  {
$('.gocover').show();
  }

var fd = new FormData(this);
var couponapproveform = $(this);
$('button.couponapproveform-btn').prop('disabled',true);
    $.ajax({
     method:"POST",
     url:$(this).prop('action'),
     data:fd,
     contentType: false,
     cache: false,
     processData: false,
     success:function(data)
     {
        
        if ((data.errors)) {
        couponapproveform.parent().find('.alert-success').hide();
        couponapproveform.parent().find('.alert-danger').show();
        couponapproveform.parent().find('.alert-danger ul').html('');
          for(var error in data.errors)
          {
            $('.alert-danger ul').append('<li>'+ data.errors[error] +'</li>')
          }
          couponapproveform.find('input , select , textarea').eq(1).focus();
        }
        else
        {
          couponapproveform.parent().find('.alert-danger').hide();
          couponapproveform.parent().find('.alert-success').show();
          couponapproveform.parent().find('.alert-success p').html(data);
          couponapproveform.find('input , select , textarea').eq(1).focus();
		  setTimeout(function(){
                  location.reload(true);
                }, 1000);
        }
          if(admin_loader == 1){
        $('.gocover').hide();
          }

        $('button.couponapproveform-btn').prop('disabled',false);


        $(window).scrollTop(0);

     }

    });

});

// NORMAL FORM ENDS

// NORMAL FORM

$(document).on('submit','#couponrejectform',function(e){
e.preventDefault();
if(admin_loader == 1)
  {
$('.gocover').show();
  }

var fd = new FormData(this);
var couponrejectform = $(this);
$('button.couponrejectform-btn').prop('disabled',true);
    $.ajax({
     method:"POST",
     url:$(this).prop('action'),
     data:fd,
     contentType: false,
     cache: false,
     processData: false,
     success:function(data)
     {
        
        if ((data.errors)) {
        couponrejectform.parent().find('.alert-success').hide();
        couponrejectform.parent().find('.alert-danger').show();
        couponrejectform.parent().find('.alert-danger ul').html('');
          for(var error in data.errors)
          {
            $('.alert-danger ul').append('<li>'+ data.errors[error] +'</li>')
          }
          couponrejectform.find('input , select , textarea').eq(1).focus();
        }
        else
        {
          couponrejectform.parent().find('.alert-danger').hide();
          couponrejectform.parent().find('.alert-success').show();
          couponrejectform.parent().find('.alert-success p').html(data);
          couponrejectform.find('input , select , textarea').eq(1).focus();
		  setTimeout(function(){
                  location.reload(true);
                }, 1000);
        }
          if(admin_loader == 1){
        $('.gocover').hide();
          }

        $('button.couponrejectform-btn').prop('disabled',false);


        $(window).scrollTop(0);

     }

    });

});

// NORMAL FORM ENDS

// NORMAL FORM

$(document).on('submit','#acceptsform',function(e){
e.preventDefault();
if(admin_loader == 1)
  {
$('.gocover').show();
  }

var fd = new FormData(this);
var acceptsform = $(this);
$('button.acceptsform-btn').prop('disabled',true);
    $.ajax({
     method:"POST",
     url:$(this).prop('action'),
     data:fd,
     contentType: false,
     cache: false,
     processData: false,
     success:function(data)
     {
        
        if ((data.errors)) {
        acceptsform.parent().find('.alert-success').hide();
        acceptsform.parent().find('.alert-danger').show();
        acceptsform.parent().find('.alert-danger ul').html('');
          for(var error in data.errors)
          {
            $('.alert-danger ul').append('<li>'+ data.errors[error] +'</li>')
          }
          acceptsform.find('input , select , textarea').eq(1).focus();
        } else if ((data.redirect_url)) {
       window.location.href = data.redirect_url;
        
        }
        else
        {
          acceptsform.parent().find('.alert-danger').hide();
          acceptsform.parent().find('.alert-success').show();
          acceptsform.parent().find('.alert-success p').html(data);
          acceptsform.find('input , select , textarea').eq(1).focus();
		  /*setTimeout(function(){
                  location.reload(true);
                }, 1000);*/
        }
          if(admin_loader == 1){
        $('.gocover').hide();
          }

        $('button.acceptsform-btn').prop('disabled',false);


        $(window).scrollTop(0);

     }

    });

});

// NORMAL FORM ENDS

// NORMAL FORM

$(document).on('submit','#editformdata',function(e){
e.preventDefault();
if(admin_loader == 1)
  {
$('.gocover').show();
  }

var fd = new FormData(this);
var editformdata = $(this);
$('button.addProductSubmit-btn').prop('disabled',true);
    $.ajax({
     method:"POST",
     url:$(this).prop('action'),
     data:fd,
     contentType: false,
     cache: false,
     processData: false,
      success:function(data)
     {
        
        if ((data.errors)) {
        //editformdata.parent().find('.alert-success').hide();
        editformdata.parent().find('.alert-danger').show();
        editformdata.parent().find('.alert-danger ul').html('');
          for(var error in data.errors)
          {
            $('.alert-danger ul').append('<li>'+ data.errors[error] +'</li>')
          }
          editformdata.find('input , select , textarea').eq(1).focus();
        }
        else
        {
          /*editformdata.parent().find('.alert-danger').hide();
          editformdata.parent().find('.alert-success').show();
          editformdata.parent().find('.alert-success p').html(data);
          editformdata.find('input , select , textarea').eq(1).focus();*/
		  $('.alert-success').show();
			  $('#modal1').modal('hide');
			  /*setTimeout(function() {
   $('#alert-success').slideUp('slow', location.reload);
}, 3000);*/
setTimeout(function(){
     $('#alert-success').slideUp('slow').fadeOut(function() {
         window.location.reload();
         /* or window.location = window.location.href; */
     });
}, 3000);
			  
			  $('.alert-success p').html(data); 
        }
          if(admin_loader == 1){
        $('.gocover').hide();
          }

        $('button.addProductSubmit-btn').prop('disabled',false);


        $(window).scrollTop(0);

     }

    });

});

// NORMAL FORM ENDS

// NORMAL FORM

$(document).on('submit','#rejectdata',function(e){
e.preventDefault();
if(admin_loader == 1)
  {
$('.gocover').show();
  }

var fd = new FormData(this);
var rejectdata = $(this);
$('button.btn-ok').prop('disabled',true);
    $.ajax({
     method:"POST",
     url:$(this).prop('action'),
     data:fd,
     contentType: false,
     cache: false,
     processData: false,
      success:function(data)
     {
        
        if ((data.errors)) {
        
        rejectdata.parent().find('.alert-danger').show();
        rejectdata.parent().find('.alert-danger ul').html('');
          for(var error in data.errors)
          {
            $('.alert-danger ul').append('<li>'+ data.errors[error] +'</li>')
          }
          rejectdata.find('input,select,textarea').eq(1).focus();
        }
        else
        {
        
		$('.alert-success').show();
		$('#modal1').modal('hide');		
     setTimeout(function(){
     $('#alert-success').slideUp('slow').fadeOut(function() {
         window.location.reload();         
     });
      }, 3000);
			  
		 $('.alert-success p').html(data); 
        }
          if(admin_loader == 1){
        $('.gocover').hide();
          }

        $('button.btn-ok').prop('disabled',false);


        $(window).scrollTop(0);

     }

    });

});

// NORMAL FORM ENDS

// NORMAL FORM

$(document).on('submit','#trackform',function(e){
  e.preventDefault();
  if(admin_loader == 1)
  {
  $('.gocover').show();
  }

  $('button.addProductSubmit-btn').prop('disabled',true);
      $.ajax({
       method:"POST",
       url:$(this).prop('action'),
       data:new FormData(this),
       contentType: false,
       cache: false,
       processData: false,
       success:function(data)
       {
          if ((data.errors)) {
          $('#trackform .alert-success').hide();
          $('#trackform .alert-danger').show();
          $('#trackform .alert-danger ul').html('');
            for(var error in data.errors)
            {
              $('#trackform .alert-danger ul').append('<li>'+ data.errors[error] +'</li>')
            }
            $('#trackform input , #trackform select , #trackform textarea').eq(1).focus();
          }
          else
          {
            
			$('.alert-danger').hide();
            $('.alert-success').show();
            $('.alert-success p').html(data);
			location.reload();

          }
  if(admin_loader == 1)
  {
          $('.gocover').hide();
  }

          $('button.addProductSubmit-btn').prop('disabled',false);
       }

      });

});


$(document).on('submit','#refundform',function(e){
  e.preventDefault();
  if(admin_loader == 1)
  {
  $('.gocover').show();
  }

  $('button.addProductSubmit-btn').prop('disabled',true);
      $.ajax({
       method:"POST",
       url:$(this).prop('action'),
       data:new FormData(this),
       contentType: false,
       cache: false,
       processData: false,
       success:function(data)
       {
          if ((data.errors)) {
          $('#refundform .alert-success').hide();
          $('#refundform .alert-danger').show();
          $('#refundform .alert-danger ul').html('');
            for(var error in data.errors)
            {
              $('#refundform .alert-danger ul').append('<li>'+ data.errors[error] +'</li>')
            }            
          }
          else
          {
            $('#refundform .alert-danger').hide();
            $('#refundform .alert-success').show();
            $('#refundform .alert-success p').html(data);            
            //$('#modal1').modal('hide');
			//table.ajax.reload();

          }
  if(admin_loader == 1)
  {
          $('.gocover').hide();
  }

          $('button.addProductSubmit-btn').prop('disabled',false);
       }

      });

});




// NORMAL FORM ENDS

// NORMAL FORM

$(document).on('submit','#shippingform',function(e){
e.preventDefault();
if(admin_loader == 1)
  {
$('.gocover').show();
  }

var fd = new FormData(this);
var shippingform = $(this);
$('button.btn-success').prop('disabled',true);
    $.ajax({
     method:"POST",
     url:$(this).prop('action'),
     data:fd,
     contentType: false,
     cache: false,
     processData: false,
     success:function(data)
     {
        console.log(data);
        if ((data.errors)) {
        shippingform.parent().find('.alert-success').hide();
        shippingform.parent().find('.alert-danger').show();
        shippingform.parent().find('.alert-danger ul').html('');
          for(var error in data.errors)
          {
            $('.alert-danger ul').append('<li>'+ data.errors[error] +'</li>')
          }
          shippingform.find('input , select , textarea').eq(1).focus();
        }
        else
        {
          shippingform.parent().find('.alert-danger').hide();
          shippingform.parent().find('.alert-success').show();
          shippingform.parent().find('.alert-success p').html(data);
          shippingform.find('input , select , textarea').eq(1).focus();
        }
          if(admin_loader == 1){
        $('.gocover').hide();
          }

        $('button.btn-success').prop('disabled',false);


        $(window).scrollTop(0);

     }

    });

});

// NORMAL FORM ENDS

// NORMAL FORM

$(document).on('submit','#createcouponform',function(e){
e.preventDefault();
if(admin_loader == 1)
  {
$('.gocover').show();
  }

var fd = new FormData(this);
var createcouponform = $(this);
$('button.createcoupon-btn').prop('disabled',true);
    $.ajax({
     method:"POST",
     url:$(this).prop('action'),
     data:fd,
     contentType: false,
     cache: false,
     processData: false,
     success:function(data)
     {
        
        if ((data.errors)) {
        createcouponform.parent().find('.alert-success').hide();
        createcouponform.parent().find('.alert-danger').show();
        createcouponform.parent().find('.alert-danger ul').html('');
          for(var error in data.errors)
          {
            $('.alert-danger ul').append('<li>'+ data.errors[error] +'</li>')
          }
          createcouponform.find('input , select , textarea').eq(1).focus();
        }
        else
        {
          createcouponform.parent().find('.alert-danger').hide();
          createcouponform.parent().find('.alert-success').show();
          createcouponform.parent().find('.alert-success p').html(data);
          createcouponform.find('input , select , textarea').eq(1).focus();
		  setTimeout(function(){
                  location.reload(true);
                }, 1000);
        }
          if(admin_loader == 1){
        $('.gocover').hide();
          }

        $('button.createcoupon-btn').prop('disabled',false);


        $(window).scrollTop(0);

     }

    });

});

// NORMAL FORM ENDS

// MESSAGE FORM

$(document).on('submit','#messageform',function(e){
  e.preventDefault();
  var href = $(this).data('href');
  if(admin_loader == 1)
  {
  $('.gocover').show();
  }
  $('button.mybtn1').prop('disabled',true);
      $.ajax({
       method:"POST",
       url:$(this).prop('action'),
       data:new FormData(this),
       contentType: false,
       cache: false,
       processData: false,
       success:function(data)
       {
          if ((data.errors)) {
          $('.alert-success').hide();
          $('.alert-danger').show();
          $('.alert-danger ul').html('');
            for(var error in data.errors)
            {
              $('.alert-danger ul').append('<li>'+ data.errors[error] +'</li>')
            }
            $('#messageform textarea').val('');
          }
          else
          {
            $('.alert-danger').hide();
            $('.alert-success').show();
            $('.alert-success p').html(data);
            $('#messageform textarea').val('');
            $('#messages').load(href);
          }
  if(admin_loader == 1)
  {
          $('.gocover').hide();
  }
          $('button.mybtn1').prop('disabled',false);
       }
      });
});

// MESSAGE FORM ENDS


// LOGIN FORM

$("#loginform").on('submit',function(e){
  e.preventDefault();
  $('button.submit-btn').prop('disabled',true);
  $('.alert-info').show();
  $('.alert-info p').html($('#authdata').val());
      $.ajax({
       method:"POST",
       url:$(this).prop('action'),
       data:new FormData(this),
       dataType:'JSON',
       contentType: false,
       cache: false,
       processData: false,
       success:function(data)
       {
          if ((data.errors)) {
          $('.alert-success').hide();
          $('.alert-info').hide();
          $('.alert-danger').show();
          $('.alert-danger ul').html('');
            for(var error in data.errors)
            {
              $('.alert-danger p').html(data.errors[error]);
            }
          }
          else
          {
            $('.alert-info').hide();
            $('.alert-danger').hide();
            $('.alert-success').show();
            $('.alert-success p').html('Success !');
            window.location = data;
          }
          $('button.submit-btn').prop('disabled',false);
       }

      });

});


// LOGIN FORM ENDS


// FORGOT FORM

$("#forgotform").on('submit',function(e){
  e.preventDefault();
  $('button.submit-btn').prop('disabled',true);
  $('.alert-info').show();
  $('.alert-info p').html($('#authdata').val());
      $.ajax({
       method:"POST",
       url:$(this).prop('action'),
       data:new FormData(this),
       dataType:'JSON',
       contentType: false,
       cache: false,
       processData: false,
       success:function(data)
       {
          if ((data.errors)) {
          $('.alert-success').hide();
          $('.alert-info').hide();
          $('.alert-danger').show();
          $('.alert-danger ul').html('');
            for(var error in data.errors)
            {
              $('.alert-danger p').html(data.errors[error]);
            }
          }
          else
          {
            $('.alert-info').hide();
            $('.alert-danger').hide();
            $('.alert-success').show();
            $('.alert-success p').html(data);
            $('input[type=email]').val('');
          }
          $('button.submit-btn').prop('disabled',false);
       }

      });

});


// FORGOT FORM ENDS

// USER REGISTER NOTIFICATION

$(document).ready(function(){
    setInterval(function(){
            $.ajax({
                    type: "GET",
                    url:$("#user-notf-count").data('href'),
                    success:function(data){
                        $("#user-notf-count").html(data);
                      }
              });
    }, 5000);
});

$(document).on('click','#notf_user',function(){
  $("#user-notf-count").html('0');
  $('#user-notf-show').load($("#user-notf-show").data('href'));
});

$(document).on('click','#user-notf-clear',function(){
  $(this).parent().parent().trigger('click');
  $.get($('#user-notf-clear').data('href'));
});

// USER REGISTER NOTIFICATION ENDS

// ORDER NOTIFICATION

$(document).ready(function(){
    setInterval(function(){
            $.ajax({
                    type: "GET",
                    url:$("#order-notf-count").data('href'),
                    success:function(data){
                        $("#order-notf-count").html(data);
                      }
              });
    }, 5000);
});

$(document).on('click','#notf_order',function(){
  $("#order-notf-count").html('0');
  $('#order-notf-show').load($("#order-notf-show").data('href'));
});

$(document).on('click','#order-notf-clear',function(){
  $(this).parent().parent().trigger('click');
  $.get($('#order-notf-clear').data('href'));
});

// ORDER NOTIFICATION ENDS

// PRODUCT NOTIFICATION

$(document).ready(function(){
    setInterval(function(){
            $.ajax({
                    type: "GET",
                    url:$("#product-notf-count").data('href'),
                    success:function(data){
                        $("#product-notf-count").html(data);
                      }
              });
    }, 5000);
});

$(document).on('click','#notf_product',function(){
  $("#product-notf-count").html('0');
  $('#product-notf-show').load($("#product-notf-show").data('href'));
});

$(document).on('click','#product-notf-clear',function(){
  $(this).parent().parent().trigger('click');
  $.get($('#product-notf-clear').data('href'));
});

// PRODUCT NOTIFICATION ENDS

// CONVERSATION NOTIFICATION

$(document).ready(function(){
    setInterval(function(){
            $.ajax({
                    type: "GET",
                    url:$("#conv-notf-count").data('href'),
                    success:function(data){
                        $("#conv-notf-count").html(data);
                      }
              });
    }, 5000);
});

$(document).on('click','#notf_conv',function(){
  $("#conv-notf-count").html('0');
  $('#conv-notf-show').load($("#conv-notf-show").data('href'));
});

$(document).on('click','#conv-notf-clear',function(){
  $(this).parent().parent().trigger('click');
  $.get($('#conv-notf-clear').data('href'));
});

// CONVERSATION NOTIFICATION ENDS


// SEND MESSAGE SECTION
$(document).on('click','.send',function(){
  $('.eml-val').val($(this).data('email'));
});

          $(document).on("submit", "#emailreply1" , function(){
          var token = $(this).find('input[name=_token]').val();
          var subject = $(this).find('input[name=subject]').val();
          var message =  $(this).find('textarea[name=message]').val();
          var to = $(this).find('input[name=to]').val();
          $('#eml1').prop('disabled', true);
          $('#subj1').prop('disabled', true);
          $('#msg1').prop('disabled', true);
          $('#emlsub1').prop('disabled', true);
            $.ajax({
            type: 'post',
            url: mainurl+'/admin/user/send/message',
            data: {
                '_token': token,
                'subject'   : subject,
                'message'  : message,
                'to'   : to
                  },
                 success: function( data) {
                  $('#eml1').prop('disabled', false);
                  $('#subj1').prop('disabled', false);
                  $('#msg1').prop('disabled', false);
                  $('#subj1').val('');
                  $('#msg1').val('');
                  $('#emlsub1').prop('disabled', false);
                  if(data == 0)
                    $.notify("Oops Something Goes Wrong !!","error");
                  else
                    $.notify("Message Sent !!","success");
                  $('.close').click();
            }
        });
          return false;
        });

// SEND MESSAGE SECTION ENDS



// SEND EMAIL SECTION

          $(document).on("submit", "#emailreply" , function(){
          var token = $(this).find('input[name=_token]').val();
          var subject = $(this).find('input[name=subject]').val();
          var message =  $(this).find('textarea[name=message]').val();
          var to = $(this).find('input[name=to]').val();
		  var orderid = $(this).find('input[name=orderid]').val();
          var vendorid = $(this).find('input[name=vendorid]').val();
          $('#eml').prop('disabled', true);
          $('#subj').prop('disabled', true);
          $('#msg').prop('disabled', true);
          $('#emlsub').prop('disabled', true);
     $.ajax({
            type: 'post',
            url: mainurl+'/admin/order/email',
            data: {
                '_token': token,
                'subject'   : subject,
                'message'  : message,
				'orderid'  : orderid,
				'vendorid'  : vendorid,
                'to'   : to
                  },
            success: function( data) {
          $('#eml').prop('disabled', false);
          $('#subj').prop('disabled', false);
          $('#msg').prop('disabled', false);
          $('#subj').val('');
          $('#msg').val('');
        $('#emlsub').prop('disabled', false);
        if(data == 0)
        $.notify("Oops Something Goes Wrong !!","error");
        else
        $.notify("Email Sent !!","success");
        $('.close').click();
            }

        });
          return false;
        });
// SEND EMAIL SECTION ENDS

// ORDER TRACKING STARTS

$(document).on('click','.track-edit',function(){
$('#track-title').focus();
var title = $(this).parent().parent().parent().find('.t-title').text();
var text = $(this).parent().parent().parent().find('.t-text').text();
var companyname = $(this).parent().parent().parent().find('.t-companyname').text();

$('#track-title').val(title);
$('#track-details').val(text);
$('#companyname').val(companyname);

$('#track-btn').text($('#edit-text').val());
$('#trackform').prop('action',$(this).data('href'));
$('#cancel-btn').removeClass('d-none');

});


$(document).on('click','#cancel-btn',function(){

$(this).addClass('d-none');
$('#track-btn').text($('#add-text').val());
$('#track-title').val('');
$('#track-details').val('');
$('#companyname').val('');
$('#trackform').prop('action',$('#track-store').val());
});


$(document).on('click','.track-delete',function(){
        $(this).parent().parent().parent().remove();
        $.get($(this).data('href'), function(data, status){
            $('#trackform .alert-success').show();
            $('#trackform .alert-success p').html(data);
  });

});



// ORDER TRACKING ENDS

$(document).on('click','.godropdown .go-dropdown-toggle', function(){
  $('.godropdown .action-list').hide();
  var $this = $(this);
  $this.next('.action-list').toggle();
});


$(document).on('click', function(e)
{
    var container = $(".godropdown");

    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0)
    {
      container.find('.action-list').hide();
    }
});



// **************************************  AJAX REQUESTS SECTION ENDS *****************************************


})(jQuery);

 $(document).on('change','#admin_country',function () {
	 
            var link = $(this).find(':selected').attr('data-href');
           
            if(link != ""){
                $('#admin_state').load(link);
                $('#admin_state').prop('disabled',false);
            }
        });
		
		$(document).on('change','#vendor_sno',function () {
	 
            var link = $(this).find(':selected').attr('data-href');
           
            if(link != ""){
                $('#order_sno').load(link);
                $('#order_sno').prop('disabled',false);
            }
        });
        
        

  $(document).ready(function () {
         $(document).on('change','#ref_quantity',function () {
             var priceprd = $(this).attr('priceprod');
             var quantity = $(this).val();
             
             
             var total = quantity * priceprd;
     
       $(this).parents('.qty_td').siblings('.price_td').find('.ref_price').val(total);
    });
});


