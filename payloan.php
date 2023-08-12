<?php
include_once "inc/header.php";
include_once "inc/sidebar.php";
?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Close'])) {

  $deleted = $ml->payLoan($_POST['gl_no']);

  $borrowerID = $_POST['b_id'];
  $loanID = $_POST['loan_id'];

  // Perform the deletion operation in your database
  // $deleted = $ml->deleteLoan($borrowerID, $loanID);

}
?>
<h3 class="page-heading mb-4">Pay Gold Loan </h3>

<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
  $gl_no = $_POST['key'];
  $br = $emp->findBorrowerByGl($gl_no);
  echo $br;

  if ($br) {
    $row = $br->fetch_assoc();
    $name = $row['name'];
    $b_id = $row['id'];
    //var_dump($b_id);
    // $total_loan = $row['total_loan'];
    // $amount_paid = $row['amount_paid'];
    $aploan = $ml->getApprovedLoanNotPaid($b_id);
    if ($aploan) {
      $loan = $aploan->fetch_assoc();

      $loan_id_r = $loan['id'];
      //var_dump($loan);
      // var_dump($loan['nid']);
    } else {
      echo "<span class='text-center' style='color:red'>Loan not approved or already Paid!</span>";
    }
  } else {
    echo "<span class='text-center' style='color:red'>Borrower NID not martched or not applicable for loan</span>";
  }
}
?>
<form action="" method="POST">
  <div class="form-group row">
    <label for="inputBorrowerFirstName" class="text-right col-2 font-weight-bold col-form-label">Search brrower: </label>
    <div class="col-sm-6">
      <input type="text" name="key" class="form-control" id="inputBorrowerFirstName" placeholder="Enter Gl_No" required>
    </div>
    <div class="col-sm-3">
      <input type="submit" class="btn btn-info" name="search" value="Search">
    </div>
  </div>

</form>

<form action="" method="post" name="myform" id="myform">

  <div class="form-group row">
    <label for="inputBorrowerFirstName" class="text-right col-2 font-weight-bold col-form-label">Full Name</label>
    <div class="col-sm-9">
      <input type="text" name="borrower_name" class="form-control" id="inputBorrowerFirstName" value="<?php if (isset($name)) echo $name; ?>" required readonly>
      <input type="hidden" name="b_id" value="<?php if (isset($b_id)) echo $b_id; ?>">
      <input type="hidden" name="loan_id" value="<?php if (isset($loan['id']))  echo $loan['id']; ?>">
    </div>
  </div>

  <div class="form-group row">
    <label for="date" class="text-right col-2 font-weight-bold col-form-label">Opening Date</label>
    <div class="col-sm-9">
      <input type="number" name="date" class="form-control" id="date" value="<?php if (isset($loan['date'])) echo $loan['date']; ?>" readonly>
    </div>
  </div>
  <?php if (isset($loan['next_date'])) {

  ?>
    <div class="form-group row">
      <label for="nextdate" class="text-right col-2 font-weight-bold col-form-label">Closing Date</label>
      <div class="col-sm-9">
        <input type="date" class="form-control" id="nextdate" value="<?php echo $loan['date']; ?>" readonly>
      </div>
    </div>
    <div class="form-group row">
      <label class="text-right col-2 font-weight-bold col-form-label">Net_weight</label>
      <div class="col-sm-9">
        <input type="number" name="net_weight" class="form-control" value="<?php
                                                                            //calculate fine
                                                                            echo  $loan['net_weight'];
                                                                            ?>" readonly>
      </div>
    </div>


  <?php
  }
  ?>


  <div class="form-group row">
    <label for="interest" class="text-right col-2 font-weight-bold col-form-label">Interest</label>
    <div class="col-sm-9">
      <input type="number" name="interest" class="form-control" id="interest" required>
    </div>
  </div>
  <div class="form-group row">
    <label class="text-right col-2 font-weight-bold col-form-label">loan amount</label>
    <div class="col-sm-9">
      <input type="number" name="current_inst" class="form-control" value="<?php if (isset($loan['loan_amnt'])) echo $loan['loan_amnt']; ?>" readonly>
    </div>
  </div>
  <div class="form-group row">
    <label class="text-right col-2 font-weight-bold col-form-label">Item Description</label>
    <div class="col-sm-9">
      <input type="text" name="item_description" class="form-control" value="<?php if (isset($loan['item_description'])) {
                                                                                echo $loan['item_description'];
                                                                              } ?>" readonly>
    </div>
  </div>
  <div class="form-group row">
    <label class="text-right col-2 font-weight-bold col-form-label">Total Amount</label>
    <div class="col-sm-9">
      <input type="number" name="Total" class="form-control" value="<?php if (isset($loan['loan_amnt'])) echo $loan['loan_amnt'] + $loan['interest']; ?>" readonly>
    </div>
  </div>

  <div class="form-group row">
    <label class="text-right col-2 font-weight-bold col-form-label">Amount Remaining</label>
    <div class="col-sm-9">
      <?php
      // Assuming you have established a MySQL connection

      $start_date_obj = new DateTime($start_date);
      $end_date_obj = new DateTime($end_date);

      $interval = $start_date_obj->diff($end_date_obj);

      $start_date = $row['start_date'];
      $end_date = $row['end_date'];
      $start_date_obj = new DateTime($start_date);
      $end_date_obj = new DateTime($end_date);

      $interval = $start_date_obj->diff($end_date_obj);
      $years = $interval->y;

      $interest = $loan_amnt * pow(1 + (.18 / 12), 12 * $years);

      // Calculate the final amount
      $total = $loan_amnt + $interest;
      ?>

      <input type="number" name="remain_amount" class="form-control" value="<?php if (isset($loan['loan_amnt'])) echo $loan['total']; ?>" readonly>
    </div>
  </div>
  <hr>
  <div class="form-group row">
    <div class="col-md-6">
      <input type="submit" name="Close" class="btn btn-info pull-right" value="Close">
    </div>
  </div><!-- /.box-footer -->
</form>
</div>

<?php
include_once "inc/footer.php";
?>