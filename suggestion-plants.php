<?php
try {
    require_once "db.inc.php";
    
    // Creating beginning and end of week variables
    $current_date = date('Y-m-d');
    $date_min = date('Y-m-d 00:00:00', strtotime('monday this week', strtotime($current_date)));

    $date_max = date('Y-m-d 00:00:00', strtotime('sunday this week', strtotime($current_date)));
    // Selecting plants based on date: Preparing the Query
    // !! will have to add username


// chatgpt attempt to do all 

$query = "SELECT random_plants.*
    FROM (
        SELECT all_plants.*
        FROM (
            SELECT plant_names.plant_id, plant_names.plant_name, COALESCE(plant_names.plant_name, emojis.emoji_name) AS final_plant_name, emojis.html_code
            FROM plant_names
            LEFT JOIN emojis ON plant_names.plant_name = emojis.emoji_name
            UNION ALL
            SELECT NULL AS plant_id, emojis.emoji_name AS plant_name, COALESCE(plant_names.plant_name, emojis.emoji_name) AS final_plant_name, emojis.html_code
            FROM emojis
            LEFT JOIN plant_names ON emojis.emoji_name = plant_names.plant_name
            WHERE plant_names.plant_name IS NULL
        ) AS all_plants
        LEFT JOIN weekly_plants ON all_plants.plant_id = weekly_plants.plant_names_id
            AND (weekly_plants.uploaded_at >= :date_min OR weekly_plants.uploaded_at IS NULL)
        WHERE weekly_plants.plant_names_id IS NULL
        ORDER BY RAND()
        LIMIT 6
    ) AS random_plants
    ORDER BY random_plants.final_plant_name ASC;
";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":date_min", $date_min, PDO::PARAM_STR);
    // $stmt->bindParam(":date_max",$date_max);
    // $stmt->bindParam(":current_date",$current_date);


    $stmt->execute();

    // Displaying the results row by row
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<div class='plant-container'>";
        foreach ($results as $row) {
            echo "<div class='plant-item'>" .  htmlspecialchars($row['final_plant_name'])  . " " . $row['html_code'] . "</div>";
            }
     echo "</div>";

    $stmt = null;


    //header("Location: index.php");
    //die();
} catch (PDOException $e) {
    die("Query failed: " . $e->getMessage());
}