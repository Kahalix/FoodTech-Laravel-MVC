<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Employee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    @include('users_sidemenu')


    <div class="col d-flex flex-column h-sm-100">
        <main class="row overflow-auto">




            <div class="container mt-4">
                <h1>Edit Employee</h1>
                <form action="{{ route('admin.update', $employee) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name:</label>
                        <input type="text" id="first_name" name="first_name" value="{{ $employee->first_name }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name:</label>
                        <input type="text" id="last_name" name="last_name" value="{{ $employee->last_name }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" id="email" name="email" value="{{ $employee->email }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number:</label>
                        <input type="text" id="phone_number" name="phone_number" value="{{ $employee->phone_number }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="login" class="form-label">Login:</label>
                        <input type="text" id="login" name="login" value="{{ $employee->login }}" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" id="password" name="password" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>



</main>
@include('footer')

</div>
</div>
</div>

</body>
</html>
