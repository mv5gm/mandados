import '../css/app.css';
import 'bootstrap-icons/font/bootstrap-icons.css';
import 'bootstrap/js/dist/dropdown';
import {
    initialize as initializeAdminLte,
} from '../../vendor/almasaeed2010/adminlte/dist/js/adminlte.esm.js';

import { createInertiaApp, router } from '@inertiajs/react';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createRoot } from 'react-dom/client';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

const initializeLayout = () => {
    requestAnimationFrame(() => initializeAdminLte());
};

router.on('finish', initializeLayout);

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.jsx`,
            import.meta.glob('./Pages/**/*.jsx'),
        ),
    setup({ el, App, props }) {
        const root = createRoot(el);

        root.render(<App {...props} />);
        initializeLayout();
    },
    progress: {
        color: '#0d6efd',
    },
});
