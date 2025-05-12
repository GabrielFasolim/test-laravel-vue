import axios from 'axios';

axios.defaults.baseURL        = 'http://localhost';  
// se o seu Laravel rodar em outra porta (ex: 8000), ajuste para 'http://localhost:8000'
axios.defaults.withCredentials = true;
axios.defaults.xsrfCookieName  = 'XSRF-TOKEN';
axios.defaults.xsrfHeaderName  = 'X-XSRF-TOKEN';

export default axios;
