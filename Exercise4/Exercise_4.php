<?php
date_default_timezone_set('Asia/Manila');
$hour = date("H");

if ($hour < 12) {
    $greeting = "Good morning!";
} elseif ($hour < 18) {
    $greeting = "Good afternoon!";
} else {
    $greeting = "Good evening!";
}

// File storage
$file = __DIR__ . "/profiles.json";

// Load profiles safely
$profiles = [];
if (file_exists($file) && filesize($file) > 0) {
    $data = file_get_contents($file);
    $profiles = json_decode($data, true);
    if (!is_array($profiles)) {
        $profiles = [];
    }
}

// Kung empty pa yung JSON, maglagay ng initial members (defaults)
if (empty($profiles)) {
    $profiles = [
        [
            "name" => "Aprilyn D. Timkang",
            "age" => 20,
            "course" => "BSIT",
            "hobbies" => "Playing basketball and watching movies.",
            "address" => "Las Pinas City",
            "image" => "aprilyn.jpeg",
            "quote" => "Success is not final, failure is not fatal: It is the courage to continue that counts."
        ],
        [
            "name" => "Jocelyn C. Lobos",
            "age" => 21,
            "course" => "BSIT",
            "hobbies" => "Watching anime, K-drama and reading manhwa.",
            "address" => "Tunasan, Muntinlupa City",
            "image" => "jc.jpeg",
            "quote" => "Life is too short to waste a second."
        ],
        [
            "name" => "Xyrll D. Rongavilla",
            "age" => 19,
            "course" => "BSIT",
            "hobbies" => "Playing Roblox, COD, and ML.",
            "address" => "Cupang Muntinlupa City",
            "image" => "xy.jpeg",
            "quote" => "A reader lives a thousand lives before he dies."
        ],
        [
            "name" => "Rizza May Ligad",
            "age" => 20,
            "course" => "BSIT",
            "hobbies" => "Watching movies and sleeping.",
            "address" => "Cupang Muntinlupa City",
            "image" => "Riz.jpeg",
            "quote" => "Protect and prioritize your peace at all cost."
        ]
    ];
    file_put_contents($file, json_encode($profiles, JSON_PRETTY_PRINT));
}

// Add new profile kapag nag-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $imageName = 'default.jpeg'; // fallback image

    if (isset($_FILES['new_image']) && $_FILES['new_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // create folder if it doesn't exist
        }

        $tmpName = $_FILES['new_image']['tmp_name'];
        $originalName = basename($_FILES['new_image']['name']);
        $imageName = $uploadDir . time() . '_' . $originalName;

        move_uploaded_file($tmpName, $imageName);
    }

    $newProfile = [
        "name" => $_POST['new_name'],
        "age" => (int)$_POST['new_age'],
        "course" => $_POST['new_course'],
        "hobbies" => $_POST['new_hobbies'],
        "address" => $_POST['new_address'],
        "image" => $imageName,
        "quote" => $_POST['new_quote']
    ];
    $profiles[] = $newProfile;

    // Save updated list to JSON
    file_put_contents($file, json_encode($profiles, JSON_PRETTY_PRINT));

    // Redirect para maiwasan ang double submit
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Search filter
$highlightName = isset($_GET['name']) ? strtolower(trim($_GET['name'])) : '';
$displayProfiles = $profiles;
if ($highlightName) {
    $displayProfiles = array_filter($profiles, function($member) use ($highlightName) {
        return strpos(strtolower($member['name']), $highlightName) !== false;
    });
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Phantom Troupe</title>
  <style>
    body {
      background-color:#A9A9A9;
      color: #333;
      font-family: Arial, sans-serif;
      text-align: center;
      margin: 0;
      padding: 0;
    }
    .logo {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      object-fit: cover;
      margin-top: 5px;
    }
    .group-name {
      font-size: 24px;
      margin: 2px 0;
      text-transform: uppercase;
      letter-spacing: 2px;
    }
    .search-bar {
      margin: 15px;
    }
    .search-bar input[type="text"] {
      padding: 8px;
      border: 1px solid #666;
      border-radius: 5px;
    }
    .search-bar button {
      padding: 8px 12px;
      border: none;
      border-radius: 5px;
      background: #333;
      color: #fff;
      cursor: pointer;
    }
    .profile-container {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 20px;
      padding: 10px;
    }
    /* Flip card styles */
    .profile {
      width: 200px;
      perspective: 1000px;
    }
    .card {
      width: 100%;
      height: 300px;
      position: relative;
      transform-style: preserve-3d;
      transition: transform 0.6s;
      cursor: pointer;
    }
    .card.is-flipped {
      transform: rotateY(180deg);
      box-shadow: 0 0 20px 5px #00ffcc;
      border: 2px solid #00ffcc;
    }
    .card-front, .card-back {
      position: absolute;
      width: 100%;
      height: 100%;
      backface-visibility: hidden;
      border-radius: 10px;
      padding: 10px;
      box-sizing: border-box;
      background:#B6B6B4;
    }
    .card-front img {
      width: 100%;
      height: 160px;
      object-fit: cover;
      border-radius: 10px;
      margin-bottom: 8px;
    }
    .card-front h3 {
      font-size: 14px;
      margin: 4px 0;
      color:black;
    }
    .card-front p {
      font-size: 12px;
      color: #222;
      margin: 2px 0;
    }
    .card-back {
      transform: rotateY(180deg);
      display: flex;
      justify-content: center;
      align-items: center;
      text-align: center;
      font-style: italic;
      font-size: 13px;
      padding: 15px;
    }
    .dark-mode {
      background-color: #1e1e1e;
      color: #f2f2f2;
    }
    .dark-btn {
      margin:10px;
      padding:8px 15px;
      border:none;
      border-radius:10px;
      cursor:pointer;
      background-color:#333;
      color:#fff;
      transition:0.3s;
    }
    .dark-mode .card-back {
      background-color: #2a2a2a;
      color: #f2f2f2;
    }
    @media (max-width: 768px) {
      .group-name{font-size:22px;}
      .profile {width: 160px;}
      .card {height: 240px;}
      .card-front img {height: 100px;}
    }
    @media (max-width: 480px) {
      .group-name {font-size: 20px;letter-spacing: 1px;}
      .profile-container {flex-direction: column;align-items: center;}
      .profile {width: 80%;}
      .card {height: 250px;}
      .card-front h3 {font-size: 14px;}
      .card-front p {font-size: 11px;}
      footer {font-size: 12px;}
    }
	.form-container {
      background-color: #f4f4f4;
      padding: 20px;
      margin: 20px auto;
      width: 90%;
      max-width: 600px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .form-container h2 {
      margin-bottom: 15px;
      font-size: 20px;
      color: #333;
    }
    .form-container form {
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    .form-container input[type="text"],
    .form-container input[type="number"] {
      padding: 10px;
      border: 1px solid #aaa;
      border-radius: 5px;
      font-size: 14px;
    }
    .form-container button {
      padding: 10px;
      background-color: #333;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    .toggle-btn {
      padding: 8px 12px;
      margin-left: 10px;
      background-color: #555;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
  </style>
</head>
<body>
  <img src="logoo.jpeg" alt="Group Logo" class="logo">
  <h1 class="group-name">PHANTOM TROUPE</h1>
  <p><?php echo $greeting;?> Welcome to our page.</p>

  <div class="search-bar">
  <form method="get" action="" style="display: inline-block;">
    <input type="text" name="name" placeholder="Search name..." value="<?= htmlspecialchars($_GET['name'] ?? '') ?>">
    <button type="submit">Search</button>
  </form>

  <!-- Add Profile Button -->
  <button class="toggle-btn" onclick="toggleForm()">Add Profile</button>
</div>

<div class="form-container" id="profileForm" style="display: none;">
  <h2>Add a New Profile</h2>
  <form method="post" action="" enctype="multipart/form-data">
    <input type="text" name="new_name" placeholder="Full Name" required>
    <input type="number" name="new_age" placeholder="Age" required>
    <input type="text" name="new_course" placeholder="Course" required>
    <input type="text" name="new_hobbies" placeholder="Hobbies" required>
    <input type="text" name="new_address" placeholder="Address" required>
    <input type="text" name="new_quote" placeholder="Favorite Quote" required>
    <input type="file" name="new_image" accept="image/*" required>
    <button type="submit">Add Profile</button>
  </form>
</div>

  <?php if ($highlightName): ?>
    <p style="font-weight:bold;">Searching for: <?= htmlspecialchars($highlightName); ?></p>
  <?php endif; ?>

  <main>
    <div class="profile-container">
      <?php if (!empty($displayProfiles)): ?>
        <?php foreach ($displayProfiles as $member): ?>
          <div class="profile">
            <div class="card">
              <div class="card-front">
                <img src="<?= $member['image']; ?>" alt="Photo of <?= $member['name']; ?>">
                <h3><?= $member['name']; ?></h3>
                <p><strong>Age:</strong> <?= $member['age']; ?> Years Old</p>
                <p><strong>Course:</strong> <?= $member['course']; ?></p>
                <p><strong>Hobbies:</strong> <?= $member['hobbies']; ?></p>
                <p><strong>Address:</strong> <?= $member['address']; ?></p>
              </div>
              <div class="card-back">
                <p><?= $member['quote']; ?></p>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No matching profiles found.</p>
      <?php endif; ?>
    </div>
  </main>

  <button class="dark-btn" onclick="DarkMode()">Dark Mode</button>

  <script>
    // Flip card on click
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
      card.addEventListener('click', () => {
        card.classList.toggle('is-flipped');
      });
    });
    // Enable dark mode on click
    function DarkMode() {
      document.body.classList.toggle('dark-mode');
    }
	
	function toggleForm() {
      const form = document.getElementById('profileForm');
      form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }
  </script>

  <footer>
    <p>&copy; <?php echo date("Y"); ?> Phantom Troupe. All rights reserved.</p>
  </footer>
</body>
</html>

