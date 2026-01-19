export async function cargarPersonal(role) {
  const response = await fetch("gestion_personal.php?accion=leer");
  const datos = await response.json();
  const tbody = document.getElementById("lista-personal-body");

  tbody.innerHTML = datos
    .map(
      (p) => `
    <tr>
        <td><img src="uploads/${p.foto}" class="img-thumb"></td>
        <td>
            <div style="font-weight: 700;">${p.nombre} ${p.apellido}</div>
        </td>
        <td style="color: var(--brand-color); font-family: monospace;">${p.telefono}</td>
        <td class="text-secondary">${p.domicilio}</td>
        <td style="text-align: center;">
            ${role !== "INVITADO" ? `<button class="btn-edit" onclick="editarPersona(${JSON.stringify(p).replace(/"/g, "&quot;")})">Editar</button>` : ""}
            ${role === "ADMIN" ? `<button class="btn-delete" onclick="eliminarPersona(${p.id})">Borrar</button>` : ""}
        </td>
    </tr>
`,
    )
    .join("");
}

// Hacemos las funciones globales para que los botones onclick las vean
window.eliminarPersona = async (id) => {
  if (confirm("¿Seguro que quieres eliminar este registro?")) {
    await fetch(`gestion_personal.php?accion=eliminar&id=${id}`);
    location.reload(); // Recarga rápida para ver cambios
  }
};

window.editarPersona = (p) => {
  document.getElementById("modal-title").innerText = "Editar Personal";
  document.getElementById("form-accion").value = "actualizar";
  document.getElementById("form-id").value = p.id;
  document.getElementById("form-nombre").value = p.nombre;
  document.getElementById("form-apellido").value = p.apellido;
  document.getElementById("form-telefono").value = p.telefono;
  document.getElementById("form-domicilio").value = p.domicilio;
  document.getElementById("modal-personal").style.display = "block";
};
