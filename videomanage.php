<?php
$videos = json_decode(file_get_contents('videos.json'), true);
$error = '';
$success = '';
$password = 'videomanager123@'; // άλλαξε το σε κάτι ασφαλές

if (isset($_POST['password']) && $_POST['password'] === $password) {
    $videoKey = $_POST['videoKey'] ?? '';
    $newUrl = $_POST['newUrl'] ?? '';

    if (array_key_exists($videoKey, $videos) && !empty($newUrl)) {
        $videos[$videoKey] = $newUrl;
        file_put_contents('videos.json', json_encode($videos, JSON_PRETTY_PRINT));
        $success = "Το $videoKey άλλαξε με επιτυχία!";
    } else {
        $error = "Λάθος επιλογή ή κενό URL.";
    }
} elseif (isset($_POST['password'])) {
    $error = "Λάθος κωδικός!";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
</head>
<body>
<h1>Admin Panel</h1>

<?php if($error) echo "<p style='color:red;'>$error</p>"; ?>
<?php if($success) echo "<p style='color:green;'>$success</p>"; ?>

<form method="post">
    <label>Password: <input type="password" name="password" required></label><br><br>

    <label>Video προς αλλαγή:
        <select name="videoKey" required>
            <?php foreach ($videos as $key => $url): ?>
                <option value="<?php echo htmlspecialchars($key); ?>"><?php echo htmlspecialchars($key); ?></option>
            <?php endforeach; ?>
        </select>
    </label><br><br>

    <label>Νέο URL: <input type="text" name="newUrl" required></label><br><br>

    <input type="submit" value="Αποθήκευση Αλλαγών">
</form>

<h2>Τρέχοντα URLs</h2>
<ul>
<?php foreach ($videos as $key => $url): ?>
    <li><?php echo htmlspecialchars($key); ?> → <?php echo htmlspecialchars($url); ?></li>
<?php endforeach; ?>
</ul>

</body>
</html>