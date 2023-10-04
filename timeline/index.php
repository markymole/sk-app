<?php

require_once '../config/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data

    $post = new Posts();

    $content = $_POST['post_content'];
    $image_src = $_POST['post_image'];
    $post_type = $_POST['post_type'];
    $author = $_POST['post_author'];

    // Call the create_post function
    if ($post->create_post($content, $image_src, $post_type, $author)) {
        echo "Post created successfully!";
    } else {
        echo "Error creating post.";
    }
}

?>

<html>

<head>
    <title>Church Event</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">

</head>

<body>
    <div class="">
        <!-- component -->
        <div class="heading text-center font-bold text-2xl m-5 text-gray-800">New Post</div>
        <form action="" method="post" class="editor mx-auto w-10/12 flex flex-col text-gray-800 border border-gray-300 p-4 shadow-lg max-w-2xl">
            <!-- <input class="title bg-gray-100 border border-gray-300 p-2 mb-4 outline-none" spellcheck="false" placeholder="Title" type="text"> -->
            <input class="hidden" type="text" name="post_author" value="1">
            <select id="PostType" name="post_type" class="bg-gray-50 border border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                <option selected>Title</option>
                <option value="Announcement">Announcement</option>
                <option value="Event">Event</option>
                <option value="Post">Post</option>
                <option value="Profile">Profile</option>
            </select>
            <textarea type="text" name="post_content" class="description bg-gray-100 sec mt-4 p-3 h-60 border border-gray-300 outline-none" spellcheck="false" placeholder="Describe everything about this post here"></textarea>

            <!-- icons -->
            <div class="icons flex text-gray-500 m-2">
                <svg class="mr-2 cursor-pointer hover:text-gray-700 border rounded-full p-1 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                </svg>
                <input type="file" name="post_image" class="hidden">
                <div class="count ml-auto text-gray-400 text-xs font-semibold">0/300</div>
            </div>
            <!-- buttons -->
            <div class="buttons flex">
                <div class="btn border border-gray-300 p-1 px-4 font-semibold cursor-pointer text-gray-500 ml-auto">Cancel</div>
                <button type="submit" class="btn border border-indigo-500 p-1 px-4 font-semibold cursor-pointer text-gray-200 ml-2 bg-indigo-500">Post</button>
            </div>
        </form>

    </div>
</body>

</html>