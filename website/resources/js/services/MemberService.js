import Repository from "../repositories/RepositoryFactory";
import {MemberCreationFailedException} from "../exceptions/MemberCreationFailedException";
import {EventBus} from "../EventBus";

export class MemberService {
    constructor() {
        this.repository = Repository.get('member_repository');
        this.maxFileSize = 100; // 100 MB
        this.byteToMB = 10485760;
    }

    validateEvent(event) {
        const allowedEvents = ["drop", "change"];
        if (!allowedEvents.includes(event.type)) {
            throw new TypeError('Event is not whitelisted');
        }
        const fileLocation = event.type === "change" ? "srcElement" : "dataTransfer";

        if (event[fileLocation].files.length !== 1) {
            throw new RangeError('Only one file is supported');
        }
        return event[fileLocation].files[0];
    }

    validateImage(image) {
        if (this.maxFileSize < image.size / this.byteToMB) {
            throw new TypeError(`Image is bigger that allowed size. Max allowed ${this.maxFileSize / 1024} MB.`);
        }
        if (image.type !== 'image/jpeg') {
            throw new TypeError('This image type is not supported. Only JPEG files');
        }
        return image;
    }

    async create(memberData) {
        let formData = new FormData();
        formData.append('name', memberData.name);
        formData.append('email', memberData.email);
        if (memberData.image !== null) {
            formData.append('image', memberData.image);
        }

        const {data, status} = await this.repository.create(formData, {header: {'Content-Type': 'image/jpg'}});
        if (status !== 201) {
            return new MemberCreationFailedException('Failed to Create Team Member', status);
        }
    }

    async list() {
        const {data, status} = await this.repository.list();
        if (status !== 200) {
            return new MemberCreationFailedException('Failed to Create Team Member', status);
        }
        return data;
    }

    addFakeMember(user) {
        const fakeUser =  {
            'avatar': user.image,
            'name' : user.name,
            'email' : user.email,
            'id': -1,
        };

        EventBus.$emit('addMember', fakeUser)
    }
}
