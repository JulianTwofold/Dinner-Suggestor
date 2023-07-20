<?php
// Create a new array to store the sorted values
$sortedData = [];

foreach ($data as $food) {
    $eat_date = strtotime($food['eat_date']);
    $daysDifference = floor((time() - $eat_date) / (60 * 60 * 24));
    $cooktime = $food['cooktime'];

    if ($daysDifference > 14) {
        $daysDifference = 14;
    }

    if ($cooktime > 30) {
        $cooktime = 30;
    }
    
    $sortNumber = (14 - $daysDifference) + (0 - rand(0, 25)) + ($cooktime * 0.3);

    // Store the food item along with its sortNumber in the new array
    $sortedData[] = ['food' => $food, 'sortNumber' => $sortNumber];
}

// Sort the new array based on the sortNumber
usort($sortedData, function($a, $b) {
    return $a['sortNumber'] - $b['sortNumber'];
});

// Access the sorted values from the new array
foreach ($sortedData as $item) {
    $food = $item['food'];
    $recipeImage = "images/user_images/".$_SESSION["id"]."/recipe/".$food["recipe_name"];
    $foodImage = "images/user_images/".$_SESSION["id"]."/food/".$food["food_name"];

    if (!is_file($recipeImage)) {
        $recipeImage = "images/standart_recipe.png";
    }

    if (!is_file($foodImage)) {
        $foodImage = "images/standart_dinner.png";
    }

    echo '<div class="food">';
    echo '<p class="anzeige" id="'.$food['id'].'">' . $food['name'] . '</p>';
    echo '<div class="imageHolder" recipeLink="'.$recipeImage.'" style="background-image:url('.$foodImage.');"></div>';
    echo "<p class='cooktime'>Kochzeit: ".$food['cooktime']." Minuten</p>";
    echo "<p class='link cookButton' foodId='".$food['id']."'>Kochen</p>";
    echo '</div>';
}
?>

















<!--
$endresult = array(10=>0, 20=>0, 30=>0, 40=>0, 50=>0, 60=>0);

function randomise(){
global $endresult;
$numbers = [10, 20, 30, 40, 50, 60];
// Add a random number between 1 and 100 to each value, treating numbers greater than 30 as 30
$addedNumbers = array_map(function($number) {
    $addition = rand(1, 100);
    return $number > 30 ? 30 + $addition : $number + $addition;
}, $numbers);

// Combine the added values with the original numbers
$result = [];
foreach ($addedNumbers as $index => $value) {
    $result[] = [
        'sum' => $value,
        'original' => $numbers[$index]
    ];
}

// Sort the array based on the sum of original values and adjusted random numbers
usort($result, function($a, $b) {
    return $a['sum'] - $b['sum'];
});

// Print the result
$endresult[$result[count($result)-1]['original']]++;
}

//echo "Sum: " . $item['sum'] . ", Original: " . $item['original'] . "<br>";

for($i = 0; $i < 100; $i++){
    randomise();
}

echo '<pre>';
print_r($endresult);
echo '</pre>';
-->


