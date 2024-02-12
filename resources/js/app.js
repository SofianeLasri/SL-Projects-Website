import './bootstrap';
import {Modal} from 'bootstrap';
import slugify from "slugify";
import FormValidator from "@/utils/form-validator";
import MediaUploadZone from "@/components/dashboard/MediaUploadZone";
import MediaLibrary from "@/pages/dashboard/MediaLibrary";
import Notification from "@/components/Notification";
import StepsGroupsList from "@/components/dashboard/StepsGroupsList";
import {Editor as TuiEditor} from '@toast-ui/editor';

import.meta.glob([
    '../images/**',
    '../fonts/**'
]);

window.slugify = slugify;
window.FormValidator = FormValidator;
window.MediaUploadZone = MediaUploadZone;
window.MediaLibrary = MediaLibrary;
window.Notification = Notification;
window.StepsGroupsList = StepsGroupsList;
window.TuiEditor = TuiEditor;