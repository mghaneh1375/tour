<html>

<head>

    <script src="{{ asset('js/newck/ckeditor5/ckeditorUpload.js') }}"></script>
    <script src="{{ asset('js/newck/ckeditor5/ckeditor.js') }}"></script>

    <style>
        #safarnamehText {
            width: calc(100% - 200px) !important;
        }
    </style>

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

            let token = 'Bearer ' + localStorage.getItem("token");

            window.uploaderClass = editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {

                return new MyUploadAdapter(loader, 'https://boom.bogenstudio.com/api/ckeditor/400',
                    token, {});
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
