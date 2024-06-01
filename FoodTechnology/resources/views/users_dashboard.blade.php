<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .profile-image {
            max-height: 150px;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

    @include('users_sidemenu')


    <div class="col d-flex flex-column h-sm-100">
        <main class="row overflow-auto">
            <div class="col pt-4">
            <div class="container">
        <h1>User Dashboard</h1>
        <div>
            <img src="{{ asset($user->employee_image) }}" alt="Profile Image" class="profile-image">
            <p>Login: {{ $user->login }}</p>
            <p>First Name: {{ $user->first_name }}</p>
            <p>Last Name: {{ $user->last_name }}</p>
            <p>Position: {{ $user->position }}</p>
            <p>Email: {{ $user->email }}</p>
            <p>Phone Number: {{ $user->phone_number }}</p>
            <a href="{{ route('user.edit') }}" class="btn btn-primary">Edit</a>
        </div>
    </div>
 </div>
        </main>
       @include('footer')

    </div>
</div>
</div>


</body>
</html>
