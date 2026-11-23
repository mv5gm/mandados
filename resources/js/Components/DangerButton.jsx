export default function DangerButton({
    type = 'button',
    className = '',
    disabled,
    children,
    ...props
}) {
    return (
        <button
            {...props}
            type={type}
            className={`btn btn-danger ${className}`}
            disabled={disabled}
        >
            {children}
        </button>
    );
}
