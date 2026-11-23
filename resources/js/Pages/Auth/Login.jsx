import Checkbox from '@/Components/Checkbox';
import InputError from '@/Components/InputError';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Login({ status, canResetPassword }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const submit = (e) => {
        e.preventDefault();

        post(route('login'), {
            onFinish: () => reset('password'),
        });
    };

    return (
        <GuestLayout>
            <Head title="Iniciar sesión" />

            <p className="login-box-msg">Inicia sesión para continuar</p>

            {status && (
                <div className="alert alert-success py-2" role="alert">
                    {status}
                </div>
            )}

            <form onSubmit={submit}>
                <div className="input-group mb-3">
                    <TextInput
                        id="email"
                        type="email"
                        name="email"
                        value={data.email}
                        placeholder="Correo electrónico"
                        aria-label="Correo electrónico"
                        autoComplete="username"
                        isFocused={true}
                        onChange={(e) => setData('email', e.target.value)}
                    />
                    <span className="input-group-text">
                        <i className="bi bi-envelope"></i>
                    </span>
                </div>

                <InputError message={errors.email} className="mb-2" />

                <div className="input-group mb-3">
                    <TextInput
                        id="password"
                        type="password"
                        name="password"
                        value={data.password}
                        placeholder="Contraseña"
                        aria-label="Contraseña"
                        autoComplete="current-password"
                        onChange={(e) => setData('password', e.target.value)}
                    />
                    <span className="input-group-text">
                        <i className="bi bi-lock"></i>
                    </span>
                </div>

                <InputError message={errors.password} className="mb-2" />

                <div className="row align-items-center">
                    <div className="col-7">
                        <div className="form-check">
                            <Checkbox
                                id="remember"
                                name="remember"
                                checked={data.remember}
                                onChange={(e) =>
                                    setData('remember', e.target.checked)
                                }
                            />
                            <label
                                className="form-check-label"
                                htmlFor="remember"
                            >
                                Recordarme
                            </label>
                        </div>
                    </div>

                    <div className="col-5">
                        <PrimaryButton
                            className="w-100"
                            disabled={processing}
                        >
                            Entrar
                        </PrimaryButton>
                    </div>
                </div>
            </form>

            <div className="d-flex justify-content-between gap-2 mt-3 small">
                {canResetPassword && (
                    <Link
                        href={route('password.request')}
                        className="text-decoration-none"
                    >
                        ¿Olvidaste tu contraseña?
                    </Link>
                )}

                <Link
                    href={route('register')}
                    className="text-decoration-none ms-auto"
                >
                    Crear una cuenta
                </Link>
            </div>
        </GuestLayout>
    );
}
