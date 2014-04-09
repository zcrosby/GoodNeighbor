<?php

class Utility extends DB{
    
    public function getNeighborhoods(){
        $sqlString = 'SELECT neighborhood_id, neighborhood_name FROM neighborhood';
        $neighborhoodList = $this->returnAFetchAll($sqlString);
        return $neighborhoodList; 
    }//end getNeighborhoods()
    
    public function getCities(){
        $sqlString = 'SELECT city_id, city_name FROM city';
        $cityList = $this->returnAFetchAll($sqlString);
        return $cityList;
    }//end getCities()
    
    public function getCityID($city){
        $db = $this->connectToDB();
        if( $db != NULL){
            $stmt = $db->prepare('SELECT city_id FROM city WHERE city_name = :city limit 1');
            $stmt->bindParam(':city', $city, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if( $stmt->execute() ){
                $cityID = intval($result["city_id"]);
                $this->closeDB();
                return $cityID;
            }
        }
    }
    
    public function getneighborhoodID($neighborhood){
        $db = $this->connectToDB();
        if( $db != NULL){
            $stmt = $db->prepare('SELECT neighborhood_id FROM neighborhood WHERE neighborhood_name = :neighborhood limit 1');
            $stmt->bindParam(':neighborhood', $neighborhood, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if( $stmt->execute() ){
                $neighborhoodID = intval($result["neighborhood_id"]);
                $this->closeDB();
                return $neighborhoodID;
            }
        }
    }
    
}
