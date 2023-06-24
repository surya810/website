<!DOCTYPE html>
<html>
<head>
  <title>Disease Data</title>
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <?php include 'includes/header.php'; ?>

  <div class="container">
    <h1>Disease Data</h1>
    
    <?php
    // Step 1: Establish database connection
    $host = 'localhost';
    $username = 'localhost';
    $password = '123';
    $database = 'your_database';
    
    $conn = mysqli_connect($host, $username, $password, $database);
    
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    
    // Step 2: User input for new data
    $add_data = isset($_POST['add_data']) ? $_POST['add_data'] : '';
    
    if ($add_data === 'yes') {
        $new_disease = isset($_POST['new_disease']) ? $_POST['new_disease'] : '';
        $new_symptoms = isset($_POST['new_symptoms']) ? $_POST['new_symptoms'] : '';
        $new_medicines = isset($_POST['new_medicines']) ? $_POST['new_medicines'] : '';
        
        // Step 3: Update the dataset
        if (!empty($new_disease) && !empty($new_symptoms) && !empty($new_medicines)) {
            $sql = "INSERT INTO disease (Diseases, Symptoms, Medicines)
                    VALUES ('$new_disease', '$new_symptoms', '$new_medicines')";
            
            if (mysqli_query($conn, $sql)) {
                echo '<p class="alert alert-success">Dataset updated successfully!</p>';
            } else {
                echo '<p class="alert alert-danger">Failed to update the dataset: ' . mysqli_error($conn) . '</p>';
            }
        } else {
            echo '<p class="alert alert-danger">Please fill in all the fields.</p>';
        }
    }
    
    // Step 4: Retrieve existing data from the database
    $select_query = "SELECT * FROM disease";
    $result = mysqli_query($conn, $select_query);
    $disease_data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    ?>
    
    <h2>Existing Data</h2>
    <table class="table">
      <thead>
        <tr>
          <th>Disease</th>
          <th>Symptoms</th>
          <th>Medicines</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($disease_data as $row): ?>
        <tr>
          <td><?php echo $row['Diseases']; ?></td>
          <td><?php echo $row['Symptoms']; ?></td>
          <td><?php echo $row['Medicines']; ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    
    <h2>Add New Data</h2>
    <form method="post" action="">
      <div class="form-group">
        <label for="new_disease">Disease:</label>
        <input type="text" class="form-control" id="new_disease" name="new_disease" required>
      </div>
      <div class="form-group">
        <label for="new_symptoms">Symptoms:</label>
        <input type="text" class="form-control" id="new_symptoms" name="new_symptoms" required>
      </div>
      <div class="form-group">
        <label for="new_medicines">Medicines:</label>
        <input type="text" class="form-control" id="new_medicines" name="new_medicines" required>
      </div>
      <div class="form-group">
        <label for="add_data">Add more data?</label>
        <select class="form-control" id="add_data" name="add_data">
          <option value="yes">Yes</option>
          <option value="no">No</option>
        </select>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>

  <?php include 'includes/footer.php'; ?>

  <script src="js/bootstrap.min.js"></script>
  <script src="js/script.js"></script>
</body>
</html>
