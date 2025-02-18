<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    <title>veggie website</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
<!-- Navigation Bar section -->
    <nav class="navbar">
    <div class="navbar__container">
        <a href="index.php" id="navbar__logo">L&#x1F49A;ve your gut</a>
        <div class="navbar__toggle" id="mobile-menu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>
        <ul class="navbar__menu">
            <li class="navbar__item">
                <a href="index.php" class="navbar__links">
                Weekly view
                </a>
            </li>
            <li class="navbar__item">
                <a href="recipes.php" class="navbar__links">
                Recipes
                </a>
            </li>
            <li class="navbar__btn">
                <a href="/" class="button">
                Sign Up
                </a>
            </li>
        </ul>
    </div>
    </nav>
    <script src="app.js"></script>

<!--  Content Section -->
<div class="container">
    <!-- First column -->
    <div class="column">
    <h1>Add a plant &#128523;</h1><br>
    <form action="new-plant-handler.php" method="post">
            <label for="plant">Plant name</label>
            <input type="text" name="plant" id="plant" ><br>
            
            <label for="date_veggie">Date</label>
            <input type ="date" name="date_veggie" id="date_veggie"  ><br>

            <button type="submit">Add plant</button><br>
    </form><br>

    <h1>Add a plate &#x1f957;</h1>
    <form action="new-file-handler.php" method="post">
                 
        <label for="file">File</label>
        <input type="file" name="file" id="file" accept=".png, .jpeg, .jpg"><br>

        <label for="date_plate">Date</label>
        <input type ="date" name="date_plate" id="date_plate"  ><br>

        <button type="submit">Add plate</button>
    </form>

    <script>
        // Set the default date to today's date
        document.getElementById("date_veggie").valueAsDate = new Date();
        document.getElementById("date_plate").valueAsDate = new Date();
    </script>
    </div>

    <!-- Second column -->
    <div class="column">
    <h1>Plants eaten this week</h1><br>
        <?php
            include_once 'plants-display.php';
        ?><br>
    <h1>Plants not eaten yet</h1><br>
        <?php
            include_once 'suggestion-plants.php'
        ?>
    </div>
</div>
<!--Footer--> 
<footer>
    <p>Inspired by Love your Gut by Dr. Megan Rossi</p>
</footer> 
</body>
</html>

