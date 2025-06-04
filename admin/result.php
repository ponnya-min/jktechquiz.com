<?php
require_once '../config.php'; // Ensure this creates a mysqli $conn connection

$perPage = 8;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $perPage;

$sql = "SELECT u.email AS user_email, r.quiz_type, r.score, 
               DATE_FORMAT(r.quiz_date, '%d.%m.%Y (%h:%i %p)') AS formatted_quiz_date,
               IF(DATEDIFF(NOW(), r.quiz_date) > 180, 'YES', 'NO') AS expired_exam,
               r.id AS result_id
        FROM result r
        JOIN users u ON r.user_id = u.id
        LIMIT ? OFFSET ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $perPage, $offset);
$stmt->execute();
$result = $stmt->get_result();

$sqlCount = "SELECT COUNT(*) FROM result";
$countResult = $conn->query($sqlCount);
$totalRows = $countResult->fetch_row()[0];
$totalPages = ceil($totalRows / $perPage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
</head>
<body>
  <nav class="navbar navbar-expand-lg bg-light">
    <div class="container">
      <a class="navbar-brand" href=""><img alt="logo" height="60" src="img/1-removebg-preview.png" /></a>
      <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto">
          <li class="nav-item px-2"><a class="nav-link" href="adminRole.php"><i class="fa-solid fa-user-tie"></i> Admin</a></li>
          <li class="nav-item px-2"><a class="nav-link" href="index.php"><i class="fa-solid fa-user"></i> User</a></li>
          <li class="nav-item px-2"><a class="nav-link" href="result.php"><i class="fa-solid fa-ranking-star"></i> Result</a></li>
          <li class="nav-item px-2"><a class="nav-link" href="comment.php"><i class="fa-solid fa-comment"></i> Comment</a></li>
        </ul>
        <a class="btn btn-danger" href="logout.php">Logout</a>
      </div>
    </div>
  </nav>

  <div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h3 class="mb-3">Quiz Results</h3>
      <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteExpiredModal">
        Delete Expired Acc
      </button>
    </div>

    <div class="table-responsive">
      <?php if ($result->num_rows > 0): ?>
      <form method="POST" action="manageResult/deleteSelectedResults.php" id="bulkDeleteForm">
        <table class="table table-striped table-bordered">
          <thead class="table-dark">
            <tr>
              <th><input type="checkbox" id="selectAll"></th>
              <th>No</th>
              <th>User Email</th>
              <th>Quiz Type</th>
              <th>Score</th>
              <th>Quiz Date</th>
              <th>Expired Exam</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php $counter = $offset + 1; while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><input type="checkbox" name="result_ids[]" value="<?= $row['result_id'] ?>"></td>
              <td><?= $counter++ ?></td>
              <td><?= htmlspecialchars($row["user_email"]) ?></td>
              <td><?= htmlspecialchars($row["quiz_type"]) ?></td>
              <td><?= htmlspecialchars($row["score"]) ?></td>
              <td><?= htmlspecialchars($row["formatted_quiz_date"]) ?></td>
              <td><?= htmlspecialchars($row["expired_exam"]) ?></td>
              <td>
                <button type="button" class="btn btn-danger" onclick="confirmDelete(<?= htmlspecialchars($row['result_id']) ?>)">
                  Delete
                </button>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
        <button type="submit" class="btn btn-danger mt-2" onclick="return confirm('Delete selected results?')">Delete Selected</button>
      </form>
      <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
          <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $page - 1 ?>">Previous</a>
          </li>
          <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
              <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
            </li>
          <?php endfor; ?>
          <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $page + 1 ?>">Next</a>
          </li>
        </ul>
      </nav>
      <?php else: ?>
        <p class="text-center">No results found.</p>
      <?php endif; ?>
    </div>
  </div>

  <div class="modal fade" id="deleteResultModal" tabindex="-1" aria-labelledby="deleteResultModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Confirm Deletion</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">Are you sure you want to delete this quiz result?</div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <form method="POST" action="manageResult/deleteResult.php">
            <input type="hidden" id="deleteResultId" name="result_id">
            <button type="submit" class="btn btn-danger">Delete</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="deleteExpiredModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Delete Expired Account?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">Are you sure you want to delete all expired accounts?</div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <form method="POST" action="manageResult/deleteExpiredResult.php">
            <button type="submit" class="btn btn-danger">Delete All</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    function confirmDelete(resultId) {
      document.getElementById("deleteResultId").value = resultId;
      var modal = new bootstrap.Modal(document.getElementById('deleteResultModal'));
      modal.show();
    }
    document.getElementById("selectAll").addEventListener("click", function () {
      const checkboxes = document.querySelectorAll('input[name="result_ids[]"]');
      checkboxes.forEach(cb => cb.checked = this.checked);
    });
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
