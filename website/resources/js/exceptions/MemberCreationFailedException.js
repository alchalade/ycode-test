export class MemberCreationFailedException {
    constructor(message, statusCode) {
        this.exception = {
            message: message,
            status_code: statusCode
        }
        this.throwIt();
    }

    throwIt() {
        throw this.exception;
    }
}


export class ErrorHandler {
    constructor(_message, _type, _status_code) {
        this.exception = {
            message: _message,
            type: _type,
            status_code: _status_code,
        }
        this.throwException()
    }

    throwException() {
        throw this.exception
    }
}
