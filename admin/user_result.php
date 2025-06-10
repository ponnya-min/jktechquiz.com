<?php
require_once '../config.php';
$sort_by = $_GET['sort_by'] ?? 'score';
$sort_order = strtoupper($_GET['sort_order'] ?? 'ASC');
$allowed_columns = ['score', 'quiz_date'];
$allowed_order = ['ASC', 'DESC'];

if (!in_array($sort_by, $allowed_columns)) $sort_by = 'score';
if (!in_array($sort_order, $allowed_order)) $sort_order = 'ASC';

if (!isset($_GET['id'])) {
    die("User ID not provided.");
}

$userId = (int)$_GET['id'];

// Fetch user
$userQuery = mysqli_prepare($conn, "SELECT username, email, last_login FROM users WHERE id = ?");
mysqli_stmt_bind_param($userQuery, "i", $userId);
mysqli_stmt_execute($userQuery);
$userResult = mysqli_stmt_get_result($userQuery);
$user = mysqli_fetch_assoc($userResult);

if (!$user) {
    die("User not found.");
}


// Fetch result
$resultQuery = mysqli_prepare($conn, "SELECT * FROM result WHERE user_id = ? ORDER BY $sort_by $sort_order");


mysqli_stmt_bind_param($resultQuery, "i", $userId);
mysqli_stmt_execute($resultQuery);
$resultData = mysqli_stmt_get_result($resultQuery);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($user['username']) ?> - Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../style/admin.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <h3>Results for <?= htmlspecialchars($user['username']) ?></h3>
        <div class="row">
            <!-- Left Section (3/4 width) -->
            <div class="col-md-9">
                <div class="mb-3">
                    <form method="GET" class="form-inline">
                        <input type="hidden" name="id" value="<?= $userId ?>">
                        <label class="me-2">Sort by:</label>
                        <select name="sort_by" class="form-select d-inline w-auto me-2">
                            <option value="score" <?= $sort_by == 'score' ? 'selected' : '' ?>>Score</option>
                            <option value="quiz_date" <?= $sort_by == 'quiz_date' ? 'selected' : '' ?>>Date</option>
                        </select>
                        <select name="sort_order" class="form-select d-inline w-auto me-2">
                            <option value="ASC" <?= $sort_order == 'ASC' ? 'selected' : '' ?>>Ascending</option>
                            <option value="DESC" <?= $sort_order == 'DESC' ? 'selected' : '' ?>>Descending</option>
                        </select>
                        <button type="submit" class="btn btn-primary btn-sm">Sort</button>
                    </form>
                </div>

                <form method="POST" action="delete_selected_results.php" id="bulkDeleteForm">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="admin_bg_color text-center"><input type="checkbox" id="selectAll"></th>
                                <th class="admin_bg_color text-center">No</th>
                                <th class="admin_bg_color text-center">Quiz Title</th>
                                <th class="admin_bg_color text-center">Score</th>
                                <th class="admin_bg_color text-center">Date</th>
                                <th class="admin_bg_color text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            while ($row = mysqli_fetch_assoc($resultData)): ?>
                                <tr>
                                    <td class="text-center"><input type="checkbox" name="result_ids[]" value="<?= $row['id'] ?>"></td>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td class="text-center"><?= htmlspecialchars($row['quiz_type']) ?></td>
                                    <td class="text-center"><?= htmlspecialchars($row['score']) ?></td>
                                    <td class="text-center"><?= htmlspecialchars($row['quiz_date']) ?></td>
                                    <td class="text-center">
                                        <form method="POST" action="delete_user_result.php" onsubmit="return confirm('Delete this result?');">
                                            <input type="hidden" name="result_id" value="<?= $row['id'] ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>

                    <div class="d-flex m-auto gap-3">
                        <button type="submit" class="btn btn-danger mt-2" onclick="return confirm('Delete selected results?')">Delete Selected</button>
                        <a href="index.php" class="btn btn-secondary mt-2">← Back to Users</a>
                    </div>
                </form>
            </div>

            <!-- Right Section (1/4 width) -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        User Info
                    </div>
                    <div class="card-body">
                        <p><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                        <p><strong>Last Login:</strong> <?= htmlspecialchars($user['last_login']) ?: 'Never logged in' ?></p>
                    </div>
                </div>
               <form method="POST" action="delete_user_from_result.php" onsubmit="return confirm('Are you sure you want to delete this user and all their results?');">
    <input type="hidden" name="user_id" value="<?= $userId ?>">
    <button type="submit" class="btn btn-danger">Delete This User</button>
</form>

            </div>
        </div>
    </div>


    <script>
        document.getElementById("selectAll").addEventListener("change", function() {
            const checkboxes = document.querySelectorAll("input[name='result_ids[]']");
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    </script>
</body>


</html>
<?php mysqli_close($conn); ?>