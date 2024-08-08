import makeRequest from '../../../../../../../../resources/js/api/makeRequest'

export default async function(params) {
    return await makeRequest('post', '/api/ref-system/make-ref-balance-withdraw', params).catch((error) => {
        toast('error', 'Ошибка отправки запроса')
    })
}
