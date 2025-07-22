import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";
import fs from "fs";

export default defineConfig({
    server: {
        host: "0.0.0.0", // VERY important to allow access from Docker
        port: 5173,
        origin:
            process.env.VITE_DEV_SERVER_URL ||
            "https://crm.vite.localhost:5173",
        hmr: {
            protocol: "wss",
            host: "crm.vite.localhost"
        },
        https: {
            key: fs.readFileSync("./certs/crm.vite.localhost.key"),
            cert: fs.readFileSync("./certs/crm.vite.localhost.crt")
        },
        cors: {
            origin: [
                process.env.APP_URL || "https://crm.localhost",
                process.env.VITE_DEV_SERVER_URL ||
                    "https://crm.vite.localhost:5173"
            ],
            credentials: true
        }
    },
    plugins: [
        laravel({
            input: "resources/js/app.jsx",
            ssr: "resources/js/ssr.jsx",
            refresh: true
        }),
        react()
    ]
});
