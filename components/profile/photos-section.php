<?php
require_once './config/autoload.php';

$images = new Images();

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    $profiles = $images->getUserProfileImages($userId);
} else {
}

?>

<div class="p-2 lg:px-8 lg:py-4">
    <div class="container mx-auto px-5 py-2 lg:pt-12">
        <div class="image-gallery -m-1 flex flex-wrap md:-m-2">
            <?php
            foreach ($profiles as $index => $profile_image) {
                echo <<<HTML
                <div class="image flex w-full lg:w-1/3 flex-wrap">
                    <div class="w-full p-3 md:p-2">
                        <img alt="$profile_image" class="block h-full w-full rounded-lg object-cover object-center" src="$profile_image" />
                    </div>
                </div>
HTML;
            }
            ?>

        </div>
    </div>
</div>

<style>
    #lightbox {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        text-align: center;
        z-index: 999;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    #lightbox img {
        max-width: 80%;
        max-height: 80%;
        margin: auto;
        display: block;
    }

    #lightbox .close-button {
        position: absolute;
        top: 15px;
        right: 15px;
        color: #fff;
        cursor: pointer;
        font-size: 24px;
        z-index: 1000;
    }
</style>

<script>
    $(document).ready(function() {
        // When an image is clicked, open the lightbox
        $(".image-gallery .image").click(function() {
            var imageUrl = $(this).find("img").attr("src");

            // Create the lightbox HTML
            var lightbox = `
                <div id="lightbox">
                    <span class="close-button">&times;</span>
                    <img src="${imageUrl}">
                </div>
            `;

            // Append the lightbox to the body
            $("body").append(lightbox);

            // Show the lightbox
            $("#lightbox").fadeIn();

            // Close the lightbox when the close button is clicked
            $("#lightbox .close-button").click(function() {
                $("#lightbox").fadeOut(function() {
                    $(this).remove();
                });
            });

            // Close the lightbox when clicking outside of the image
            $("#lightbox").click(function(event) {
                if ($(event.target).is("#lightbox")) {
                    $("#lightbox").fadeOut(function() {
                        $(this).remove();
                    });
                }
            });

            // Close the lightbox when the Escape key is pressed
            $(document).keydown(function(event) {
                if (event.key === "Escape") {
                    $("#lightbox").fadeOut(function() {
                        $(this).remove();
                    });
                }
            });
        });
    });
</script>