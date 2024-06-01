<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Tests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .expandable-row {
            cursor: pointer;
        }
        .expandable-row:hover {
            background-color: #f8f9fa;
        }
        .expandable-row-icon::before {
            content: "\25B6"; /* Right-pointing arrow */
            display: inline-block;
            margin-right: 5px;
            transition: transform 0.2s;
        }
        .expandable-row-icon.collapsed::before {
            transform: rotate(90deg); /* Down-pointing arrow */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Review Tests</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="accordion" id="productsAccordion">
            @foreach($products as $product)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{ $product->id_product }}">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $product->id_product }}" aria-expanded="true" aria-controls="collapse{{ $product->id_product }}">
                            {{ $product->name }} <br> Status: {{ $product->status }}
                        </button>
                    </h2>

                    <div id="collapse{{ $product->id_product }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $product->id_product }}" data-bs-parent="#productsAccordion">
                        <div class="accordion-body">
                            <div class="d-flex mb-3">
                                <form method="POST" action="{{ route('tests.accept', $product->id_product) }}" class="me-2">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Accept</button>
                                </form>
                                <form method="POST" action="{{ route('tests.decline', $product->id_product) }}" class="me-2">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Decline</button>
                                </form>
                                <form method="POST" action="{{ route('tests.reassign', $product->id_product) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-warning">Reassign</button>
                                </form>
                            </div>
                            <div class="accordion" id="detailsAccordion{{ $product->id_product }}">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingResults{{ $product->id_product }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseResults{{ $product->id_product }}" aria-expanded="false" aria-controls="collapseResults{{ $product->id_product }}">
                                            Test Results
                                        </button>
                                    </h2>
                                    <div id="collapseResults{{ $product->id_product }}" class="accordion-collapse collapse" aria-labelledby="headingResults{{ $product->id_product }}" data-bs-parent="#detailsAccordion{{ $product->id_product }}">
                                        <div class="accordion-body">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Test Result</th>
                                                        <th>Decision</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                        <tr>
                                                            <td>{{ $product->test_result->test_results }}</td>
                                                            <td>{{ $product->test_result->decision }}</td>
                                                        </tr>
                                                        @if($product->test_result->resultImages->count() > 0)
                                                            <tr>
                                                                <td colspan="2">
                                                                    <strong>Result Images:</strong>
                                                                    <ul>
                                                                        @foreach($product->test_result->resultImages as $image)
                                                                            <li><img src="{{ asset('storage/' . $image->image_path) }}" alt="Result Image" style="max-width: 100px;"></li>
                                                                        @endforeach
                                                                    </ul>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingIngredients{{ $product->id_product }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseIngredients{{ $product->id_product }}" aria-expanded="false" aria-controls="collapseIngredients{{ $product->id_product }}">
                                            Ingredients
                                        </button>
                                    </h2>
                                    <div id="collapseIngredients{{ $product->id_product }}" class="accordion-collapse collapse" aria-labelledby="headingIngredients{{ $product->id_product }}" data-bs-parent="#detailsAccordion{{ $product->id_product }}">
                                        <div class="accordion-body">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Ingredient Name</th>
                                                        <th>Amount</th>
                                                        <th>Unit</th>
                                                        <th>Completed By</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($product->product_ingredients as $ingredient)
                                                        <tr>
                                                            <td>{{ $ingredient->name }}</td>
                                                            <td>{{ $ingredient->ingredient_amount }}</td>
                                                            <td>{{ $ingredient->unit }}</td>
                                                            <td>{{ $ingredient->completed_by }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingMicroorganisms{{ $product->id_product }}">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMicroorganisms{{ $product->id_product }}" aria-expanded="false" aria-controls="collapseMicroorganisms{{ $product->id_product }}">
                                            Microorganisms
                                        </button>
                                    </h2>
                                    <div id="collapseMicroorganisms{{ $product->id_product }}" class="accordion-collapse collapse" aria-labelledby="headingMicroorganisms{{ $product->id_product }}" data-bs-parent="#detailsAccordion{{ $product->id_product }}">
                                        <div class="accordion-body">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Microorganism Name</th>
                                                        <th>Type</th>
                                                        <th>Amount</th>
                                                        <th>Unit</th>
                                                        <th>Completed By</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($product->product_microorganisms as $microorganism)
                                                        <tr>
                                                            <td>{{ $microorganism->name }}</td>
                                                            <td>{{ $microorganism->type }}</td>
                                                            <td>{{ $microorganism->microorganism_amount }}</td>
                                                            <td>{{ $microorganism->unit }}</td>
                                                            <td>{{ $microorganism->completed_by }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Reassign Modal -->
    <div class="modal fade" id="reassignModal" tabindex="-1" aria-labelledby="reassignModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="reassignModalLabel">Reassign Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="reassignForm" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="employee_id" class="form-label">Select Employee</label>
                            <select id="employee_id" name="employee_id" class="form-control" required>
                                <!-- Options will be populated by JavaScript -->
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Reassign</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const reassignButtons = document.querySelectorAll('form[action*="reassign"] button');
            const reassignForm = document.getElementById('reassignForm');
            const employeeSelect = document.getElementById('employee_id');

            reassignButtons.forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault();

                    const formAction = button.closest('form').action;
                    reassignForm.action = formAction;

                    // Fetch active employees
                    fetch('{{ route("active.employees") }}')
                        .then(response => response.json())
                        .then(data => {
                            employeeSelect.innerHTML = ''; // Clear existing options
                            data.forEach(employee => {
                                const option = document.createElement('option');
                                option.value = employee.id_employee;
                                option.textContent = `${employee.first_name} ${employee.last_name}`;
                                employeeSelect.appendChild(option);
                            });

                            // Show the modal
                            const reassignModal = new bootstrap.Modal(document.getElementById('reassignModal'));
                            reassignModal.show();
                        })
                        .catch(error => console.error('Error fetching active employees:', error));
                });
            });
        });
    </script>
</body>
</html>
