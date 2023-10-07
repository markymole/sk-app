<?php

?>

<div class="w-60">
    <h1 class="mb-2 font-semibold">Messages</h1>
    <?php 
       if(empty($messages)){
        echo <<<HTML
        <div>
            <p>No messages yet</p>
            <a href="message.php" class="w-full mt-4 inline-flex items-center justify-center px-6 py-1 mr-3 text-base text-center text-white rounded bg-yellow-400 border border-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 dark:focus:ring-yellow-900">Start a New Conversation</a>
        </div>
HTML;
} else {
    echo <<<HTML
    <p>Yes messages yet</p>
HTML;
}
    
    ?>
</div>