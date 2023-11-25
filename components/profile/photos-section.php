<?php
require_once './config/autoload.php';

$images = new Images();

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $profiles = $images->getUserProfileImages($user_id);
} else {
    $user_id = $_SESSION['user_id'];
    $profiles = $images->getUserProfileImages($user_id);
}

?>


<div class="p-2 lg:px-8 lg:py-4">
    <div class="container mx-auto px-5 py-2 lg:pt-12">
        <div class="image-gallery -m-1 flex flex-wrap md:-m-2">
            <?php
            if ($profiles) {
                foreach ($profiles as $index => $profile_image) {
                    echo <<<HTML
                <div class="image-container  flex w-full lg:w-1/4 flex-wrap">
                    <div class="w-full p-3 md:p-2 relative">
                        <img alt="$profile_image" class="image h-full w-full rounded-lg object-cover object-center cursor-pointer" src="$profile_image" />
                        
HTML; ?>

            <?php
                    if ($_SESSION['user_id'] == $user_id) {
                        echo <<<HTML
                        <div id="remove-button" data-remove-id="$user_id" data-src="$profile_image" class="p-1 bg-white rounded-full absolute top-4 right-4">
                            <svg id="" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 cursor-pointer">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                    </div>
                </div>
HTML;
                    }
                }
            } else {
                echo <<<HTML
                <div>
                    <p class="pb-10">No upload yet</p>
                </div>
HTML;
            }

            ?>

        </div>
    </div>
</div>

<style>
    #remove-button {
        display: none;
    }

    .image-container:hover #remove-button {
        display: block;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const imageContainers = document.querySelectorAll('.image-container');

        imageContainers.forEach(container => {
            const removeButton = container.querySelector('#remove-button');
            const userId = removeButton.getAttribute('data-remove-id');

            container.addEventListener('mouseenter', () => {
                removeButton.style.display = 'block';
            });

            container.addEventListener('mouseleave', () => {
                removeButton.style.display = 'none';
            });

            removeButton.addEventListener('click', (event) => {
                if (confirm('Are you sure you want to delete this image?')) {
                    const imgSrc = removeButton.getAttribute('data-src');

                    $.ajax({
                        type: 'POST',
                        url: './controllers/delete_profile.php',
                        data: {
                            user_id: userId,
                            img_src: imgSrc
                        },
                        success: function(response) {
                            const parsedResponse = JSON.parse(response);

                            if (parsedResponse.success) {
                                container.remove();
                                console.log('Image deleted successfully.');
                            } else {
                                console.log('Failed to delete image.');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error deleting image:', error);
                        }
                    });
                }
            });
        });
    });
</script>