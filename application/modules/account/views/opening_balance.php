<section class="content-header">
  <h1>
    AR Opening Balance
  </h1>
</section>

<section class="content">
  <?php echo get_flash_message('message'); ?>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-header with-border">
          <div class="tooltip">Hover over me
            <span class="tooltiptext">Tooltip text</span>
          </div>
          <div class="col-md-12">
            <div class="col-md-6">
              <h3 id="flag_text">
                Mode: Invoice Entry
              </h3>
            </div>
            <div class="col-md-6">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <form autocomplete="off" id="form_" class="form-horizontal validate" method="post" action="<?php echo $save_url; ?>"> <!-- <?php echo $save_url; ?> -->
    <div class="row">
      <div class="col-md-12">
        <div class="box box-danger">
          <div class="row">
            <div class="col-md-12">
              <div class="box-body">
                <section class="receipt">
                  <!-- info row -->
                  <div class="row receipt-info">
                    <div class="col-sm-4 receipt-col">
                      <b>To,</b>
                      <address>
                        <select name="customer_id" id="customer_id" title="Select Customer" class="form-control select2" required="">
                          <?php echo $customer_options; ?>
                        </select><br>
                        <b>Name:</b><span id="customer_name"></span><br>
                        <b>Customer_Code:</b> <span id="customer_code"></span><br>
                        <b>Customer_Currency:</b> <span id="customer_currency"></span>
                      </address>
                    </div>
                                      
                  </div>
                  <!-- /.row -->
                  <br>
                  <hr>
                  <div class="table-responsive">
                    <table class="table" id="open_table">
                      <thead>
                        <tr>
                          <th>Transaction Date</th>
                          <th>Doc Reference</th>
                          <th>Remarks</th>
                          <th>Amount</th>
                          <th class="hidden">Sign</th>
                          <th>ACTION</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr id="row">
                          <td class="form-group error_block">
                            <input style="min-width: 120px;" type="text" class="my_date transaction_date form-control" name="data[transaction_date][]" required="">
                          </td>
                          <td class="form-group error_block">
                            <input style="min-width: 120px;" type="text" class="doc_reference form-control" name="data[doc_reference][]" required="">
                          </td>
                          <td>
                            <input style="min-width: 250px;" type="text" class="remarks form-control" name="data[remarks][]">
                          </td>
                          <td class="form-group error_block">
                            <input style="min-width: 120px;" type="number" min="1" class="amount form-control" name="data[amount][]" required="">
                          </td>
                          <td class="hidden">
                            <input type="text" readonly class="sign form-control" name="data[sign][]" value="+" >
                          </td>
                          <td>
                            <button class="form-control btn-warning" id="del_btn" onclick="delete_row(this)">Delete</button>
                            
                          </td>
                        </tr>
                      </tbody>
                    </table>


                  </div>
                  <div class="col-md-6 col-md-offset-6 col-xs-12">
                      <div id="another_entry" class="pull-right">
                        Input Another Entry?
                        <!--<button type="button" class="btn btn-primary" onclick="$('#summary').removeClass('hidden');$('#done_btn').hide();$('#product_id_div select').attr('disabled',true);$('#edit_btn').removeClass('hidden');">Yes</button>-->
                        <button type="button" class="btn btn-primary" id="input_another_entry">Yes</button>
                        <!-- <button type="button" class="btn btn-primary " onclick='$("#product_id").select2("open");'>No</button> -->
                        <button type="button" class="btn btn-primary " onclick="$('#credit_btn').removeClass('hidden');$('#another_entry').hide();">No</button> 
                      </div>
                      <!--<button class="btn btn-primary pull-right hidden" id="edit_btn" onclick="$('#summary').addClass('hidden');$('#done_btn').show();$('#product_id_div select').attr('disabled',false);$('#edit_btn').addClass('hidden');">Edit Product List</button>-->
                  </div>
                  <div class="col-md-6 col-md-offset-6 col-xs-12">
                      <div id="credit_btn" class="hidden pull-right">
                        Input Credit note?
                        <!--<button type="button" class="btn btn-primary" onclick="$('#summary').removeClass('hidden');$('#done_btn').hide();$('#product_id_div select').attr('disabled',true);$('#edit_btn').removeClass('hidden');">Yes</button>-->
                        <button type="button" class="btn btn-primary" id="input_credit_note">Yes</button>
                        <!-- <button type="button" class="btn btn-primary " onclick='$("#product_id").select2("open");'>No</button> -->
                        <button type="button" class="btn btn-primary " onclick="$('#credit_btn').hide();$('#submitbtn').removeClass('hidden');">No</button> 
                      </div>
                      <!--<button class="btn btn-primary pull-right hidden" id="edit_btn" onclick="$('#summary').addClass('hidden');$('#done_btn').show();$('#product_id_div select').attr('disabled',false);$('#edit_btn').addClass('hidden');">Edit Product List</button>-->
                  </div>
                  <br>
                  
                  <!-- <legend></legend> -->
                  <!-- Table row -->
                  
                  <!-- /.row -->
                  <!-- <hr> -->
                  <div class="row no-print">
                    <div class="col-xs-12">
                      <button type="submit" class="btn btn-success pull-right hidden" id="submitbtn"><i class="fa fa-credit-card"></i> Submit
                      </button>
                    </div>
                  </div>
                </section>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</section>
<script src="<?php echo JS_PATH."/dist/jquery.inputmask.bundle.js";?>"></script>
<script type="text/javascript">
$(function() {
  //=========================customer details ====================================================

  $cansend = false;
  $(".my_date").inputmask("9999/99/99",{ "placeholder": "yyyy/mm/dd" });
    $('form#form_').submit(function(){
      $("#row").each(function(){
        if (!$(this).find("td input[name^='data[transaction_date]']").val() 
          && !$(this).find("td input[name^='data[doc_reference]']").val()
          && !$(this).find("td input[name^='data[remarks]']").val()
          && !$(this).find("td input[name^='data[amount]']").val()) 
        {
          console.log("sss");
          $(this).remove();
        }
        
      });
     var form = $(this);
         if ($cansend == true)
            {
                $cansend = false;
                return true;
            }
            $('#quot_status').html('');
            $.confirm({
                title:"<i class='fa fa-info'></i> Opening Balance Confirmation",
                text: "Confirm?",
                cancelButton: "No",
                confirm: function(button) {
                  $('#quot_status').html('');
                    $('#quot_status').html('<input type="hidden" name="invoice_status" value="C">');
                    $cansend = true;
                    form.submit();
                },
                cancel: function(button) {
                 
                    $cansend = true;
                    form.submit();
                }
            });
            return false;
  })


  $("#customer_id").change(function(event) {
    customer_id=$("#customer_id option:selected").val();
    if(customer_id!=""){
      $.post('<?php echo base_url('common/Ajax/quotationlist_ajax/get_customer_details') ?>', {customer_id: customer_id}, function(data, textStatus, xhr) {
        console.log(data);
        var obj = $.parseJSON(data);
        console.log(obj);
        
        $("#customer_name").html(obj.customer_name);
        $("#customer_code").html(obj.customer_code);
        $("#customer_currency").html(obj.customer_currency);
        $(".my_date").focus();
      });
      // get_sub_total();
  }
  });

  $("td input[name^='data[transaction_date]'],td input[name^='data[doc_reference]'],td input[name^='data[amount]']").focusout(function() {
    if(!$(this).val())
    {
      
      $(this).addClass("custom_error_block");
      $(this).focus();
    }
    else
    {
      $(this).removeClass("custom_error_block");
    }
  });
 
  $("#input_credit_note").click(function(evernt) {
    
    $("#flag_text").html("Mode: Credit Note");
    var numrows = $("form#form_").find("input[name^='data[transaction_date]']").length;
    console.log(numrows);
    var append_str_credit = '<tr id="row">' 
                          +'<td class="form-group error_block">'
                          + '<input type="text" required="" class="form-control my_date" name="data[transaction_date]['
                         // + numrows
                          + ']">'
                          + '</td>'
                          + '<td class="form-group error_block">'
                          + '<input type="text" required="" class="form-control" name="data[doc_reference]['
                          //+ numrows
                          + ']">'
                          + '</td>'
                          + '<td>'
                          +  '<input type="text" class="form-control" name="data[remarks]['
                          //+ numrows
                          + ']">'
                          + '</td>'
                          + '<td class="form-group error_block">'
                          +  '<input type="text" required="" class="form-control" name="data[amount]['
                          //+ numrows
                          + ']">'
                          + '</td>'
                          + '<td class="hidden">'
                          + '<input type="text" readonly class="form-control" name="data[sign]['
                          //+ numrows
                          + ']" value="-">'
                          + '</td>'
                          + '<td>'
                          + '<button class="form-control btn-warning" onclick="delete_row(this)">Delete</button>'
                          + '</td>'
                          + '</tr>';
    
    $("#open_table tbody").append(append_str_credit);
    $(".my_date").inputmask("9999/99/99",{ "placeholder": "yyyy/mm/dd" });
    $(".my_date").focus();

    $("td input[name^='data[transaction_date]'],td input[name^='data[doc_reference]'],td input[name^='data[amount]']").focusout(function() {
      if(!$(this).val())
      {
        
        $(this).focus();
        $(this).addClass("custom_error_block");
      }
      else
      {
        $(this).removeClass("custom_error_block");
      }
    });

    $("td input[name^='data[amount]']").focusout(function() {
      if(!$(this).val())
      {
        alert("sdfs");
        $(this).focus();
        // $(this).addClass("custom_error_block");
      }
      else
      {
        $(this).removeClass("custom_error_block");
      }
    });

  }); 
  $("#input_another_entry").click(function(evernt) {
    
    $("#flag_text").html("Mode: Invoice Entry");
    var numrows = $("form#form_").find("input[name^='data[transaction_date]']").length;

    console.log(numrows);
    var append_str_entry = '<tr id="row">' 
                          +'<td class="form-group error_block">'
                          + '<input type="text" required="" class="form-control my_date" name="data[transaction_date]['
                          //+ numrows
                          + ']">'
                          + '</td>'
                          + '<td class="form-group error_block">'
                          + '<input type="text" required="" class="form-control" name="data[doc_reference]['
                          //+ numrows
                          + ']">'
                          + '</td>'
                          + '<td>'
                          +  '<input type="text" class="form-control" name="data[remarks]['
                          //+ numrows
                          + ']">'
                          + '</td>'
                          + '<td class="form-group error_block">'
                          +  '<input type="text" required="" class="form-control" name="data[amount]['
                          //+ numrows
                          + ']">'
                          + '</td>'
                          + '<td class="hidden">'
                          + '<input type="text" readonly class="form-control" name="data[sign]['
                          //+ numrows
                          + ']" value="+">'
                          + '</td>'
                          + '<td>'
                          + '<button class="form-control btn-warning" onclick="delete_row(this)">Delete</button>'
                          + '</td>'
                          + '</tr>';

    $("#open_table tbody").append(append_str_entry);
    //console.log(index_add);
    $(".my_date").inputmask("9999/99/99",{ "placeholder": "yyyy/mm/dd" });
    $(".my_date").focus();

    $("td input[name^='data[transaction_date]'],td input[name^='data[doc_reference]'],td input[name^='data[amount]']").focusout(function() {
      if(!$(this).val())
      {
        $(this).focus();
        $(this).addClass("custom_error_block");
      }
      else
      {
        $(this).removeClass("custom_error_block");
      }
    });
  });
});


function delete_row(data) {
    
    $(data).parents("tr").remove();
}

</script>