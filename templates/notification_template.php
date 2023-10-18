<?php


?>
<div class="w-72 h-96  bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-800 dark:divide-gray-700 overflow-y-scroll">

    <div class="bg-white block px-6 py-2 font-bold text-start text-gray-800 rounded-t-lg bg-gray-50 dark:bg-gray-800 dark:text-white">
        Notification
    </div>
    <div id="notifications-container" class="relative divide-y divide-gray-100 dark:divide-gray-700">


    </div>
</div>

<script>
    function loadNotifications() {
        $.ajax({
            type: 'GET',
            url: './controllers/get_notifications.php',
            success: function(response) {
                try {
                    response = JSON.parse(response);
                } catch (e) {
                    console.error('Error parsing JSON: ' + e);
                }

                if (response.notifications) {
                    $('#notifications-container').html(response.notifications);
                } else if (response.error) {
                    console.log('error');
                }
                setTimeout(loadNotifications, 1000);
            },
            error: function(xhr, status, error) {
                console.error('Error loading notifications: ' + error);

                setTimeout(loadNotifications, 1000);
            }
        });
    }

    // Initial call to load notifications
    loadNotifications();
</script>