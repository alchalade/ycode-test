import axios from 'axios'


const apiURL = 'http://ycode.local'

const axiosClient = axios.create({ apiURL })

export default axiosClient
