<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Extract data from the form
    $plant = $_POST["plant"];
    $date_submitted = $_POST["date_veggie"];

    // Harmonise all entries with uppercase
    $plant = ucwords(strtolower($plant)); // lowercasing first
    
    // Validate form data
    if (empty($plant)) {
        header("Location: index.html");
        exit();
    }
  
    try {
        require_once "db.inc.php";
        // Checking if the plant is already in the database
        $query_checkplant = "SELECT plant_name FROM plant_names WHERE plant_name = :plant LIMIT 1;";

        $stmt = $pdo->prepare($query_checkplant);
        $stmt->bindParam(":plant",$plant);

        $stmt->execute();

        $plant_exist = $stmt->fetch(PDO::FETCH_ASSOC)["plant_name"];
        $stmt = null;

        // Adding the plant in the database in case it is not yet in there
        if (empty($plant_exist)) {
            $query_newplant = "INSERT INTO plant_names (plant_name) VALUE (:plant);";

            $stmt = $pdo->prepare($query_newplant);
            $stmt->bindParam(":plant",$plant);
            $stmt->execute();
            $stmt = null;
        }
        

        // Retrieving the foreign key

        $query_match = "SELECT plant_id FROM plant_names WHERE plant_name = :plant LIMIT 1;";
        
        $stmt = $pdo->prepare($query_match);
        $stmt->bindParam(":plant",$plant);

        $stmt->execute();

        $plant_names_id = $stmt->fetch(PDO::FETCH_ASSOC)["plant_id"];
        
        $stmt = null;

        // Inserting into the weekly plants table
        // Need to add the username here
        $query_weekly = "INSERT INTO weekly_plants (plant_name, uploaded_at, plant_names_id) VALUE (:plant, :uploaded_at, $plant_names_id);";
        $stmt = $pdo->prepare($query_weekly);

        $stmt->bindParam(":plant",$plant);
        $stmt->bindParam(":uploaded_at",$date_submitted);

        $stmt->execute();

        $stmt = null;
        $pdo = null;

        header("Location: index.html");
        die();
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    header("Location: index.html");
}


