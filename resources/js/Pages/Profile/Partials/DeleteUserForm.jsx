import DangerButton from '@/Components/DangerButton';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import Modal from '@/Components/Modal';
import SecondaryButton from '@/Components/SecondaryButton';
import TextInput from '@/Components/TextInput';
import { useForm } from '@inertiajs/react';
import { useRef, useState } from 'react';

export default function DeleteUserForm({ className = '' }) {
    const [confirmingUserDeletion, setConfirmingUserDeletion] = useState(false);
    const passwordInput = useRef();

    const {
        data,
        setData,
        delete: destroy,
        processing,
        reset,
        errors,
        clearErrors,
    } = useForm({
        password: '',
    });

    const confirmUserDeletion = () => {
        setConfirmingUserDeletion(true);
    };

    const deleteUser = (e) => {
        e.preventDefault();

        destroy(route('profile.destroy'), {
            preserveScroll: true,
            onSuccess: () => closeModal(),
            onError: () => passwordInput.current.focus(),
            onFinish: () => reset(),
        });
    };

    const closeModal = () => {
        setConfirmingUserDeletion(false);

        clearErrors();
        reset();
    };

    return (
        <section className={className}>
            <h5 className="fw-semibold text-danger">Eliminar cuenta</h5>

            <p className="text-secondary small">
                Una vez eliminada tu cuenta, todos sus recursos y datos se
                borrarán de forma permanente. Antes de eliminarla, descarga
                cualquier información que desees conservar.
            </p>

            <DangerButton onClick={confirmUserDeletion}>
                Eliminar cuenta
            </DangerButton>

            <Modal
                show={confirmingUserDeletion}
                onClose={closeModal}
                maxWidth="md"
            >
                <form onSubmit={deleteUser}>
                    <div className="modal-header">
                        <h5 className="modal-title">
                            ¿Seguro que quieres eliminar tu cuenta?
                        </h5>
                        <button
                            type="button"
                            className="btn-close"
                            onClick={closeModal}
                            aria-label="Cerrar"
                        ></button>
                    </div>

                    <div className="modal-body">
                        <p className="text-secondary small">
                            Una vez eliminada tu cuenta, todos sus recursos y
                            datos se borrarán de forma permanente. Introduce tu
                            contraseña para confirmar que deseas eliminarla.
                        </p>

                        <InputLabel
                            htmlFor="password"
                            value="Contraseña"
                            className="visually-hidden"
                        />

                        <TextInput
                            id="password"
                            type="password"
                            name="password"
                            ref={passwordInput}
                            value={data.password}
                            onChange={(e) =>
                                setData('password', e.target.value)
                            }
                            isFocused
                            placeholder="Contraseña"
                        />

                        <InputError message={errors.password} />
                    </div>

                    <div className="modal-footer">
                        <SecondaryButton onClick={closeModal}>
                            Cancelar
                        </SecondaryButton>

                        <DangerButton disabled={processing}>
                            Eliminar cuenta
                        </DangerButton>
                    </div>
                </form>
            </Modal>
        </section>
    );
}
