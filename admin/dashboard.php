<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: ../login/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Dashboard - Admin Panel</title>
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/main.css" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .sidebar { height: 100vh; position: fixed; z-index: 1030; }
        .sidebar-nav .nav-link { color: #495057; padding: 12px 20px; border-radius: 8px; margin: 4px 8px; }
        .sidebar-nav .nav-link:hover, .sidebar-nav .nav-link.active { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .main-content { margin-left: 280px; padding: 80px 20px 20px; }
        @media (max-width: 992px) { .sidebar { transform: translateX(-100%); } .main-content { margin-left: 0; } }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar bg-light border-end shadow-sm">
        <div class="p-4 border-bottom">
            <h4 class="text-primary mb-0">Admin Panel</h4>
            <small>Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? 'Admin'); ?></small>
        </div>
        <nav class="sidebar-nav p-3">
            <a class="nav-link active" href="dashboard.php">
                <i class="bi bi-house-door me-2"></i> Dashboard
            </a>
            <a class="nav-link" href="users.php">
                <i class="bi bi-people me-2"></i> Users
            </a>
            <a class="nav-link" href="orders.php">
                <i class="bi bi-cart me-2"></i> Orders
            </a>
            <a class="nav-link" href="products.php">
                <i class="bi bi-box me-2"></i> Products
            </a>
            <a class="nav-link" href="analytics.php">
                <i class="bi bi-graph-up me-2"></i> Analytics
            </a>
            <a class="nav-link" href="settings.php">
                <i class="bi bi-gear me-2"></i> Settings
            </a>
            <hr>
            <form method="post" class="d-inline">
                <button type="submit" name="logout" class="nav-link text-danger border-0 bg-transparent w-100 text-start">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </button>
            </form>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Dashboard</h2>
            <a href="../index.php" class="btn btn-outline-primary">
                <i class="bi bi-globe me-1"></i> View Site
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-5">
            <div class="col-xl-3 col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Total Users</h6>
                                <h3 class="text-primary mb-0">1,234</h3>
                            </div>
                            <i class="bi bi-people fs-1 opacity-25"></i>
                        </div>
                        <small class="text-success"><i class="bi bi-arrow-up"></i> 12% from last month</small>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Total Orders</h6>
                                <h3 class="text-success mb-0">2,567</h3>
                            </div>
                            <i class="bi bi-cart fs-1 opacity-25"></i>
                        </div>
                        <small class="text-success"><i class="bi bi-arrow-up"></i> 8% increase</small>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Revenue</h6>
                                <h3 class="text-info mb-0">$45,678</h3>
                            </div>
                            <i class="bi bi-currency-dollar fs-1 opacity-25"></i>
                        </div>
                        <small class="text-success"><i class="bi bi-arrow-up"></i> 15% growth</small>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Pending Tasks</h6>
                                <h3 class="text-warning mb-0">12</h3>
                            </div>
                            <i class="bi bi-check-circle fs-1 opacity-25"></i>
                        </div>
                        <small class="text-danger"><i class="bi bi-arrow-down"></i> 3 new today</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts & Recent Activity -->
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0">Sales Overview (Placeholder Chart)</h6>
                    </div>
                    <div class="card-body p-4">
                        <canvas id="salesChart" height="100"></canvas>
                        <p class="text-muted mt-3">Interactive chart would go here. Data: Jan: $12k, Feb: $15k, Mar: $18k...</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white border-bottom">
                        <h6 class="mb-0">Recent Activity</h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex mb-3 p-2 border-bottom">
                            <div class="flex-shrink-0">
                                <i class="bi bi-person-plus text-primary fs-5"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <small class="text-muted">New user registered</small><br>
                                <span class="fw-bold">john.doe@example.com</span>
                            </div>
                        </div>
                        <div class="d-flex mb-3 p-2 border-bottom">
                            <div class="flex-shrink-0">
                                <i class="bi bi-cart-check text-success fs-5"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <small class="text-muted">Order #ORD-1234</small><br>
                                <span class="fw-bold">$89.99</span>
                            </div>
                        </div>
                        <div class="d-flex p-2">
                            <div class="flex-shrink-0">
                                <i class="bi bi-gear text-warning fs-5"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <small class="text-muted">Homepage updated</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Sidebar toggle for mobile
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            // Simple chart (placeholder)
            const ctx = document.getElementById('salesChart');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                    datasets: [{
                        label: 'Sales',
                        data: [12000, 15000, 18000, 16000, 22000],
                        borderColor: '#667eea',
                        tension: 0.4
                    }]
                },
                options: { responsive: true, plugins: { legend: { display: false } } }
            });
        });
    </script>
</body>
</html>
<?php
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: ../login/login.php');
    exit;
}
?>

