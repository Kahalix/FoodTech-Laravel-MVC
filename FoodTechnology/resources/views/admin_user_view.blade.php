<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    @include('users_sidemenu')



<div class="col d-flex flex-column h-sm-100">




       <div class="row overflow-auto">
    <div class="container mt-4">
        <h1>Employee Details</h1>
        <div class="row">
            <div class="col-md-6">
                <p class="mb-0"><strong>Employee ID:</strong> {{ $employee->id_employee }}</p>
                <p class="mb-0"><strong>First Name:</strong> {{ $employee->first_name }}</p>
                <p class="mb-0"><strong>Last Name:</strong> {{ $employee->last_name }}</p>
                <p class="mb-0"><strong>Email:</strong> {{ $employee->email }}</p>
                <p class="mb-0"><strong>Phone Number:</strong> {{ $employee->phone_number }}</p>
                <p class="mb-0"><strong>Login:</strong> {{ $employee->login }}</p>
                <p class="mb-0"><strong>Status:</strong> {{ $employee->status }}</p>
                <p class="mb-0"><strong>Position:</strong> {{ $employee->position }}</p>
                <p class="mb-0"><strong>Employee Image:</strong></p>
                <img src="{{ asset($employee->employee_image) }}" class="img-fluid mb-3" style="max-height: 200px;" alt="Employee Image">
                <h2></h2>
                <a href="{{ route('admin.edit', $employee) }}" class="btn btn-primary mb-2">Edit</a>
                @if ($employee->position === 'food_technologist')

                <button id="showAssignManagerForm" class="btn btn-primary mb-2">Assign Manager</button>
                <form id="assignManagerForm" action="{{ route('admin.assignManager', $employee) }}" method="post" style="display: none;">
                    @csrf
                    <label for="manager_id" class="form-label">Select Manager:</label>
                    <select name="manager_id" id="manager_id" class="form-select mb-2">
                        @foreach($managers as $manager)
                            <option value="{{ $manager->id_manager }}">{{ $manager->employee->first_name }} {{ $manager->employee->last_name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary">Assign to Manager</button>
                </form>
                @endif
            </div>
            @if ($employee->position === 'food_technologist')
            <div class="col-md-6">
                <h2>Manager Information:</h2>
                @if ($employee->food_technologists)
                    @if ($employee->food_technologists->manager)
                        <p class="mb-0"><strong>Manager employee ID:</strong> {{ $employee->food_technologists->manager->id_employee }}</p>
                        <p class="mb-0"><strong>First Name:</strong> {{ $employee->food_technologists->manager->employee->first_name }}</p>
                        <p class="mb-0"><strong>Last Name:</strong> {{ $employee->food_technologists->manager->employee->last_name }}</p>
                        <p class="mb-0"><strong>Email:</strong> {{ $employee->food_technologists->manager->employee->email }}</p>
                        <p class="mb-0"><strong>Manager Image:</strong></p>
                        <img src="{{ asset($employee->food_technologists->manager->employee->employee_image) }}" class="img-fluid mb-3" style="max-height: 200px;" alt="Employee Image">
                    @else
                        <p>No manager assigned.</p>
                    @endif
                @else
                    <p>No manager assigned.</p>
                @endif
            </div>
            @endif
        </div>
        <form action="{{ route('admin.assignPosition', $employee) }}" method="post" class="mb-2">
            @csrf
            <label for="position" class="form-label">Position:</label>
            <select name="position" id="position" class="form-select mb-2">
                <option value="manager">Manager</option>
                <option value="secretary">Secretary</option>
                <option value="food_technologist">Food Technologist</option>
            </select>
            <button type="submit" class="btn btn-primary">Assign Position</button>
        </form>
        <form action="{{ route('admin.changeStatus', $employee) }}" method="post" class="mb-2">
            @csrf
            <label for="status" class="form-label">Status:</label>
            <select name="status" id="status" class="form-select mb-2">
                <option value="active" {{ $employee->status === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $employee->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="on_leave" {{ $employee->status === 'on_leave' ? 'selected' : '' }}>On Leave</option>
            </select>
            <button type="submit" class="btn btn-primary">Change Status</button>
        </form>
        <form action="{{ route('admin.destroy', $employee) }}" method="POST" class="mb-2">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Remove Employee</button>
        </form>
    </div>
       </div>


        </main>
       @include('footer')

    </div>
</div>
</div>
<script>
    document.getElementById('showAssignManagerForm').addEventListener('click', function() {
        var assignManagerForm = document.getElementById('assignManagerForm');
        if (assignManagerForm.style.display === 'none') {
            assignManagerForm.style.display = 'block';
        } else {
            assignManagerForm.style.display = 'none';
        }
    });
</script>

</body>
</html>
