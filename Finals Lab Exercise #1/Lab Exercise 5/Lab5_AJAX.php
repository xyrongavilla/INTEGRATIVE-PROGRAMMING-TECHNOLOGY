<?php
// Check if this is an AJAX request (Fetch POST sending JSON)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    // Get JSON data from request body
    $input = json_decode(file_get_contents('php://input'), true);

    // Validate and respond
    if (isset($input['name']) && !empty(trim($input['name']))) {
        $name = htmlspecialchars(trim($input['name']));
        $response = [
            "status" => "success",
            "message" => "Welcome, $name!"
        ];
    } else {
        $response = [
            "status" => "error",
            "message" => "Name cannot be empty!"
        ];
    }

    echo json_encode($response);
    exit; // stop PHP here so it doesn’t output HTML below
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab Exercise 5 - PHP + JSON + AJAX</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
            background: #f8f9fa;
        }
        h2 {
            color: #333;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 8px;
            font-size: 1rem;
        }
        button {
            padding: 8px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background-color: #0056b3;
        }
        pre {
            background: #f1f1f1;
            padding: 15px;
            border-radius: 5px;
            font-size: 1rem;
        }
    </style>
</head>
<body>
    <h2>PHP + JSON + AJAX Example</h2>

    <form id="userForm">
        <label for="name">Enter your name:</label>
        <input type="text" id="name" name="name" required>
        <button type="submit">Submit</button>
    </form>

    <h3>Response:</h3>
    <pre id="output"></pre> <!-- JSON output will appear here -->

    <script>
        document.getElementById('userForm').addEventListener('submit', function(event) {
            event.preventDefault(); // prevent page reload

            const name = document.getElementById('name').value;

            // Send data to the same PHP file using Fetch
            fetch(window.location.href, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ name: name })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then(data => {
                // Display JSON nicely formatted
                document.getElementById('output').textContent = JSON.stringify(data, null, 2);
            })
            .catch(error => {
                document.getElementById('output').textContent = "Error occurred: " + error.message;
            });
        });
    </script>
</body>
</html>
