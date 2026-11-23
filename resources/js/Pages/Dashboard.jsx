import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Dashboard({ stats, roles, permissionsCount }) {
    const { auth } = usePage().props;
    const can = (permission) => auth.permissions.includes(permission);

    const cards = [
        {
            key: 'users',
            label: 'Usuarios registrados',
            value: stats.users,
            href: can('users.view') ? route('users.index') : null,
            className: 'text-bg-primary',
            icon: 'bi-people-fill',
        },
        {
            key: 'roles',
            label: 'Roles definidos',
            value: stats.roles,
            href: can('roles.view') ? route('roles.index') : null,
            className: 'text-bg-success',
            icon: 'bi-shield-check',
        },
        {
            key: 'permissions',
            label: 'Permisos disponibles',
            value: stats.permissions,
            href: can('roles.view') ? route('roles.index') : null,
            className: 'text-bg-warning',
            icon: 'bi-key-fill',
        },
    ].filter((card) => card.value !== null);

    return (
        <AuthenticatedLayout
            header={
                <div className="d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <div>
                        <h3 className="mb-1">Dashboard</h3>
                        <p className="text-secondary mb-0">
                            Resumen general de tu aplicación.
                        </p>
                    </div>
                    <nav aria-label="breadcrumb">
                        <ol className="breadcrumb mb-0">
                            <li className="breadcrumb-item active">
                                Inicio
                            </li>
                        </ol>
                    </nav>
                </div>
            }
        >
            <Head title="Dashboard" />

            <div className="row g-3 mb-3">
                <div className="col-12">
                    <div className="card border-0 text-bg-primary overflow-hidden">
                        <div className="card-body d-flex flex-wrap justify-content-between align-items-center gap-3">
                            <div>
                                <h4 className="mb-1 fw-semibold">
                                    ¡Hola, {auth.user.name}!
                                </h4>
                                <p className="mb-0 opacity-75">
                                    Has iniciado sesión correctamente en el
                                    panel de administración.
                                </p>
                            </div>
                            <div className="d-flex flex-wrap gap-2">
                                {roles.length === 0 ? (
                                    <span className="badge text-bg-light">
                                        Sin rol asignado
                                    </span>
                                ) : (
                                    roles.map((role) => (
                                        <span
                                            key={role}
                                            className="badge text-bg-light text-capitalize"
                                        >
                                            {role}
                                        </span>
                                    ))
                                )}
                                <span className="badge text-bg-light">
                                    {permissionsCount} permisos
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {cards.length > 0 && (
                <div className="row g-3 mb-3">
                    {cards.map((card) => (
                        <div className="col-12 col-sm-6 col-lg-4" key={card.key}>
                            <div className={`small-box ${card.className}`}>
                                <div className="inner">
                                    <h3>{card.value}</h3>
                                    <p>{card.label}</p>
                                </div>
                                <i
                                    className={`small-box-icon bi ${card.icon}`}
                                    aria-hidden="true"
                                ></i>
                                {card.href ? (
                                    <Link
                                        href={card.href}
                                        className="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
                                    >
                                        Ver detalles{' '}
                                        <i className="bi bi-arrow-right-circle"></i>
                                    </Link>
                                ) : (
                                    <span className="small-box-footer">
                                        &nbsp;
                                    </span>
                                )}
                            </div>
                        </div>
                    ))}
                </div>
            )}

            <div className="row g-3">
                <div className="col-12 col-lg-7">
                    <div className="card h-100">
                        <div className="card-header">
                            <h5 className="card-title mb-0">
                                Accesos rápidos
                            </h5>
                        </div>
                        <div className="card-body">
                            <p className="text-secondary">
                                Tareas de administración disponibles para tu
                                cuenta.
                            </p>

                            <div className="d-flex flex-wrap gap-2">
                                {can('users.view') && (
                                    <Link
                                        href={route('users.index')}
                                        className="btn btn-primary"
                                    >
                                        <i className="bi bi-people me-2"></i>
                                        Gestionar usuarios
                                    </Link>
                                )}
                                {can('roles.view') && (
                                    <Link
                                        href={route('roles.index')}
                                        className="btn btn-outline-primary"
                                    >
                                        <i className="bi bi-shield-check me-2"></i>
                                        Gestionar roles
                                    </Link>
                                )}
                                <Link
                                    href={route('profile.edit')}
                                    className="btn btn-outline-secondary"
                                >
                                    <i className="bi bi-person me-2"></i>
                                    Mi perfil
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

                <div className="col-12 col-lg-5">
                    <div className="card h-100">
                        <div className="card-header">
                            <h5 className="card-title mb-0">Tu cuenta</h5>
                        </div>
                        <ul className="list-group list-group-flush">
                            <li className="list-group-item d-flex justify-content-between gap-3">
                                <span className="text-secondary">Nombre</span>
                                <span className="fw-medium text-end">
                                    {auth.user.name}
                                </span>
                            </li>
                            <li className="list-group-item d-flex justify-content-between gap-3">
                                <span className="text-secondary">Correo</span>
                                <span className="fw-medium text-end">
                                    {auth.user.email}
                                </span>
                            </li>
                            <li className="list-group-item d-flex justify-content-between gap-3">
                                <span className="text-secondary">Roles</span>
                                <span className="fw-medium text-end text-capitalize">
                                    {roles.length > 0
                                        ? roles.join(', ')
                                        : 'Sin rol'}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
