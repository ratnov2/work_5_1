import makeRequest from '../../../../../../../../../../resources/js/api/makeRequest'

export default async function(params) {
    return await makeRequest('post', '/api/site/quest/check-in-working', params, {
        headers: {
            "Content-Type": "multipart/form-data",
        }
    }).catch((error) => {
        toast('error', 'Ошибка отправки запроса')
    })
}
