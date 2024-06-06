import {Editor} from '@toast-ui/editor';
import route from 'ziggy-js';
import {ProjectEditorResponse} from "../../types";
import slugify from "slugify";
import Input from "../../components/gui/Input";

const saveDraftRoute: string = route('dashboard.ajax.projects.save-draft');
const publishProjectRoute: string = route('dashboard.ajax.projects.publish');
const addProjectForm: HTMLFormElement = document.getElementById('addProjectForm') as HTMLFormElement;
const previewProjectBtn: HTMLButtonElement = document.getElementById('previewProjectBtn') as HTMLButtonElement;
const saveDraftBtn: HTMLButtonElement = document.getElementById('saveDraftBtn') as HTMLButtonElement;
const publishProjectBtn: HTMLButtonElement = document.getElementById('publishProjectBtn') as HTMLButtonElement;
const editorElement: HTMLDivElement = document.getElementById('editor') as HTMLDivElement;
const editor: Editor = new Editor({
    el: editorElement,
    height: '500px',
    initialEditType: 'markdown',
    previewStyle: 'vertical'
});
const projectContentElement: HTMLTextAreaElement = document.getElementById('projectContent') as HTMLTextAreaElement;

const projectNameInput: Input = new Input(document.getElementById('projectNameInput') as HTMLInputElement);
const projectSlugInput: Input = new Input(document.getElementById('projectSlugInput') as HTMLInputElement)

projectNameInput.getInput().addEventListener('input', () => {

    projectSlugInput.getInput().value = slugify(projectNameInput.getInput().value, {
        lower: true,
        strict: true
    });

    fetch(route('dashboard.ajax.projects.check-slug'), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement).content
        },
        body: JSON.stringify({slug: projectSlugInput.getInput().value})
    })
        .then(response => response.json())
        .then(data => {
            if (data.hasOwnProperty('exists') && data.exists) {
                projectSlugInput.setValidationState('invalid', 'This slug is already used.');
            } else {
                projectSlugInput.setValidationState('valid', null);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        })

    fetch(route('dashboard.ajax.projects.check-name'), {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement).content
        },
        body: JSON.stringify({name: projectNameInput.getInput().value})
    })
        .then(response => response.json())
        .then(data => {
            if (data.hasOwnProperty('exists') && data.exists) {
                projectNameInput.setValidationState('invalid', 'This name is already used.');
            } else {
                projectNameInput.setValidationState('valid', null);
            }
        })
});

addProjectForm.addEventListener('submit', (event) => {
    event.preventDefault();
});

previewProjectBtn.addEventListener('click', async () => {
    console.log('Preview project');
    const data: ProjectEditorResponse | null = await sendProjectFormToServer(true);

    if (data !== null && data.hasOwnProperty('success') && data.success) {
        window.open(data.url, '_blank');
    } else {
        console.error('Error:', data);
    }
});

saveDraftBtn.addEventListener('click', () => {
    console.log('Save draft');
    sendProjectFormToServer(true);
});

publishProjectBtn.addEventListener('click', () => {
    console.log('Publish project');
    if (addProjectForm.reportValidity()) {
        console.log("Form is valid");
        sendProjectFormToServer();
    } else {
        console.log("Form is invalid");
    }
});

document.addEventListener('DOMContentLoaded', () => {
    editor.getMarkdown();
    editor.setMarkdown(projectContentElement.value);
});

async function sendProjectFormToServer(isDraft: boolean = false): Promise<ProjectEditorResponse | null> {
    const route: string = isDraft ? saveDraftRoute : publishProjectRoute;
    const formData: FormData = new FormData(addProjectForm);
    formData.append('content', editor.getMarkdown());

    const data = Object.fromEntries(formData);
    let returnedData: ProjectEditorResponse | null = null;

    console.log(data);
    await fetch(route, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': (document.querySelector('meta[name="csrf-token"]') as HTMLMetaElement).content
        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(responseData => {
            console.log(responseData);
            returnedData = responseData;
        })
        .catch(error => {
            console.error('Error:', error);
        });

    return returnedData;
}
