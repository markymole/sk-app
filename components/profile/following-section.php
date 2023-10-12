<?php

$image_src = $image->getUserProfileImage($id, $gender);
?>

<section class="bg-white dark:bg-gray-900">
    <div class="py-6 px-4 mx-auto max-w-screen-xl lg:py-10 lg:px-6">
        <div class="mx-auto text-left mb-4 lg:mb-4">
            <h2 class="mb-4 text-2xl tracking-tight font-extrabold text-gray-900 dark:text-white">Following</h2>
        </div>
        <div class="grid gap-8 mb-6 lg:mb-16 md:grid-cols-2">
            <div class="h-20 bg-gray-50 rounded-lg shadow sm:flex dark:bg-gray-800 dark:border-gray-700">
                <a href="#">
                    <img class="h-20 w-auto rounded-lg sm:rounded-none sm:rounded-l-lg" img src="<?php echo $image_src ?>" alt="Profile Picture">
                </a>
                <div class="p-2">
                    <div class="flex flex-wrap">
                        <h3 class="text-sm font-bold tracking-tight text-gray-900 dark:text-white">
                            <a href="#"><?php echo $firstname ?> <?php echo  $lastname ?></a>
                        </h3>
                        <!-- <button type="button" class=" ml-36 px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Follow</button> -->
                    </div>
                    <span class="text-xs text-gray-500 dark:text-gray-700"><?php echo $role ?></span>
                    <p class=" font-light text-xs text-gray-500 dark:text-gray-700 overflow-hidden">From: <?php echo $barangay ?></p>
                </div>
            </div>

        </div>
</section>