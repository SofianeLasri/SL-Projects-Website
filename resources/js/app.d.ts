import routeFn from 'ziggy-js';
import MediaUploadZone from "./components/dashboard/MediaUploadZone";
import StepsGroupsList from "./components/dashboard/StepsGroupsList";

declare global {
    var route: typeof routeFn;

    interface Window {
        TuiEditor: any;
        MediaLibrary: any;
        MediaUploadZone: any;
        StepsGroupsList: any;
    }
}
