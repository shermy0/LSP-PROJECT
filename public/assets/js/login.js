let selectedRole = null;

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.role-option').forEach(item => {
        item.addEventListener('click', function () {
            document.querySelectorAll('.role-option').forEach(el => el.classList.remove('active'));
            this.classList.add('active');
            selectedRole = this.getAttribute('data-role');
        });
    });

    document.getElementById('continueRole').addEventListener('click', function () {
        if (selectedRole) {
            if (selectedRole === "asesi") {
                window.location.href = "/register/asesi";
            } else if (selectedRole === "asesor") {
                window.location.href = "/register/asesor";
            }
        } else {
            alert("Pilih salah satu peran terlebih dahulu!");
        }
    });
});
