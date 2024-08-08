export default async function(method, url, params = {}, options = {}) {
    switch (method) {
        case 'get':
            let queryString = Object.keys(params).map(key => key + '=' + params[key]).join('&');
            queryString = queryString.length == 0 ? '' : '?' + queryString;
            return await axios.get(`${url}${queryString}`, options).then((response) => handleResponse(response))

        case 'post':
            return await axios.post(url, params, options).then((response) => handleResponse(response))

        default:
            throw new Error('Method not found');
    }
}

function handleResponse(response) {
    const data = response.data
    if(data.status == 'error') {
        toast('error', data.msg);
        return false;
    }
    return data;
}
