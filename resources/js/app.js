import './bootstrap';
import '../../node_modules/quill/dist/quill';
import slugify from "slugify";
import.meta.glob([
    '../images/**',
    '../fonts/**'
]);

window.slugify = slugify;
