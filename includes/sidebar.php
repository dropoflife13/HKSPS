<!-- includes/sidebar.php -->
<!-- Sidebar -->
<nav class="col-md-2 d-none d-md-block bg-light sidebar vh-100">
    <div class="position-sticky pt-3 d-flex flex-column justify-content-between h-100">
        <div>
            <h4 class="text-center">Admin Panel</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage-departments.php">Manage Departments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reports.php">Reports</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="settings.php">Settings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="students.php">Students</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="teachers.php">Teachers</a>
                </li>
            </ul>
        </div>

        <!-- Logout Button -->
        <div class="text-center mb-3">
            <a href="../Auth/logout.php" class="btn btn-danger btn-sm w-75">Logout</a>
        </div>
    </div>
</nav>


<!-- Feather icons -->
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script>
    feather.replace()
</script>
