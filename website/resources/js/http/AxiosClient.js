import axios from 'axios'
import Swal from "sweetalert2";


const apiURL = 'http://ycode.local'

const axiosClient = axios.create({baseURL: apiURL})

axiosClient.interceptors.response.use(response => response, error => {
    const {status} = error.response
    console.log('ALO', status)

    if (status >= 500) {
        Swal.fire({
            icon: "error",
            title: 'The Server is crying :\'( ',
            text: 'Please give it some time',
            showConfirmButton: false,
            toast: true,
            timer: 2500,
        })
    }
    return Promise.reject(error)
})


export default axiosClient
