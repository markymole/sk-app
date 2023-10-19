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
                setTimeout(loadNotifications, 3000);
            },
            error: function(xhr, status, error) {
                console.error('Error loading notifications: ' + error);

                setTimeout(loadNotifications, 3000);
            }
        });
    }

    $(document).on('click', 'a[data-notification-id]', function(e) {
        e.preventDefault();

        var notificationId = $(this).data('notification-id');
        var redirectURL = $(this).attr('href'); // Store the URL first

        markNotificationAsSeen(notificationId, function() {
            window.location.href = redirectURL;
        });
    });


    function markNotificationAsSeen(notificationId, callback) {
        // console.log(notificationId);
        $.ajax({
            type: 'POST',
            url: './controllers/mark_notification_as_seen.php',
            data: {
                notificationId: notificationId
            },
            success: function(response) {
                if (callback && typeof callback === 'function') {
                    callback();
                }
            },
            error: function(xhr, status, error) {
                console.error('Error marking notification as seen: ' + error);
            }
        });
    }

    // Initial call to load notifications
    loadNotifications();
</script>