<?php
  include_once __DIR__ . "/../partials/header-operacao.php";
?>

  <div class="container">
      <div class="row">
          <form class="form-horizontal" action="import_form.php" method="post" name="upload_excel" enctype="multipart/form-data">
              <fieldset>

                  <!-- Form Name -->
                  <legend>Form Name</legend>

                  <!-- File Button -->
                  <div class="form-group">
                      <label class="col-md-4 control-label" for="filebutton">Select File</label>
                      <div class="col-md-4">
                          <input type="file" name="file" id="file" class="input-large">
                      </div>
                  </div>

                  <!-- Button -->
                  <div class="form-group">
                      <label class="col-md-4 control-label" for="singlebutton">Import data</label>
                      <div class="col-md-4">
                          <button type="submit" id="submit" name="Import" class="btn btn-primary button-loading" data-loading-text="Loading...">Import</button>
                      </div>
                  </div>

              </fieldset>
          </form>

      </div>
<?php

  // function get_all_records() {


  //   $query = "
  //   UPDATE
  //     users
  //   SET
  //     name = '$name',
  //     birthday = '$birthday',
  //     phone = '$phone',
  //     alias = '$alias',
  //     email = '$email',
  //     cpf = '$cpf',
  //     gender = '$gender',
  //     type = '$type'
  //   WHERE
  //     id = $userId
  // ";

  // $result = $db->query($query);

  //   $con = getdb();
  //   $Sql = "SELECT * FROM employeeinfo";
  //   $result = mysqli_query($con, $Sql);


  //   if (mysqli_num_rows($result) > 0) {
  //     echo "<div class='table-responsive'><table id='myTable' class='table table-striped table-bordered'>
  //             <thead><tr><th>EMP ID</th>
  //                         <th>First Name</th>
  //                         <th>Last Name</th>
  //                         <th>Email</th>
  //                         <th>Registration Date</th>
  //                       </tr></thead><tbody>";


  //     while($row = mysqli_fetch_assoc($result)) {

  //         echo "<tr><td>" . $row['emp_id']."</td>
  //                   <td>" . $row['firstname']."</td>
  //                   <td>" . $row['lastname']."</td>
  //                   <td>" . $row['email']."</td>
  //                   <td>" . $row['reg_date']."</td></tr>";
  //     }

  //     echo "</tbody></table></div>";

  //   } else {
  //       echo "you have no records";
  //   }
  // }

  // get_all_records();
?>
  </div>

<?php
  include_once __DIR__ . "/../partials/footer.php";
  include_once __DIR__ . "/../partials/foot.php";
?>
