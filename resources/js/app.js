import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import "@fortawesome/fontawesome-free/css/all.min.css";
import "vue-toastification/dist/index.css";
import "./bootstrap";
import Toast from "vue-toastification";

InertiaProgress.init();

createInertiaApp({
    resolve: (name) => import(`./${name}.vue`),
    setup({ el, App, props }) {
        const app = createApp({ render: () => h(App, props) });

        app.use(Toast);

        app.mount(el);
    },
});
