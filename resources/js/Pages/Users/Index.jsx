import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import Checkbox from '@/Components/Checkbox';
import DangerButton from '@/Components/DangerButton';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import Modal from '@/Components/Modal';
import Pagination from '@/Components/Pagination';
import PrimaryButton from '@/Components/PrimaryButton';
import SecondaryButton from '@/Components/SecondaryButton';
import TextInput from '@/Components/TextInput';
import { Head, router, useForm, usePage } from '@inertiajs/react';
import { useState } from 'react';

export default function Index({ users, roles, filters }) {
    const { auth } = usePage().props;
    const can = (permission) => auth.permissions.includes(permission);

    const [search, setSearch] = useState(filters.search ?? '');
    const [isModalOpen, setIsModalOpen] = useState(false);
    const [editingUser, setEditingUser] = useState(null);

    const form = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        roles: [],
    });

    const openCreateModal = () => {
        setEditingUser(null);
        form.reset();
        form.clearErrors();
        setIsModalOpen(true);
    };

    const openEditModal = (user) => {
        setEditingUser(user);
        form.setData({
            name: user.name,
            email: user.email,
            password: '',
            password_confirmation: '',
            roles: user.roles.map((role) => role.name),
        });
        form.clearErrors();
        setIsModalOpen(true);
    };

    const closeModal = () => {
        setIsModalOpen(false);
        form.reset();
        form.clearErrors();
    };

    const submitSearch = (event) => {
        event.preventDefault();

        router.get(
            route('users.index'),
            { search },
            { preserveState: true, replace: true },
        );
    };

    const submit = (event) => {
        event.preventDefault();

        const options = {
            preserveScroll: true,
            onSuccess: () => closeModal(),
        };

        if (editingUser) {
            form.put(route('users.update', editingUser.id), options);
        } else {
            form.post(route('users.store'), options);
        }
    };

    const toggleRole = (roleName, checked) => {
        form.setData(
            'roles',
            checked
                ? [...form.data.roles, roleName]
                : form.data.roles.filter((name) => name !== roleName),
        );
    };

    const deleteUser = (user) => {
        if (
            window.confirm(
                `¿Eliminar al usuario "${user.name}"? Esta acción no se puede deshacer.`,
            )
        ) {
            router.delete(route('users.destroy', user.id), {
                preserveScroll: true,
            });
        }
    };

    const formatDate = (value) =>
        value ? new Date(value).toLocaleDateString('es-ES') : '—';

    return (
        <AuthenticatedLayout
            header={
                <div className="d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div>
                        <h3 className="mb-1">Usuarios</h3>
                        <p className="text-secondary mb-0">
                            Gestiona las cuentas y los roles del sistema.
                        </p>
                    </div>

                    {can('users.create') && (
                        <PrimaryButton onClick={openCreateModal}>
                            <i className="bi bi-plus-lg me-2"></i>
                            Nuevo usuario
                        </PrimaryButton>
                    )}
                </div>
            }
        >
            <Head title="Usuarios" />

            <div className="card">
                <div className="card-header">
                    <form
                        onSubmit={submitSearch}
                        className="row g-2 align-items-center"
                    >
                        <div className="col-12 col-md-6 col-lg-5">
                            <div className="input-group">
                                <span className="input-group-text">
                                    <i className="bi bi-search"></i>
                                </span>
                                <TextInput
                                    value={search}
                                    onChange={(event) =>
                                        setSearch(event.target.value)
                                    }
                                    placeholder="Buscar por nombre o correo..."
                                    aria-label="Buscar usuarios"
                                />
                                <button
                                    type="submit"
                                    className="btn btn-primary"
                                >
                                    Buscar
                                </button>
                            </div>
                        </div>

                        {filters.search && (
                            <div className="col-auto">
                                <SecondaryButton
                                    onClick={() => {
                                        setSearch('');
                                        router.get(route('users.index'));
                                    }}
                                >
                                    <i className="bi bi-x-lg me-1"></i>
                                    Limpiar
                                </SecondaryButton>
                            </div>
                        )}
                    </form>
                </div>

                <div className="card-body p-0">
                    <div className="table-responsive">
                        <table className="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th className="ps-3">Usuario</th>
                                    <th>Roles</th>
                                    <th>Registrado</th>
                                    <th className="text-end pe-3">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                {users.data.length === 0 && (
                                    <tr>
                                        <td
                                            colSpan="4"
                                            className="text-center text-secondary py-5"
                                        >
                                            <i className="bi bi-search fs-3 d-block mb-2"></i>
                                            No se encontraron usuarios.
                                        </td>
                                    </tr>
                                )}

                                {users.data.map((user) => (
                                    <tr key={user.id}>
                                        <td className="ps-3">
                                            <div className="d-flex align-items-center gap-2">
                                                <span className="avatar-circle avatar-circle-lg bg-primary-subtle text-primary-emphasis">
                                                    {user.name
                                                        .charAt(0)
                                                        .toUpperCase()}
                                                </span>
                                                <div>
                                                    <div className="fw-semibold">
                                                        {user.name}
                                                        {user.id ===
                                                            auth.user.id && (
                                                            <span className="badge text-bg-secondary ms-2">
                                                                Tú
                                                            </span>
                                                        )}
                                                    </div>
                                                    <div className="small text-secondary">
                                                        {user.email}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div className="d-flex flex-wrap gap-1">
                                                {user.roles.length === 0 ? (
                                                    <span className="text-secondary small">
                                                        Sin rol
                                                    </span>
                                                ) : (
                                                    user.roles.map((role) => (
                                                        <span
                                                            key={role.id}
                                                            className={`badge ${
                                                                role.name ===
                                                                'admin'
                                                                    ? 'text-bg-primary'
                                                                    : 'text-bg-secondary'
                                                            }`}
                                                        >
                                                            {role.name}
                                                        </span>
                                                    ))
                                                )}
                                            </div>
                                        </td>
                                        <td className="text-secondary">
                                            {formatDate(user.created_at)}
                                        </td>
                                        <td className="text-end pe-3 table-actions">
                                            <div className="d-inline-flex gap-1">
                                                {can('users.update') && (
                                                    <button
                                                        type="button"
                                                        className="btn btn-sm btn-outline-primary"
                                                        onClick={() =>
                                                            openEditModal(user)
                                                        }
                                                    >
                                                        <i className="bi bi-pencil me-1"></i>
                                                        Editar
                                                    </button>
                                                )}

                                                {can('users.delete') &&
                                                    user.id !==
                                                        auth.user.id && (
                                                        <button
                                                            type="button"
                                                            className="btn btn-sm btn-outline-danger"
                                                            onClick={() =>
                                                                deleteUser(user)
                                                            }
                                                        >
                                                            <i className="bi bi-trash me-1"></i>
                                                            Eliminar
                                                        </button>
                                                    )}
                                            </div>
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>

                <div className="card-footer d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <span className="text-secondary small">
                        Mostrando {users.from ?? 0} a {users.to ?? 0} de{' '}
                        {users.total} usuarios
                    </span>
                    <Pagination links={users.links} />
                </div>
            </div>

            <Modal show={isModalOpen} onClose={closeModal} maxWidth="lg">
                <form onSubmit={submit}>
                    <div className="modal-header">
                        <h5 className="modal-title">
                            {editingUser ? 'Editar usuario' : 'Nuevo usuario'}
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
                            {editingUser
                                ? 'Actualiza los datos y los roles del usuario.'
                                : 'Crea una cuenta y asígnale uno o varios roles.'}
                        </p>

                        <div className="row g-3">
                            <div className="col-12">
                                <InputLabel htmlFor="name" value="Nombre" />
                                <TextInput
                                    id="name"
                                    value={form.data.name}
                                    onChange={(event) =>
                                        form.setData(
                                            'name',
                                            event.target.value,
                                        )
                                    }
                                    className="mt-1"
                                    autoComplete="name"
                                />
                                <InputError message={form.errors.name} />
                            </div>

                            <div className="col-12">
                                <InputLabel htmlFor="email" value="Correo" />
                                <TextInput
                                    id="email"
                                    type="email"
                                    value={form.data.email}
                                    onChange={(event) =>
                                        form.setData(
                                            'email',
                                            event.target.value,
                                        )
                                    }
                                    className="mt-1"
                                    autoComplete="email"
                                />
                                <InputError message={form.errors.email} />
                            </div>

                            <div className="col-12 col-sm-6">
                                <InputLabel
                                    htmlFor="password"
                                    value="Contraseña"
                                />
                                <TextInput
                                    id="password"
                                    type="password"
                                    value={form.data.password}
                                    onChange={(event) =>
                                        form.setData(
                                            'password',
                                            event.target.value,
                                        )
                                    }
                                    className="mt-1"
                                    autoComplete="new-password"
                                />
                                {editingUser && (
                                    <div className="form-text">
                                        Déjala vacía para conservar la actual.
                                    </div>
                                )}
                                <InputError message={form.errors.password} />
                            </div>

                            <div className="col-12 col-sm-6">
                                <InputLabel
                                    htmlFor="password_confirmation"
                                    value="Confirmar contraseña"
                                />
                                <TextInput
                                    id="password_confirmation"
                                    type="password"
                                    value={form.data.password_confirmation}
                                    onChange={(event) =>
                                        form.setData(
                                            'password_confirmation',
                                            event.target.value,
                                        )
                                    }
                                    className="mt-1"
                                    autoComplete="new-password"
                                />
                            </div>

                            <div className="col-12">
                                <InputLabel value="Roles" />
                                <div className="row g-2 mt-0">
                                    {roles.map((role) => (
                                        <div
                                            className="col-12 col-sm-6"
                                            key={role.id}
                                        >
                                            <div className="form-check border rounded p-2 ps-5">
                                                <Checkbox
                                                    id={`role-${role.id}`}
                                                    checked={form.data.roles.includes(
                                                        role.name,
                                                    )}
                                                    onChange={(event) =>
                                                        toggleRole(
                                                            role.name,
                                                            event.target
                                                                .checked,
                                                        )
                                                    }
                                                />
                                                <label
                                                    className="form-check-label"
                                                    htmlFor={`role-${role.id}`}
                                                >
                                                    {role.name}
                                                </label>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                                <InputError message={form.errors.roles} />
                            </div>
                        </div>
                    </div>

                    <div className="modal-footer">
                        <SecondaryButton
                            onClick={closeModal}
                            disabled={form.processing}
                        >
                            Cancelar
                        </SecondaryButton>
                        <PrimaryButton disabled={form.processing}>
                            {editingUser ? 'Guardar cambios' : 'Crear usuario'}
                        </PrimaryButton>
                    </div>
                </form>
            </Modal>
        </AuthenticatedLayout>
    );
}
