<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
    exit;
}

$page = $_GET['page'] ?? 'dashboard';
$username = $_SESSION['username'] ?? 'Admin';

if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: ../login/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Admin Panel - <?php echo ucfirst($page); ?></title>
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="../assets/css/main.css" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background: #f8f9ff; }
        .sidebar { min-height: 100vh; position: fixed; z-index: 1035; width: 260px; background: linear-gradient(180deg, #667eea 0%, #764ba2 100%); color: white; overflow-y: auto; transition: transform 0.3s; }
        .sidebar-header { padding: 24px 20px; border-bottom: 1px solid rgba(255,255,255,0.1); }
        .sidebar-nav { padding: 0 20px 20px; }
        .sidebar-nav .nav-link { color: rgba(255,255,255,0.9); padding: 14px 16px; border-radius: 12px; margin-bottom: 8px; transition: all 0.3s; display: flex; align-items: center; text-decoration: none; }
        .sidebar-nav .nav-link:hover, .sidebar-nav .nav-link.active { background: rgba(255,255,255,0.2); color: white; transform: translateX(4px); }
        .main-content { margin-left: 260px; min-height: 100vh; padding: 80px 30px 30px; transition: margin-left 0.3s; }
        .page-content { display: none; animation: fadeIn 0.4s ease-in; }
        .page-content.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .stat-card { border: none; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border-radius: 16px; transition: transform 0.3s, box-shadow 0.3s; }
        .stat-card:hover { transform: translateY(-4px); box-shadow: 0 12px 40px rgba(0,0,0,0.15); }
        @media (max-width: 992px) { .sidebar { transform: translateX(-100%); } .main-content { margin-left: 0; } .sidebar.show { transform: translateX(0); } }
        .toggle-sidebar { position: fixed; z-index: 1040; }
    </style>
</head>
<body>
    <!-- Mobile Sidebar Toggle -->
    <button class="btn btn-primary toggle-sidebar d-lg-none position-fixed" style="top:20px; left:20px; z-index:1041;" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </button>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header text-center">
            <h4 class="mb-1">Admin Panel</h4>
            <small class="opacity-75">Welcome, <strong><?php echo htmlspecialchars($username); ?></strong></small>
        </div>
        <nav class="sidebar-nav">
            <a href="#" class="nav-link active" data-page="dashboard"><i class="bi bi-house-door fs-5 me-3"></i>Dashboard</a>
            <a href="#" class="nav-link" data-page="users"><i class="bi bi-people fs-5 me-3"></i>Users</a>
            <a href="#" class="nav-link" data-page="orders"><i class="bi bi-cart fs-5 me-3"></i>Orders</a>
            <a href="#" class="nav-link" data-page="products"><i class="bi bi-box-seam fs-5 me-3"></i>Products</a>
            <a href="#" class="nav-link" data-page="analytics"><i class="bi bi-graph-up fs-5 me-3"></i>Analytics</a>
            <a href="#" class="nav-link" data-page="settings"><i class="bi bi-gear fs-5 me-3"></i>Settings</a>
            <hr class="my-3 opacity-25">
            <form method="post" class="d-inline-block w-100">
                <button type="submit" name="logout" class="nav-link text-danger border-0 bg-transparent w-100 text-start p-0">
                    <i class="bi bi-box-arrow-right fs-5 me-3"></i>Logout
                </button>
            </form>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Dashboard Page -->
        <div id="dashboard" class="page-content active">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <div>
                    <h1 class="display-5 fw-bold text-dark mb-1">Dashboard</h1>
                    <p class="text-muted mb-0">Welcome back! Here's what's happening with your store today.</p>
                </div>
                <a href="../index.php" class="btn btn-outline-primary btn-lg">
                    <i class="bi bi-eye me-2"></i>View Public Site
                </a>
            </div>

            <!-- Stats Grid -->
            <div class="row g-4 mb-5">
                <div class="col-xl-3 col-md-6">
                    <div class="card stat-card h-100 bg-gradient-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-2">Total Users</h6>
                                    <h2 class="mb-1">1,847</h2>
                                    <small><i class="bi bi-arrow-up-circle text-success"></i> 18% from last month</small>
                                </div>
                                <i class="bi bi-people fs-1 opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card stat-card h-100 bg-gradient-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-2">Orders</h6>
                                    <h2 class="mb-1">2,342</h2>
                                    <small><i class="bi bi-arrow-up-circle text-light"></i> 12% increase</small>
                                </div>
                                <i class="bi bi-bag fs-1 opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card stat-card h-100 bg-gradient-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-2">Revenue</h6>
                                    <h2 class="mb-1">$67,342</h2>
                                    <small><i class="bi bi-arrow-up-circle text-light"></i> 25% growth</small>
                                </div>
                                <i class="bi bi-currency-dollar fs-1 opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card stat-card h-100 bg-gradient-warning text-dark">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-2">Pending</h6>
                                    <h2 class="mb-1">34</h2>
                                    <small><i class="bi bi-exclamation-triangle text-danger"></i> 5 new</small>
                                </div>
                                <i class="bi bi-clock fs-1 opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts & Activity -->
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="card shadow-lg border-0">
                        <div class="card-header bg-white border-0 pb-0">
                            <h5 class="mb-0">Sales Analytics</h5>
                        </div>
                        <div class="card-body p-4">
                            <canvas id="salesChart" height="120"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card shadow-lg border-0 h-100">
                        <div class="card-header bg-white border-0">
                            <h6 class="mb-0">Recent Activity</h6>
                        </div>
                        <div class="card-body py-3">
                            <div class="activity-item d-flex align-items-center py-3 border-bottom">
                                <div class="activity-icon bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:40px;height:40px;">
                                    <i class="bi bi-person-plus fs-6"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">New user registered</small>
                                    <strong>john.doe@...</strong>
                                    <small class="text-muted d-block">2 min ago</small>
                                </div>
                            </div>
                            <div class="activity-item d-flex align-items-center py-3 border-bottom">
                                <div class="activity-icon bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:40px;height:40px;">
                                    <i class="bi bi-check-circle fs-6"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Order completed</small>
                                    <strong>#ORD-5678</strong>
                                    <small class="text-muted d-block">15 min ago</small>
                                </div>
                            </div>
                            <div class="activity-item d-flex align-items-center py-3">
                                <div class="activity-icon bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width:40px;height:40px;">
                                    <i class="bi bi-pencil fs-6"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Content updated</small>
                                    <strong>Homepage banner</strong>
                                    <small class="text-muted d-block">1 hr ago</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users Page (Placeholder) -->
        <div id="users" class="page-content">
            <h1 class="mb-4">Users Management</h1>
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>John Doe</td>
                                    <td>john@example.com</td>
                                    <td><span class="badge bg-success">Active</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary me-1">Edit</button>
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </td>
                                </tr>
                                <!-- More rows... -->
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-primary">+ Add New User</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Page -->
        <div id="orders" class="page-content">
            <h1 class="mb-4">Orders</h1>
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>#ORD-1234</td>
                                    <td>Jane Smith</td>
                                    <td>$89.99</td>
                                    <td><span class="badge bg-info">Processing</span></td>
                                    <td>2024-01-15</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-success">Ship</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Page -->
        <div id="products" class="page-content">
            <h1 class="mb-4">Products</h1>
            <p>Product management interface with add/edit/delete - ready for database integration.</p>
        </div>

        <!-- Analytics Page -->
        <div id="analytics" class="page-content">
            <h1 class="mb-4">Analytics</h1>
            <p>Advanced charts and reports section.</p>
            <canvas id="analyticsChart" height="200"></canvas>
        </div>

        <!-- Settings Page -->
        <div id="settings" class="page-content">
            <h1 class="mb-4">Settings</h1>
            <form>
                <div class="card shadow">
                    <div class="card-body">
                        <h6>Site Settings</h6>
                        <div class="mb-3">
                            <label class="form-label">Site Title</label>
                            <input type="text" class="form-control" value="PROJECT WSI">
                        </div>
                        <button class="btn btn-primary">Save Settings</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let currentPage = '<?php echo $page; ?>';
        
        // Load page
        function loadPage(page) {
            document.querySelectorAll('.page-content').forEach(p => p.classList.remove('active'));
            document.querySelectorAll('.nav-link').forEach(n => n.classList.remove('active'));
            document.getElementById(page).classList.add('active');
            document.querySelector(`[data-page="${page}"]`).classList.add('active');
            currentPage = page;
            window.history.pushState({}, '', `?page=${page}`);
            
            // Re-init charts if needed
            if (page === 'analytics') initAnalyticsChart();
        }

        // Sidebar toggle
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
        }

        // Navigation
        document.querySelectorAll('.nav-link[data-page]').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const page = link.dataset.page;
                loadPage(page);
            });
        });

        // Chart initialization
        function initSalesChart() {
            const ctx = document.getElementById('salesChart');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Sales',
                        data: [65000, 72000, 85000, 78000, 95000, 110000],
                        borderColor: '#667eea',
                        backgroundColor: 'rgba(102, 126, 234, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true } }
                }
            });
        }

        function initAnalyticsChart() {
            const ctx = document.getElementById('analyticsChart');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Desktop', 'Mobile', 'Tablet'],
                    datasets: [{
                        data: [55, 35, 10],
                        backgroundColor: ['#667eea', '#764ba2', '#f093fb']
                    }]
                }
            });
        }

        // Init
        document.addEventListener('DOMContentLoaded', () => {
            initSalesChart();
            if (currentPage === 'analytics') initAnalyticsChart();
            
            // Popstate for browser back/forward
            window.addEventListener('popstate', () => {
                const urlParams = new URLSearchParams(window.location.search);
                const page = urlParams.get('page') || 'dashboard';
                loadPage(page);
            });
        });

        // Close sidebar on outside click (mobile)
        document.addEventListener('click', (e) => {
            if (window.innerWidth < 992 && !e.target.closest('.sidebar') && !e.target.classList.contains('toggle-sidebar')) {
                document.getElementById('sidebar').classList.remove('show');
            }
        });
    </script>
</body>
</html>

