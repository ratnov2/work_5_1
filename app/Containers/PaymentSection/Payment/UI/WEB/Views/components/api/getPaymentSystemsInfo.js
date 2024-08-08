import makeRequest from '../../../../../../../../../resources/js/api/makeRequest'

export default async function() {
    return await makeRequest('get', '/api/payment/systems-info').catch((error) => {
        toast('error', 'Ошибка отправки запроса')
    })
}
