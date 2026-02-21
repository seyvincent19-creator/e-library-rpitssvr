document.addEventListener("DOMContentLoaded", function () {
    const now = new Date();

    // ===== TIME (HH:MM:SS) =====
    const hours   = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    // const seconds = String(now.getSeconds()).padStart(2, '0');

    // const currentTime = `${hours}:${minutes}:${seconds}`;
    const currentTime = `${hours}:${minutes}`;

    document.getElementById("entryTime").value = currentTime;
    document.getElementById("exitTime").value  = currentTime;

    // ===== DATE (YYYY-MM-DD) =====
    const year  = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day   = String(now.getDate()).padStart(2, '0');

    const today = `${year}-${month}-${day}`;

    document.getElementById("entryDate").value = today;
});
