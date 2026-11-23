import { initialize as initializeAdminLte } from '../../../vendor/almasaeed2010/adminlte/dist/js/adminlte.esm.js';
import { Link, usePage } from '@inertiajs/react';
import { useEffect } from 'react';

export default function AuthenticatedLayout({ header, children }) {
    const { auth, flash } = usePage().props;
    const user = auth.user;
    const can = (permission) => auth.permissions.includes(permission);
    const isActive = (pattern) => route().current(pattern);

    useEffect(() => {
        initializeAdminLte();
    }, []);

    return (
        <div className="app-wrapper">
            <nav className="app-header navbar navbar-expand bg-body">
                <div className="container-fluid">
                    <ul className="navbar-nav">
                        <li className="nav-item">
                            <a
                                className="nav-link"
                                data-lte-toggle="sidebar"
                                href="#"
                                role="button"
                                aria-label="Alternar menú lateral"
                            >
                                <i className="bi bi-list fs-4"></i>
                            </a>
                        </li>
                        <li className="nav-item d-none d-md-block">
                            <span className="nav-link text-secondary">
                                Panel de administración
                            </span>
                        </li>
                    </ul>

                    <ul className="navbar-nav ms-auto">
                        <li className="nav-item dropdown">
                            <a
                                className="nav-link dropdown-toggle d-flex align-items-center gap-2"
                                href="#"
                                role="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                <span className="avatar-circle bg-primary text-white">
                                    {user.name.charAt(0).toUpperCase()}
                                </span>
                                <span className="d-none d-lg-inline fw-medium">
                                    {user.name}
                                </span>
                            </a>
                            <ul className="dropdown-menu dropdown-menu-end shadow">
                                <li className="px-3 py-2">
                                    <div className="fw-semibold">
                                        {user.name}
                                    </div>
                                    <div className="small text-secondary">
                                        {user.email}
                                    </div>
                                    <div className="small text-secondary text-capitalize">
                                        {auth.roles.length > 0
                                            ? auth.roles.join(', ')
                                            : 'Sin rol'}
                                    </div>
                                </li>
                                <li>
                                    <hr className="dropdown-divider" />
                                </li>
                                <li>
                                    <Link
                                        href={route('profile.edit')}
                                        className="dropdown-item"
                                    >
                                        <i className="bi bi-person me-2"></i>
                                        Mi perfil
                                    </Link>
                                </li>
                                <li>
                                    <Link
                                        href={route('logout')}
                                        method="post"
                                        as="button"
                                        className="dropdown-item text-danger"
                                    >
                                        <i className="bi bi-box-arrow-right me-2"></i>
                                        Cerrar sesión
                                    </Link>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <aside
                className="app-sidebar bg-body-secondary shadow"
                data-bs-theme="dark"
            >
                <div className="sidebar-brand">
                    <Link
                        href={route('dashboard')}
                        className="brand-link text-decoration-none"
                    >
                        <span className="brand-logo-chip">
                            <img
                                src="/img/logo/logo-pequenio.png"
                                alt="Mandados Paria"
                            />
                        </span>
                        <span className="brand-text fw-light">Mandados</span>
                    </Link>
                </div>

                <div className="sidebar-wrapper">
                    <nav className="mt-2" aria-label="Navegación principal">
                        <ul
                            className="nav sidebar-menu flex-column"
                            data-lte-toggle="treeview"
                            data-accordion="false"
                            id="navigation"
                        >
                            <li className="nav-header">PRINCIPAL</li>

                            <li className="nav-item">
                                <Link
                                    href={route('dashboard')}
                                    className={`nav-link ${
                                        isActive('dashboard') ? 'active' : ''
                                    }`}
                                >
                                    <i className="nav-icon bi bi-speedometer2"></i>
                                    <p>Dashboard</p>
                                </Link>
                            </li>

                            {can('users.view') && (
                                <li className="nav-item">
                                    <Link
                                        href={route('users.index')}
                                        className={`nav-link ${
                                            isActive('users.*') ? 'active' : ''
                                        }`}
                                    >
                                        <i className="nav-icon bi bi-people"></i>
                                        <p>Usuarios</p>
                                    </Link>
                                </li>
                            )}

                            {can('roles.view') && (
                                <li className="nav-item">
                                    <Link
                                        href={route('roles.index')}
                                        className={`nav-link ${
                                            isActive('roles.*') ? 'active' : ''
                                        }`}
                                    >
                                        <i className="nav-icon bi bi-shield-check"></i>
                                        <p>Roles y permisos</p>
                                    </Link>
                                </li>
                            )}

                            <li className="nav-header">CUENTA</li>

                            <li className="nav-item">
                                <Link
                                    href={route('profile.edit')}
                                    className={`nav-link ${
                                        isActive('profile.*') ? 'active' : ''
                                    }`}
                                >
                                    <i className="nav-icon bi bi-person"></i>
                                    <p>Mi perfil</p>
                                </Link>
                            </li>

                            <li className="nav-item">
                                <Link
                                    href={route('logout')}
                                    method="post"
                                    as="button"
                                    className="nav-link text-start w-100"
                                >
                                    <i className="nav-icon bi bi-box-arrow-right"></i>
                                    <p>Cerrar sesión</p>
                                </Link>
                            </li>
                        </ul>
                    </nav>
                </div>
            </aside>

            <main className="app-main">
                {header && (
                    <div className="app-content-header">
                        <div className="container-fluid">{header}</div>
                    </div>
                )}

                <div className="app-content">
                    <div className="container-fluid">
                        {flash?.success && (
                            <div
                                className="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2"
                                role="alert"
                            >
                                <i className="bi bi-check-circle-fill"></i>
                                <span>{flash.success}</span>
                            </div>
                        )}

                        {children}
                    </div>
                </div>
            </main>

            <footer className="app-footer">
                <div className="float-end d-none d-sm-inline">
                    Laravel 13 + React
                </div>
                <strong>
                    © {new Date().getFullYear()} Mandados.
                </strong>{' '}
                Todos los derechos reservados.
            </footer>
        </div>
    );
}
