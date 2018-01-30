<?php

include "photo_tag_pdo.php";

$status_messages=array(
    200 => "OK",
    201 => "Created",
    400 => "Bad request",
    404 => "Not found",
    405 => "Method not allowed",
    500 => "Internal server error");

/* Odgovor koji treba vratiti */
$response=new stdClass();
$response->data="";
$response->status=0;
$response->error=false;
$response->error_message="";

/* Podrzane metode API-ja */
$supported_methods=array("GET", "POST", "PUT", "DELETE");
$method=strtoupper($_SERVER['REQUEST_METHOD']);

/* Provera zahteva koji treba da se opsluzi */
if(!in_array($method,$supported_methods)) {
    $response->status=405;
}
else {

    /* Obrada podrzanih zahteva */

    $number_of_url_elements = 0;
    $url_elements = array();

    if (isset($_SERVER['PATH_INFO'])) {
        $url_elements = explode("/", $_SERVER['PATH_INFO']);
        $number_of_url_elements = count($url_elements) - 1;
    }


    $pdo = Connection::getConnectionInstance();

    try {
        switch ($method) {

            case "GET":

                switch ($number_of_url_elements) {
                    case 2:
                        // GET/photo/{photoId}
                        if ($url_elements[1] == "photo") {
                            $response->data = getPhotoTags($pdo, intval($url_elements[2]));
                            $response->status = 200;
                        }  if ($url_elements[1] == "query") {
                            //echo $url_elements[2];
                            $response->data = getSpecialPhotos($pdo, $url_elements[2]);
                            $response->status = 200;
                        } else {
                            $response->status = 400;
                            $response->data = null;
                        }
                        break;

                }
                break;
            case "POST":
                $newPhotoTag = json_decode(file_get_contents("php://input"));

                if(insertPhotoTag($pdo, $newPhotoTag->photoId, $newPhotoTag->tagId, $newPhotoTag->value)){
                    $response->status = 201;
                } else {

                    $response->status = 400;

                    $mmm = getTagName($pdo, $newPhotoTag->tagId);
                    $values = getTagPossibleValues($pdo, $newPhotoTag->tagId);
                    $response->data = "Value --". $newPhotoTag->value ."-- for tag --". $mmm->name ."-- is not correct.
                                       Possible values for tag --". $mmm->name . "-- are: " . $values . "." ;

                }
                break;


            case "DELETE":

                // DELETE/photo/{photoId}

            /*    if($number_of_url_elements == 2 and $url_elements[1] == "photo") {

                    if (deletePhoto($pdo, intval($url_elements[2]))) {
                        $response->data = "true";
                        $response->status = 200;
                    } else {
                        $response->data = null;
                        $response->status = 400;
                    }
                }
                else{
                    $response->status = 400;
                    $response->data = null;
                }

                break;
            */
        }

    } catch (Exception $e) {
        $response->status = 500;
        $response->error = true;
        $response->data = null;
    }
}
// zaglavlje

/*   if(headers_sent()){
    echo "Ne moze!";
}*/
//   else {

// Menjamo promenljivama
header("HTTP/1.1 " . $response->status . " " . $status_messages[$response->status]);
// Dodajemo da je u json formatu
header("Content-Type:application/json");
//}


// telo
if($response->data != null){
    echo json_encode($response->data);

}


?>