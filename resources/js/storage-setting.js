export function listenForStorageToggleChange() {
    document.addEventListener('DOMContentLoaded', function () {
        const storageToggle = document.getElementById('storage-toggle');

        if (storageToggle) {
            storageToggle.addEventListener('change', function () {
                fetch('/admin/dashboard/storage-mode', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_storage_setting_token"]').value,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        mode: this.value,
                    }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        alert(data.message);
                        location.reload();
                    })
                    .catch((error) => console.error('Error:', error));
            });
        }
    });
}

