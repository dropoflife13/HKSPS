<?php
require_once __DIR__ . '/../modals/department.php';

// Fetch all departments first
$departments = $conn->query("SELECT * FROM departments ORDER BY id ASC");

$totalDepartments = $conn->query("SELECT COUNT(*) as count FROM departments")->fetch_assoc()['count'];
$totalStudents = $conn->query("SELECT COUNT(*) as count FROM users WHERE role='student'")->fetch_assoc()['count'];
$totalFaculty = $conn->query("SELECT COUNT(*) as count FROM users WHERE role='teacher'")->fetch_assoc()['count'];
$totalCourses = $conn->query("SELECT COUNT(*) as count FROM courses")->fetch_assoc()['count'];



showDepartmentModals();
?>
    <style>
       
        
        .stat-card {
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }

    </style>
<div class="px-6 py-6">
    <!-- Page Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Department Management</h1>
            <p class="text-gray-600 mt-2">Manage all academic departments and their details</p>
        </div>
    </div>

    <!-- Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Departments -->
    <div class=" stat-card bg-white p-5 rounded-2xl shadow-lg border border-gray-100 flex items-center gap-4">
        <div class="p-3 rounded-full bg-blue-100">
            <i class="fas fa-university text-blue-600 text-2xl"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Departments</p>
            <p class="text-2xl font-bold text-gray-900">
                <?= $totalDepartments ?? '0' ?>
            </p>
        </div>
    </div>

    <!-- Total Students -->
    <div class=" stat-card bg-white p-5 rounded-2xl shadow-lg border border-gray-100 flex items-center gap-4">
        <div class="p-3 rounded-full bg-green-100">
            <i class="fas fa-users text-green-600 text-2xl"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Students</p>
            <p class="text-2xl font-bold text-gray-900">
                <?= $totalStudents ?? '0' ?>
            </p>
        </div>
    </div>

    <!-- Total Faculty -->
    <div class=" stat-card bg-white p-5 rounded-2xl shadow-lg border border-gray-100 flex items-center gap-4">
        <div class="p-3 rounded-full bg-purple-100">
            <i class="fas fa-chalkboard-teacher text-purple-600 text-2xl"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Faculty</p>
            <p class="text-2xl font-bold text-gray-900">
                <?= $totalFaculty ?? '0' ?>
            </p>
        </div>
    </div>

    <!-- Total Courses -->
    <div class="stat-card bg-white p-5 rounded-2xl shadow-lg border border-gray-100 flex items-center gap-4">
        <div class="p-3 rounded-full bg-teal-100">
            <i class="fas fa-book-open text-teal-600 text-2xl"></i>
        </div>
        <div>
            <p class="text-sm font-medium text-gray-500 uppercase tracking-wide">Total Courses</p>
            <p class="text-2xl font-bold text-gray-900">
                <?= $totalCourses ?? '0' ?>
            </p>
        </div>
    </div>
</div>

    <!-- Department Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php
        $departments->data_seek(0); // reset pointer if needed

        $departmentImages = [
            'CAS' => './assets/img/cas.png',
            'CBA' => './assets/img/cba.png',
            'CCJE' => './assets/img/ccje.png',
            'CITE' => './assets/img/cite.png',
            'CNAHS' => './assets/img/cnahs.png',
            'COE' => './assets/img/coe.png',
            'COM' => './assets/img/com.png',
            'CTED' => './assets/img/cted.png',
            'CAHS' => './assets/img/cahs.png',
            'COME' => './assets/img/come.png'
        ];

        $gradients = [
            'from-blue-500 to-blue-700',
            'from-green-500 to-green-700',
            'from-purple-500 to-purple-700',
            'from-teal-500 to-teal-700',
            'from-orange-500 to-orange-700',
            'from-pink-500 to-pink-700',
            'from-indigo-500 to-indigo-700',
            'from-red-500 to-red-700'
        ];
        $gradientIndex = 0;

        while ($dept = $departments->fetch_assoc()):
            $gradient = $gradients[$gradientIndex % count($gradients)];
            $gradientIndex++;

            $deptCode = strtoupper($dept['code']);
            $imageUrl = $departmentImages[$deptCode] ?? 'https://cdn-icons-png.flaticon.com/512/3635/3635441.png';
        ?>
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover border border-gray-100 transform transition duration-300 hover:scale-105">
            <div class="bg-gradient-to-r <?php echo $gradient; ?> h-44 flex items-center justify-center relative">
                <img src="<?php echo $imageUrl; ?>" alt="<?php echo $dept['name']; ?>" class="w-36 h-36 object-contain">
                <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-40 text-white text-center py-2 font-semibold">
                    <?php echo $dept['code']; ?>
                </div>
            </div>
            <div class="p-5 flex flex-col justify-between h-52">
                <h3 class="text-lg font-semibold text-gray-900 truncate"><?php echo $dept['name']; ?></h3>
                <p class="text-sm text-gray-600 mb-4 line-clamp-3"><?php echo $dept['description'] ?: 'No description available.'; ?></p>
                <div class="flex justify-between mt-auto gap-2">
                    <button
                        onclick="openModal('editDeptModal<?= $dept['id'] ?>')"
                        class="bg-hk-green-600 hover:bg-hk-green-700 text-white px-3 py-2 rounded-lg shadow-sm text-sm flex-1 flex items-center justify-center">
                        <i class="fas fa-edit mr-2"></i> Edit
                    </button>
                    <button
                        onclick="openModal('deleteDeptModal<?= $dept['id'] ?>')"
                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded-lg shadow-sm text-sm flex-1 flex items-center justify-center">
                        <i class="fas fa-trash-alt mr-2"></i> Delete
                    </button>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<script>
function openModal(id) {
    const modal = document.getElementById(id);
    if(modal) modal.classList.remove('hidden');
}
function closeModal(id) {
    const modal = document.getElementById(id);
    if(modal) modal.classList.add('hidden');
}
</script>
