import sendAjaxCall from "./ajaxCall.mjs";
let search = () => {
    $('#searchForm').submit(function(event) {
        event.preventDefault();

        let productColumns = $('.products-columns');
        let searchQuery = $('#searchQuery').val();
        let url = "/search";
        let method = "GET";
        let dataType = 'json';
        let data = { q: searchQuery };

        let success = (data) => {
            productColumns.empty();
            if (searchQuery === "") {
                productColumns.html('<div class="empty-results">I cannot give you respond if you don\'t give me request.</div>');
                return false;
            }

            const elements = data.map((car) => {
                const showUrl = `/show/${car.id}`;
                const imagePath = car.imagePath ?? '';

                return `
                   <div class="product-row">
                       <div class="product name one">${car.name}</div>
                       <div class="product model one">${car.model}</div>
                       <div class="image-row">
                           ${car.imagePath ? `<a href="${showUrl}"><img class="product-image" id="car-image-${car.id}" src="${imagePath}" alt="${car.name}" title="${car.name}"></a>` : ''}
                           <span class="status">${car.availability}</span>
                       </div>
                       <div class="product-redirect"></div>
                   </div>
                   `;
            });

            productColumns.html(elements.join(''));
        };

        let error = (xhr, status, error) => {
            const errMsg = xhr.responseJSON.message;
            if (xhr.status === 404) {
                productColumns.html('<div class="error-message">' + errMsg + '</div>');
            }
        }

        sendAjaxCall(url, method, dataType, data, success, error);
    });
}

search();