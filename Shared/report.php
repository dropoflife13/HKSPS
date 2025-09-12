<h2>📢 Submit a Report</h2>
<div id="report-msg"></div>
<form id="report-form">
    <input type="text" name="title" placeholder="Title" required class="w-full p-2 mb-2 border rounded">
    <textarea name="description" placeholder="Describe your issue" required class="w-full p-2 mb-2 border rounded"></textarea>
    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Submit</button>
</form>

<script>
document.getElementById('report-form').addEventListener('submit', function(e){
    e.preventDefault();
    const formData = new FormData(this);

    fetch('Shared/submit_report.php', { method: 'POST', body: formData })
        .then(res => res.json())
        .then(data => {
            const msgDiv = document.getElementById('report-msg');
            msgDiv.innerHTML = data.message;
            msgDiv.style.color = data.status === 'success' ? 'green' : 'red';
            if(data.status === 'success') this.reset();
        });
});
</script>
