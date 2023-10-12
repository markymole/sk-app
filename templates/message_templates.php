<?php
?>

<div class="w-72 h-96  bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-800 dark:divide-gray-700">
    <div class="bg-white block px-6 py-2 font-bold text-start text-gray-800 rounded-t-lg bg-gray-50 dark:bg-gray-800 dark:text-white">
        Messages
    </div>
    <div class="h-full bg-white flex flex-col justify-between rounded-b-lg shadow-lg">
        <div class="">
            <?php
            if (empty($messages)) {
                echo <<<HTML
        <div>
            <p>No messages yet</p>
            <a href="messages.php" class="w-full mt-4 inline-flex items-center justify-center px-6 py-1 mr-3 text-base text-center text-white rounded bg-yellow-400 border border-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 dark:focus:ring-yellow-900">Start a New Conversation</a>
        </div>
HTML;
            } else {
                foreach ($messages as $message) {
                    $receiver_id = $message['receiver_id'];
                    $receiver_first_name = $message['receiver_first_name'];
                    $receiver_last_name = $message['receiver_last_name'];
                    $receiver_gender = $message['receiver_gender'];
                    $last_message = $message['last_message']['message'];

                    $message_url = 'messages.php?id=' . $receiver_id;


                    $profile_image = $image->getUserProfileImage($receiver_id, $receiver_gender);

                    echo <<<HTML
                <a href="$message_url"> 
                    <div id="conversation-item" class="px-6 flex items-center cursor-pointer hover:bg-gray-100 p-1.5 rounded-md">
                        <div class="w-10 h-10 bg-gray-300 rounded-full mr-3">
                            <img src="$profile_image" alt="User Avatar" class="w-10 h-10 rounded-full">
                        </div>
                        <div class="flex-1">
                            <h2 class="text-base font-semibold">$receiver_first_name $receiver_last_name</h2>
                            <p class="text-sm text-gray-600">$last_message</p>
                        </div>
                    </div>
                </a>
               
HTML;
                }
            }

            ?>
        </div>
        <div class="text-center py-2 border-t text-gray-800">
            <a href="messages.php">All Messages</a>
        </div>
    </div>

</div>