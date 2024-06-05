<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Microorganisms</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    @include('users_sidemenu')

    <div class="col d-flex flex-column h-sm-100">
        <main class="row overflow-auto">
            <div class="container mt-5">
                <h1>Manage Microorganisms</h1>

                <!-- Success Message -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Search Bar -->
                <div class="mb-3">
                    <form method="GET" action="{{ route('admin.microorganisms') }}">
                        <div class="input-group">
                            <input type="text" name="search" id="searchBar" class="form-control" placeholder="Search Microorganisms" value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">Search</button>
                        </div>
                    </form>
                </div>

                <!-- Button to Open the Modal for Adding Microorganism -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMicroorganismModal">
                    Add Microorganism
                </button>

                <!-- Microorganisms Table -->
                <table class="table table-bordered mt-3" id="microorganismsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Safe Amount</th>
                            <th>Unit</th>
                            <th>Safety</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($microorganisms as $microorganism)
                            <tr>
                                <td>{{ $microorganism->id_microorganism }}</td>
                                <td>{{ $microorganism->name }}</td>
                                <td>{{ $microorganism->type }}</td>
                                <td>{{ $microorganism->safe_amount }}</td>
                                <td>{{ $microorganism->unit }}</td>
                                <td>{{ $microorganism->safety }}</td>
                                <td>
                                    <!-- Button to Open the Modal for Editing Microorganism -->
                                    <button type="button" class="btn btn-warning" onclick="openEditModal({{ $microorganism->id_microorganism }}, '{{ $microorganism->name }}', '{{ $microorganism->type }}', '{{ $microorganism->safe_amount }}', '{{ $microorganism->unit }}', '{{ $microorganism->safety }}')">
                                        Edit
                                    </button>
                                    <!-- Form to Delete Microorganism -->
                                    <form action="{{ route('admin.microorganisms.destroy', $microorganism->id_microorganism) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination Links -->
                <div class="d-flex justify-content-center">
                    {{ $microorganisms->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
                </div>

                <!-- Add Microorganism Modal -->
                <div class="modal fade" id="addMicroorganismModal" tabindex="-1" aria-labelledby="addMicroorganismModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addMicroorganismModalLabel">Add Microorganism</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.microorganisms.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="type" class="form-label">Type</label>
                                        <input type="text" class="form-control" id="type" name="type" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="safe_amount" class="form-label">Safe Amount</label>
                                        <input type="text" class="form-control" id="safe_amount" name="safe_amount">
                                    </div>
                                    <div class="mb-3">
                                        <label for="unit" class="form-label">Unit</label>
                                        <input type="text" class="form-control" id="unit" name="unit">
                                    </div>
                                    <div class="mb-3">
                                        <label for="safety" class="form-label">Safety</label>
                                        <input type="text" class="form-control" id="safety" name="safety">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Add Microorganism</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Microorganism Modal -->
                <div class="modal fade" id="editMicroorganismModal" tabindex="-1" aria-labelledby="editMicroorganismModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editMicroorganismModalLabel">Edit Microorganism</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editMicroorganismForm" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="edit_name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="edit_name" name="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_type" class="form-label">Type</label>
                                        <input type="text" class="form-control" id="edit_type" name="type" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_safe_amount" class="form-label">Safe Amount</label>
                                        <input type="text" class="form-control" id="edit_safe_amount" name="safe_amount">
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_unit" class="form-label">Unit</label>
                                        <input type="text" class="form-control" id="edit_unit" name="unit">
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit_safety" class="form-label">Safety</label>
                                        <input type="text" class="form-control" id="edit_safety" name="safety">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        @include('footer')
    </div>

    <script>
        function openEditModal(id, name, type, safeAmount, unit, safety) {
            document.getElementById('editMicroorganismForm').action = '/admin/microorganisms/' + id;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_type').value = type;
            document.getElementById('edit_safe_amount').value = safeAmount;
            document.getElementById('edit_unit').value = unit;
            document.getElementById('edit_safety').value = safety;
            var editModal = new bootstrap.Modal(document.getElementById('editMicroorganismModal'));
            editModal.show();
        }
    </script>
</body>
</html>
