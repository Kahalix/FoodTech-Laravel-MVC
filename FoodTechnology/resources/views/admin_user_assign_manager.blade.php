<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assign Food Technologist to Manager</title>
</head>
<body>
    <h1>Assign Food Technologist to Manager</h1>
    <form action="{{ route('admin.assignFoodTechnologistToManager') }}" method="POST">
        @csrf
        <label for="food_technologist_id">Food Technologist:</label>
        <select name="food_technologist_id" id="food_technologist_id">
            @foreach($foodTechnologists as $technologist)
                <option value="{{ $technologist }}">{{ $technologist->first_name }} {{ $technologist->last_name }}</option>
            @endforeach
        </select><br><br>
        <label for="manager_id">Manager:</label>
        <select name="manager_id" id="manager_id">
            @foreach($managers as $manager)
                <option value="{{ $manager }}">{{ $manager->first_name }} {{ $manager->last_name }}</option>
            @endforeach
        </select><br><br>
        <button type="submit">Assign to Manager</button>
    </form>
</body>
</html> -->
