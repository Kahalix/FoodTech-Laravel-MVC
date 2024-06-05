<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Ingredients</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    @include('users_sidemenu')

    <div class="col d-flex flex-column h-sm-100">
        <main class="row overflow-auto">
            <div class="container mt-5">
                <h1>Manage Ingredients</h1>

                <!-- Success Message -->
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- <!-- Search Bar -->
                <div class="mb-3">
                    <input type="text" id="searchBar" class="form-control" placeholder="Search Ingredients">
                </div> --}}

                <!-- Search Bar -->
                <div class="mb-3">
                    <form method="GET" action="{{ route('admin.ingredients') }}">
                        <div class="input-group">
                            <input type="text" name="search" id="searchBar" class="form-control" placeholder="Search Ingredients" value="{{ request('search') }}">
                            <button class="btn btn-outline-secondary" type="submit">Search</button>
                        </div>
                    </form>
                </div>

                <!-- Button to Open the Modal for Adding Ingredient -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addIngredientModal">
                    Add Ingredient
                </button>

                <!-- Ingredients Table -->
                <table class="table table-bordered mt-3" id="ingredientsTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Safe Amount</th>
                            <th>Unit</th>
                            <th>Safety</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ingredients as $ingredient)
                            <tr>
                                <td>{{ $ingredient->id_ingredient }}</td>
                                <td>{{ $ingredient->name }}</td>
                                <td>{{ $ingredient->safe_amount }}</td>
                                <td>{{ $ingredient->unit }}</td>
                                <td>{{ $ingredient->safety }}</td>
                                <td>
                                    <!-- Button to Open the Modal for Editing Ingredient -->
                                    <button type="button" class="btn btn-warning" onclick="openEditModal({{ $ingredient->id }}, '{{ $ingredient->name }}', '{{ $ingredient->safe_amount }}', '{{ $ingredient->unit }}', '{{ $ingredient->safety }}')">
                                        Edit
                                    </button>
                                    <!-- Form to Delete Ingredient -->
                                    <form action="{{ route('admin.ingredients.destroy', $ingredient->id_ingredient) }}" method="POST" style="display:inline;">
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
                    {{ $ingredients->links('pagination::bootstrap-5') }}
                </div>

                <!-- Add Ingredient Modal -->
                <div class="modal fade" id="addIngredientModal" tabindex="-1" aria-labelledby="addIngredientModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addIngredientModalLabel">Add Ingredient</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('admin.ingredients.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" required>
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
                                    <button type="submit" class="btn btn-primary">Add Ingredient</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Ingredient Modal -->
                <div class="modal fade" id="editIngredientModal" tabindex="-1" aria-labelledby="editIngredientModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editIngredientModalLabel">Edit Ingredient</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editIngredientForm" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="edit_name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="edit_name" name="name" required>
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

        <script>
            // // Function to handle ingredient search
            // document.getElementById('searchBar').addEventListener('input', function() {
            //     const searchText = this.value.toLowerCase();
            //     const rows = document.querySelectorAll('#ingredientsTable tbody tr');

            //     rows.forEach(row => {
            //         const name = row.cells[1].textContent.toLowerCase();
            //         if (name.includes(searchText)) {
            //             row.style.display = '';
            //         } else {
            //             row.style.display = 'none';
            //         }
            //     });
            // });

            function openEditModal(id, name, safeAmount, unit, safety, added_by) {
                document.getElementById('editIngredientForm').action = '/admin/ingredients/' + id;
                document.getElementById('edit_name').value = name;
                document.getElementById('edit_safe_amount').value = safeAmount;
                document.getElementById('edit_unit').value = unit;
                document.getElementById('edit_safety').value = safety;
                document.getElementById('edit_added_by').value = added_by;
                var editModal = new bootstrap.Modal(document.getElementById('editIngredientModal'));
                editModal.show();
            }
        </script>
    </body>
</html>
