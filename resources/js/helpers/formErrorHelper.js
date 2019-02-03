class FormErrorHelper {
    constructor(errors) {
        this.errors = errors;
    }
    get message() {
        let errorText = '';
        if (this.errors.response) {
            let er = this.errors.response.data;
            if (typeof er === 'string' || er instanceof String) {
                errorText += er;
            }
            for (let e in er.errors) {
                errorText += er.errors[e][0] + '</br>'
            }
        } else if (this.errors.request) {
            errorText += this.errors.request;
        } else {
            errorText += this.errors.message;
        }
        return errorText;
    }

}

module.exports = FormErrorHelper;

