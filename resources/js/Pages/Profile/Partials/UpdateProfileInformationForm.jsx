import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import { Link, useForm, usePage } from '@inertiajs/react';

export default function UpdateProfileInformation({
    mustVerifyEmail,
    status,
    className = '',
}) {
    const user = usePage().props.auth.user;

    const { data, setData, patch, errors, processing, recentlySuccessful } =
        useForm({
            name: user.name,
            email: user.email,
        });

    const submit = (e) => {
        e.preventDefault();

        patch(route('profile.update'));
    };

    return (
        <section className={className}>
            <h5 className="fw-semibold">Información del perfil</h5>
            <p className="text-secondary small">
                Actualiza la información de tu cuenta y tu correo electrónico.
            </p>

            <form onSubmit={submit}>
                <div className="mb-3">
                    <InputLabel htmlFor="name" value="Nombre" />

                    <TextInput
                        id="name"
                        value={data.name}
                        onChange={(e) => setData('name', e.target.value)}
                        required
                        isFocused
                        autoComplete="name"
                    />

                    <InputError message={errors.name} />
                </div>

                <div className="mb-3">
                    <InputLabel htmlFor="email" value="Correo" />

                    <TextInput
                        id="email"
                        type="email"
                        value={data.email}
                        onChange={(e) => setData('email', e.target.value)}
                        required
                        autoComplete="username"
                    />

                    <InputError message={errors.email} />
                </div>

                {mustVerifyEmail && user.email_verified_at === null && (
                    <div className="alert alert-warning small">
                        Tu correo electrónico no está verificado.{' '}
                        <Link
                            href={route('verification.send')}
                            method="post"
                            as="button"
                            className="alert-link"
                        >
                            Haz clic aquí para reenviar el correo de
                            verificación.
                        </Link>

                        {status === 'verification-link-sent' && (
                            <div className="text-success fw-semibold mt-2">
                                Se ha enviado un nuevo enlace de verificación a
                                tu correo.
                            </div>
                        )}
                    </div>
                )}

                <div className="d-flex align-items-center gap-3">
                    <PrimaryButton disabled={processing}>Guardar</PrimaryButton>

                    {recentlySuccessful && (
                        <span className="text-success small">
                            <i className="bi bi-check-circle me-1"></i>
                            Guardado.
                        </span>
                    )}
                </div>
            </form>
        </section>
    );
}
