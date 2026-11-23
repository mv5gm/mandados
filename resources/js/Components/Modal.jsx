import { useEffect } from 'react';

export default function Modal({
    children,
    show = false,
    maxWidth = 'lg',
    closeable = true,
    onClose = () => {},
}) {
    useEffect(() => {
        if (!show) {
            return;
        }

        const handleKeyDown = (event) => {
            if (event.key === 'Escape' && closeable) {
                onClose();
            }
        };

        document.addEventListener('keydown', handleKeyDown);

        return () => document.removeEventListener('keydown', handleKeyDown);
    }, [show, closeable, onClose]);

    if (!show) {
        return null;
    }

    const handleBackdropClick = (event) => {
        if (closeable && event.target === event.currentTarget) {
            onClose();
        }
    };

    return (
        <>
            <div
                className="modal fade show d-block"
                tabIndex="-1"
                role="dialog"
                aria-modal="true"
                onMouseDown={handleBackdropClick}
            >
                <div
                    className={`modal-dialog modal-${maxWidth} modal-dialog-centered modal-dialog-scrollable`}
                >
                    <div className="modal-content">{children}</div>
                </div>
            </div>
            <div className="modal-backdrop fade show" />
        </>
    );
}
