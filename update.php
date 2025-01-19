<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the update operation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];

    $stmt = $conn->prepare("UPDATE items SET name = ?, description = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $description, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Record updated successfully.');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
}

// Fetch all items from the database
$sql = "SELECT * FROM items";
$result = $conn->query($sql);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Items</title>
    <script>
        function confirmUpdate(itemId) {
            if (confirm("Are you sure you want to update this item?")) {
                document.getElementById('update-form-' + itemId).submit();
            }
        }
    </script>
</head>
<body>
<h1>Update Items</h1>

<?php if ($result->num_rows > 0): ?>
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <form id="update-form-<?php echo $row['id']; ?>" method="POST" action="">
                    <td><?php echo $row['id']; ?></td>
                    <td>
                        <input type="text" name="name" value="<?php echo htmlspecialchars($row['name']); ?>" required>
                    </td>
                    <td>
                        <textarea name="description" required><?php echo htmlspecialchars($row['description']); ?></textarea>
                    </td>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="button" onclick="confirmUpdate(<?php echo $row['id']; ?>)">Update</button>
                    </td>
                </form>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>No items found.</p>
<?php endif; ?>
</body>
</html>
