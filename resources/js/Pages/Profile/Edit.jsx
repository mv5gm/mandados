import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, usePage } from '@inertiajs/react';
import DeleteUserForm from './Partials/DeleteUserForm';
import UpdatePasswordForm from './Partials/UpdatePasswordForm';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm';

export default function Edit({ mustVerifyEmail, status }) {
    const { auth } = usePage().props;

    return (
        <AuthenticatedLayout
            header={
                <div>
                    <h3 className="mb-1">Mi perfil</h3>
                    <p className="text-secondary mb-0">
                        Administra tu información personal y la seguridad de tu
                        cuenta.
                    </p>
                </div>
            }
        >
            <Head title="Mi perfil" />

            <div className="row g-3">
                <div className="col-12 col-xl-8">
                    <div className="card mb-3">
                        <div className="card-body">
                            <UpdateProfileInformationForm
                                mustVerifyEmail={mustVerifyEmail}
                                status={status}
                            />
                        </div>
                    </div>

                    <div className="card mb-3">
                        <div className="card-body">
                            <UpdatePasswordForm />
                        </div>
                    </div>

                    <div className="card border-danger">
                        <div className="card-body">
                            <DeleteUserForm />
                        </div>
                    </div>
                </div>

                <div className="col-12 col-xl-4">
                    <div className="card">
                        <div className="card-body text-center">
                            <span className="avatar-circle avatar-circle-lg bg-primary text-white mx-auto mb-3 fs-4">
                                {auth.user.name.charAt(0).toUpperCase()}
                            </span>
                            <h5 className="mb-1">{auth.user.name}</h5>
                            <p className="text-secondary mb-3">
                                {auth.user.email}
                            </p>
                            <div className="d-flex flex-wrap justify-content-center gap-1">
                                {auth.roles.length === 0 ? (
                                    <span className="badge text-bg-secondary">
                                        Sin rol
                                    </span>
                                ) : (
                                    auth.roles.map((role) => (
                                        <span
                                            key={role}
                                            className="badge text-bg-primary text-capitalize"
                                        >
                                            {role}
                                        </span>
                                    ))
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
