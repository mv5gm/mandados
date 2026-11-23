import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, useForm } from '@inertiajs/react';

export default function ConfirmPassword() {
    const { data, setData, post, processing, errors, reset } = useForm({
        password: '',
    });

    const submit = (e) => {
        e.preventDefault();

        post(route('password.confirm'), {
            onFinish: () => reset('password'),
        });
    };

    return (
        <GuestLayout>
            <Head title="Confirmar contraseña" />

            <p className="login-box-msg">Confirma tu contraseña</p>

            <p className="text-secondary small">
                Esta es un área segura de la aplicación. Confirma tu contraseña
                antes de continuar.
            </p>

            <form onSubmit={submit}>
                <div className="mb-3">
                    <InputLabel htmlFor="password" value="Contraseña" />
                    <TextInput
                        id="password"
                        type="password"
                        name="password"
                        value={data.password}
                        isFocused={true}
                        onChange={(e) => setData('password', e.target.value)}
                    />
                    <InputError message={errors.password} />
                </div>

                <div className="d-flex justify-content-end">
                    <PrimaryButton disabled={processing}>
                        Confirmar
                    </PrimaryButton>
                </div>
            </form>
        </GuestLayout>
    );
}
