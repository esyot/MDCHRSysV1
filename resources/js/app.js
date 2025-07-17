import { createApp, h, reactive } from "vue";
import { createInertiaApp, router } from "@inertiajs/vue3";
import { InertiaProgress } from "@inertiajs/progress";
import "@fortawesome/fontawesome-free/css/all.min.css";
import "vue-toastification/dist/index.css";
import "./bootstrap";
import Toast from "vue-toastification";

InertiaProgress.init();

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        const page = pages[`./${name}.vue`];
        if (!page) {
            throw new Error(`Page './Pages/${name}.vue' not found.`);
        }
        return page.default;
    },
    setup({ el, App, props }) {
        const app = createApp({
            render: () => h(App, props),
        });

        app.use(Toast);

        app.mount(el);
    },
});
