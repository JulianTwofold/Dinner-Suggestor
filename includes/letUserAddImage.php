<?php
    $path = "images/user_images/".$_SESSION["id"]."/";
    $textRecipe = "hinzufügen";
    $textFood = "hinzufügen";
    $fotoRecipe = "";
    $fotoFood = "";

    //load the image if one is already slected

    if(isset($recipeName)){
        if (file_exists($path."recipe/".$recipeName) && $recipeName !== ""){
            $imgPath = $path."recipe/".$recipeName;
            $fotoRecipe = "<img src='".$imgPath."' />";
            $textRecipe = "ändern";
        }
    }
    
    if(isset($foodName)){
        if (file_exists($path."food/".$foodName) && $foodName !== ""){
            $imgPath = $path."food/".$foodName;
            $fotoFood = "<img src='".$imgPath."' />";
            $textFood = "ändern";
        }
    }
?>

<label for="recipe" id="addRecipeLabel">Rezept <?php echo $textRecipe;?></label>
<input id="recipe" type="file" accept="image/*" />
<div id="recipeImage">
    <?php echo $fotoRecipe; ?>
</div>

<label for="food" id="addFoodLabel">Bild <?php echo $textFood;?></label>
<input id="food" type="file" accept="image/*" />
<div id="foodImage">
    <?php echo $fotoFood; ?>
</div>

<style>
input[type="file"] {
    display: none;
}

#recipeImage, #foodImage{
    max-width: 80vw;
    max-height: 25vh;
    overflow:hidden;
}

#recipeImage img, #foodImage img{
    max-width: 100%;
    max-height: 100%;
}

#addRecipeLabel, #addFoodLabel{
    text-decoration: underline;
    margin-top:15px;
}
</style>

<script>
    function addFileListener(uploadId, displayDiv, label, newText) {
        document.getElementById(uploadId).addEventListener('change', function () {
            const file = this.files[0];
            const reader = new FileReader();

            reader.addEventListener('load', function () {
                const img = document.createElement('img');
                img.src = reader.result;
                document.getElementById(displayDiv).innerHTML = '';
                document.getElementById(displayDiv).appendChild(img);
                label.innerText = newText;
            });

            if (file) {
                reader.readAsDataURL(file);
            }
        });
    }
    addFileListener("recipe", "recipeImage", document.getElementById("addRecipeLabel"), "Rezept ändern");
    addFileListener("food", "foodImage", document.getElementById("addFoodLabel"), "Bild ändern");
</script>