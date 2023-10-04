<section class="min-h-screen bg-gray-900">
    <div class="py-8 lg:py-16 px-4 mx-auto max-w-screen-md">
        <h2 class="mb-4 text-2xl lg:text-4xl tracking-tight font-extrabold text-center text-white">Contact Us</h2>
        <div class="bg-yellow-400 h-0.5 lg:h-1 w-24 mb-4 mx-auto"></div>
        <p class="text-center mb-6 font-light lg:mb-8 md:text-lg lg:text-xl text-gray-300">Got a technical issue? Want to send feedback about a beta feature? Need details about our Business plan? Let us know.</p>
        <form id="contact-form" class="space-y-6 lg:space-y-8">
            <div id="response-message" class="text-white mt-4"></div>
            <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-300">Your email</label>
                <input type="email" id="email" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light" placeholder="name@flowbite.com" required>
            </div>
            <div>
                <label for="subject" class="block mb-2 text-sm font-medium text-gray-300">Subject</label>
                <input type="text" id="subject" class="block p-3 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 shadow-sm focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 dark:shadow-sm-light" placeholder="Let us know how we can help you" required>
            </div>
            <div class="sm:col-span-2">
                <label for="message" class="block mb-2 text-sm font-medium text-gray-400">Your message</label>
                <textarea id="message" rows="6" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg shadow-sm border border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Leave a comment..."></textarea>
            </div>
            <button type="submit" id="submit-button" class="inline-flex items-center justify-center px-4 py-2 mr-3 text-base font-medium text-center text-white rounded bg-yellow-400 hover:bg-yellow-500 focus:ring-4 focus:ring-yellow-300 dark:focus:ring-yellow-900">
                Send message
            </button>
        </form>
    </div>
</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $("#submit-button").click(function() {
            // Get form data
            var email = $("#email").val();
            var subject = $("#subject").val();
            var message = $("#message").val();

            if (email === '' || subject === '' || message === '') {
                $("#response-message").html("Please fill in all fields.").addClass("text-red-500");
            } else {
                $.ajax({
                    type: "POST",
                    url: "./controllers/send_email.php",
                    data: {
                        email: email,
                        subject: subject,
                        message: message
                    },
                    success: function(response) {
                        if (response === "success") {
                            $("#response-message").html("Message sent successfully!").addClass("text-green-500");
                        } else {
                            // Email sending failed
                            $("#response-message").html("Message could not be sent.").addClass("text-red-500");
                        }
                    },
                    error: function() {
                        $("#response-message").html("An error occurred. Please try again later.").addClass("text-red-500");
                    }
                });
            }
        });
    });
</script>