// js/ui.js (Añadir estas funciones)

export async function cargarPersonal(role) {
    const response = await fetch('gestion_personal.php?accion=leer');
    const datos = await response.json();
    const tbody = document.getElementById('lista-personal-body');
    
    tbody.innerHTML = datos.map(p => `
        <tr>
            <td><img src="uploads/${p.foto}" class="img-thumb"></td>
            <td>${p.nombre} ${p.apellido}</td>
            <td>${p.telefono}</td>
            <td>${p.domicilio}</td>
            <td>
                ${role !== 'INVITADO' ? `<button class="btn-edit" onclick="editarPersona(${JSON.stringify(p).replace(/"/g, '&quot;')})">Editar</button>` : ''}
                ${role === 'ADMIN' ? `<button class="btn-delete" onclick="eliminarPersona(${p.id})">Eliminar</button>` : ''}
            </td>
        </tr>
    `).join('');
}

// Hacemos las funciones globales para que los botones onclick las vean
window.eliminarPersona = async (id) => {
    if(confirm('¿Seguro que quieres eliminar este registro?')) {
        await fetch(`gestion_personal.php?accion=eliminar&id=${id}`);
        location.reload(); // Recarga rápida para ver cambios
    }
}

window.editarPersona = (p) => {
    document.getElementById('modal-title').innerText = "Editar Personal";
    document.getElementById('form-accion').value = "actualizar";
    document.getElementById('form-id').value = p.id;
    document.getElementById('form-nombre').value = p.nombre;
    document.getElementById('form-apellido').value = p.apellido;
    document.getElementById('form-telefono').value = p.telefono;
    document.getElementById('form-domicilio').value = p.domicilio;
    document.getElementById('modal-personal').style.display = 'block';
}