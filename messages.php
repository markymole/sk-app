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

<head>
    <Title>SK Webby App</Title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <div class="bg-gray-900 h-screen overflow-hidden flex flex-col">
        <?php include(__DIR__ . '/components/navigation.php'); ?>

        <div class="flex h-screen overflow-hidden w-full mx-auto">
            <!-- Sidebar -->
            <div class="fixed h-fit w-full lg:relative h-full lg:w-1/4 bg-white border-r border-gray-300">
                <!-- Sidebar Header -->
                <header class="p-4 border-b border-t flex justify-between items-center text-gray-700 px-5">
                    <h1 class="text-xl font-semibold">Messages</h1>
                </header>
                <div class="mt-4 px-5">
                    <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="search" id="message-search" class="block w-full px-4 py-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search" required>
                    </div>
                    <div id="message-search-results" class="">

                    </div>
                </div>
                <div id="active-conversations" class="py-4 px-6">

                </div>
            </div>

            <!-- Main Chat Area -->
            <div id="chat-messages" class="flex-1 relative">
                <!-- Chat Header -->

                <header id="user-info" class="bg-white border-t border-b p-4 text-gray-700 flex gap-4 items-center">
                    <div id="back-to-conversation" class="bg-white text-gray-600 rounded-lg cursor-pointer hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                        </svg>
                    </div>
                    <img id="receiver_img" class="w-10 h-10 lg:w-12 lg:h-12 rounded-full"></img>
                    <div>
                        <h1 id="receiver_name" class="text-sm font-semibold text-gray-800"></h1>
                        <p id="receiver_barangay" class="text-xs text-gray-600"></p>
                    </div>
                </header>

                <!-- Chat Messages -->
                <div id="conversation" class="bg-white h-screen overflow-y-auto p-4 pb-36">
                    <!-- Incoming Message -->
                    <div id="messages" class="flex flex-col mt-5 mb-20 lg:mb-24">

                    </div>
                </div>

                <!-- Chat Input -->
                <footer class="bg-white border-t border-gray-300 p-4 absolute bottom-0 w-full">
                    <div class="flex items-center">
                        <input id="message-input" class="w-full bg-gray-white py-1.5 px-3 rounded-lg border" type="text" placeholder="type your message here..." />
                        <button id="send-message-btn" class="inline-flex items-center justify-center px-6 py-1.5 mr-3 text-base text-center text-white rounded bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 dark:focus:ring-yellow-900">Send</button>
                    </div>
                </footer>
            </div>
        </div>
</body>

</html>
<style>
    #modal-create {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
    }

    #modal-content {
        position: absolute;
        min-height: 20vh;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
    }
</style>

<script>
    $(document).ready(function() {

        const chatMessages = $('#chat-messages');
        chatMessages.hide();

        const backToConversationButton = $('#back-to-conversation');
        backToConversationButton.hide();

        backToConversationButton.click(function() {
            // Hide the chat-messages div and the back button
            chatMessages.hide();
            backToConversationButton.hide();

            // Hide the chat-messages on mobile when going back to active conversation
            if ($(window).width() <= 768) {
                $('#active-conversations').show();
            }
        });

        var messages = [];
        updateMessageContainer(messages);
        loadConversationUsers();

        function getReceiverIdFromURL() {
            const params = new URLSearchParams(window.location.search);
            return params.get('id');
        }

        // Load conversation when the page is initially loaded
        const receiverIdFromURL = getReceiverIdFromURL();
        if (receiverIdFromURL) {
            loadConversationMessages(receiverIdFromURL);
            scrollMessagesToBottom();
        }

        function updateMessageContainer(messages) {
            var messageContainer = $('#chat-messages');
            var noChatsMessage = $('#no-chats-message');

            if (messages.length === 0) {
                messageContainer.hide();
                noChatsMessage.show();
            } else {
                noChatsMessage.hide();
                messageContainer.show();
            }
        }

        function loadConversationMessages(receiverId) {
            var chatContainer = $('#chat-messages');
            var noChatsMessage = $('#no-chats-message');

            loadConversationUsers();

            if ($(window).width() >= 768) {
                noChatsMessage.hide();
                chatContainer.show()
            }

            // noChatsMessage.hide();
            // chatContainer.show()

            // Load user information and conversation messages in parallel using Promise.all
            Promise.all([
                    loadUserInformation(receiverId),
                    loadMessages(receiverId),
                ])
                .then(function([userInfo, messages]) {
                    var userInfo = JSON.parse(userInfo);
                    var messages = JSON.parse(messages);

                    $('#receiver_img').attr('src', userInfo.image_src);
                    $('#receiver_name').text(userInfo.first_name + ' ' + userInfo.last_name);
                    $('#receiver_barangay').text(userInfo.barangay);

                    $('#mobile-receiver_img').attr('src', userInfo.image_src);
                    $('#mobile-receiver_name').text(userInfo.first_name + ' ' + userInfo.last_name);
                    $('#mobile-receiver_barangay').text(userInfo.barangay);

                    $('#messages').empty();
                    $('#mobile-messages').empty();


                    if (messages.length === 0) {
                        // If there are no messages, display a "No messages found" message
                        $('#messages').append('<div class="text-center text-gray-500 py-4">No messages found.</div>');
                        $('#mobile-messages').append('<div class="text-center text-gray-500 py-4">No messages found.</div>');
                    } else {
                        messages.forEach(function(message) {
                            var messageElement = $('<div>').addClass('flex justify-' + (message.isSender ? 'end' : 'start') + ' mb-4');
                            var messageTextElement = $('<div>')
                                .addClass('py-1.5 px-4 rounded-' + (message.isSender ? 'bl' : 'br') + '-3xl rounded-' + (message.isSender ? 'tl' : 'tr') + '-3xl rounded-' + (message.isSender ? 'tr' : 'tl') + '-xl')
                                .addClass(message.isSender ? 'bg-gray-400 text-white' : 'bg-gray-200 text-gray-800')
                                .text(message.message);

                            // Append the message text element to the message element
                            messageTextElement.appendTo(messageElement);

                            // Append the message element to the messages container
                            messageElement.appendTo($('#messages'));
                            messageElement.appendTo($('#mobile-messages'));

                        });
                    }
                })
                .catch(function(error) {
                    console.error('Error loading user information and messages:', error);
                });
        }

        function loadUserInformation(userId) {
            return new Promise(function(resolve, reject) {
                $.ajax({
                    type: 'GET',
                    url: './controllers/load_user_info.php',
                    data: {
                        userId: userId
                    },
                    success: function(userInfo) {
                        resolve(userInfo);
                    },
                    error: function(xhr, status, error) {
                        reject(error);
                    }
                });
            });
        }

        function loadMessages(receiverId) {
            return new Promise(function(resolve, reject) {
                $.ajax({
                    type: 'GET',
                    url: './controllers/fetch_messages.php',
                    data: {
                        receiverId: receiverId
                    },
                    success: function(messages) {
                        console.log('mmessage', messages);
                        resolve(messages);
                    },
                    error: function(xhr, status, error) {
                        reject(error);
                    }
                });
            });
        }

        function loadConversationUsers() {
            $.ajax({
                type: 'GET',
                url: './controllers/get_active_conversations.php',
                success: function(users) {
                    var activeConversations = $('#active-conversations');
                    activeConversations.empty();

                    var users = JSON.parse(users);

                    if (users.length === 0) {
                        activeConversations.append('<p class="text-gray-700">No active conversations.</p>');
                    } else {
                        users.forEach(function(user) {
                            var conversationItem = $('<div>')
                                .addClass('conversation-item flex items-center mb-2 cursor-pointer hover:bg-gray-100 p-2 rounded-md')
                                .attr('data-receiver-id', user.receiver_id)

                            var userImage = $('<div>')
                                .addClass('w-10 h-10 bg-gray-300 rounded-full mr-3')
                                .html('<img src="' + user.image_src + '" alt="User Avatar" class="w-10 h-10 rounded-full">');

                            var userInfo = $('<div>').addClass('flex-1');
                            $('<h2>').addClass('text-base font-semibold').text(user.receiver_first_name + ' ' + user.receiver_last_name).appendTo(userInfo);
                            $('<p>').addClass('text-sm text-gray-600').text(user.last_message.message + " • " + user.messageTime).appendTo(userInfo);
                            // $('<p>').addClass('text-sm text-gray-600').text().appendTo(userInfo);

                            userImage.appendTo(conversationItem);
                            userInfo.appendTo(conversationItem);

                            conversationItem.appendTo(activeConversations);
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading conversation users: ' + error);
                }
            });
        }

        const messagesContainer = document.getElementById('messages');
        messagesContainer.onmouseenter = () => {
            messagesContainer.classList.add("active");
        }
        messagesContainer.onmouseleave = () => {
            messagesContainer.classList.remove("active");
        }

        function scrollMessagesToBottom() {
            var messageContainer = $('#conversation');
            messageContainer.scrollTop(messageContainer[0].scrollHeight);
        }

        function formatTimeAgo(created_at) {
            const currentTime = new Date();
            const messageTime = new Date(created_at);
            const timeDifference = currentTime - messageTime;
            const seconds = Math.floor(timeDifference / 1000);
            const minutes = Math.floor(seconds / 60);
            const hours = Math.floor(minutes / 60);
            const days = Math.floor(hours / 24);

            if (days > 0) {
                return `${days}d`;
            } else if (hours > 0) {
                return `${hours}h `;
            } else if (minutes > 0) {
                return `${minutes}m `;
            } else {
                return 'Just now';
            }
        }

        $('#message-search-results').on('click', '.users-item', function() {
            var receiverId = $(this).data('receiver-id');
            var receiverBarangay = $(this).data('receiver-barangay');
            var receiverFname = $(this).data('receiver-fname');
            var receiverLname = $(this).data('receiver-lname');
            var receiverImage = $(this).data('receiver-image');

            var conversationUrl = 'messages.php?id=' + receiverId;

            window.history.pushState({
                receiver_id: receiverId
            }, receiverFname + ' ' + receiverLname, conversationUrl);

            $('#receiver_img').attr('src', receiverImage);
            $('#receiver_name').text(receiverFname + ' ' + receiverLname);
            $('#receiver_barangay').text(receiverBarangay);

            $('#message-search').val('');
            $('#active-conversations').show();
            $("#message-search-results").html("");

            chatMessages.show();
            if ($(window).width() <= 768) {
                backToConversationButton.show();
            }

            console.log('conversation id:', receiverId);
            loadConversationMessages(receiverId);
        });

        $('#active-conversations').on('click', '.conversation-item', function() {
            var receiverId = $(this).data('receiver-id');
            var receiverBarangay = $(this).data('receiver-barangay');
            var receiverFname = $(this).data('receiver-fname');
            var receiverLname = $(this).data('receiver-lname');
            var receiverImage = $(this).data('receiver-image')

            var conversationUrl = 'messages.php?id=' + receiverId;

            window.history.pushState({
                receiver_id: receiverId
            }, receiverFname + ' ' + receiverLname, conversationUrl);

            $('#receiver_img').attr('src', receiverImage);
            $('#receiver_name').text(receiverFname + ' ' + receiverLname);
            $('#receiver_barangay').text(receiverBarangay);

            chatMessages.show();
            if ($(window).width() <= 768) {
                backToConversationButton.show();
            }



            console.log('conversation id:', receiverId);
            loadConversationMessages(receiverId);

            // $('#message-search-results').hide();
        });

        setInterval(function() {
            const receiverIdFromURL = getReceiverIdFromURL();
            if (receiverIdFromURL) {
                loadConversationMessages(receiverIdFromURL);
            }

            if (!messagesContainer.classList.contains("active")) {
                scrollMessagesToBottom();
            }
        }, 1000);

        $('#message-input').on('keyup', function(event) {
            // Check if the Enter key (key code 13) is pressed
            if (event.keyCode === 13) {
                // Prevent the default Enter key behavior (e.g., line break)
                event.preventDefault();

                // Trigger the click event of the Send button
                $('#send-message-btn').click();
            }
        });

        $('#send-message-btn').click(function() {
            const receiverIdFromURL = getReceiverIdFromURL();
            if (receiverIdFromURL) {
                loadConversationMessages(receiverIdFromURL);
            }
            var messageInput = $('#message-input');
            var messageText = messageInput.val().trim();

            if (messageText === "") {
                // Handle empty message, e.g., show an error message to the user.
                return;
            }

            $.ajax({
                type: 'POST',
                url: './controllers/send_message.php',
                data: {
                    receiverId: receiverIdFromURL,
                    message: messageText
                },
                success: function(response) {
                    messageInput.val('');

                    var messageElement = $('<div>').addClass('flex justify-end mb-4');
                    var messageTextElement = $('<div>')
                        .addClass('py-1.5 px-4 bg-gray-400 rounded-bl-3xl rounded-tl-3xl rounded-tr-xl text-white')
                        .text(messageText);

                    messageTextElement.appendTo(messageElement);

                    messageElement.appendTo($('#messages'));
                    scrollMessagesToBottom();
                },
                error: function(xhr, status, error) {
                    console.error('Error sending message: ' + error);
                }
            });
        });

        $("#message-search").on("input", function() {
            var message_search = $(this).val();
            if (message_search === "") {
                $('#active-conversations').show();
                $("#message-search-results").html("");
                return;
            } else {
                $('#active-conversations').hide();
            }
            $.ajax({
                // replace with any php file to handle the retrieval of post data
                url: "search.php",
                method: "POST",
                // pass the value, use the set value ex: query to retrieve in the $_POST() search.php
                data: {
                    message_search: message_search
                },
                success: function(data) {
                    // replace this 
                    var messageSearchResults = $("#message-search-results");

                    messageSearchResults.html("");

                    var results = JSON.parse(data);

                    if (results.length === 0) {
                        messageSearchResults.html("<p class='px-4 py-6 text-gray-700'>No users found.</p>");
                    } else {
                        results.forEach(function(result) {
                            // Create a list item for each result and append it to the container
                            var userContainer = $("<div>")
                                .addClass("users-item flex items-center px-2 mt-4 py-2 text-gray-700 hover:bg-gray-100 active:bg-blue-100 cursor-pointer rounded-md")
                                .attr("data-receiver-id", result.id)
                                .attr("data-receiver-fname", result.first_name)
                                .attr("data-receiver-lname", result.last_name)
                                .attr("data-receiver-barangay", result.barangay)
                                .attr("data-receiver-image", result.image_src);

                            // Create an image element for the user's image
                            var userImage = $("<img>")
                                .addClass("w-10 h-10 rounded-full")
                                .attr("src", result.image_src) // Set the image source
                                .attr("alt", "User Avatar"); // Provide alt text for accessibility

                            // Create a span for the user's name
                            var userName = $("<span>")
                                .addClass("text-base font-semibold ml-3")
                                .text(result.first_name + " " + result.last_name); // You can adjust the text as needed

                            // Append the image and name to the user container
                            userImage.appendTo(userContainer);
                            userName.appendTo(userContainer);

                            // Append the user container to the search results container
                            userContainer.appendTo(messageSearchResults);
                        });

                    }


                }
            });
        });
    });
</script>