<?php

require_once './config/autoload.php';

$post = new Posts();
$user = new Users();
$image = new Images();
$message = new Messages();

$posts = $post->get_all_posts();

$user_data = $user->authenticate($_SESSION['user_id']);

if ($user_data) {
    $id = $user_data['id'];
    $firstname = $user_data['first_name'];
    $lastname = $user_data['last_name'];
    $username = $user_data['username'];
    $barangay = $user_data['barangay'];
    $gender = $user_data['gender'];
    $role = $user_data['role'];
    $bio = $user_data['bio'];
} else {
    $firstname = 'Unknown';
    $lastname = 'Unknown';
    $barangay = 'Unknown';
    $username = 'Unknown';
    $role = 'Guest';
}
?>


<!doctype html>
<html lang="en">

<body>

    <head>
        <Title>SK Webby App</Title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    </head>

    <body>
        <div id="timeline" class="bg-gray-900 min-h-screen">
            <?php include(__DIR__ . '/components/nav.php'); ?>

            <?php include(__DIR__ . '/templates/cover.php'); ?>

            <!-- profile content -->
            <div class="px-3 lg:px-0 max-w-5xl mx-auto mt-4">
                <div class="bg-white border border-gray-300 rounded-lg ">
                    <!-- About section -->
                    <div id="about-section" style="display: none">
                        <?php include './components/profile/bio-section.php' ?>
                    </div>

                    <!-- Followers section -->
                    <div id="followers-section" style="display: none">
                        <!-- Content of the Followers section -->
                        <h1>followers</h1>

                    </div>

                    <!-- Following section -->
                    <div id="following-section" style="display: none">
                        <!-- Content of the Following section -->
                        <h1>following</h1>

                    </div>

                    <!-- Photos section -->
                    <div id="photos-section" style="display: none">
                        <!-- Content of the Photos section -->
                        <?php include './components/profile/photos-section.php' ?>

                    </div>

                    <!-- Settings section -->
                    <div id="settings-section" style="display: none">
                        <!-- Content of the Settings section -->
                        <?php include './components/profile/setting.php' ?>

                    </div>

                </div>

            </div>
        </div>
    </body>
</body>

</html>

<script>
    $(document).ready(function() {
        function showSection(sectionId) {
            const sections = ['about-section', 'followers-section', 'following-section', 'photos-section', 'settings-section'];
            sections.forEach(section => {
                const element = document.getElementById(section);
                if (element) {
                    element.style.display = 'none';
                }
            });

            const selectedSection = document.getElementById(sectionId);
            if (selectedSection) {
                selectedSection.style.display = 'block';
            }
        }

        showSection('about-section');

        document.getElementById('about-link').addEventListener('click', function() {
            showSection('about-section');
        });

        document.getElementById('followers-link').addEventListener('click', function() {
            showSection('followers-section');
        });

        document.getElementById('following-link').addEventListener('click', function() {
            showSection('following-section');
        });

        document.getElementById('photos-link').addEventListener('click', function() {
            showSection('photos-section');
        });

        document.getElementById('settings-link').addEventListener('click', function() {
            showSection('settings-section');
        });
    });
</script>