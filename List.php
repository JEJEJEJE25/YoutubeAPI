<?php
     include_once('config.php');
    
    $query ="SELECT * FROM tblsongs ORDER BY Title ASC";  
    $result = mysqli_query($conn, $query);  
    ?>  
    <!DOCTYPE html>  
    <html>  
    <head>  
         <title>Platinum Karaoke Song Finder</title>  
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
         <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
         <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>  
         <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>            
         <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css" />  


    </head>  
    <body>  
           
         <div class="container" >  
              <div class="table-responsive"  width=50%>  
              <table id="employee_data" class="table table-striped table-bordered">  
                        <thead>  
                             <tr>  
                                  <td>Code</td>  
                                  <td>Title</td>  
                                  <td>Artist</td>  
                                  <td>Action</td>
                             </tr>  
                        </thead>  
                        <?php  
                        while($row = mysqli_fetch_array($result))  
                        {              
                          echo '<tr>
                          <td>'.$row["Code"].'</td>
                          <td>'.$row["Title"].'</td>
                          <td>'.$row["Artist"].'</td>';
                          ?>

                          <form id="myForm" action="List.php" method="POST">
                              <td>
                                   <input type="submit" name="btnAdd" value="Add" />
                                   <input type="hidden" name="searchCode" value="<?php echo $row["SearchCode"] ?>" />
                                   <input type="hidden" name="Code" value="<?php echo $row["Code"] ?>" />
                                   <input type="hidden" name="Title" value="<?php echo $row["Title"] ?>" />
                              </td>
                          </form>
                                           
                          </tr>                           
                          <?php
                    	 } 
                   		 ?> 
                          <?php
                          
                                   if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btnAdd"])) {
                                        // Get form values
                                        $searchCode = $_POST["searchCode"];
                                        $code = $_POST["Code"];
                                        $title = $_POST["Title"];
                                   
                                        if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                        }
                                   
                                        // SQL query to insert data into the table
                                        $sql = "INSERT INTO tblqueue (searchCode, Code, Title) VALUES (?, ?, ?)";
                                   
                                        // Prepare and bind the statement
                                        $stmt = $conn->prepare($sql);
                                        $stmt->bind_param("sss", $searchCode, $code, $title);
                                   
                                        // Execute the statement
                                        if ($stmt->execute()) {
                                        echo "Record added successfully";
                                        } else {
                                        echo "Error: " . $stmt->error;
                                        }
                                   
                                        // Close the statement and connection
                                        $stmt->close();
                                        $conn->close();
                                   }
 
                          ?>
                     </table>  
               </div>  
          </div>  
</body> 
<script type="text/javascript" src="script.js"></script> 
</html>  
<script>  
    $(document).ready(function(){  
         $('#employee_data').DataTable();  
         
    });
</script>  