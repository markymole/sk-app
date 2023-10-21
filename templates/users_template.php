<?php


function renderUsers(&$users)
{

    require_once './config/autoload.php';

    $image = new Images();

    echo <<<HTML
  <div class="max-w-2xl mx-auto">
                <div class="">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold leading-none text-gray-900 dark:text-white">SK Members</h3>
                    </div>
                    <div class="flow-root">
                        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
HTML;

    if (!empty($users)) {
        foreach ($users as $user) {
            $user_id = $user['id'];
            $first_name = $user['first_name'];
            $last_name = $user['last_name'];
            $role = $user['role'];
            $gender = $user['gender'];
            $image_src = $image->getUserProfileImage($user_id, $gender);


            echo <<<HTML
            <li class="py-3 sm:py-4">
                <a href="profile.php?user_id=$user_id">
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <img class="w-14 h-14 rounded-full object-cover" src="$image_src" alt="Neil image">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-base font-medium text-gray-900 truncate dark:text-white">
                                $first_name $last_name
                            </p>
                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                $role
                            </p>
                        </div>
                    </div>
                </a>
            </li>
HTML;
        }
    } else {
        echo <<<HTML
     <div class="">
        <h5>No users found</h5>
HTML;
    }
    echo <<<HTML
    </ul>
       </div>
   </div>
</div>
HTML;
}
