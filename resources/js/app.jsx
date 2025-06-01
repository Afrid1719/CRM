import "./bootstrap";
import "../css/app.css";

import { createRoot } from "react-dom/client";
import { createInertiaApp } from "@inertiajs/react";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import RolesProvider from "./Context/RolesContext";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.jsx`,
            import.meta.glob("./Pages/**/*.jsx")
        ),
    setup({ el, App, props }) {
        if (props.initialPage.props.roles && !localStorage.getItem("roles")) {
            localStorage.setItem(
                "roles",
                JSON.stringify(props.initialPage.props.roles)
            );
        }

        const root = createRoot(el);

        root.render(
            <RolesProvider>
                <App {...props} />
            </RolesProvider>
        );
    },
    progress: {
        color: "#4B5563"
    }
});
