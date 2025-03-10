function displayFlashMessage(message, type) {
    const alertContainer = document.createElement('div');
    alertContainer.className = `alert ${type}`;
    const alertMessage = document.createElement('p');
    alertMessage.textContent = message;
    alertContainer.appendChild(alertMessage);
    document.body.appendChild(alertContainer);
    setTimeout(() => {
        alertContainer.remove();
    }, 3000*3);
}