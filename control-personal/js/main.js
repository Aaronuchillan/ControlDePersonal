import { cargarPersonal } from './ui.js';

document.addEventListener('DOMContentLoaded', () => {
    const role = document.getElementById('session-data').dataset.role;
    const modal = document.getElementById('modal-personal');
    const btnAdd = document.getElementById('btn-add-person');
    const btnClose = document.querySelector('.close-modal');
    const form = document.getElementById('form-personal');

    // Cargar tabla al inicio
    cargarPersonal(role);

    // Abrir modal
    btnAdd?.addEventListener('click', () => {
        form.reset();
        document.getElementById('form-accion').value = "crear";
        modal.style.display = 'block';
    });

    // Cerrar modal
    btnClose.addEventListener('click', () => modal.style.display = 'none');

    // Enviar datos por AJAX (Sin recargar página)
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        
        const res = await fetch('gestion_personal.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await res.json();
        if(result.status === 'success') {
            modal.style.display = 'none';
            cargarPersonal(role); // Recargar solo la tabla
        } else {
            alert(result.msg);
        }
    });
});