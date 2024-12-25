function sendAjax(action, data, callback) {
    fetch('/ajax_handler.php?ajax=true', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({
            action: action,
            data: JSON.stringify(data)
        })
    })
        .then(response => response.json())
        .then(callback)
        .catch(error => {
            console.error('Ошибка AJAX:', error);
        });
}
