const successBox = document.querySelector('.success-box');

const successMsg = () => {
    setTimeout(() => {
        if (successBox) {
            successBox.style.display = 'none';
        }

    }, 2000);
}

successMsg();

