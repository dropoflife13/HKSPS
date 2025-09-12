<?php
$teacherId = $_SESSION['user_id'] ?? 0;

// Fetch filled (ongoing) duties posted by this teacher
$sql = "SELECT jp.id, jp.title, jp.description, jp.status, jp.posted_date, jp.deadline, jp.max_applicants
        FROM job_postings jp
        WHERE jp.posted_by_id = ? AND jp.status = 'filled'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $teacherId);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HAWAK KAMAY - Ongoing Duties</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        'hk-green': {
                            50: '#eff1ed',
                            100: '#f0fff1',
                            200: '#d8f3dc',
                            300: '#b7e4c7',
                            400: '#52b788',
                            500: '#40916c',
                            600: '#1b4332',
                            700: '#081c15',
                            800: '#071a14',
                            900: '#051611',
                        }
                    },
                    backgroundImage: {
                        'hk-gradient-text': 'linear-gradient(135deg, #081c15 0%, #40916c 100%)',
                        'hk-gradient-bg': 'linear-gradient(135deg, #081c15 0%, #40916c 100%)',
                        'table-header-gradient': 'linear-gradient(135deg, #f0fff1 0%, #d8f3dc 100%)',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 min-h-screen font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Ongoing Duties</h2>
            <p class="text-gray-600 mt-2">These duties have been filled and are currently in progress</p>
        </div>

        <!-- Ongoing Duties Table -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            <!-- Table Header -->
            <div class="bg-table-header-gradient px-6 py-4 border-b border-d8f3dc">
                <h3 class="text-lg font-semibold text-gray-800">Filled Duties</h3>
            </div>
            
            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 text-left text-gray-600 font-medium text-sm">
                            <th class="px-6 py-4">Title & Description</th>
                            <th class="px-6 py-4">Posted Date</th>
                            <th class="px-6 py-4">Deadline</th>
                            <th class="px-6 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php while($row = $result->fetch_assoc()): ?>
                        <tr class="bg-white hover:bg-green-50/30 transition-all duration-300 ease-in-out border-l-4 border-transparent hover:border-hk-green-500 hover:-translate-y-0.5 hover:shadow-md">
                            <td class="px-6 py-5">
                                <div class="flex items-start">
                                    <div class="bg-green-100 p-3 rounded-lg mr-4">
                                        <i class="fas fa-tasks text-green-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800"><?= htmlspecialchars($row['title']) ?></h4>
                                        <p class="text-gray-600 text-sm mt-1"><?= htmlspecialchars($row['description']) ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-gray-700"><?= $row['posted_date'] ?></div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="text-gray-700"><?= $row['deadline'] ?></div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800"><?= ucfirst($row['status']) ?></span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Empty State -->
            <?php if($result->num_rows === 0): ?>
            <div class="text-center py-12">
                <div class="mx-auto w-24 h-24 rounded-full bg-green-50 flex items-center justify-center mb-6">
                    <i class="fas fa-clipboard-list text-green-500 text-3xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No ongoing duties</h3>
                <p class="text-gray-500">You don't have any duties that are currently in progress.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // You can add any JavaScript functionality here if needed
    </script>
</body>
</html>