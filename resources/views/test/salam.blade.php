<html>

<head>

    <script src="{{ asset('js/ckeditor5/ckeditorUpload.js') }}"></script>
    <script src="{{ asset('js/ckeditor5/ckeditor.js') }}"></script>

</head>

<div>
    <div id="safarnamehText" class="textEditor"></div>
</div>

<script>
    BalloonBlockEditor.create(document.querySelector('#safarnamehText'), {
            placeholder: 'متن سفرنامه خود را اینجا وارد کنید...',
            toolbar: {
                items: [
                    'bold',
                    'italic',
                    'link',
                    'highlight'
                ]
            },
            language: 'fa',
            blockToolbar: [
                'blockQuote',
                'heading',
                'indent',
                'outdent',
                'numberedList',
                'bulletedList',
                'insertTable',
                'imageUpload',
                'undo',
                'redo'
            ],
            table: {
                contentToolbar: [
                    'tableColumn',
                    'tableRow',
                    'mergeTableCells'
                ]
            },
            licenseKey: '',
        })
        .then(editor => {
            window.editor = editor;
            window.uploaderClass = editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                let data = {
                    code: {{ $code }}
                };
                data = JSON.stringify(data);
                return new MyUploadAdapter(loader, '/',
                    'csrf', data);
            };


        })
        .catch(error => {
            console.error('Oops, something went wrong!');
            console.error(
                'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:'
            );
            console.warn('Build id: wgqoghm20ep6-7otme29let2s');
            console.error(error);
        });
</script>

</html>
