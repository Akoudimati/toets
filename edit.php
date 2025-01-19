<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$item = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fetch'])) {
    $id = $_POST['id'];

    $stmt = $conn->prepare("SELECT * FROM items WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $item = $result->fetch_assoc();
    } else {
        echo "No item found with ID $id.";
    }

    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("UPDATE items SET name = ?, description = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $description, $id);

    if ($stmt->execute()) {
        echo "Record updated successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item</title>
</head>
<body>
<h1>Edit an Item</h1>
<form method="POST" action="">
    <label for="id">Item ID:</label>
    <input type="number" id="id" name="id" required>
    <br><br>
    <button type="submit" name="fetch">Fetch Item</button>
</form>

<?php if ($item): ?>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $item['name']; ?>" required>
        <br><br>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo $item['description']; ?></textarea>
        <br><br>
        <button type="submit" name="edit">Save Changes</button>
    </form>
<?php endif; ?>
</body>
</html>
