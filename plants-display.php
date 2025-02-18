<?php
try {
    require_once "db.inc.php";
    
    // Creating beginning and end of week variables
    $current_date = date('Y-m-d');
    $date_min = date('Y-m-d 00:00:00', strtotime('monday this week', strtotime($current_date)));

    $date_max = date('Y-m-d 00:00:00', strtotime('sunday this week', strtotime($current_date)));
    // Selecting plants based on date: Preparing the Query
    // !! will have to add username

    $query = "SELECT DISTINCT weekly_plants.plant_name, emojis.html_code FROM weekly_plants LEFT JOIN emojis ON weekly_plants.plant_name = emojis.emoji_name WHERE weekly_plants.uploaded_at >= :date_min ORDER BY weekly_plants.plant_name;";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":date_min", $date_min, PDO::PARAM_STR);


    $stmt->execute();

    // Displaying the results row by row
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (empty($results)){
        echo "<p>No plants eaten this week!</p>";
    } else {
        echo "<p>Total: " . count($results) . "</p><br>";
        echo "<div class='plant-container'>";
        foreach ($results as $row) {
            echo "<div class='plant-item'>" . htmlspecialchars($row['plant_name'])  . " " . $row['html_code'] . "</div>";
        }
        echo "</div>";
    }

   
    

    $stmt = null;

    //header("Location: index.php");
    //die();
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}

