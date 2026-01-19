export const ROLES = {
    ADMIN: {
        label: "Administrador",
        permissions: ["ver_dashboard", "editar_usuarios", "borrar_todo"],
        color: "#dc2626"
    },
    SUPERVISOR: {
        label: "Supervisor",
        permissions: ["ver_dashboard", "editar_usuarios"],
        color: "#059669"
    },
    INVITADO: {
        label: "Invitado",
        permissions: ["ver_dashboard"],
        color: "#6b7280"
    }
};

export function hasPermission(role, permission) {
    return ROLES[role].permissions.includes(permission);
}