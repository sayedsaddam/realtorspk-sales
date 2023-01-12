<div class="jumbotron jumbotron-fluid text-white d-print-none" style="background-color: purple;">
    <div class="container">
        <div class="row">
            <div class="col-xl-lg-8 col-md-8">
                <h1 class="font-weight-bold">Bookings &raquo; Installment Calculator | <small style="font-size: 20px;"><a class="text-light" href="javascript:history.go(-1);">Back</a></small></h1>
                <p class="text-justify">
                    Welcome: <strong><?= $this->session->userdata('fullname'); ?></strong><br><a class="text-white" href="<?= base_url('admin/logout'); ?>" title="Click to sign out.">Sign Out</a>
                </p>
            </div>
            <div class="col-xl-lg-4 col-md-4 text-right text-light">
                <a href="<?= base_url('admin/dashboard'); ?>" class="btn btn-outline-light btn-lg btn-block">Home</a>
                <a href="javascript:history.go(-1)" class="btn btn-outline-light btn-lg btn-block">Bookings' Home</a>
            </div>
        </div>
    </div>
</div>
<div class="container mb-3">
   <div class="row mb-4 mt-4">
      <div class="col-md-1">
         <img src="<?= base_url('assets/images/favicon-final.ico'); ?>" alt="AH Group" class="img-fluid" width="90" srcset="">
      </div>
      <div class="col-md-7">
         <h3 class="mb-0 font-weight-bold">Installment Plan</h3>
         <h5>AH Group of Companies Pvt. Ltd</h5>
      </div>
   </div>
   <div class="row">
      <div class="col-md-5">
         <legend class="d-print-none">Calculate</legend>
         <div class="form-group d-print-none">
            <label for="">Rate per ft<sup>2</sup></label>
            <input type="number" class="form-control rate" name="rate" placeholder="Rate per sqft...">
         </div>
         <div class="form-group d-print-none">
            <label for="">Buying Area</label>
            <input type="number" class="form-control area" name="area" placeholder="Enter buying area...">
         </div>
         <div class="form-group d-print-none">
            <label for="">Payment Plan</label>
            <select name="payment_plan" class="custom-select payment_plan">
               <option value="" disabled selected>Choose Payment Plan</option>
               <option value="1">1 Year</option>
               <option value="2">2 Years</option>
               <option value="3">3 Years</option>
               <option value="4">4 Years</option>
            </select>
         </div>
         <div class="form-group d-print-none">
            <label for="">Installment Plan</label>
            <select name="installment_duration" class="custom-select installment_duration">
               <option value="" disabled selected>Choose Payment Plan</option>
               <option value="1">Monthly</option>
               <option value="3">Quarterly</option>
            </select>
         </div>
         <div class="form-group">
            <button type="button" class="btn btn-primary d-print-none calculate">Calculate</button>
            <button type="reset" class="btn btn-danger d-print-none">Clear</button>
         </div>
         <div class="row">
            <div class="col-md-12">
               <legend>Calculated Result</legend>
               <table class="table table-bordered table-sm">
                  <tbody>
                     <tr>
                        <th>Area</th>
                        <td class="area"></td>
                     </tr>
                     <tr>
                        <th>Rate per ft<sup>2</sup></th>
                        <td class="rate"></td>
                     </tr>
                     <tr>
                        <th>Total Value</th>
                        <td class="total_value"></td>
                     </tr>
                     <tr>
                        <th>No. of Installments</th>
                        <td class="no_of_installments"></td>
                     </tr>
                     <tr>
                        <th>Down Payment</th>
                        <td class="down_payment"></td>
                     </tr>
                     <tr>
                        <th>Final Payment</th>
                        <td class="final_payment"></td>
                     </tr>
                     <tr>
                        <th>Remaining Insallments</th>
                        <td class="remaining_installments"></td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
      <div class="col-md-7">
         <div class="row">
            <div class="col-md-10"><legend>Complete Installment Plan</legend></div>
            <div class="col-md-2 text-right"><button onclick="window.print()" class="btn btn-outline-secondary d-print-none">Print</button></div>
         </div>
         <div class="row">
            <div class="col-md-12 printInstallmentPlan"></div>
         </div>
      </div>
   </div>
</div>

<div class="container mb-4">
   <div class="row">
      <div class="col-md-12 text-center">
         <small class="text-dark">Copyright &copy; <?= date('Y'); ?>, AH Group of Companies Pvt. Ltd. <br>Office #11, 2nd floor, Umer Building, Jinnah Avenue, Blue Area, Islamabad 44000.</small><br>
         <img src="<?= base_url('assets/images/favicon-final.ico'); ?>" alt="" class="img-fluid ml-3" width="40">
         <img src="<?= base_url('assets/images/logos/aht.png'); ?>" alt="" class="img-fluid ml-3" width="40">
         <img src="<?= base_url('assets/images/logos/fl.png'); ?>" alt="" class="img-fluid ml-3" width="40">
         <img src="<?= base_url('assets/images/logos/moh.png'); ?>" alt="" class="img-fluid ml-3" width="40">
         <img src="<?= base_url('assets/images/logos/nh.png'); ?>" alt="" class="img-fluid ml-3" width="40">
         <img src="<?= base_url('assets/images/logos/realtors-icon.ico'); ?>" alt="" class="img-fluid ml-3" width="40">                  
      </div>
   </div>
</div>

<script>
$(document).ready(function(){
   $('.calculate').on('click', function(){
      var rate = $('.rate').val(); // Get values from inputs.
      var area = $('.area').val();
      var plan = $('.payment_plan').val();
      var duration = $('.installment_duration').val();
      var total_value = rate * area; // Calculate total value.
      var noOfInstallments = (plan * 12) / duration; // Total no. of installments.
      var downPayment = (total_value / 100) * 25; // 25% of total value.
      var finalPayment = (total_value / 100) * 15; // 15% of total value.
      var remainingInstallments = (total_value / 100) * 60; // 60% of total value.
      var afterFinalDownPay = (remainingInstallments / (noOfInstallments-2)); // Installments left after down and final payments.
      $('.area').html(Number(area).toLocaleString());
      $('.rate').html(Number(rate).toLocaleString());
      $('.total_value').html(Number(total_value).toLocaleString());
      $('.no_of_installments').html(noOfInstallments);
      $('.down_payment').html(Number(downPayment).toLocaleString());
      $('.final_payment').html(Number(finalPayment).toLocaleString());
      $('.remaining_installments').html(Math.ceil(afterFinalDownPay).toLocaleString() + ' PKR. in <strong>' + (noOfInstallments - 2) + '</strong> installments.');
      $('.printInstallmentPlan').html('');
      for(let i = 0; i < noOfInstallments - 2; i++){ // exclude the down and final payments.
         let addMonth = parseInt(duration) * i; // get the installment duration and parse into integer.
         let nextInstallment = new Date();
         nextInstallment.setMonth(nextInstallment.getMonth() + addMonth);
         $('.printInstallmentPlan').append('<div class="row mb-2"><div class="col-md-6"><strong>On</strong> '+ nextInstallment.toDateString() +'</div><div class="col-md-6"><strong>PKR</strong> '+ Number(afterFinalDownPay).toLocaleString() +'</div></div>');
      }
   });
});
</script>
