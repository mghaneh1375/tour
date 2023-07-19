class MyUploadAdapter {
    constructor(loader, url, token, data2) {
        // CKEditor 5's FileLoader instance.
        this.loader = loader;
        this.url = url;
        this.token = token;
        this.data2 = data2;
    }

    upload() {
        console.log("upload call");
        return new Promise((resolve, reject) => {
            this._initRequest();
            this._initListeners(resolve, reject);
            this._sendRequest();
        });
    }

    // Aborts the upload process.
    abort() {
        if (this.xhr) {
            this.xhr.abort();
        }
    }

    // Example implementation using XMLHttpRequest.
    _initRequest() {
        const xhr = (this.xhr = new XMLHttpRequest());

        xhr.open("POST", this.url, true);
        xhr.responseType = "json";
    }

    // Initializes XMLHttpRequest listeners.
    _initListeners(resolve, reject) {
        const xhr = this.xhr;
        const loader = this.loader;
        const genericErrorText =
            "Couldn't upload file:" + ` ${loader.file.name}.`;

        xhr.addEventListener("error", () => reject(genericErrorText));
        xhr.addEventListener("abort", () => reject());
        xhr.addEventListener("load", () => {
            const response = xhr.response;
            if (!response || response.error)
                return reject(
                    response && response.error
                        ? response.error.message
                        : genericErrorText
                );

            resolve({
                default: response.url,
            });
        });

        if (xhr.upload) {
            xhr.upload.addEventListener("progress", (evt) => {
                if (evt.lengthComputable) {
                    loader.uploadTotal = evt.total;
                    loader.uploaded = evt.loaded;
                }
            });
        }
    }

    // Prepares the data and sends the request.
    _sendRequest() {
        let token = this.token;
        let url = this.url;
        let data2 = this.data2;
        let xhr = this.xhr;
        Promise.resolve(this.loader.file).then(
            function (value) {
                const data = new FormData();
                data.append("pic", value);
                // data.append( 'data', data2);

                xhr.setRequestHeader("Authorization", token);
                xhr.send(data);
            },
            function (value) {
                console.log("_sendRequest", value);
            }
        );
    }
}
