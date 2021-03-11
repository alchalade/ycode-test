import AxiosClient from "../http/AxiosClient";

const resource = '/api/members';


export default {

    list() {
        return AxiosClient.get(`${resource}`)
    },

    create(data, config) {
        return AxiosClient.post(`${resource}`, data, config)
    }
}
