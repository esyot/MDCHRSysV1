import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import "@fortawesome/fontawesome-free/css/all.min.css";

import "./bootstrap";

InertiaProgress.init();

createInertiaApp({
    resolve: (name) => import(`./${name}.vue`),
    setup({ el, App, props }) {
        return createApp({ render: () => h(App, props) }).mount(el);
    },
});
