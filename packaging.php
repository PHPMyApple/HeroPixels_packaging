<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <!-- Compiled and minified CSS -->
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css"> -->
 

    <title>HeroPixels Packaking-Tool</title>
</head>
    <body>
    <?php

        function createContentDir() {
            $structure = './Content/skin_pack/texts/';
            mkdir($structure, 0777, true);
            echo "<script type = 'text/javascript'>alert('Done!');</script>";
        }


        function createStoreArt() {
            mkdir("Store Art");
        }

        function createMarketingArt() {
            mkdir("Marketing Art");
        }

        if (isset($_POST['create'])) {
            createMarketingArt();
            createStoreArt();
            createContentDir();
        } else {
            #echo "<script type = 'text/javascript'>alert('Gibt es schon!');</script>";
        }

        ##############################################################################################################
         
        if (($_FILES['skin_file']['name']!="")){
            $target_dir = "Content/skin_pack/";
            $file = $_FILES['skin_file']['name'];
            $path = pathinfo($file);
            $filename = $path['filename'];
            $ext = $path['extension'];
            $temp_name = $_FILES['skin_file']['tmp_name'];
            $path_filename_ext = $target_dir.$filename.".".$ext;
         
        if (file_exists($path_filename_ext)) {
         echo "Der Skin wurde erfolgreich hochgeladen.";
         }else{
         move_uploaded_file($temp_name,$path_filename_ext);
         echo "Es gab ein Fehler beim hochladen des Skins";
         }
        }

#Erstellt die Manifest.json Datei ##########################################################################################

if (isset($_POST["submitJson"])) {
    $Name = $_POST["name"];
    $Author = $_POST["author"];
    $header_uuid = $_POST["header_uuid"];
    $module_uuid = $_POST["module_uuid"];

    
    $array_manifest = Array (
        "format_version" => 1,
        "header" => Array (
            "name" => $Name,
            "uuid" => $header_uuid,
            "version" => [1, 0, 0],
        ),
        "modules" => Array ([
            "type" => "skin_pack",
            "uuid" => $module_uuid,
            "version" => [1, 0, 0]
        ]),
        "metadata" => Array (
            "authors" => $Author
        )
    );
    
    // encode array to json
    $json_manifest = json_encode($array_manifest);
    
    //write json to file
    if (file_put_contents("Content/skin_pack/manifest.json", $json_manifest))
        echo "Die Manifest.json Datei wurde erfolgreich hochgeladen";
    else 
        echo "Es ist ein Fehler beim erstellen der Manifest.json Datei aufgetreten";
    
    // data.json
}
        ####################################################################################################





#Erstellt die skins.json Datei ##########################################################################################

if(isset($_POST["submitSkin"])) {
    $final_data=fileCreateWrite();
    if(file_put_contents('skins.json', $final_data))
        {
            $message = "<label class='text-success'>File createed and  data added Success fully</p>";
        }
} //ende submit
//##############################################################
function fileCreateWrite(){


    $file=fopen("skins.json","w");
    $array_data=array();
	$extra = array(
        "skins" => Array ([
            "name" => $_POST['skin_name'],
            "geometry" => $_POST["geometry"],
            "texture" => $_POST["texture"],
            "Typ" => $_POST["type"]
        ]),
        "serialize_name" => $_POST["s_pack_name"],
        "localization_name" => $_POST["s_pack_name"]
    );
    $array_data = $extra;
    $final_data = json_encode($array_data);
    fclose($file);
    return $final_data;
}
    //#################################################################################
    if(isset($_POST["submitLanguage"])) {
        if(file_exists('Content/skin_pack/texts/languages.json'))
        {
             $final_data=fileWriteAppendLangugages();
             if(file_put_contents('Content/skin_pack/texts/languages.json', $final_data))
             {
                  $message = "<label class='text-success'>Data added Success fully</p>";
             }
        }
        else
        {
             $final_data=fileCreateWriteLanguages();
             if(file_put_contents('Content/skin_pack/texts/languages.json', $final_data))
             {
                  $message = "<label class='text-success'>File createed and  data added Success fully</p>";
             }
        
        }
    } //ende submit
    //#################### ##########################################
    function fileCreateWriteLanguages(){
    
    
        $file=fopen("Content/skin_pack/texts/languages.json","w");
        $array_data=array();
        $extra = array(
                $_POST['type']
        );
        $array_data = $extra;
        $final_data = json_encode($array_data);
        fclose($file);
        return $final_data;
    }
    //########################################################################
    function fileWriteAppendLangugages(){
        $current_data = file_get_contents('Content/skin_pack/texts/languages.json');
        $array_data = json_decode($current_data, true);
        $extra = $_POST['type'];
        $array_data[] = $extra;
        $final_data = json_encode($array_data);
        return $final_data;
    }
    //############################################################################################
    if(isset($_POST["submitLanguage"])) {
        $myfile = fopen($_POST["filename"].".lang", "w") or die("Unable to open file!");
    $skinpackname = "skinpack.".$_POST["SkinPackName"]."SkinPack=".$_POST["SkinPackName"]."\n";
    fwrite($myfile, $skinpackname);

    for ($skincount=0; $skincount < 10; $skincount++) { 
        $skinname = "skin.".$_POST["SkinPackName"]."SkinPack".".".$_POST["SkinName"]."Skin=".$_POST["SkinName"]."\n";
        $skin = $skinname;
        fwrite($myfile, $skin);
    }
    fclose($myfile);
    } //ende submit
    //##############################################################
    if (($_FILES['store_file']['name']!="")){
        $target_dir = "Store Art/";
        $file = $_FILES['store_file']['name'];
        $path = pathinfo($file);
        $filename = $path['filename'];
        $ext = $path['extension'];
        $temp_name = $_FILES['store_file']['tmp_name'];
        $path_filename_ext = $target_dir.$filename.".".$ext;
     
    if (file_exists($path_filename_ext)) {
     echo "Die Store Art Datei existiert bereits.";
     }else{
     move_uploaded_file($temp_name,$path_filename_ext);
     echo "Die Store Art Datei wurde erfolgreich hochgeladen.";
     }
    }
    //#########################################################

    if (($_FILES['marketing_file']['name']!="")){
        $target_dir = "Marketing Art/";
        $file = $_FILES['marketing_file']['name'];
        $path = pathinfo($file);
        $filename = $path['filename'];
        $ext = $path['extension'];
        $temp_name = $_FILES['marketing_file']['tmp_name'];
        $path_filename_ext = $target_dir.$filename.".".$ext;
     
    if (file_exists($path_filename_ext)) {
     echo "Die Marketing Art Datei existiert bereits.";
     }else{
     move_uploaded_file($temp_name,$path_filename_ext);
     echo "Die Marketing Art Datei wurde erfolgreich hochgeladen.";
     }
    }
    //#########################################################
    ?>
        <h4>1. Erstelle hier das Verzeichnis</h4>
        <!--Form für Create Directory-->
        <form action = "index.php" method = "post">
            <input type = "submit" name = "create" value = "Create directory" /> 
        </form>

        <br><br>

        <h4>2. Lade hier die Skins hoch</h4>
        <!-- Form für upload File-->
        <form name="form" action="index.php"  method="post" enctype="multipart/form-data" >
            <input type="file" name="skin_file" multiple/><br>
            <input type="submit" name="submit" value="Upload skin"/>
        </form>

        <br><br>

        <h4>3. Erstelle hier die Manifest.json Datei</h4>
         <!-- Form für create json File-->
         <form action = "index.php" method = "post">
            <input type="text" name="name" placeholder="Name eingeben"> <br>
            <input type="text" name="author" placeholder="Author eingeben"> <br>
            <input type="text" name="header_uuid" placeholder="Header UUID eingeben"><br>
            <input type="text" name="module_uuid" placeholder="Module UUID eingeben"><br>
            <input type = "submit" name = "submitJson" value = "Create json" /> 
        </form>

        <br><br>




        <h4>4. Erstelle hier die Skin.json Datei (hier wird nur 1 Skin hinzugefügt)</h4>
        <div class="container" style="width:500px;">
            <form method = "post">
            <input type="text" name="skin_name" placeholder="Name eingeben" required><br>
            <label>Geometrie:</label>
            <select name="geometry" required>
                <option value="geometry.humanoid.custom">Normal</option>
                <option value="geometry.humanoid.customSlim">Slim</option>
            </select><br>
            <label>Typ:</label>
            <select name="type" required>
                <option value="paid">Bezahlt</option>
                <option value="free">Kostenlos</option>
            </select><br>
            <input type = "text" name = "texture" placeholder="Texture eingeben" value = "s/a_skin_SKINNAME.png" required/><br>
            <input type = "text" name = "s_pack_name" placeholder="Skinpack Name" required/><br>
            <input type = "submit" name = "submitSkin" value = "Den Skin hinzufügen"/>
        </form>
        </div>

        <br><br>

        <h4>5. Erstelle hier die languages.json Datei</h4>
        <div class="container" style="width:500px;">
     <form method = "post">
    <label>Typ:</label>
    <select name="type" required>
        <option value="EN_US">Englisch</option>
        <option value="DE_DE">Deutsch</option>
    </select><br>
    <input type = "submit" name = "submitLanguage" value = "Den Skin hinzufügen"/>
</form>
</div>

        <br><br>
        <h4>6. Erstelle hier die SPRACHE.lang Dateien</h4>
    <div class="container" style="width:500px;">
        <form method = "post" enctype="multipart/form-data">
        <input type = "text" name = "filename" value="EN_US"/><br>
        <input type = "text" name = "SkinPackName" placeholder="Wie heißt das Skinpack"/><br>
        <input type = "text" name = "SkinName" placeholder="Füge hier einen Skin hinzu"/><br>
        <input type = "submit" name = "submitLanguage" value = "Den Skin hinzufügen"/>
    </form>
    </div>

    <br><br>

    <h4>6. Lade hier die Store Art Datei hoch</h4>
        <!-- Form für upload File-->
        <form name="form" action="index.php"  method="post" enctype="multipart/form-data" >
            <input type="file" name="store_file" multiple/><br>
            <input type="submit" name="submitStoreArt" value="Upload StoretArt"/>
        </form>
        <br><br>

<h4>7. Lade hier die Marketings Art Datei hoch</h4>
    <!-- Form für upload File-->
    <form name="form" action="index.php"  method="post" enctype="multipart/form-data" >
        <input type="file" name="marketing_file" multiple/><br>
        <input type="submit" name="submitMarketingArt" value="Upload MarketingArt"/>
    </form>

    </body>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</html>