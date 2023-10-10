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
    <div class="bg-gray-900 min-h-screen">
        <?php include(__DIR__ . '/components/profile_nav.php'); ?>

        <div class="container flex flex-col bg-white rounded-lg lg:flex-row mt-10 w-full lg:max-w-7xl mx-auto h-full">
            <div id="left-section" class="w-full lg:w-1/4 border-r">
                <div class=" rounded-t-lg text-gray-700 px-4 py-3.5 border-b">
                    <h3 class="font-semibold text-lg">Sk Webby App Chat</h3>
                </div>

                <div class="mt-4 px-3">
                    <label for="search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="search" id="message-search" class="block w-full px-4 py-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search" required>
                    </div>
                    <div id="message-search-results" class="mt-2">

                    </div>
                    <hr class="mt-4">
                </div>
                <div id="active-conversations" class="p-3">
                    <!-- <div id="conversation-item" class="flex items-center mb-4 cursor-pointer hover:bg-gray-100 p-2 rounded-md">
                        <div class="w-10 h-10 bg-gray-300 rounded-full mr-3">
                            <img src="https://placehold.co/200x/ffa8e4/ffffff.svg?text=ʕ•́ᴥ•̀ʔ&font=Lato" alt="User Avatar" class="w-10 h-10 rounded-full">
                        </div>
                        <div class="flex-1">
                            <h2 class="text-base font-semibold">Alice</h2>
                            <p class="text-sm text-gray-600">Hoorayy!!</p>
                        </div>
                    </div> -->
                </div>
            </div>

            <div id="right-section" class="w-full px-3 lg:px-0 lg:w-3/4">
                <div id="chat-container" class="py-2">
                    <div id="chat-messages" class="hidden">
                        <div id="user-info" class="p-4 flex gap-4 items-center border-b">
                            <img id="receiver_img" class="w-12 h-12 rounded-full"></img>
                            <div>
                                <p id="receiver_name" class="font-semibold text-gray-800"></p>
                                <span id="receiver_barangay" class="text-base text-gray-600"></span>
                            </div>
                        </div>
                        <div id="conversation">
                            <div class="w-full px-5 flex flex-col h-full justify-between">
                                <div id="messages" class="flex flex-col mt-5 overflow-y-scroll">

                                </div>
                            </div>
                        </div>
                        <div class="border-t py-4 px-4 gap-2 flex flew-row items-center">
                            <input id="message-input" class="w-full bg-gray-white py-1.5 px-3 rounded-lg border" type="text" placeholder="type your message here..." />
                            <button id="send-message-btn" class="inline-flex items-center justify-center px-6 py-1.5 mr-3 text-base text-center text-white rounded bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 dark:focus:ring-yellow-900">Send</button>
                        </div>
                    </div>
                    <div id="no-chats-message" class="px-4 text-center py-80" style="display: none;">No chats selected.</div>
                </div>
            </div>
        </div>
</body>

<style>
    /* Standard scrollbar styles for Firefox and Edge */
    #messages {
        scrollbar-width: thin;
        height: 50vh;
        padding: 0px 4px;
    }

    #messages::-webkit-scrollbar-corner {
        display: none;
        /* Hide scrollbar corner in WebKit browsers */
    }
</style>

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

            noChatsMessage.hide();
            chatContainer.show()

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

                    $('#messages').empty();

                    if (messages.length === 0) {
                        // If there are no messages, display a "No messages found" message
                        $('#messages').append('<div class="text-center text-gray-500 py-4">No messages found.</div>');
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
                                .addClass('conversation-item flex items-center mb-4 cursor-pointer hover:bg-gray-100 p-2 rounded-md')
                                .attr('data-receiver-id', user.receiver_id)

                            var userImage = $('<div>')
                                .addClass('w-10 h-10 bg-gray-300 rounded-full mr-3')
                                .html('<img src="' + user.image_src + '" alt="User Avatar" class="w-10 h-10 rounded-full">');

                            var userInfo = $('<div>').addClass('flex-1');
                            $('<h2>').addClass('text-base font-semibold').text(user.receiver_first_name + ' ' + user.receiver_last_name).appendTo(userInfo);
                            $('<p>').addClass('text-sm text-gray-600').text(user.last_message.message).appendTo(userInfo);

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
            var messageContainer = $('#messages');
            messageContainer.scrollTop(messageContainer[0].scrollHeight);
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
                        messageSearchResults.html("<p class='px-2 py-2 text-gray-700'>No users found.</p>");
                    } else {
                        results.forEach(function(result) {
                            // Create a list item for each result and append it to the container
                            var userContainer = $("<div>")
                                .addClass("users-item flex items-center px-4 py-2 text-gray-700 hover:bg-gray-100 active:bg-blue-100 cursor-pointer rounded-md")
                                .attr("data-receiver-id", result.id)
                                .attr("data-receiver-fname", result.first_name)
                                .attr("data-receiver-lname", result.last_name)
                                .attr("data-receiver-barangay", result.barangay)
                                .attr("data-receiver-image", result.image_src);

                            // Create an image element for the user's image
                            var userImage = $("<img>")
                                .addClass("w-8 h-8 rounded-full")
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