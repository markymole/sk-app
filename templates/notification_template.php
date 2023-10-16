<?php


?>
<div class="w-72 h-96  bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-800 dark:divide-gray-700 overflow-y-scroll">

    <div class="bg-white block px-6 py-2 font-bold text-start text-gray-800 rounded-t-lg bg-gray-50 dark:bg-gray-800 dark:text-white">
        Notification
    </div>
    <div class="relative divide-y divide-gray-100 dark:divide-gray-700">
        <?php
        if (isset($notifications) && count($notifications) > 0) {
            foreach ($notifications as $notification) {
                $notif_post_id = $notification['post_id'];
                $notif_fro_id = $notification['notif_from'];
                $notif_from_gender = $notification['gender'];
                $notif_content = $notification['content'];
                $context = $notification['context'];

                $notif_name = $notification['first_name'] . ' ' . $notification['last_name'];
                $notif_created_at = $notification['created_at'];

                // $receiver_gender = $notifications['receiver_gender'];

                $notif_fro_img = $image->getUserProfileImage($receiver_id, $notif_from_gender);
                $notif_formmated_date =  $date->formatDate($notif_created_at);

                if ($context === "Post") {
                    $icon = '  <svg class="w-2 h-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">
                        <path d="M1 18h16a1 1 0 0 0 1-1v-6h-4.439a.99.99 0 0 0-.908.6 3.978 3.978 0 0 1-7.306 0 .99.99 0 0 0-.908-.6H0v6a1 1 0 0 0 1 1Z" />
                        <path d="M4.439 9a2.99 2.99 0 0 1 2.742 1.8 1.977 1.977 0 0 0 3.638 0A2.99 2.99 0 0 1 13.561 9H17.8L15.977.783A1 1 0 0 0 15 0H3a1 1 0 0 0-.977.783L.2 9h4.239Z" />
                    </svg>';
                    $backgroundColor = 'bg-green-600';
                    $redirect = "post.php?post_id=$notif_post_id";
                } elseif ($context === "Like Post") {
                    $icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-2 h-2 lg:w-2.5 lg:h-2.5 text-white">
                    <path d="M1 8.25a1.25 1.25 0 112.5 0v7.5a1.25 1.25 0 11-2.5 0v-7.5zM11 3V1.7c0-.268.14-.526.395-.607A2 2 0 0114 3c0 .995-.182 1.948-.514 2.826-.204.54.166 1.174.744 1.174h2.52c1.243 0 2.261 1.01 2.146 2.247a23.864 23.864 0 01-1.341 5.974C17.153 16.323 16.072 17 14.9 17h-3.192a3 3 0 01-1.341-.317l-2.734-1.366A3 3 0 006.292 15H5V8h.963c.685 0 1.258-.483 1.612-1.068a4.011 4.011 0 012.166-1.73c.432-.143.853-.386 1.011-.814.16-.432.248-.9.248-1.388z" />
                  </svg>';
                    $backgroundColor = 'bg-blue-600';
                    $redirect = "post.php?post_id=$notif_post_id";
                } elseif ($context === "Like Comment") {
                    $icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-2 h-2 lg:w-2.5 lg:h-2.5 text-white">
                    <path d="M1 8.25a1.25 1.25 0 112.5 0v7.5a1.25 1.25 0 11-2.5 0v-7.5zM11 3V1.7c0-.268.14-.526.395-.607A2 2 0 0114 3c0 .995-.182 1.948-.514 2.826-.204.54.166 1.174.744 1.174h2.52c1.243 0 2.261 1.01 2.146 2.247a23.864 23.864 0 01-1.341 5.974C17.153 16.323 16.072 17 14.9 17h-3.192a3 3 0 01-1.341-.317l-2.734-1.366A3 3 0 006.292 15H5V8h.963c.685 0 1.258-.483 1.612-1.068a4.011 4.011 0 012.166-1.73c.432-.143.853-.386 1.011-.814.16-.432.248-.9.248-1.388z" />
                  </svg>';
                    $backgroundColor = 'bg-blue-600';
                    $res = $comments->get_parent_post_of_comment($notif_post_id);
                    if ($res) {
                        $notif_post_id = $res;
                    }
                    $redirect = "post.php?post_id=$notif_post_id";
                } elseif ($context === "Comment") {
                    $icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-2 h-2 lg:w-2.5 lg:h-2.5 text-white">
                        <path d="M3.505 2.365A41.369 41.369 0 019 2c1.863 0 3.697.124 5.495.365 1.247.167 2.18 1.108 2.435 2.268a4.45 4.45 0 00-.577-.069 43.141 43.141 0 00-4.706 0C9.229 4.696 7.5 6.727 7.5 8.998v2.24c0 1.413.67 2.735 1.76 3.562l-2.98 2.98A.75.75 0 015 17.25v-3.443c-.501-.048-1-.106-1.495-.172C2.033 13.438 1 12.162 1 10.72V5.28c0-1.441 1.033-2.717 2.505-2.914z" />
                        <path d="M14 6c-.762 0-1.52.02-2.271.062C10.157 6.148 9 7.472 9 8.998v2.24c0 1.519 1.147 2.839 2.71 2.935.214.013.428.024.642.034.2.009.385.09.518.224l2.35 2.35a.75.75 0 001.28-.531v-2.07c1.453-.195 2.5-1.463 2.5-2.915V8.998c0-1.526-1.157-2.85-2.729-2.936A41.645 41.645 0 0014 6z" />
                    </svg>
                    ';
                    $backgroundColor = 'bg-yellow-400';
                    $res = $comments->get_parent_post_of_comment($notif_post_id);
                    if ($res) {
                        $notif_post_id = $res;
                    }
                    $redirect = "post.php?post_id=$notif_post_id";
                } elseif ($context === "Follow") {
                    $icon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-2 h-2 lg:w-2.5 lg:h-2.5 text-white">
                        <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.784 6.131-2.1.43-.333.604-.903.408-1.41a7.002 7.002 0 00-13.074.003z" />
                    </svg>
                    ';
                    $backgroundColor = 'bg-yellow-600';
                    $redirect = "profile.php?user_id=$notif_fro_id";
                } else {
                    // Default icon and background color
                    $icon = '<svg class="w-2 h-2 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 18">...</svg>';
                    $backgroundColor = 'bg-gray-600';
                    $redirect = "post.php?post_id=$notif_post_id";
                }
        ?>
            <?php
                echo <<<HTML
                <a href=$redirect class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700">
                    <div class="flex-shrink-0">
                        <img class="rounded-full w-11 h-11" src="$notif_fro_img" alt="Jese image">
                        <div class="absolute flex items-center justify-center w-5 h-5 ml-6 -mt-5 $backgroundColor border border-white rounded-full dark:border-gray-800">
                            $icon
                        </div>
                    </div>
                    <div class="w-full pl-3">
                        <div class="text-gray-500 text-sm mb-1.5 dark:text-gray-400"><span class="font-semibold text-gray-900 dark:text-white">$notif_name</span> $notif_content</div>
                        <div class="text-xs text-blue-600 dark:text-blue-500">$notif_formmated_date</div>
                    </div>
                </a>
HTML;
            }
        } else {
            ?>
        <?php
            echo <<<HTML
            <a class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700">
                <h5>No notification.</h5>
            </a>
HTML;
        }
        ?>

    </div>
</div>