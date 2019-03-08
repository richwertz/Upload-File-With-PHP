<?php
$conn = mysqli_connect("localhost", "root", "YES", "adres");

if (isset($_POST["import"])) {
    
    $fileName = $_FILES["file"]["tmp_name"];
    
    if ($_FILES["file"]["size"] > 0) {
        
        $file = fopen($fileName, "r");
        
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            $sqlInsert = "INSERT into users (userID,userNaam,wachtwoord,userAdres,userStad)
                   values ('" . $column[0] . "','" . $column[1] . "','" . $column[2] . "','" . $column[3] . "','" . $column[4] . "')";
            $result = mysqli_query($conn, $sqlInsert);
            
            if (! empty($result)) {
                $type = "success";
                $message = "Succes- CSV Data Imported into the Database | Succes- CSV-gegevens geïmporteerd in de database";
            } else {
                $type = "error";
                $message = "Issue with Importing CSV Data | Probleem met het importeren van CSV-gegevens";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
<script src="js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/bootstrap-filestyle.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/style.css">
<script type="text/javascript">
$(document).ready(function() {
    $("#frmCSVImport").on("submit", function () {

	    $("#response").attr("class", "");
        $("#response").html("");
        var fileType = ".csv";
        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + fileType + ")$");
        if (!regex.test($("#file").val().toLowerCase())) {
        	    $("#response").addClass("error");
        	    $("#response").addClass("display-block");
            $("#response").html("Invalid File. Upload : <strong>" + fileType + "</strong> Files Only.<br/>Ongeldig bestand. Uploaden : <strong>" + fileType + "</strong>-bestanden alleen.");
            return false;
        }
        return true;
    });
});
</script>
</head>

<body>
    <h2>Importeer CSV-bestanden in een MySQL-database met behulp van PHP</h2>
    <h2>Import CSV file into a Mysql database using PHP</h2>
    
    <div id="response" class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>"><?php if(!empty($message)) { echo $message; } ?></div>
    <div class="outer-scontainer">
        <div class="row">

            <form class="form-horizontal" action="" method="post"
                name="frmCSVImport" id="frmCSVImport" enctype="multipart/form-data">
                <div class="input-row">
                    <label class="col-md-4 control-label">Kies CSV-bestand | Choose CSV
                        File</label> <input type="file" name="file" id="file" class="filestyle" data-buttonText="Vind bestand | Find file" data-placeholder="Geen bestand | No file" accept=".csv">
                    <button type="submit" id="submit" name="import"
                        class="btn-submit">Importeren Import<br/></button>
                    <br />

                </div>

            </form>

        </div>
               <?php
            $sqlSelect = "SELECT * FROM users";
            $result = mysqli_query($conn, $sqlSelect);
            
            if (mysqli_num_rows($result) > 0) {
                ?>
        <h2>Data obtained from CSV file</h2>
        <h2>Gegevens verkregen uit CSV-bestand</h2>
            <table id='userTable'>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Gebruikersnaam</th>
                    <th>Adres</th>
                    <th>Stad</th>

                </tr>
            </thead>
<?php
                
                while ($row = mysqli_fetch_array($result)) {
                    ?>
                    
                <tbody>
                <tr>
                    <td><?php  echo $row['userID']; ?></td>
                    <td><?php  echo $row['userNaam']; ?></td>
                    <td><?php  echo $row['userAdres']; ?></td>
                    <td><?php  echo $row['userStad']; ?></td>
                </tr>
                    <?php
                }
                ?>
                </tbody>
        </table>
        <?php } ?>
    </div>
<script type="text/javascript">
 //   $(":file").filestyle({buttonText: "Kies bestand | Choose File", badge: true});
    
</script>
</body>

</html>