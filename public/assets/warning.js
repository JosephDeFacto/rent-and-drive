const warningBox = document.querySelector('.warning-box');

const warningMsg = () => {
    setTimeout(() => {
        if (warningBox) {
            warningBox.style.display = 'none';
        }
    }, 2000)
}

warningMsg();