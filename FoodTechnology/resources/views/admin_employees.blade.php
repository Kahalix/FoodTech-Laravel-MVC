<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .employee-list {
            display: flex;
            flex-wrap: wrap;
        }
        .employee-item {
            flex: 0 0 33.3333%;
            box-sizing: border-box;
            padding: 10px;
        }
        .employee-card {
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
        }
        .employee-card img {
            max-height: 50px;
            margin-bottom: 10px;
        }
        .employee-card a {
            display: block;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    @include('users_sidemenu')

    <div class="col d-flex flex-column h-sm-100">
        <main class="row overflow-auto">


            @if(session()->has('success'))
            <div class="alert alert-success" role="alert">
                {{ session()->get('success') }}
            </div>
        @endif

        @if(session()->has('error'))
            <div class="alert alert-danger" role="alert">
                {{ session()->get('error') }}
            </div>
        @endif
            <!-- Search input and dropdown -->
            <div class="input-group mb-3">
                <label class="input-group-text" for="searchInput">Search</label>
                <select class="form-select" id="searchOption">
                    <option value="name">Name</option>
                    <option value="position">Position</option>
                    <option value="status">Status</option>
                </select>
                <input type="text" class="form-control" id="searchInput" placeholder="Search...">
            </div>



            <div class="col-12 text-end mb-3">

            </div>



            <div class="col-12 text-end mb-3">
                <button class="btn btn-primary" id="generateLinkButton">Generate Registration Link</button>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">Add Employee</button>
            </div>


            <div class="modal fade" id="linkModal" tabindex="-1" aria-labelledby="linkModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="linkModalLabel">Generated Registration Link</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="text" id="generatedLink" class="form-control" readonly>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" onclick="copyToClipboard()">Copy Link</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>



            <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form class="modal-content" method="POST" action="{{ route('admin.store') }}">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addEmployeeModalLabel">Add Employee</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="first_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="last_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="phoneNumber" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="phoneNumber" name="phone_number" required>
                            </div>
                            <div class="mb-3">
                                <label for="login" class="form-label">Login</label>
                                <input type="text" class="form-control" id="login" name="login" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="position" class="form-label">Position</label>
                                <select class="form-select" id="position" name="position" required>
                                    <option value="manager">Manager</option>
                                    <option value="secretary">Secretary</option>
                                    <option value="food_technologist">Food Technologist</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            </div>


                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Add Employee</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>




            <h2>Employee List</h2>
            <div class="employee-list" id="employeeList">
                @foreach($employees as $employee)
                @if ($employee->position !== 'admin')
                <div class="employee-item" data-id="{{ $employee->id_employee }}">
                    <div class="employee-card" data-bs-toggle="modal" data-bs-target="#employeeModal"
                         data-id="{{ $employee->id_employee }}"
                         data-name="{{ $employee->first_name }} {{ $employee->last_name }}"
                         data-image="{{ asset($employee->employee_image) }}"
                         data-position="{{ $employee->position }}"
                         data-status="{{ $employee->status }}">
                        <img src="{{ asset($employee->employee_image) }}" alt="Employee Image">
                        <a data-attribute="name">{{ $employee->first_name }} {{ $employee->last_name }}</a>
                        <a>Employee ID: {{ $employee->id_employee }}</a>
                        <a data-attribute="position">{{ $employee->position }}</a>
                        <a data-attribute="status">Status: {{ $employee->status }}</a>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </main>
        @include('footer')
    </div>

    <!-- Employee Modal -->
    <div class="modal fade" id="employeeModal" tabindex="-1" aria-labelledby="employeeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-slideout">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="employeeModalLabel">Employee Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img id="modalEmployeeImage" src="" alt="Employee Image" style="max-height: 100px;">
                    <p id="modalEmployeeName"></p>
                    <p id="modalEmployeePosition"></p>
                    <p id="modalEmployeeStatus"></p>
                </div>
                <div class="modal-footer">
                    <a href="" id="editEmployeeButton" class="btn btn-primary">Edit Employee</a>
                </div>
            </div>
        </div>
    </div>

    <script>
       document.getElementById('generateLinkButton').addEventListener('click', function() {
    fetch('{{ route("admin.generateTemporaryLink") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('generatedLink').value = data.link;
            var linkModal = new bootstrap.Modal(document.getElementById('linkModal'));
            linkModal.show();
        } else {
            alert('Failed to generate link.');
        }
    });
});

function copyToClipboard() {
    var copyText = document.getElementById("generatedLink");
    copyText.select();
    copyText.setSelectionRange(0, 99999); // For mobile devices

    document.execCommand("copy");

    alert("Copied the link: " + copyText.value);
}



    // Function to update search results
    function updateSearch() {
        var searchTerm = searchInput.value.trim().toLowerCase();
        var searchAttribute = searchOption.value;
        var employeeList = document.getElementById('employeeList');
        var matchingCards = [];
        var nonMatchingCards = [];

        // Loop through all employee cards
        employeeCards.forEach(function (card) {
            var attributeElement = card.querySelector(`[data-attribute="${searchAttribute}"]`);
            if (attributeElement) {
                var attributeValue = attributeElement.textContent.toLowerCase();
                if (attributeValue.includes(searchTerm)) {
                    matchingCards.push(card.parentElement);
                } else {
                    nonMatchingCards.push(card.parentElement);
                }
            } else {
                console.error(`Attribute "${searchAttribute}" not found in employee card.`);
            }
        });

        // Clear the current list and append matching cards first, then non-matching cards
        employeeList.innerHTML = '';
        matchingCards.forEach(function (item) {
            employeeList.appendChild(item);
        });
        nonMatchingCards.forEach(function (item) {
            employeeList.appendChild(item);
        });
    }

    // Get the input field, dropdown, and employee cards
    var searchInput = document.getElementById('searchInput');
    var searchOption = document.getElementById('searchOption');
    var employeeCards = document.querySelectorAll('.employee-card');

    // Add event listener for input field and dropdown
    searchInput.addEventListener('input', updateSearch);
    searchOption.addEventListener('change', updateSearch);

    // Call the updateSearch function to ensure it filters based on the initial values
    updateSearch();

    var employeeModal = document.getElementById('employeeModal');
    employeeModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var employeeId = button.getAttribute('data-id');
        var employeeName = button.getAttribute('data-name');
        var employeeImage = button.getAttribute('data-image');
        var employeePosition = button.getAttribute('data-position');
        var employeeStatus = button.getAttribute('data-status');

        var modalTitle = employeeModal.querySelector('.modal-title');
        var modalEmployeeImage = employeeModal.querySelector('#modalEmployeeImage');
        var modalEmployeeName = employeeModal.querySelector('#modalEmployeeName');
        var modalEmployeePosition = employeeModal.querySelector('#modalEmployeePosition');
        var modalEmployeeStatus = employeeModal.querySelector('#modalEmployeeStatus');
        var editEmployeeButton = employeeModal.querySelector('#editEmployeeButton');

        modalTitle.textContent = 'Employee Details';
        modalEmployeeImage.src = employeeImage;
        modalEmployeeName.textContent = 'Name: ' + employeeName;
        modalEmployeePosition.textContent = 'Position: ' + employeePosition;
        modalEmployeeStatus.textContent = 'Status: ' + employeeStatus;
        editEmployeeButton.href = '{{ route("admin.show", ["employee" => ":employeeId"]) }}'.replace(':employeeId', employeeId);
    });
    </script>
</body>
</html>
