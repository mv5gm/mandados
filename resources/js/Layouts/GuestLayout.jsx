import { Link } from '@inertiajs/react';

export default function GuestLayout({ children }) {
    return (
        <div className="login-page bg-body-secondary d-flex align-items-center justify-content-center py-4">
            <div className="login-box" style={{ width: '100%', maxWidth: '420px' }}>
                <div className="login-logo mb-3">
                    <Link href="/" className="text-decoration-none">
                        <img
                            src="/img/logo/logo-grande.jpeg"
                            alt="Mandados Paria"
                            className="login-logo-img"
                        />
                    </Link>
                </div>

                <div className="card shadow-sm">
                    <div className="card-body login-card-body">{children}</div>
                </div>
            </div>
        </div>
    );
}
