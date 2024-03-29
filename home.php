<?php

require_once './config/autoload.php';

$post = new Posts();
$user = new Users();
$image = new Images();
$date = new General();
$uploads = new Uploads();
$message = new Messages();
$notification = new Notifications();
$barangays = new Barangays;

$user_data = null;
if (isset($_SESSION['user_id'])) {
    $user_data = $user->check_login($_SESSION['user_id']);

    if ($user_data) {
        $id = $user_data['id'];
        $firstname = $user_data['first_name'];
        $lastname = $user_data['last_name'];
        $username = $user_data['username'];
        $barangay = $user_data['barangay'];
        $gender = $user_data['gender'];
        $role = $user_data['role'];
    } else {
        $id = $firstname = $lastname = $username = $barangay = $gender = $role = 'Unknown';
    }
} else {
    $id = $firstname = $lastname = $username = $gender = $role = 'Guest';
    $barangay = 'All';
}

$postsPerPage = 6;

$currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

if (!$user_data || $barangay == "Guest" ||  $barangay == "Unknown") {
    $posts = $post->get_all_posts_with_author_info();
} else {
    $posts = $post->get_posts_by_barangay($barangay);
    $barangayUsers = $user->getUsersByBarangay($barangay);
}

$barangay_list = $barangays->getAllBarangays();

?>


<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'create_post') {
            if (isset($_FILES['post_image']) && $_FILES['post_image']['error'] === UPLOAD_ERR_OK) {
                $image_src = $uploads->addPostImage($id);


                if ($post->create_post($_POST['post_content'], $image_src, $barangay, $_SESSION['user_id'])) {
                    $last_post_res = $post->get_last_post();
                    $lastPostID = "";

                    if ($last_post_res) {
                        $row = mysqli_fetch_assoc($last_post_res);
                        $lastPostID = $row['post_id'];
                        $lastPostContent = $row['post_content'];
                    }

                    $context = "Post";
                    $content = "Created a new post/announcement";

                    $barangay_users = $user->getBarangayUsers($barangay, $_SESSION['user_id']);

                    if ($barangay_users) {
                        foreach ($barangay_users as $user) {
                            $res = $notification->createNotification($context, $content, $lastPostID, $user['id'], $_SESSION['user_id']);
                        }
                        header("Location: home.php");
                        exit();
                    } else {
                        header("Location: home.php");
                        exit();
                    }
                } else {
                    echo "Error creating post.";
                }
            } else {
                if ($post->create_post($_POST['post_content'], '', $barangay, $_SESSION['user_id'])) {
                    $last_post_res = $post->get_last_post();
                    $lastPostID = "";

                    if ($last_post_res) {
                        $row = mysqli_fetch_assoc($last_post_res);
                        $lastPostID = $row['post_id'];
                        $lastPostContent = $row['post_content'];
                    }

                    $context = "Post";
                    $content = "Created a new post/announcement";

                    $barangay_users = $user->getBarangayUsers($barangay, $_SESSION['user_id']);

                    if ($barangay_users) {
                        foreach ($barangay_users as $user) {
                            $res = $notification->createNotification($context, $content, $lastPostID, $user['id'], $_SESSION['user_id']);
                        }
                        header("Location: home.php");
                        exit();
                    } else {
                        header("Location: home.php");
                        exit();
                    }
                } else {
                    echo "Error creating post.";
                }
            }
        } elseif ($action === 'edit_post') {
            if (isset($_POST['post_id'])) {
                $post_id = $_POST['post_id'];
                $post_content = $_POST['post_content_edit'];


                if (isset($_FILES['new_post_image']) && $_FILES['new_post_image']['error'] === UPLOAD_ERR_OK) {
                    $image_path = $uploads->updatePostImage($_SESSION['user_id'], $post_id);

                    if (!$image_path) {
                        echo "Error uploading file!";
                    }
                } else {
                    $image_path = $_POST['editImagePreviewContainer'];
                    if ($image_path !== '') {
                        $image_path = $image_path;
                    } else {
                        $removed = $uploads->removePostImage($post_id);
                        if ($removed) {
                            $image_path = '';
                        } else {
                            $image_path = '';
                        }
                    }
                }

                $result = $post->edit_post($post_id, $post_content, $image_path);

                if ($result) {
                    header("Location: home.php");
                    exit();
                } else {
                    echo "Error updating post!";
                }
            } else {
            }
        } else {
            // Handle invalid action or other cases
        }
    }
}

?>

<!DOCTYPE html>

<html lang="en" class="">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>

<body>
    <div class="sticky top-0 z-50">
        <?php include './components/navigation.php' ?>
    </div>

    <?php include './components/home-section.php' ?>

    <script src="https://unpkg.com/flowbite@1.4.7/dist/flowbite.js"></script>
</body>

</html>