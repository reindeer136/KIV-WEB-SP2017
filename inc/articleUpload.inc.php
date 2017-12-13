
<?php
$target_dir = "files/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
 /*
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "Soubor je platným PDF souborem - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "Soubor není PDF";
        $uploadOk = 0;
    }
*/
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Omlouváme se, takový soubor tu již máme. Prosím, přejmenujte jej. ";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "Omlouváme se, Váš soubor je příliš velký";
    $uploadOk = 0;
}
// Allow certain file formats
if($FileType != "pdf") {
    echo "Povoleny jsou pouze soubory PDF. ";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Váš soubor nemohl být nahrán";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "Soubor ". basename( $_FILES["fileToUpload"]["name"]). " byl úspěšně nahrán na server";
    } else {
        echo "Omlouváme se, při nahrávání Vašeho článku se vyskytly potíže";
    }
}
?>
