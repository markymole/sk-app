<?php
require_once './config/autoload.php';

$image_src = '';
$message = new Messages();
$comments = new Comments();
$notification = new Notifications();
$date = new General();

if ($user_data) {
    if (isset($_SESSION['user_id'])) {
        $image_src = $image->getUserProfileImage($_SESSION['user_id'], $gender);
        $messages = $message->getUsersWithLastMessage($_SESSION['user_id']);
        $notifications = $notification->getUserNotification($_SESSION['user_id']);
    }
}
?>
<header>
    <nav class="bg-white border-gray-200 relative lg:px-6 dark:bg-gray-900">
        <div class="w-full flex flex-wrap items-center justify-between mx-auto p-4">
            <div class="flex items-center lg:gap-4  xl:gap-16">
                <a href="home.php" class="flex items-center">
                    <img src="./assets/logo/logo-v1.png" class="mr-3 object-cover h-10 w-28 lg:h-16 lg:w-52 " alt="SK Webby App Logo" />
                </a>
                <div class="hidden justify-between items-center w-full lg:flex lg:w-auto lg:order-1 mt-2">
                    <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-2 2xl:space-x-8 lg:gap-4 lg:mt-0">
                        <li>
                            <a href="index.php" class="block py-2 pr-4 pl-3 mt-2 lg:mt-0 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-yellow-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700" aria-current="page">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="./about.php" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-yellow-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">
                                About Us
                            </a>
                        </li>
                        <li>
                            <a href="how-it-works.php" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-yellow-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">
                                How it works
                            </a>
                        </li>
                        <li>
                            <a href="contact.php" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-yellow-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>


            <!-- only visible to mobile -->
            <div class="flex">
                <?php
                if ($user_data) {
                    echo <<<HTML
                    <button id="search-button" type="button" aria-controls="navbar-search" aria-expanded="false" class="lg:hidden text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 mr-1">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                        <span class="sr-only">Search</span>
                    </button>
                    <a href="messages.php" type="button" class="block mt-2 lg:hidden relative rounded-full bg-transparent text-gray-500 hover:text-black focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                        <span class="absolute -inset-1.5"></span>
                        <span class="sr-only">View messages</span>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z" />
                            <path d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z" />
                        </svg>

                    </a>
                    <a href="notifications.php" class="block lg:hidden ml-2 inline-flex items-center text-sm font-medium text-center text-gray-500 hover:text-gray-900 focus:outline-none dark:hover:text-white dark:text-gray-400" type="button">
                        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 14 20">
                            <path d="M12.133 10.632v-1.8A5.406 5.406 0 0 0 7.979 3.57.946.946 0 0 0 8 3.464V1.1a1 1 0 0 0-2 0v2.364a.946.946 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C1.867 13.018 0 13.614 0 14.807 0 15.4 0 16 .538 16h12.924C14 16 14 15.4 14 14.807c0-1.193-1.867-1.789-1.867-4.175ZM3.823 17a3.453 3.453 0 0 0 6.354 0H3.823Z" />
                        </svg>
                        <div id="mobile-notification-icon" class="relative flex">     </div>
                    </a>
                    <div class="relative hidden md:block">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                            <span class="sr-only">Search icon</span>
                        </div>
                        <input type="text" id="search-navbar" class="block w-full p-2 pl-10 px-20 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search...">
                        <div id="results" class="block w-full absolute z-50 bg-white rounded-lg border-2 " style="display: none;"></div>
                    </div>
                HTML;
                } ?>

                <button id="menu-button" data-collapse-toggle="navbar-search" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg lg:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-search" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                    </svg>
                </button>

                <div>
                    <?php
                    if (!$user_data) {
                        echo <<<HTML
                <div class="flex items-center lg:order-2">
                    <a href="login.php" class="hidden lg:flex text-gray-800 dark:text-white hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">Log in</a>
                    <a href="register.php" class="hidden lg:flex text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-yellow-600 dark:hover:bg-yellow-700 focus:outline-none dark:focus:ring-yellow-800">Register</a>
                </div>
HTML;
                    } else {
                        echo <<<HTML
                <div class="hidden lg:flex items-center lg:order-2">
                    <div class="flex md:order-2 ">
                        <div class="inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                            <div class="relative">
                                <a href="messages.php" type="button" class="flex lg:hidden mr-2 relative rounded-full bg-transparent p-1 text-gray-500 hover:text-black focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                                    <span class="absolute -inset-1.5"></span>
                                    <span class="sr-only">View messages</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                        <path d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z" />
                                        <path d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z" />
                                    </svg>

                                </a>
                                <button id="message-button" type="button" class="hidden lg:flex mr-2 relative rounded-full bg-transparent p-1 text-gray-500 hover:text-black focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
                                    <span class="absolute -inset-1.5"></span>
                                    <span class="sr-only">View messages</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                        <path d="M1.5 8.67v8.58a3 3 0 003 3h15a3 3 0 003-3V8.67l-8.928 5.493a3 3 0 01-3.144 0L1.5 8.67z" />
                                        <path d="M22.5 6.908V6.75a3 3 0 00-3-3h-15a3 3 0 00-3 3v.158l9.714 5.978a1.5 1.5 0 001.572 0L22.5 6.908z" />
                                    </svg>

                                </button>
HTML; ?>
                        <div id="message-container" class="hidden right-0 absolute z-50">
                            <?php include './templates/message_templates.php' ?>
                        </div>
                        <?php
                        echo <<<HTML
                            </div>
                            <div class="relative">
                                <a href="notifications.php"  class="block lg:hidden inline-flex items-center text-sm font-medium text-center text-gray-500 hover:text-gray-900 focus:outline-none dark:hover:text-white dark:text-gray-400" type="button">
                                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 14 20">
                                        <path d="M12.133 10.632v-1.8A5.406 5.406 0 0 0 7.979 3.57.946.946 0 0 0 8 3.464V1.1a1 1 0 0 0-2 0v2.364a.946.946 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C1.867 13.018 0 13.614 0 14.807 0 15.4 0 16 .538 16h12.924C14 16 14 15.4 14 14.807c0-1.193-1.867-1.789-1.867-4.175ZM3.823 17a3.453 3.453 0 0 0 6.354 0H3.823Z" />
                                    </svg>
                                  
                                </a>
                                <button id="dropdownNotificationButton" class="hidden lg:inline-flex inline-flex items-center text-sm font-medium text-center text-gray-500 hover:text-gray-900 focus:outline-none dark:hover:text-white dark:text-gray-400" type="button">
                                    <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 14 20">
                                        <path d="M12.133 10.632v-1.8A5.406 5.406 0 0 0 7.979 3.57.946.946 0 0 0 8 3.464V1.1a1 1 0 0 0-2 0v2.364a.946.946 0 0 0 .021.106 5.406 5.406 0 0 0-4.154 5.262v1.8C1.867 13.018 0 13.614 0 14.807 0 15.4 0 16 .538 16h12.924C14 16 14 15.4 14 14.807c0-1.193-1.867-1.789-1.867-4.175ZM3.823 17a3.453 3.453 0 0 0 6.354 0H3.823Z" />
                                    </svg>
                                    <div id="notification-icon" class="relative flex">
                                        <!-- <div class="relative inline-flex w-3 h-3 bg-red-500 border-2 border-white rounded-full -top-2 right-3 dark:border-gray-900"></div> -->
                                    </div>
                                </button>
                    
                                <div class="absolute right-0 z-50" id="">
                                    <div id="dropdownNotification" class="z-20 hidden w-full max-w-sm bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-800 dark:divide-gray-700">
HTML;       ?>
                        <?php include './templates/notification_template.php' ?>
                    <?php
                        echo <<<HTML
                                    </div>
                                </div>

                            </div>
                         
                            <div class="relative">
                                <div class="hidden lg:flex ml-3">
                                    <button id="profile" type="button" class="relative flex rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                        <span class="absolute -inset-1.5"></span>
                                        <span class="sr-only">Open user menu</span>
                                        <img class="h-9 w-9 rounded-full object-cover" src="$image_src" alt="">
                                    </button>
                                </div>
                                <div id="profile-menu" class="hidden absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                                    <a href="./profile.php" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a>
                                    <a href="logout.php" class="block px-4 py-2 text-sm text-gray-700" role="menuitem" tabindex="-1" id="user-menu-item-2">Sign out</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
HTML;
                    } ?>
                </div>
            </div>



        </div>
        <!-- mobile nav -->
        <div class="hidden w-full absolute w-full z-50 left-0 top-16 border-t bg-white pb-6 px-4" id="mobile-menu">
            <div class="">
                <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:gap-4 lg:mt-0">
                    <?php
                    if ($user_data) {
                        echo <<<HTML
                    <li class="block lg:hidden">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>

                                <span class="sr-only">Search icon</span>
                            </div>
                            <input type="text" id="search-navbar-mobile" class="block w-full px-4 py-2 pl-10  text-sm  text-gray-900 border border-gray-200 rounded-lg bg-gray-100 focus:ring-yellow-500 focus:border-yellow-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search...">
                            <div id="results-mobile" class="block w-full absolute z-50 bg-white rounded-lg border-2 shadow-xl" style="display: none;"></div>
                        </div>
                    </li>
HTML;
                    }
                    ?>
                    <li>
                        <a href="index.php" class="block py-2 pr-4 pl-3 mt-2 lg:mt-0 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-yellow-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700" aria-current="page">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="./about.php" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-yellow-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">
                            About Us
                        </a>
                    </li>
                    <li>
                        <a href="how-it-works.php" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-yellow-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">
                            How it works
                        </a>
                    </li>
                    <li>
                        <a href="contact.php" class="block py-2 pr-4 pl-3 text-gray-700 border-b border-gray-100 hover:bg-gray-50 lg:hover:bg-transparent lg:border-0 lg:hover:text-yellow-700 lg:p-0 dark:text-gray-400 lg:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white lg:dark:hover:bg-transparent dark:border-gray-700">Contact</a>
                    </li>
                    <li>
                        <?php
                        if (!$user_data) {
                            echo <<<HTML
                                    <div class="space-y-4 mt-6">
                                        <a href="login.php" class="flex lg:hidden border border-gray-500 text-gray-800 dark:text-white hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">Log in</a>
                                        <a href="register.php" class="flex lg:hidden text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-yellow-600 dark:hover:bg-yellow-700 focus:outline-none dark:focus:ring-yellow-800">Register</a>
                                    </div>
    HTML;
                        } else {
                            echo <<<HTML
                            <div class="space-y-4 mt-6">
                            <a href="profile.php" class="flex lg:hidden border border-gray-500 text-gray-800 dark:text-white hover:bg-gray-50 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:hover:bg-gray-700 focus:outline-none dark:focus:ring-gray-800">Profile</a>
                            <a href="logout.php" class="flex lg:hidden text-white bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 dark:bg-yellow-600 dark:hover:bg-yellow-700 focus:outline-none dark:focus:ring-yellow-800">Log out</a>
                        </div>
    HTML;
                        }
                        ?>

                    </li>
                </ul>
            </div>

        </div>
    </nav>
</header>

<script>
    $(document).ready(function() {
        $('#menu-button').click(function() {
            $('#mobile-menu').toggle();
        })

        $('#search-button').click(function() {
            $('#mobile-menu').show();
        })

        $('#profile').click(function() {
            $('#profile-menu').toggle();
        });

        $('#message-button').click(function() {
            $('#message-container').toggle();
        });

        $("#dropdownNotificationButton").click(function() {
            $('#dropdownNotification').toggle();
        })

        $(document).on('click', function(event) {
            if (!$(event.target).closest('#profile').length && !$(event.target).closest('#profile-menu').length) {
                $('#profile-menu').hide();
            }
        });

        $(document).on('click', function(event) {
            if (!$(event.target).closest('#message-button').length && !$(event.target).closest('#message-container').length) {
                $('#message-container').hide();
            }
        });

        $(document).on('click', function(event) {
            if (!$(event.target).closest('#dropdownNotificationButton').length && !$(event.target).closest('#dropdownNotification').length) {
                $('#dropdownNotification').hide();
            }
        });

        $("#search-navbar").on("input", function() {
            var query = $(this).val();
            var resultsContainer = $("#results");

            if (query === "") {
                resultsContainer.hide();
                resultsContainer.html("");
                return;
            }

            $.ajax({
                url: "search.php",
                method: "POST",
                data: {
                    query: query
                },
                success: function(data) {
                    var results = JSON.parse(data);
                    var resultList = '<ul class="list-style-type: none">';

                    if (results.length === 0) {
                        resultList += '<li class="w-full text-sm text-gray-700 p-2 bg-white">No results found</li>';
                    } else {
                        results.forEach(function(result) {
                            var userImage = '<img src="' + result.image_src + '" alt="User Image" class="w-8 h-8 rounded-full mr-2 object-cover">';
                            // Create a link to the user's profile with userContainer
                            var userContainer = '<a href="profile.php?user_id=' + result.id + '" class="w-full text-sm text-gray-700 p-2 bg-white hover:bg-gray-100 transition duration-200 flex items-center">' + userImage + result.first_name + ' ' + result.last_name + '</a>';
                            resultList += '<li>' + userContainer + '</li>';
                        });
                    }

                    resultList += '</ul>';
                    resultsContainer.html(resultList);
                    resultsContainer.show();
                }
            });
        });

        $("#search-navbar-mobile").on("input", function() {
            var query = $(this).val();
            var resultsContainer = $("#results-mobile");

            if (query === "") {
                resultsContainer.hide();
                resultsContainer.html("");
                return;
            }

            $.ajax({
                url: "search.php",
                method: "POST",
                data: {
                    query: query
                },
                success: function(data) {
                    var results = JSON.parse(data);
                    var resultList = '<ul class="list-style-type: none">';

                    if (results.length === 0) {
                        resultList += '<li class="w-full text-sm font-semibold text-gray-700 p-2 bg-white">No results found</li>';
                    } else {
                        results.forEach(function(result) {
                            var userImage = '<img src="' + result.image_src + '" alt="User Image" class="w-8 h-8 rounded-full mr-2 object-cover">';
                            // Create a link to the user's profile with userContainer
                            var userContainer = '<a href="profile.php?user_id=' + result.id + '" class="w-full text-sm font-semibold  text-gray-700 p-2 bg-white hover:bg-gray-100 transition duration-200 flex items-center">' + userImage + result.first_name + ' ' + result.last_name + '</a>';
                            resultList += '<li>' + userContainer + '</li>';
                        });
                    }
                    resultList += '</ul>';
                    resultsContainer.html(resultList);
                    resultsContainer.show();
                }
            });
        });

        function checkNotifications() {
            $.ajax({
                url: './controllers/get_notif.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var count_new = data.count;

                    if (count_new > 0) {
                        $('#notification-icon').html('<div class="relative inline-flex w-3 h-3 bg-red-500 border-2 border-white rounded-full -top-2 right-3 dark:border-gray-900"></div>');
                        $('#mobile-notification-icon').html('<div class="relative inline-flex w-3 h-3 bg-red-500 border-2 border-white rounded-full -top-2 right-3 dark:border-gray-900"></div>');

                    } else {
                        $('#notification-icon').html('');
                        $('#mobile-notification-icon').html('');

                    }
                }
            });
        }

        setInterval(checkNotifications, 2000);
    })
</script>