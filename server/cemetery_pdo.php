<?php

include 'connection.php';

function getAllCemeteries($db){
    $query = "select * from CentralCemeteries.cemetery";

    $stmt = $db->prepare($query);
    if($stmt->execute()) {

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    else {
        return null;
    }
}


function getCemetery($db, $id){
    $query="select * from CentralCemeteries.cemetery where id=:Id";
    $stmt=$db->prepare($query);
    $stmt->bindParam(":Id", $id, PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_OBJ);
}

function insertCemetery($db ,$place_id, $description, $additional_data, $longitude, $latitude){

    $query = "insert into CentralCemeteries.cemetery
              values(NULL, :place_id, :description, :additional_data, :longitude, :latitude)";

    $stmt = $db->prepare($query);

    $stmt->bindParam(":place_id", $place_id, PDO::PARAM_INT);
    $stmt->bindParam(":description", $description, PDO::PARAM_STR);
    $stmt->bindParam(":additional_data", $additional_data, PDO::PARAM_STR);
    $stmt->bindParam(":longitude", $longitude, PDO::PARAM_STR);
    $stmt->bindParam(":latitude", $latitude, PDO::PARAM_STR);

    if($stmt->execute())
        return true;
    else
        return false;

}

function getCemeteriesInRegion($db, $regionId){
    $query = "select * from CentralCemeteries.cemetery where regionId = :regionId";

    $stmt = $db->prepare($query);

    $stmt->bindParam(":regionId", $regionId, PDO::PARAM_INT);

    if($stmt->execute()){
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    else {
        return null;
    }
}

function getCemeteriesInCountry($db, $countryId){
    $query = "select * 
              from CentralCemeteries.cemetery
              where regionId in (select id
                                 from CentralCemeteries.region
                                 where countryId = :countryId)";
    $stmt = $db->prepare($query);

    $stmt->bindParam(":countryId", $countryId, PDO::PARAM_INT);

    if($stmt->execute()){
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    else {
        return null;
    }
}



try{
    $pdo=PDO_DB::getConnectionInstance();
//    $all_cemeteries=getAllCemeteries($pdo);
//    var_dump($all_cemeteries);

//    $cemteries_in_region = getCemeteriesInRegion($pdo, 1);
//    var_dump($cemteries_in_region);
//
//
//    $cemteries_in_region = getCemeteriesInCountry($pdo, 1);
//    var_dump($cemteries_in_region);
//


//    $cemetery_id=1;
//    $cemetery_info=$pdo->getCemetery($cemetery_id);
//    var_dump($cemetery_info);

//    $insert_cemetery=$pdo->insertCemetery(1, "Test description", null, 45.3815612, 20.36857370000007);
//    var_dump($insert_cemetery);
//

}catch(PDOException $e){

    echo $e->getMessage();
    unset($pdo);
}

?>
