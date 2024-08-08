export default (types = []) => ({
    dropHandler(event) {
        event.preventDefault();

        if (event.dataTransfer.items) {
            [...event.dataTransfer.items].forEach((item) => {
                if (item.kind === "file") {
                    this.onFileUploaded(item.getAsFile());
                }
            });
        } else {
            [...event.dataTransfer.files].forEach((file) => {
                this.onFileUploaded(file);
            });
        }
    },

    onFileUploaded(file) {
        if(!types.includes(file.type)) {
            toast('error', 'Допустимые типы файлов: ' + types.join(', '));
            return;
        }

        this.$dispatch('file-uploaded', file);
    },

    dragOverHandler(event) {
        event.preventDefault();
    },

    dragLeaveHandler(event) {
        event.preventDefault();
    },

    dragEnterHandler(event) {
        event.preventDefault();
    },
});
