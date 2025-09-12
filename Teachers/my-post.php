<?php
$teacherId = $_SESSION['user_id'];

$stmt = $conn->prepare("
 SELECT jp.*, 
       d.code AS department_code,
       (SELECT COUNT(*) 
        FROM applications a 
        WHERE a.job_id = jp.id AND a.status = 'approved') AS accepted_applicants
FROM job_postings jp
LEFT JOIN departments d ON jp.department_id = d.id
WHERE jp.posted_by_id = ?
ORDER BY jp.posted_date DESC

");
$stmt->bind_param("i", $teacherId);
$stmt->execute();
$result = $stmt->get_result();
$duties = $result->fetch_all(MYSQLI_ASSOC);

$alertMessage = '';
$alertType = 'success';

if (isset($_GET['success'])) {
    $alertMessage = 'Duty created successfully!';
    $alertType = 'success';
} elseif (isset($_GET['error'])) {
    $alertMessage = 'Error: ' . htmlspecialchars($_GET['error']);
    $alertType = 'error';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Duty Management System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Pass PHP data to JavaScript
        const phpDuties = <?php echo json_encode($duties); ?>;
        
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563eb',
                        secondary: '#8b5cf6',
                        dark: '#1f2937',
                        light: '#f9fafb'
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background: #f3f4f6;
            transition: all 0.3s ease;
        }
        
        .duty-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .duty-card:hover {
            transform: translateY(-5px);
        }
        
        .status-badge {
            transition: background-color 0.3s ease;
        }
        
        .action-btn {
            transition: all 0.2s ease;
        }
        
        .action-btn:hover {
            transform: scale(1.05);
        }
        
        .stats-card {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            color: white;
            border-radius: 12px;
            overflow: hidden;
        }
        
        .pagination-btn {
            transition: all 0.2s ease;
        }
        
        .pagination-btn:hover:not(.disabled) {
            background-color: #e5e7eb;
        }
        
        .filter-btn.active {
            background-color: #2563eb;
            color: white;
        }
        
        /* Animation for alerts */
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        .alert-slide {
            animation: slideIn 0.3s ease forwards;
        }
        
        /* Modal styles */
        .modal {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
        
        .modal-content {
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }
        
        .modal.open {
            opacity: 1;
            pointer-events: auto;
        }
        
        .modal.open .modal-content {
            transform: scale(1);
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen">
    <!-- Alert Notification -->
    <?php if ($alertMessage): ?>
    <div class="fixed top-4 right-4 z-50">
        <div class="<?= $alertType === 'success' ? 'bg-green-500' : 'bg-red-500' ?> text-white px-6 py-4 rounded-lg shadow-lg">
            <?= $alertMessage ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="fixed top-4 right-4 z-50 hidden" id="alert">
        <div class="bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center alert-slide">
            <i class="fas fa-check-circle mr-3"></i>
            <span id="alert-message">Operation completed successfully!</span>
        </div>
    </div>

    <!-- Create/Edit Duty Modal -->
<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-40 opacity-0 pointer-events-none modal" id="dutyModal">
    <div class="modal-content bg-white rounded-lg shadow-xl p-4 max-w-md w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-lg font-semibold text-gray-800" id="modalTitle">Create New Duty</h3>
            <button class="text-gray-500 hover:text-gray-700 text-sm" onclick="closeModal('dutyModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="dutyForm" method="POST">
            <input type="hidden" name="id" id="dutyId">
            
                
                <div class="grid grid-cols-2 gap-3">
                    <div class="col-span-2">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Title</label>
                        <input type="text" name="title" id="title" required class="w-full px-3 py-1.5 text-sm border rounded-md">
                    </div>

                    <div class="col-span-2">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Description</label>
                        <textarea name="description" id="description" rows="2" required class="w-full px-3 py-1.5 text-sm border rounded-md"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Department</label>
                        <select name="department_id" id="department" required class="w-full px-3 py-1.5 text-sm border rounded-md">
                            <option value="">Select Department</option>
                            <?php
                          $deptResult = $conn->query("SELECT id, code FROM departments");
while ($dept = $deptResult->fetch_assoc()) {
    echo "<option value='{$dept['id']}'>{$dept['code']}</option>";
}

                            ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Status</label>
                        <select name="status" id="status" required class="w-full px-3 py-1.5 text-sm border rounded-md">
                            <option value="open">Open</option>
                            <option value="closed">Closed</option>
                            <option value="filled">Filled</option>
                        </select>
                    </div>
                    
                    <div class="col-span-2">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Requirements</label>
                        <textarea name="requirements" id="requirements" rows="2" class="w-full px-3 py-1.5 text-sm border rounded-md"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Schedule</label>
                        <input type="text" name="schedule" id="schedule" required class="w-full px-3 py-1.5 text-sm border rounded-md">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Location</label>
                        <input type="text" name="location" id="location" class="w-full px-3 py-1.5 text-sm border rounded-md">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Max Applicants</label>
                        <input type="number" name="max_applicants" id="max_applicants" min="1" class="w-full px-3 py-1.5 text-sm border rounded-md" value="1">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Deadline</label>
                        <input type="date" name="deadline" id="deadline" class="w-full px-3 py-1.5 text-sm border rounded-md">
                    </div>
                </div>

              <div class="mt-4 flex justify-end space-x-2">
                <button type="button" class="px-3 py-1.5 text-xs border rounded-md" onclick="closeModal('dutyModal')">Cancel</button>
                <button type="submit" id="dutySubmitBtn" class="px-3 py-1.5 text-xs bg-blue-600 text-white rounded-md">
                    Save Duty
                </button>
            </div>
        </form>
    </div>
</div>      
    <!-- Main Content -->
<div class="max-w-7xl mx-auto p-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 bg-white p-6 rounded-2xl shadow-md border border-gray-200">
        <div class="mb-4 md:mb-0">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">My Duties</h1>
            <p class="text-gray-500 mt-1 text-sm md:text-base">Manage and track your job postings for students effectively</p>
        </div>
        <button onclick="openCreateModal()"
            class="flex items-center justify-center bg-gradient-to-r from-hk-green-500 to-hk-green-600 hover:from-hk-green-600 hover:to-hk-green-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg transition-all duration-300">
            <i class="fas fa-plus mr-2"></i> Create Duty
        </button>
    </div>
</div>

        <!-- Stats Overview -->
         
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="stats-card p-6" style="background: linear-gradient(135deg, #1a5d8bff 0%, #09484fff 100%);">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-semibold">Total Duties</h3>
                        <p class="text-3xl font-bold mt-2" id="total-duties">0</p>
                    </div>
                    <div class="bg-white bg-opacity-20 p-3 rounded-full">
                        <i class="fas fa-tasks text-xl"></i>
                    </div>
                </div>
                <p class="text-sm mt-3 opacity-90"><i class="fas fa-arrow-up mr-1"></i> <span id="total-change">0</span> from last week</p>
            </div>
            
            <div class="stats-card p-6" style="background: linear-gradient(135deg, #07622bff 0%, #083a13ff 100%);">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-semibold">Open Duties</h3>
                        <p class="text-3xl font-bold mt-2" id="open-duties">0</p>
                    </div>
                    <div class="bg-white bg-opacity-20 p-3 rounded-full">
                        <i class="fas fa-door-open text-xl"></i>
                    </div>
                </div>
                <p class="text-sm mt-3 opacity-90"><i class="fas fa-arrow-down mr-1"></i> <span id="open-change">0</span> from last week</p>
            </div>
            
            <div class="stats-card p-6" style="background: linear-gradient(135deg, #27978aff 0%, #0a4e48ff 100%);">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-lg font-semibold">Filled Positions</h3>
                        <p class="text-3xl font-bold mt-2" id="filled-duties">0</p>
                    </div>
                    <div class="bg-white bg-opacity-20 p-3 rounded-full">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                </div>
                <p class="text-sm mt-3 opacity-90"><i class="fas fa-arrow-up mr-1"></i> <span id="filled-change">0</span> from last week</p>
            </div>
        </div>
        
        <!-- Duties Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="duties-container">
            <!-- Duties will be dynamically inserted here -->
        </div>

        <!-- Empty State -->
        <div id="empty-state" class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg shadow-sm text-center hidden">
            <i class="fas fa-clipboard-list text-4xl mb-3 text-blue-500"></i>
            <h3 class="text-xl font-semibold mb-2">No duties found</h3>
            <p class="text-blue-600">Get started by creating your first duty assignment.</p>
            <button onclick="openCreateModal()" class="mt-4 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                Create Your First Duty
            </button>
        </div>
    </div>

    <script>
    // Use the PHP data passed to JavaScript
    let duties = phpDuties;
    let currentFilter = 'all';
    let currentDutyId = null;

    // Initialize the page
    document.addEventListener('DOMContentLoaded', function() {
        renderDuties();
        updateStats();
    });

    // Render duties based on current filter
    function renderDuties() {
        const container = document.getElementById('duties-container');
        const emptyState = document.getElementById('empty-state');
        
        container.innerHTML = '';

        const filteredDuties = duties.filter(duty => {
            if (currentFilter === 'all') return true;
            return duty.status === currentFilter;
        });

        if (filteredDuties.length === 0) {
            container.classList.add('hidden');
            emptyState.classList.remove('hidden');
            return;
        }

        container.classList.remove('hidden');
        emptyState.classList.add('hidden');

        filteredDuties.forEach(duty => {
            const dutyCard = document.createElement('div');
     dutyCard.className = 'duty-card bg-white border border-gray-100 rounded-2xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl hover:-translate-y-1';
dutyCard.innerHTML = `
    <!-- Header with gradient background -->    
    <div class="bg-gradient-to-r from-emerald-900 to-green-600 px-5 py-4 text-white">
        <div class="flex justify-between items-start mb-2">
            <h2 class="text-xl font-bold tracking-tight">${duty.title}</h2>
            <span class="text-xs font-semibold bg-white/40 backdrop-blur-sm px-2 py-1 rounded-full">${duty.department_code}</span>
        </div>
        <div class="flex items-center">
            <span class="status-badge text-xs px-3 py-1 rounded-full font-semibold backdrop-blur-sm ${duty.status === 'open' ? 'bg-emerald-100/90 text-emerald-900' : duty.status === 'closed' ? 'bg-rose-100/90 text-rose-900' : 'bg-blue-100/90 text-blue-900'}">
                ${duty.status.charAt(0).toUpperCase() + duty.status.slice(1)}
            </span>
            
        </div>
    </div>

  <!-- Content Section -->
<div class="p-4">
    <!-- Description -->
    <div class="mb-4">
        <p class="text-gray-900 text-base font-semibold leading-relaxed bg-gray-50/60 p-3 rounded-lg border border-gray-100">
            ${duty.description}
        </p>
    </div>

    <!-- Thick Separator Line -->
  <div class="my-4 border-t-2 border-gray-300 rounded w-full"></div> <!-- full width -->

    <!-- Details Grid -->
    <div class="grid grid-cols-2 gap-4">
        <!-- Your detail items go here -->
    </div>
</div>

        <ul class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
            <li class="flex flex-col gap-1 p-2 bg-gray-50/50 rounded-md border border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-full bg-indigo-100 flex items-center justify-center">
                        <i class="fas fa-list-check text-indigo-600 text-xs"></i>
                    </div>
                    <span class="font-semibold text-gray-800 text-xs">Requirements</span>
                </div>
                <span class="ml-8 text-gray-600 text-xs">${duty.requirements || 'None specified'}</span>
            </li>
            
            <li class="flex flex-col gap-1 p-2 bg-gray-50/50 rounded-md border border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-full bg-purple-100 flex items-center justify-center">
                        <i class="fas fa-clock text-purple-600 text-xs"></i>
                    </div>
                    <span class="font-semibold text-gray-800 text-xs">Schedule</span>
                </div>
                <span class="ml-8 text-gray-600 text-xs">${duty.schedule}</span>
            </li>
            
            <li class="flex flex-col gap-1 p-2 bg-gray-50/50 rounded-md border border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-full bg-red-100 flex items-center justify-center">
                        <i class="fas fa-map-marker-alt text-red-600 text-xs"></i>
                    </div>
                    <span class="font-semibold text-gray-800 text-xs">Location</span>
                </div>
                <span class="ml-8 text-gray-600 text-xs">${duty.location || 'Not specified'}</span>
            </li>
            
            <li class="flex flex-col gap-1 p-2 bg-gray-50/50 rounded-md border border-gray-100">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-full bg-teal-100 flex items-center justify-center">
                        <i class="fas fa-user-check text-teal-600 text-xs"></i>
                    </div>
                    <span class="font-semibold text-gray-800 text-xs">Accepted</span>
                </div>
                <span class="ml-8 text-gray-600 text-xs">${duty.accepted_applicants || 0}/${duty.max_applicants}</span>
            </li>
        </ul>
    </div>
<!-- Footer with Deadline and Actions -->
<div class="px-4 py-3 bg-gradient-to-r from-gray-50 to-gray-100 border-t-2 border-gray-300 flex flex-col sm:flex-row justify-between items-center gap-3">
    <!-- Simple thick separator line -->
    <div class="absolute left-0 right-0 -top-1.5 h-1.5 bg-gradient-to-r from-transparent via-gray-500 "></div>

        <!-- Deadline -->
        <div class="flex items-center gap-2 text-xs text-gray-700 bg-white px-3 py-2 rounded-lg shadow-sm border border-gray-200/60 relative">
            <!-- Left accent line -->
            <div class="absolute -left-1.5 top-1/2 transform -translate-y-1/2 w-1.5 h-10 bg-gradient-to-b from-orange-400 to-orange-500 rounded-full"></div>
            
            <div class="w-6 h-6 rounded-full bg-orange-100 flex items-center justify-center">
                <i class="fas fa-calendar-day text-orange-600 text-xs"></i>
            </div>
            <div>
                <span class="font-semibold">Deadline: </span>
                <span class="text-gray-600">${new Date(duty.deadline).toLocaleDateString()}</span>
            </div>
        </div>
        
        <!-- Vertical separator line for larger screens -->
        <div class="hidden sm:block h-6 w-px bg-gradient-to-b from-gray-300 to-transparent mx-1"></div>
        
        <!-- Horizontal separator line for mobile -->
        <div class="sm:hidden w-full h-px bg-gradient-to-r from-transparent via-gray-300 to-transparent my-1"></div>
        
        <!-- Action Buttons -->
     
         
            <div class="absolute -left-2 top-1/2 transform -translate-y-1/2 w-2 h-px bg-gray-300"></div>
            
            <button class="action-btn bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-3 py-1.5 text-xs rounded-lg shadow-md transition-all duration-200 hover:scale-105 flex items-center gap-1 group relative overflow-hidden" onclick="openEditModal(${duty.id})">
                <!-- Button top line accent -->
                <div class="absolute top-0 left-0 right-0 h-0.5 bg-blue-400/50"></div>
                <i class="fas fa-edit text-xs transition-transform group-hover:rotate-12"></i> 
                <span class="text-xs">Edit</span>
            </button>
            
            <button class="action-btn bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-3 py-1.5 text-xs rounded-lg shadow-md transition-all duration-200 hover:scale-105 flex items-center gap-1 group relative overflow-hidden" onclick="confirmDelete(${duty.id})">
                <!-- Button top line accent -->
                <div class="absolute top-0 left-0 right-0 h-0.5 bg-red-400/50"></div>
                <i class="fas fa-trash text-xs transition-transform group-hover:rotate-12"></i> 
                <span class="text-xs">Delete</span>
            </button>
        </div>
    </div>
`;
container.appendChild(dutyCard);    

        });
    }

    // Update statistics
    function updateStats() {
        const total = duties.length;
        const open = duties.filter(d => d.status === 'open').length;
        const filled = duties.filter(d => d.status === 'filled').length;
        
        document.getElementById('total-duties').textContent = total;
        document.getElementById('open-duties').textContent = open;
        document.getElementById('filled-duties').textContent = filled;

        document.getElementById('total-change').textContent = '+2';
        document.getElementById('open-change').textContent = '-1';
        document.getElementById('filled-change').textContent = '+3';
    }

    // Open create modal
   function openCreateModal() {
    document.getElementById('modalTitle').textContent = 'Create New Duty';
    document.getElementById('dutySubmitBtn').textContent = 'Create Duty';
    document.getElementById('dutyForm').reset();
    document.getElementById('dutyId').value = '';
    openModal('dutyModal');
}

    // Open edit modal
 // Open edit modal
function openEditModal(id) {
    const duty = duties.find(d => d.id == id);
    if (duty) {
        document.getElementById('modalTitle').textContent = 'Edit Duty';
        document.getElementById('dutySubmitBtn').textContent = 'Update Duty';
        document.getElementById('dutyId').value = duty.id;
        document.getElementById('title').value = duty.title;
        document.getElementById('description').value = duty.description;
        document.getElementById('department').value = duty.department_id;
        document.getElementById('status').value = duty.status;
        document.getElementById('requirements').value = duty.requirements || '';
        document.getElementById('schedule').value = duty.schedule;
        document.getElementById('location').value = duty.location || '';
        document.getElementById('max_applicants').value = duty.max_applicants;
        document.getElementById('deadline').value = duty.deadline;
        openModal('dutyModal');
    }
}

  function confirmDelete(id) {
    if (!confirm("Are you sure you want to delete this duty?")) return;

    fetch(`./Teachers/duties/delete-duty.php?id=${id}`, {
        method: 'GET'
    })
    .then(response => {
        if (!response.ok) throw new Error("Network response was not ok");
        return response.text();
    })
    .then(data => {
        // Remove duty from JS array
        duties = duties.filter(d => d.id !== id);

        // Re-render and update stats
        renderDuties();
        updateStats();

        showAlert("Duty deleted successfully!");
    })
    .catch(error => {
        console.error("Error deleting duty:", error);
        showAlert("Error deleting duty.");
    });
}


    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.add('open');
        modal.classList.remove('opacity-0', 'pointer-events-none');
    }

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.classList.remove('open');
        modal.classList.add('opacity-0', 'pointer-events-none');
    }

    function showAlert(message) {
        const alert = document.getElementById('alert');
        const alertMessage = document.getElementById('alert-message');
        
        alertMessage.textContent = message;
        alert.classList.remove('hidden');
        
        setTimeout(() => {
            alert.classList.add('hidden');
        }, 3000);
    }

    // Handle form submission
document.getElementById('dutyForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const dutyId = document.getElementById('dutyId').value;

    // Decide whether to create or update
    let url = dutyId 
        ? './Teachers/duties/update-duty.php' 
        : './Teachers/duties/create-duty.php';

    fetch(url, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert(dutyId ? 'Duty updated successfully!' : 'Duty created successfully!');
            closeModal('dutyModal');

            if (dutyId) {
                // Update existing duty in array
                const index = duties.findIndex(d => d.id == dutyId);
                if (index !== -1) duties[index] = data.duty;
            } else {
                // Add new duty
                duties.unshift(data.duty);
            }

            renderDuties();
            updateStats();
        } else {
            showAlert('Error: ' + data.error);
        }
    })
    .catch(err => {
        showAlert('Error submitting duty');
        console.error(err);
    });
});
    </script>
</body>
</html>