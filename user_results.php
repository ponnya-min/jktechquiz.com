<?php
require("config.php");
session_start();

$userId = null;
$userName = 'Unknown';
$email = 'Unknown';
$quizResults = [];

// If admin clicked on a user (via ?username)
if (isset($_GET['username'])) {
    $username = $_GET['username'];

    $stmt = $conn->prepare("SELECT id, userName, email FROM users WHERE userName = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($user) {
        $userId = $user['id'];
        $userName = $user['userName'];
        $email = $user['email'];
    } else {
        echo "<p class='text-danger text-center'>User not found.</p>";
        exit;
    }
} 
// Else: it's a logged-in user checking their own profile
elseif (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT userName, email FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($user) {
        $userName = $user['userName'];
        $email = $user['email'];
    } else {
        echo "<p class='text-danger text-center'>Session user not found.</p>";
        exit;
    }
} 
else {
    echo "<p class='text-danger text-center'>No user specified or logged in.</p>";
    exit;
}

// Fetch quiz results
$stmt = $conn->prepare("SELECT quiz_type, score, quiz_date FROM result WHERE user_id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$quizResults = $stmt->get_result();
?>

<!-- HTML: identical to before -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>JKTechQuiz - User Results</title>
    <link rel="stylesheet" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3 class="text-center text-primary">Quiz Results</h3>
    <p class="text-center">Viewing results for: <strong><?= htmlspecialchars($userName) ?></strong></p>
    <p class="text-center text-muted"><?= htmlspecialchars($email) ?></p>

    <?php if ($quizResults->num_rows > 0): ?>
        <table class="table table-bordered text-center mt-4">
            <thead class="table-dark">
            <tr>
                <th>Quiz Type</th>
                <th>Score</th>
                <th>Exam Date</th>
            </tr>
            </thead>
            <tbody>
            <?php while ($row = $quizResults->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['quiz_type']) ?></td>
                    <td><?= htmlspecialchars($row['score']) ?></td>
                    <td><?= htmlspecialchars($row['quiz_date']) ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center text-warning mt-4">No quiz results found for this user.</p>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="admin_users.php" class="btn btn-outline-secondary">← Back to Users</a>
    </div>
</div>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
