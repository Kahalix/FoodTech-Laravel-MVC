<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Information</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .profile-image {
            max-height: 150px;
        }
        .error {
            color: red;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    @include('users_sidemenu')


    <div class="col d-flex flex-column h-sm-100">
        <div class="container">
            <h1 class="mb-4">Edit User Information</h1>
            <form action="{{ route('user.update') }}" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name:</label>
                    <input type="text" name="first_name" id="first_name" class="form-control" value="{{ $user->first_name }}" required>
                </div>

                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name:</label>
                    <input type="text" name="last_name" id="last_name" class="form-control" value="{{ $user->last_name }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
                </div>

                <div class="mb-3">
                    <label for="phone_number" class="form-label">Phone Number:</label>
                    <input type="text" name="phone_number" id="phone_number" class="form-control" value="{{ $user->phone_number }}" required>
                </div>

                <div class="mb-3">
                    <label for="login" class="form-label">Login:</label>
                    <input type="text" name="login" id="login" class="form-control" value="{{ $user->login }}" required>
                </div>

                <div id="password_fields" style="display: none;">
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" name="password" id="password" class="form-control" minlength="8">
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password:</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                    </div>
                </div>

                <button type="button" class="btn btn-secondary mb-3" onclick="togglePasswordFields()">Change Password</button>

                <div class="mb-3">
                    <label for="employee_image" class="form-label">Profile Image:</label>
                    <input type="file" name="employee_image" id="employee_image" class="form-control" onchange="readURL(this);">
                    <img id="image_preview" class="profile-image mt-2" src="{{ asset($user->employee_image) }}" alt="Image Preview">
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>


       @include('footer')

    </div>
</div>
</div>



        <script>
            function togglePasswordFields() {
        var passwordFields = document.getElementById('password_fields');
        if (passwordFields.style.display === "none") {
            passwordFields.style.display = "block";
        } else {
            passwordFields.style.display = "none";
        }
    }
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        document.getElementById('image_preview').src = e.target.result;
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function validateForm() {
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('password_confirmation').value;
                if (password !== confirmPassword) {
                    alert('Passwords do not match');
                    return false;
                }
                return true;
            }

            document.getElementById('employee_image').addEventListener('change', function () {
                readURL(this);
            });
        </script>
</body>
</html>
