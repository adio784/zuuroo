
    <script>
        $(document).ready(function() {
          $('#example').DataTable( {
              dom: 'Bfrtip',
              buttons: [
                  'copyHtml5',
                  'excelHtml5',
                  'csvHtml5',
                  'pdfHtml5'
              ]
          } );
      } );
    </script>
     <script>
      $(document).ready(function() {
        $('#loan_receipt').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'pdfHtml5'
            ]
        } );
    } );
  </script>

      <!-- Phone Number Validation =================================== -->
  <script>
    if($('#phone_Number').length){
      var userName = document.querySelector('#phone_Number');

        userName.addEventListener('input', restrictNumber);
        function restrictNumber (e) {  
        var newValue = this.value.replace(new RegExp(/[^\d]/,'ig'), "");
        this.value = newValue;
        }
      }

  </script>

 <script>
  $(document).ready(function(){
    // $('#country').change(function(){
    //   let ctr = $('#country').val();
    //   let phone = $('.phoneNumber').val();
    //   let vp = $('.phoneNumber').val()
    //   // alert(vp);
      
    //   $.ajax({
    //     method: 'GET',
    //     url: '/getOperatorByPhone/'+ctr,
    //     success:function(response)
    //     {
    //       if(response != ""){
    //           if($('#network_airtime').length) {
    //             $('#network_airtime').html("<option> Select Network </option>");
    //             $.each(response.Operators, function(key, item) {
    //               $('#network_airtime').append(
    //                 '<option value='+ item.ProviderCode +'>'+ item.Name + '</option>'
    //               )
    //             });
    //           }else{
    //               $('#network').html("<option> Select Network </option>");
    //               console.log(response);
    //               $.each(response.Operators, function(key, item) {
    //                 $('#network').append(
    //                   '<option value='+item.ProviderCode+'>'+ item.Name +'</option>'
    //                 )
    //               }); 
    //             }
    //       }else{
    //         $('#network').html("<option> Select Network </option>");
    //       }
    //       // $('#countryInfoContainer').toggleClass('d-none');
    //       // for(i in response.Operators){
    //       //   $('#network').append('<option>'+ response.Operators[i].operator +'</option>');
    //       //   // console.log(response.Operators[i].operator);
    //       // }
    //     }
    //   });
    //   $.ajax({
    //     method: 'GET',
    //     url: '/getPhoneCodeIso/'+ctr,
    //     success:function(data)
    //     {
    //       if(data != ""){
    //         // $('#network').html("<option> Select Network </option>");
    //         $.each(data.PhoneCode, function(key, phn) {
    //           let vall = phn.phonecode;
    //           // console.log(vall);
    //           $('.phoneNumber').val(vall);
    //         })
    //       }
          
    //     }
    //     });
    // });



    // Checking data product for each network
  if ($('#network').length) {
    // $('#network').on('change', function(){
    //   let ph_no = $('#phone_Number').val();
    //   // alert(ph_no);
    //   $.ajax({
    //     method: 'GET',
    //     url: '/getProductByPhone/'+ph_no,
    //     success:function(response)
    //     {
    //       if(response != ""){
    //         $('#data_plan').html("<option> Select Plan </option>");
    //         // console.log(response.DefaultDisplayText);
    //         $.each(response, function(key, item) {
    //           let validperiod = "";
    //           if(item.ValidityPeriodIso == " "){ validperiod = '-';}else{validperiod= '(' +item.ValidityPeriodIso +'Days )';}
    //           let inpu_amt_val = item.SkuCode+','+item.Minimum.SendValue +','+ item.DefaultDisplayText;
    //           if(item.DefaultDisplayText == ''){
    //             $('#data_plan').append(
    //               "<option value=''> -- Input phone number with country code -- </option>"
    //             );
    //           }else{
    //             $('#data_plan').append(
    //               "<option value="+ inpu_amt_val +">" + item.DefaultDisplayText + " -- " + validperiod + " -- " + " - at ( " + item.Minimum.ReceiveValue + ' ' + item.Minimum.ReceiveCurrencyIso + ' ) '+ "</option>"
    //             );
    //           }
              
    //            // Passing values
    //           let distributorReference = Math.floor(100000 + Math.random() * 900000);
    //           let SendCurrencyIso = item.Minimum.SendCurrencyIso;
    //           let BillRef = item.LookupBillsRequired;
    //           let ReceiveCurrencyIso = item.Minimum.ReceiveCurrencyIso;
    //           let DefaultDisplayText = item.DefaultDisplayText;

    //           $('#SendCurrencyIso').val(SendCurrencyIso); 
    //           $('#DefaultDisplayText').val(DefaultDisplayText); 
    //           $('#DistributorRef').val(distributorReference); 
    //           $('#SName').val('Data'); 
    //           $('#BillRef').val(BillRef); 
    //           $('#ReceiveCurrencyIso').val(ReceiveCurrencyIso); 
    //         });
            
    //       }else{
    //         $('#data_plan').html("<option value=''> Select Plan </option>");
    //       }
    //     }
    //   })
    // });
  }else{
    // $('#network_airtime').on('change', function(){
    //   let ph_no = $('#phone_Number').val();
    //   let network_provider = $(this).val();
    //   // alert(ph_no);
      
    //       // alert(network_provider);
    //       // Ajax  request to get provider details
    //       $.ajax({
    //         method: 'GET',
    //         url: '/getLogoByProviderCode/'+network_provider,
    //         success:function(data)
    //         {
    //           if(data != ""){
    //             $('#modileNetworkDetaile').toggleClass('d-none');
    //             $.each(data.OperatorLogos, function(key, item) {
    //               let opUrl = item.LogoUrl;
    //               let Name = item.Name;
    //               console.log(opUrl);
    //               $('#network_logo').attr('src', opUrl);
    //               $('#operator_CName').html(Name);
    //             });
    //           }
              
    //         }
    //       });
    //   $.ajax({
    //     method: 'GET',
    //     url: '/getAirtimeProductByPhone/'+ph_no,
    //     success:function(response)
    //     {
    //       if(response != ""){
    //         $('#input_amount').html("<option> Select Amount </option>");
    //         console.log(response);
    //         $.each(response, function(key, item) {
    //           if(item.ValidityPeriodIso=='undefined'){ validperiod = '';}else{validperiod= item.ValidityPeriodIso +'ays';}
    //             let inpu_amt_val = item.SkuCode+','+item.Minimum.SendValue ;
    //           $('#input_amount').append(
    //             "<option value="+ inpu_amt_val + ">" +  
                  
    //               item.Minimum.ReceiveValue + ' ' + item.Minimum.ReceiveCurrencyIso + "</option>"
    //           );
    //            // Passing values
    //           let distributorReference = Math.floor(100000 + Math.random() * 900000);
    //           let SendCurrencyIso = item.Minimum.SendCurrencyIso;
    //           let BillRef = item.LookupBillsRequired;
    //           let ReceiveCurrencyIso = item.Minimum.ReceiveCurrencyIso;
              
    //           $('#SendCurrencyIso').val(SendCurrencyIso);  $('#DistributorRef').val(distributorReference); 
    //           $('#SName').val('Airtime'); $('#BillRef').val(BillRef); 
    //           $('#ReceiveCurrencyIso').val(ReceiveCurrencyIso); 
    //         });
            
    //       }else{
    //         $('#input_amount').html("<option value=''> Select Amount </option>");
    //       }
    //     }
    //   })
    // });
  }
// =======================================   Getting Product With Network ID ================== >





  })
  
</script>
<script>
  $(function() {
    $("#print_btn").click(function (){
        $("body > table").addClass("print-hidden");
        $(this).parents("table").last().removeClass("print-hidden");
        if (window.print) {
            window.print();
        }
    });
});
</script>

<script>
  async function generatePDF() {
      document.getElementById("downloadReceipt_btn").innerHTML = "downloading ...";

      //Downloading
      var downloading = document.getElementById("loan_receipt");
      var doc = new jsPDF('l', 'pt');

      await html2canvas(downloading, {
          //allowTaint: true,
          //useCORS: true,
          width: 530
      }).then((canvas) => {
          //Canvas (convert to PNG)
          doc.addImage(canvas.toDataURL("image/png"), 'PNG', 5, 5, 500, 200);
      })

      doc.save("Receipt.pdf");

      //End of downloading

      document.getElementById("downloadReceipt_btn").innerHTML = "Download";
  }
</script>

<script>
    function getRate(from, to) {
    var script = document.createElement('script');
    script.setAttribute('src', "http://query.yahooapis.com/v1/public/yql?q=select%20rate%2Cname%20from%20csv%20where%20url%3D'http%3A%2F%2Fdownload.finance.yahoo.com%2Fd%2Fquotes%3Fs%3D"+from+to+"%253DX%26f%3Dl1n'%20and%20columns%3D'rate%2Cname'&format=json&callback=parseExchangeRate");
    document.body.appendChild(script);
  }

  function parseExchangeRate(data) {
    var name = data.query.results.row.name;
    var rate = parseFloat(data.query.results.row.rate, 10);
    console.log("Exchange rate " + name + " is " + rate);
  }
  
getRate("SEK", "USD");
  getRate("USD", "SEK");
</script>

<script>
if($('#paymentForm').length){
var paymentForm = document.getElementById('paymentForm');
paymentForm.addEventListener('submit', payWithPaystack, false);
function payWithPaystack(e) {
  e.preventDefault();
  let handler = PaystackPop.setup({
    key: 'pk_test_394f238d02a87de9c5611878d71cf84df06bb015', // Replace with your public key
    email: document.getElementById('email_address').value,
    amount: document.getElementById('pay_amount').value * 100, // the amount value is multiplied by 100 to convert to the lowest currency unit
    currency: 'NGN', // Use GHS for Ghana Cedis or USD for US Dollars
    ref: ''+Math.floor((Math.random() * 100000000) + 1), // Replace with a reference you generated
    callback: function(response) {
      //this happens after the payment is completed successfully
      let reference = response.reference;
      // alert('Payment complete! Reference: ' + reference);
      // Make an AJAX call to your server with the reference to verify the transaction
      $.ajax({
        url: "{{ URL::to('verifyPayment')}}/"+ response.reference,
        method: 'get',
        success: function (response) {
          // the transaction status is in response.data.status
          $('#pay_amount_error').html("You have added a new balance");
          $('#pay_amount').val(' ');
        }
      });
    },
    onClose: function() {
      alert('Transaction was not completed, window closed.');
    },
  });
  handler.openIframe();
}}
</script>




<script>
  $(function (){
    $('#automateBankTransfer').submit(function(e){
      e.preventDefault();

      document.getElementById("hideWindowButton").innerHTML = "Loading ";
      $("#hideWindowButton").addClass("disabled");
      $("#hideWindowButton").append($('<div class="spinner-border spinner-border-sm text-secondary" role="status"><span class="visually-hidden">Loading...</span></div>'));
      // document.getElementById("hideWindowButton").innerHTML = "downloading ...";
      
      let name = $('#username').val();
      let email = $('#email_address').val();
      let phone = $('#phone_number').val();
      let amount = $('#pay_amount').val();
      makePayment(amount,email,phone,name);
    })
  });


  function makePayment(amount,email,phone_number,name) {
    FlutterwaveCheckout({
      public_key: "FLWPUBK_TEST-4656ea3f37bef493c54d971a4b89ecec-X",
      tx_ref: "SNK-{{ substr(rand(0,time()), 0,11) }}",
      amount,
      currency: "NGN",
      payment_options: "card, mobilemoneyghana, ussd",
      callback: function(payment) {
        // Send AJAX verification request 
        let transaction_id = payment.transaction_id;
        let _token = $("input[name=_token]").val();
        $.ajax({
          method: 'POST',
          url: "{{ URL::to('verifyPaymentFlutterWave') }}",
          data: { 
            transaction_id,
            _token
            },
          success: function (response) {
            console.log(response);
            $('#payment_failed').html(response +" You have added a new balance");
            $('#pay_amount').val(' ');
          }
      });
        verifyTransactionOnBackend(payment.id);
      },
      onclose: function(incomplete) {
        if (incomplete || window.verified === false) {
          document.querySelector("#payment-failed").style.display = 'block';
        } else {
          document.querySelector("form").style.display = 'none';
          if (window.verified == true) {
            document.querySelector("#payment-success").style.display = 'block';
          } else {
            document.querySelector("#payment-pending").style.display = 'block';
          }
        }
      },

      customer: {
        email,
        phone_number,
        name,
      },
      customizations: {
        title: "The Titanic Store",
        description: "Payment for an awesome cruise",
        logo: "https://www.logolynx.com/images/logolynx/22/2239ca38f5505fbfce7e55bbc0604386.jpeg",
      },
    });
  }

  function verifyTransactionOnBackend(transactionId) {
    // Let's just pretend the request was successful
    setTimeout(function() {
      window.verified = true;
    }, 200);
  }
</script>




<script>
//   if($('#automateBankTransfer').length){
//   function makePayment() {
//     FlutterwaveCheckout({
//       public_key: "FLWPUBK_TEST-SANDBOXDEMOKEY-X",
//       tx_ref: ''+Math.floor((Math.random() * 100000000) + 1),
//       amount: document.getElementById('pay_amount').value,
//       currency: "NGN",
//       payment_options: "card, mobilemoneyghana, ussd",
//       callback: function(payment) {
//         // Send AJAX verification request to backend
//         let reference = payment.id;
//         console.log(reference)
//         $.ajax({
//           url: "{{ URL::to('verifyPayment')}}/"+ reference,
//           method: 'get',
//           success: function (response) {
//             $('#pay_amount_error').toggleClass('d-none');
//             $('#pay_amount_error').html("You have added a new balance");
//             $('#pay_amount').val(' ');
//           }
//         });
//         verifyTransactionOnBackend(payment.id);
//       },
//       onclose: function(incomplete) {
//         if (incomplete || window.verified === false) {
//           $('#error_result').toggleClass('d-none');
//           document.querySelector("#payment-failed").style.display = 'block';
//         } else {
//           document.querySelector("form").style.display = 'none';
//           if (window.verified == true) {
//             $('#error_result').toggleClass('d-none');
//             document.querySelector("#payment-success").style.display = 'block';
//           } else {
//             $('#error_result').toggleClass('d-none');
//             document.querySelector("#payment-pending").style.display = 'block';
//           }
//         }
//       },
//       meta: {
//         consumer_id: 23,
//         consumer_mac: "92a3-912ba-1192a",
//       },
//       customer: {
//         email: document.getElementById('email_address').value,
//         phone_number: document.getElementById('phone_number').value,
//         name: document.getElementById('username').value,
//       },
//       customizations: {
//         title: "The Sean Telecommunications",
//         description: "Payment for wallet funding",
//         logo: "https://www.logolynx.com/images/logolynx/22/2239ca38f5505fbfce7e55bbc0604386.jpeg",
//       },
//     });
//   }

//   function verifyTransactionOnBackend(transactionId) {
//     // Let's just pretend the request was successful
//     setTimeout(function() {
//       window.verified = true;
//     }, 200);
//   }

// }
</script> 
</body>
</html>

    {{-- 
    5531 8866 5214 2950
    09 32
    564
    3310 --}}
<!-- 
SkuCode  - An agent will construct a request that contains a product and a
SendValue   -  that is between the Min and Max price (inclusive)
SendCurrencyIso
AccountNumber
Settings -> Name, Value
ValidateOnly
BillRef
DistributorRef  - uniquely identifies the transfer within their system.
TransferRef  -  that uniquely identifies the transfer within our system


The SendTranfer method has a maximum proccessing time of 90 seconds. 
After 90 seconds, if the SendTransfer request is not completed, 
the system will return a response with ProviderTimedOut.

SkuCode -       values returned by the GetProducts   API call
ValidateOnly -  When ValidateOnly=true, we will validate 
                the request in our system to give an indication 
                if a non validate transfer would succeed with the 
                submitted parameters.

                When ValidateOnly=true, the Price in the response should be 
                interpreted as an estimate only.
                We will not assign a TransferId to the response when ValidateOnly=true
Settings -      Some products declare SettingDefintions that mandate name-value pairs that 
                can be submitted with the transfer and will be passed to the Provider. 

                Agents can submit their own name-value pairs and we will store them with the transfer. 
                These name-value pairs can be queried upon using the ListTransferRecords method.

Processing State  - Processing State will indicate the current state of the 
                    transfer as it progresses through our system over time.

                    Submitted:  The transfer was just submitted to the system 
                                and we have a record of it.
                    Processing: The system has started processing the request 
                                and we are in the act of fulfilling the transfer.
                    Complete:   The transfer request is finished and it was successful.
                    Failed:     The transfer request is finished, but there was some form of error.
                    Cancelled:  The transfer request was cancelled.
                    Cancelling: A request to cancel the transfer has been sent to the provider.
 -->
<!-- Mexico
Korea
Americal Samao
Andorra
Autria
Azerbajia -->
