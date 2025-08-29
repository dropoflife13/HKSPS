<?php
// Ensure session is started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
    Reusable modal function
    Usage: showModal($id, $title, $content, $buttons)
*/
function showModal($id, $title, $content, $buttons = []) { ?>
    <div id="<?= $id ?>" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-800"><?= $title ?></h3>
                <button onclick="closeModal('<?= $id ?>')" class="text-gray-500 hover:text-gray-700">&times;</button>
            </div>
            <div class="modal-body space-y-4"><?= $content ?></div>
            <?php if (!empty($buttons)) : ?>
                <div class="flex justify-end space-x-2 mt-4">
                    <?php foreach($buttons as $btn): ?>
                        <button 
                            type="<?= $btn['type'] ?? 'button' ?>" 
                            class="<?= $btn['class'] ?? 'bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded' ?>" 
                            id="<?= $btn['id'] ?? '' ?>"
                            <?= isset($btn['onclick']) ? "onclick=\"{$btn['onclick']}\"" : '' ?>>
                            <?= $btn['label'] ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php } ?>

<script>
function openModal(id) {
    const modal = document.getElementById(id);
    if(modal) modal.classList.remove('hidden');
}

function closeModal(id) {
    const modal = document.getElementById(id);
    if(modal) modal.classList.add('hidden');
}

// Close modal if click outside content
document.addEventListener('click', function(e){
    if(e.target.classList.contains('bg-black') && e.target.classList.contains('bg-opacity-30')){
        e.target.classList.add('hidden');
    }
});
</script>
