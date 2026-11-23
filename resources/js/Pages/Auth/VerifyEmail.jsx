import PrimaryButton from '@/Components/PrimaryButton';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function VerifyEmail({ status }) {
    const { post, processing } = useForm({});

    const submit = (e) => {
        e.preventDefault();

        post(route('verification.send'));
    };

    return (
        <GuestLayout>
            <Head title="Verificación de correo" />

            <p className="login-box-msg">Verifica tu correo</p>

            <p className="text-secondary small">
                Gracias por registrarte. Antes de comenzar, verifica tu correo
                electrónico haciendo clic en el enlace que acabamos de enviarte.
                Si no lo recibiste, podemos enviarte otro.
            </p>

            {status === 'verification-link-sent' && (
                <div className="alert alert-success py-2" role="alert">
                    Se ha enviado un nuevo enlace de verificación al correo que
                    indicaste al registrarte.
                </div>
            )}

            <form onSubmit={submit}>
                <div className="d-flex align-items-center justify-content-between gap-2">
                    <PrimaryButton disabled={processing}>
                        Reenviar verificación
                    </PrimaryButton>

                    <Link
                        href={route('logout')}
                        method="post"
                        as="button"
                        className="btn btn-link text-decoration-none p-0"
                    >
                        Cerrar sesión
                    </Link>
                </div>
            </form>
        </GuestLayout>
    );
}
