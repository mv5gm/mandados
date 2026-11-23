import { Link } from '@inertiajs/react';

export default function Pagination({ links = [] }) {
    if (links.length <= 3) {
        return null;
    }

    return (
        <nav aria-label="Paginación">
            <ul className="pagination pagination-sm mb-0">
                {links.map((link, index) => (
                    <li
                        key={index}
                        className={`page-item ${link.active ? 'active' : ''} ${
                            link.url ? '' : 'disabled'
                        }`}
                    >
                        {link.url ? (
                            <Link
                                href={link.url}
                                preserveScroll
                                className="page-link"
                                dangerouslySetInnerHTML={{ __html: link.label }}
                            />
                        ) : (
                            <span
                                className="page-link"
                                dangerouslySetInnerHTML={{ __html: link.label }}
                            />
                        )}
                    </li>
                ))}
            </ul>
        </nav>
    );
}
