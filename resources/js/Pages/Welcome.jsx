import { Head, Link } from '@inertiajs/react';

export default function Welcome({ canLogin, canRegister, laravelVersion, phpVersion }) {
    return (
        <>
            <Head title="Bienvenido" />

            <div className="d-flex flex-column min-vh-100 bg-body-tertiary">
                <nav className="navbar navbar-expand bg-body border-bottom">
                    <div className="container">
                        <Link
                            href="/"
                            className="navbar-brand d-flex align-items-center gap-2"
                        >
                            <span className="avatar-circle bg-primary text-white">
                                <i className="bi bi-shield-lock-fill"></i>
                            </span>
                            <span className="fw-semibold">Mandados</span>
                        </Link>

                        <div className="d-flex gap-2">
                            {canLogin && (
                                <Link
                                    href={route('login')}
                                    className="btn btn-outline-primary"
                                >
                                    Iniciar sesión
                                </Link>
                            )}
                            {canRegister && (
                                <Link
                                    href={route('register')}
                                    className="btn btn-primary"
                                >
                                    Registrarse
                                </Link>
                            )}
                        </div>
                    </div>
                </nav>

                <main className="flex-grow-1 d-flex align-items-center">
                    <div className="container py-5">
                        <div className="row justify-content-center text-center">
                            <div className="col-lg-9 col-xl-8">
                                <span
                                    className="d-inline-flex align-items-center justify-content-center rounded-circle bg-primary-subtle text-primary mb-4"
                                    style={{
                                        width: '5rem',
                                        height: '5rem',
                                        fontSize: '2rem',
                                    }}
                                >
                                    <i className="bi bi-shield-lock-fill"></i>
                                </span>

                                <h1 className="display-5 fw-bold mb-3">
                                    Panel de administración
                                </h1>
                                <p className="lead text-secondary mb-4">
                                    Sistema de gestión de usuarios, roles y
                                    permisos construido con Laravel, React y
                                    AdminLTE.
                                </p>

                                <div className="d-flex flex-wrap justify-content-center gap-2 mb-5">
                                    {canLogin && (
                                        <Link
                                            href={route('login')}
                                            className="btn btn-primary btn-lg"
                                        >
                                            <i className="bi bi-box-arrow-in-right me-2"></i>
                                            Acceder al panel
                                        </Link>
                                    )}
                                    {canRegister && (
                                        <Link
                                            href={route('register')}
                                            className="btn btn-outline-secondary btn-lg"
                                        >
                                            Crear una cuenta
                                        </Link>
                                    )}
                                </div>

                                <div className="row g-3 text-start">
                                    <div className="col-12 col-md-4">
                                        <div className="card h-100">
                                            <div className="card-body">
                                                <i className="bi bi-people fs-3 text-primary"></i>
                                                <h6 className="fw-semibold mt-3">
                                                    Usuarios
                                                </h6>
                                                <p className="text-secondary small mb-0">
                                                    Alta, edición y control de
                                                    cuentas.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-12 col-md-4">
                                        <div className="card h-100">
                                            <div className="card-body">
                                                <i className="bi bi-shield-check fs-3 text-success"></i>
                                                <h6 className="fw-semibold mt-3">
                                                    Roles
                                                </h6>
                                                <p className="text-secondary small mb-0">
                                                    Agrupación flexible de
                                                    responsabilidades.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div className="col-12 col-md-4">
                                        <div className="card h-100">
                                            <div className="card-body">
                                                <i className="bi bi-key fs-3 text-warning"></i>
                                                <h6 className="fw-semibold mt-3">
                                                    Permisos
                                                </h6>
                                                <p className="text-secondary small mb-0">
                                                    Acceso granular a cada
                                                    módulo del sistema.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>

                <footer className="border-top bg-body py-3 text-center text-secondary small">
                    Laravel {laravelVersion} · PHP {phpVersion} · AdminLTE 4
                </footer>
            </div>
        </>
    );
}
