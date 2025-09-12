<?php if (in_array($tableType, ['teachers', 'students'])): ?>
  <!-- Table Header Section -->
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 px-1">
    <div class="flex flex-col">
      <h2 class="text-2xl md:text-3xl font-bold text-gray-900 tracking-tight">
        <?= $tableType === 'teachers' ? 'Teacher Directory' : 'Student Roster' ?>
      </h2>
      <p class="text-sm text-gray-600 mt-1">
        <?= $tableType === 'teachers' ? 'Manage faculty members and their details' : 'View and manage student information' ?>
      </p>
    </div>

    <!-- Add Teacher Button (Only for Teachers) -->
    <?php if ($tableType === 'teachers'): ?>
      <div class="flex gap-3 w-full sm:w-auto">
        <button class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg shadow-md transition-all duration-200 flex items-center justify-center font-medium hover:shadow-lg transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-50"
                onclick="openModal('addTeacherModal')">
          <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
          </svg>
          Add New Teacher
        </button>
      </div>
    <?php endif; ?>
  </div>
<?php endif; ?>

<!-- Teacher/Student Table -->
<div class="overflow-x-auto rounded-xl bg-white shadow-lg border border-gray-200">
  <table class="min-w-full divide-y divide-gray-200">
    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
      <tr>
        <?php foreach ($headers as $col => $label): ?>
          <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
            <?= htmlspecialchars($label) ?>
          </th>
        <?php endforeach; ?>
        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
      </tr>
    </thead>

    <tbody class="bg-white divide-y divide-gray-200">
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr class="hover:bg-blue-50 transition-colors duration-200 even:bg-gray-50/30">
            <?php foreach ($headers as $col => $label): ?>
              <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-700">
                <?php 
                  // Replace department_id with name for teachers
                  if ($tableType === 'teachers' && $col === 'department_id') {
                      echo htmlspecialchars($departments[$row['department_id']] ?? 'Unassigned');
                  } else {
                      echo htmlspecialchars($row[$col]);
                  }
                ?>
              </td>
            <?php endforeach; ?>

            <!-- Action Buttons -->
            <td class="px-6 py-4 whitespace-nowrap">
              <div class="flex items-center space-x-2">
                <?php if ($tableType === 'students'): ?>
                  <button class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1.5 rounded-md text-xs font-medium transition-all duration-200 shadow-sm hover:shadow-md flex items-center"
                          onclick="openModal('editStudentModal<?= $row['id'] ?>')">
                    Edit
                  </button>
                  <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-md text-xs font-medium transition-all duration-200 shadow-sm hover:shadow-md flex items-center"
                          onclick="openModal('deleteStudentModal<?= $row['id'] ?>')">
                    Delete
                  </button>
                <?php elseif ($tableType === 'teachers'): ?>
                  <button class="bg-amber-500 hover:bg-amber-600 text-white px-3 py-1.5 rounded-md text-xs font-medium transition-all duration-200 shadow-sm hover:shadow-md flex items-center"
                          onclick="openModal('editTeacherModal<?= $row['id'] ?>')">
                    Edit
                  </button>
                  <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-md text-xs font-medium transition-all duration-200 shadow-sm hover:shadow-md flex items-center"
                          onclick="openModal('deleteTeacherModal<?= $row['id'] ?>')">
                    Delete
                  </button>
                <?php else: ?>
                  <span class="text-gray-400 text-xs italic">No actions available</span>
                <?php endif; ?>
              </div>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="<?= count($headers) + 1 ?>" class="px-6 py-8 text-center">
            <div class="flex flex-col items-center justify-center text-gray-400">
              <p class="text-sm font-medium">No records found</p>
            </div>
          </td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<?php
// Call modal functions
if ($tableType === 'teachers') {
    showAddTeacherModal();
    showTeacherModals();
}
?>
