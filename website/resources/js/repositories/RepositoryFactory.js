import MemberRepository from "./MemberRepository";


const repositories = {
    'member_repository': MemberRepository,
}


export default {
    get: name => repositories[name],
}
