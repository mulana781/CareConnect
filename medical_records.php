<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

// Get user data from session
$user = $_SESSION['user'];

// Check if user has permission to access medical records
if ($user['role'] !== 'doctor' && $user['role'] !== 'nurse') {
    header('Location: index.php');
    exit();
}

// Database connection (ganti dengan konfigurasi database Anda)
try {
    $pdo = new PDO("mysql:host=localhost;dbname=careconnect", "username", "password");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    error_log("Connection failed: " . $e->getMessage());
    die("Connection failed. Please try again later.");
}

// Handle form submission for new medical record
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    try {
        switch ($_POST['action']) {
            case 'add':
                $stmt = $pdo->prepare("
                    INSERT INTO medical_records 
                    (patient_id, doctor_id, diagnosis, treatment, notes, date_created)
                    VALUES (?, ?, ?, ?, ?, NOW())
                ");
                $stmt->execute([
                    $_POST['patient_id'],
                    $user['id'],
                    $_POST['diagnosis'],
                    $_POST['treatment'],
                    $_POST['notes']
                ]);
                $_SESSION['success'] = "Medical record added successfully";
                break;

            case 'update':
                $stmt = $pdo->prepare("
                    UPDATE medical_records 
                    SET diagnosis = ?, treatment = ?, notes = ?
                    WHERE id = ? AND doctor_id = ?
                ");
                $stmt->execute([
                    $_POST['diagnosis'],
                    $_POST['treatment'],
                    $_POST['notes'],
                    $_POST['record_id'],
                    $user['id']
                ]);
                $_SESSION['success'] = "Medical record updated successfully";
                break;
        }
    } catch(PDOException $e) {
        error_log("Error: " . $e->getMessage());
        $_SESSION['error'] = "An error occurred. Please try again.";
    }
    header('Location: medical_records.php');
    exit();
}

// Fetch medical records
try {
    $stmt = $pdo->prepare("
        SELECT mr.*, p.name as patient_name, p.date_of_birth
        FROM medical_records mr
        JOIN patients p ON mr.patient_id = p.id
        WHERE mr.doctor_id = ?
        ORDER BY mr.date_created DESC
    ");
    $stmt->execute([$user['id']]);
    $medical_records = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    error_log("Error fetching records: " . $e->getMessage());
    $medical_records = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medical Records - CareConnect</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .medical-record-card {
            transition: transform 0.2s;
            border-left: 4px solid #3498db;
        }

        .medical-record-card:hover {
            transform: translateX(5px);
        }

        .record-header {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .search-box {
            position: relative;
            margin-bottom: 20px;
        }

        .search-box .form-control {
            padding-left: 40px;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .filter-section {
            background: #fff;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8rem;
        }

        .record-actions {
            opacity: 0;
            transition: opacity 0.2s;
        }

        .medical-record-card:hover .record-actions {
            opacity: 1;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Include your navbar here -->

    <div class="container py-4">
        <div class="record-header d-flex justify-content-between align-items-center">
            <h2><i class="fas fa-notes-medical me-2"></i>Medical Records</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRecordModal">
                <i class="fas fa-plus me-2"></i>New Record
            </button>
        </div>

        <!-- Search and Filter Section -->
        <div class="filter-section">
            <div class="row">
                <div class="col-md-6">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" class="form-control" id="searchRecords" placeholder="Search records...">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex gap-2">
                        <select class="form-select" id="filterDate">
                            <option value="">Filter by Date</option>
                            <option value="today">Today</option>
                            <option value="week">This Week</option>
                            <option value="month">This Month</option>
                        </select>
                        <select class="form-select" id="filterStatus">
                            <option value="">Filter by Status</option>
                            <option value="active">Active</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Medical Records List -->
        <div class="row">
            <?php foreach ($medical_records as $record): ?>
            <div class="col-12 mb-3">
                <div class="card medical-record-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="card-title"><?php echo htmlspecialchars($record['patient_name']); ?></h5>
                                <p class="text-muted mb-2">
                                    <small>
                                        <i class="fas fa-calendar-alt me-2"></i>
                                        <?php echo date('F j, Y', strtotime($record['date_created'])); ?>
                                    </small>
                                </p>
                            </div>
                            <div class="record-actions">
                                <button class="btn btn-sm btn-outline-primary me-2" 
                                        onclick="editRecord(<?php echo $record['id']; ?>)">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-info" 
                                        onclick="viewRecord(<?php echo $record['id']; ?>)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mt-3">
                            <h6>Diagnosis:</h6>
                            <p><?php echo nl2br(htmlspecialchars($record['diagnosis'])); ?></p>
                            <h6>Treatment:</h6>
                            <p><?php echo nl2br(htmlspecialchars($record['treatment'])); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Add Record Modal -->
    <div class="modal fade" id="addRecordModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Medical Record</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addRecordForm" method="POST">
                        <input type="hidden" name="action" value="add">
                        
                        <div class="mb-3">
                            <label class="form-label">Patient</label>
                            <select class="form-select" name="patient_id" required>
                                <option value="">Select Patient</option>
                                <!-- Add PHP to populate patients -->
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Diagnosis</label>
                            <textarea class="form-control" name="diagnosis" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Treatment</label>
                            <textarea class="form-control" name="treatment" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Additional Notes</label>
                            <textarea class="form-control" name="notes" rows="2"></textarea>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save Record</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Record Modal -->
    <div class="modal fade" id="viewRecordModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Medical Record Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Content will be loaded dynamically -->
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Function to handle record editing
        function editRecord(recordId) {
            // Implement edit functionality
            console.log('Editing record:', recordId);
        }

        // Function to handle record viewing
        function viewRecord(recordId) {
            // Implement view functionality
            console.log('Viewing record:', recordId);
        }

        // Search functionality
        document.getElementById('searchRecords').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const records = document.querySelectorAll('.medical-record-card');
            
            records.forEach(record => {
                const text = record.textContent.toLowerCase();
                record.closest('.col-12').style.display = 
                    text.includes(searchTerm) ? 'block' : 'none';
            });
        });

        // Filter functionality
        document.getElementById('filterDate').addEventListener('change', function(e) {
            // Implement date filtering
        });

        document.getElementById('filterStatus').addEventListener('change', function(e) {
            // Implement status filtering
        });
    </script>
</body>
</html> 