<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User data deletion</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="max-w-4xl mx-auto p-8 bg-white shadow-md mt-10">
        <h1 class="text-3xl font-bold mb-6">User data deletion</h1>
        <form id="contactForm" class="space-y-6">
            <div>
                <label for="instagramID" class="block text-sm font-medium text-gray-700">Instagram ID</label>
                <input type="text" id="instagramID" name="instagramID" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md" placeholder="Enter your Instagram ID">
                <span id="instagramIDError" class="text-red-500 text-sm hidden">This field is required.</span>
            </div>
            <div>
                <label for="phoneNumber" class="block text-sm font-medium text-gray-700">Phone Number</label>
                <input type="text" id="phoneNumber" name="phoneNumber" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md" placeholder="Enter your phone number">
                <span id="phoneNumberError" class="text-red-500 text-sm hidden">Please enter a valid phone number.</span>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded-md">Submit</button>
        </form>
    </div>
    <script>
        $(document).ready(function () {
            $('#contactForm').on('submit', function (e) {
                e.preventDefault();

                let instagramID = $('#instagramID').val().trim();
                let phoneNumber = $('#phoneNumber').val().trim();
                let valid = true;

                if (instagramID === '') {
                    $('#instagramIDError').removeClass('hidden');
                    valid = false;
                } else {
                    $('#instagramIDError').addClass('hidden');
                }

                if (phoneNumber === '' || !/^\d{10}$/.test(phoneNumber)) {
                    $('#phoneNumberError').removeClass('hidden');
                    valid = false;
                } else {
                    $('#phoneNumberError').addClass('hidden');
                }

                if (valid) {
                    $.ajax({
                        type: 'POST',
                        url: 'submit_form.php',
                        data: {
                            instagramID: instagramID,
                            phoneNumber: phoneNumber
                        },
                        success: function (response) {
                            alert('Form submitted successfully.');
                            $('#contactForm')[0].reset();
                        },
                        error: function () {
                            alert('An error occurred. Please try again.');
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
