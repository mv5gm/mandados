import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Checkbox from '@/Components/Checkbox';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import Modal from '@/Components/Modal';
import PrimaryButton from '@/Components/PrimaryButton';
import SecondaryButton from '@/Components/SecondaryButton';
import TextInput from '@/Components/TextInput';
import { Head, router, useForm, usePage } from '@inertiajs/react';
import { useState } from 'react';

const permissionLabels = {
    'users.view': 'Ver usuarios',
    'users.create': 'Crear usuarios',
    'users.update': 'Editar usuarios',
    'users.delete': 'Eliminar usuarios',
    'roles.view': 'Ver roles',
    'roles.create': 'Crear roles',
    'roles.update': 'Editar roles',
    'roles.delete': 'Eliminar roles',
};

const groupLabels = {
    users: 'Usuarios',
    roles: 'Roles y permisos',
};

export default function Index({ roles, permissions }) {
    const { auth } = usePage().props;
    const can = (permission) => auth.permissions.includes(permission);

    const [isModalOpen, setIsModalOpen] = useState(false);
    const [editingRole, setEditingRole] = useState(null);

    const form = useForm({
        name: '',
        permissions: [],
    });

    const groupedPermissions = permissions.reduce((groups, permission) => {
        const group = permission.split('.')[0];
        groups[group] = [...(groups[group] ?? []), permission];

        return groups;
    }, {});

    const openCreateModal = () => {
        setEditingRole(null);
        form.reset();
        form.clearErrors();
        setIsModalOpen(true);
    };

    const openEditModal = (role) => {
        setEditingRole(role);
        form.setData({
            name: role.name,
            permissions: [...role.permissions],
        });
        form.clearErrors();
        setIsModalOpen(true);
    };

    const closeModal = () => {
        setIsModalOpen(false);
        form.reset();
        form.clearErrors();
    };

    const submit = (event) => {
        event.preventDefault();

        const options = {
            preserveScroll: true,
            onSuccess: () => closeModal(),
        };

        if (editingRole) {
            form.put(route('roles.update', editingRole.id), options);
        } else {
            form.post(route('roles.store'), options);
        }
    };

    const togglePermission = (permission, checked) => {
        form.setData(
            'permissions',
            checked
                ? [...form.data.permissions, permission]
                : form.data.permissions.filter((name) => name !== permission),
        );
    };

    const toggleGroup = (groupPermissions) => {
        const allSelected = groupPermissions.every((permission) =>
            form.data.permissions.includes(permission),
        );

        form.setData(
            'permissions',
            allSelected
                ? form.data.permissions.filter(
                      (permission) =>
                          !groupPermissions.includes(permission),
                  )
                : [
                      ...new Set([
                          ...form.data.permissions,
                          ...groupPermissions,
                      ]),
                  ],
        );
    };

    const deleteRole = (role) => {
        if (
            window.confirm(
                `¿Eliminar el rol "${role.name}"? Los usuarios que lo tengan quedarán sin este rol.`,
            )
        ) {
            router.delete(route('roles.destroy', role.id), {
                preserveScroll: true,
            });
        }
    };

    const permissionLabel = (permission) =>
        permissionLabels[permission] ?? permission;

    return (
        <AuthenticatedLayout
            header={
                <div className="d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div>
                        <h3 className="mb-1">Roles y permisos</h3>
                        <p className="text-secondary mb-0">
                            Define qué puede hacer cada tipo de usuario.
                        </p>
                    </div>

                    {can('roles.create') && (
                        <PrimaryButton onClick={openCreateModal}>
                            <i className="bi bi-plus-lg me-2"></i>
                            Nuevo rol
                        </PrimaryButton>
                    )}
                </div>
            }
        >
            <Head title="Roles y permisos" />

            <div className="alert alert-info d-flex gap-2" role="alert">
                <i className="bi bi-info-circle-fill"></i>
                <div>
                    El rol <strong>admin</strong> es un rol protegido: tiene
                    todos los permisos y no puede editarse ni eliminarse.
                </div>
            </div>

            <div className="card">
                <div className="card-body p-0">
                    <div className="table-responsive">
                        <table className="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th className="ps-3">Rol</th>
                                    <th>Usuarios</th>
                                    <th>Permisos</th>
                                    <th className="text-end pe-3">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                {roles.map((role) => (
                                    <tr key={role.id}>
                                        <td className="ps-3">
                                            <div className="d-flex align-items-center gap-2">
                                                <span className="fw-semibold">
                                                    {role.name}
                                                </span>
                                                {role.name === 'admin' && (
                                                    <span className="badge text-bg-primary">
                                                        <i className="bi bi-lock-fill me-1"></i>
                                                        Protegido
                                                    </span>
                                                )}
                                            </div>
                                        </td>
                                        <td className="text-secondary">
                                            {role.users_count}
                                        </td>
                                        <td>
                                            <div className="d-flex flex-wrap gap-1">
                                                {role.name === 'admin' ? (
                                                    <span className="badge text-bg-success">
                                                        Todos los permisos
                                                    </span>
                                                ) : role.permissions
                                                      .length === 0 ? (
                                                    <span className="text-secondary small">
                                                        Sin permisos
                                                    </span>
                                                ) : (
                                                    role.permissions.map(
                                                        (permission) => (
                                                            <span
                                                                key={
                                                                    permission
                                                                }
                                                                className="badge text-bg-light border permission-badge"
                                                            >
                                                                {permissionLabel(
                                                                    permission,
                                                                )}
                                                            </span>
                                                        ),
                                                    )
                                                )}
                                            </div>
                                        </td>
                                        <td className="text-end pe-3 table-actions">
                                            {role.name !== 'admin' && (
                                                <div className="d-inline-flex gap-1">
                                                    {can('roles.update') && (
                                                        <button
                                                            type="button"
                                                            className="btn btn-sm btn-outline-primary"
                                                            onClick={() =>
                                                                openEditModal(
                                                                    role,
                                                                )
                                                            }
                                                        >
                                                            <i className="bi bi-pencil me-1"></i>
                                                            Editar
                                                        </button>
                                                    )}

                                                    {can('roles.delete') && (
                                                        <button
                                                            type="button"
                                                            className="btn btn-sm btn-outline-danger"
                                                            onClick={() =>
                                                                deleteRole(role)
                                                            }
                                                        >
                                                            <i className="bi bi-trash me-1"></i>
                                                            Eliminar
                                                        </button>
                                                    )}
                                                </div>
                                            )}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <Modal show={isModalOpen} onClose={closeModal} maxWidth="lg">
                <form onSubmit={submit}>
                    <div className="modal-header">
                        <h5 className="modal-title">
                            {editingRole ? 'Editar rol' : 'Nuevo rol'}
                        </h5>
                        <button
                            type="button"
                            className="btn-close"
                            onClick={closeModal}
                            aria-label="Cerrar"
                        ></button>
                    </div>

                    <div className="modal-body">
                        <p className="text-secondary small mb-3">
                            Asigna un nombre y marca los permisos que tendrá
                            este rol.
                        </p>

                        <div className="mb-3">
                            <InputLabel htmlFor="role_name" value="Nombre" />
                            <TextInput
                                id="role_name"
                                value={form.data.name}
                                onChange={(event) =>
                                    form.setData('name', event.target.value)
                                }
                                className="mt-1"
                                placeholder="ej. editor"
                            />
                            <InputError message={form.errors.name} />
                        </div>

                        {Object.entries(groupedPermissions).map(
                            ([group, groupPermissions]) => (
                                <div className="card mb-3" key={group}>
                                    <div className="card-header d-flex justify-content-between align-items-center">
                                        <span className="fw-semibold">
                                            {groupLabels[group] ?? group}
                                        </span>
                                        <button
                                            type="button"
                                            onClick={() =>
                                                toggleGroup(groupPermissions)
                                            }
                                            className="btn btn-link btn-sm p-0 text-decoration-none"
                                        >
                                            {groupPermissions.every(
                                                (permission) =>
                                                    form.data.permissions.includes(
                                                        permission,
                                                    ),
                                            )
                                                ? 'Quitar todos'
                                                : 'Seleccionar todos'}
                                        </button>
                                    </div>
                                    <div className="card-body">
                                        <div className="row g-2">
                                            {groupPermissions.map(
                                                (permission) => (
                                                    <div
                                                        className="col-12 col-sm-6"
                                                        key={permission}
                                                    >
                                                        <div className="form-check">
                                                            <Checkbox
                                                                id={`permission-${permission}`}
                                                                checked={form.data.permissions.includes(
                                                                    permission,
                                                                )}
                                                                onChange={(
                                                                    event,
                                                                ) =>
                                                                    togglePermission(
                                                                        permission,
                                                                        event
                                                                            .target
                                                                            .checked,
                                                                    )
                                                                }
                                                            />
                                                            <label
                                                                className="form-check-label"
                                                                htmlFor={`permission-${permission}`}
                                                            >
                                                                {permissionLabel(
                                                                    permission,
                                                                )}
                                                            </label>
                                                        </div>
                                                    </div>
                                                ),
                                            )}
                                        </div>
                                    </div>
                                </div>
                            ),
                        )}
                        <InputError message={form.errors.permissions} />
                    </div>

                    <div className="modal-footer">
                        <SecondaryButton
                            onClick={closeModal}
                            disabled={form.processing}
                        >
                            Cancelar
                        </SecondaryButton>
                        <PrimaryButton disabled={form.processing}>
                            {editingRole ? 'Guardar cambios' : 'Crear rol'}
                        </PrimaryButton>
                    </div>
                </form>
            </Modal>
        </AuthenticatedLayout>
    );
}
