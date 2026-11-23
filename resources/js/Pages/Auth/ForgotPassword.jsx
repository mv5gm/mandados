import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function ForgotPassword({ status }) {
    const { data, setData, post, processing, errors } = useForm({
        email: '',
    });

    const submit = (e) => {
        e.preventDefault();

        post(route('password.email'));
    };

    return (
        <GuestLayout>
            <Head title="Recuperar contraseña" />

            <p className="login-box-msg">Recupera tu contraseña</p>

            <p className="text-secondary small">
                Indica tu correo electrónico y te enviaremos un enlace para
                restablecer tu contraseña.
            </p>

            {status && (
                <div className="alert alert-success py-2" role="alert">
                    {status}
                </div>
            )}

            <form onSubmit={submit}>
                <div className="mb-3">
                    <InputLabel htmlFor="email" value="Correo" />
                    <TextInput
                        id="email"
                        type="email"
                        name="email"
                        value={data.email}
                        isFocused={true}
                        onChange={(e) => setData('email', e.target.value)}
                    />
                    <InputError message={errors.email} />
                </div>

                <div className="d-flex align-items-center justify-content-between gap-2">
                    <Link
                        href={route('login')}
                        className="text-decoration-none small"
                    >
                        Volver al inicio de sesión
                    </Link>

                    <PrimaryButton disabled={processing}>
                        Enviar enlace
                    </PrimaryButton>
                </div>
            </form>
        </GuestLayout>
    );
}
