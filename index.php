<?php
  require_once("EmployeeManager.php");

$FILE_NAME = "employees.xml";

$employeeManager = new EmployeeManager($FILE_NAME);

$currentEmployeeIndex = isset($_POST['currentIndex']) ? $_POST['currentIndex'] : 0;

if (isset($_POST['prev'])) {
    $currentEmployeeIndex = max(0, $currentEmployeeIndex - 1);
} elseif (isset($_POST['next'])) {
    $employees = $employeeManager->getEmployees();
    $totalEmployees = count($employees);
    $currentEmployeeIndex = min($totalEmployees - 1, $currentEmployeeIndex + 1);
}


if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $employeeManager->insertEmployee($name, $email, $phone, $address);
}

if (isset($_POST['update'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $employees = $employeeManager->getEmployees();
    $employees[$currentEmployeeIndex] = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'address' => $address
    ];

    $employeeManager->updateEmployees($employees);
}

if (isset($_POST['delete'])) {
    $employeeManager->deleteEmployee($currentEmployeeIndex);
    $currentEmployeeIndex = 0;
}

if (isset($_POST['update'])) {
  $name = $_POST['name'];

  $employeeManager->searchByName($name);
}
$employees = $employeeManager->getEmployees();
$currentEmployee = $employees[$currentEmployeeIndex] ?? null;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud-Data-Xml</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <section class="bg-light p-5 p-md-5 p-sm-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-11 border-light-subtle col-lg-8 offset-2">
                    <div class="card shadow-sm">
                        <div class="container mt-5 p-3 rounded cart">
                            <div class="row">
                                <div class="col-12 col-lg-9 offset-1">
                                  <div class="row">
                                    <div class="col-12">
                                     <form action="">

                                     </form>
                                    </div>
                                  </div>
                                    <form method="post">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" name="name" placeholder="Enter name" value="<?php echo $currentEmployee['name'] ?? ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email address</label>
                                            <input type="email" class="form-control" name="email" placeholder="Enter email" value="<?php echo $currentEmployee['email'] ?? ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Phone</label>
                                            <input type="text" class="form-control" name="phone" placeholder="Enter phone number" value="<?php echo $currentEmployee['phone'] ?? ''; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <input type="text" class="form-control" name="address" placeholder="Enter address" value="<?php echo $currentEmployee['address'] ?? ''; ?>">
                                        </div>
                                        <input type="hidden" name="currentIndex" value="<?php echo $currentEmployeeIndex; ?>">
                                        <input type="submit" class="btn btn-secondary" name="prev" value="Prev">
                                        <input type="submit" class="btn btn-secondary" name="next" value="Next">
                                        <input type="submit" class="btn btn-success" name="submit" value="Insert">
                                        <input type="submit" class="btn btn-primary" name="update" value="Update">
                                        <input type="submit" class="btn btn-danger" name="delete" value="Delete">
                                        <input type="submit" class="btn btn-info" name="search" value="Search">
                                    </form>
                                 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
