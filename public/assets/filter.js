let filter = () => {
    $('form').submit(function (event) {

        event.preventDefault();

        let productColumns = $(".products-columns");

        let vehicleType = $('input[type=checkbox][data-vehicle-type]:checked').map(function() { return $(this).val();}).get();
        let brand = $('input[type=checkbox][data-vehicle-brand]:checked').map(function() {
            return $(this).val();
        }).get();


        $.ajax({
            //url: "{{ path('filter_api') }}?vehicleType=" + vehicleType + "&brand=" + brand,
            url: "/filter?vehicleType=" + vehicleType + "&brand=" + brand,
            dataType: 'json',
            method: 'GET',
            data: { vehicleType: vehicleType, brand: brand },

            success: function (data) {
                productColumns.empty();

                let ajaxResults = '';
                data.forEach(function(car) {

                    let url = `{{ path('car_show', {'id': 'car.id'}) }}`.replace('car.id', car.id);

                    ajaxResults += '<div class="product-row">';
                    ajaxResults += '<div class="product name one">' + car.name + '</div>';
                    ajaxResults += '<div class="product model one">' + car.model + '</div>';
                    ajaxResults += '<div class="image-row">';
                    if (car.imagePath) {
                        let imagePath = car.imagePath;
                        ajaxResults += '<img class="product-image" id="car-image-' + car.id + '" src="' + imagePath + '" alt="' + car.name + '" title="' + car.name + '">';
                        ajaxResults += '<span class="status">' + car.availability + '</span>';
                    }
                    ajaxResults += '</div>';

                    ajaxResults += '<div class="product-redirect">';
                    ajaxResults += '<a class="product-link link-one" href="' + url + '">Select</a>';
                    ajaxResults += '</div>';
                    ajaxResults += '</div>';

                })

                productColumns.append(ajaxResults);

                let url = new URL(window.location.href);

                url.searchParams.set('vehicleType', vehicleType);

                if (!url.searchParams.get('vehicleType')) {
                    url.searchParams.delete('vehicleType');
                }

                if (brand.length > 0) {
                    url.searchParams.set('brand', brand);
                }

                window.history.pushState({}, null, url.toString());
            },

            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            },
        });
    });
}
filter();

let clearFilters = () => {
    $("#clear-filters-btn").click(function () {

        let vehicleType = $('select[name=vehicle_type]').val();
        let brand = $('select[name=brand]').val();

        $.ajax({
            //url: "{{ path('clear_filter') }}",
            url: "/cars/clear-filters/",
            success: function () {
                let url = new URL(window.location.href);

                url.searchParams.delete('vehicleType', vehicleType);
                url.searchParams.delete('brand', brand);

                window.history.pushState({}, null, url.toString());

                url.searchParams.set('clearFilter', true);
                window.history.pushState({}, null, url.toString());
                location.reload();
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        })
    })
}
clearFilters();

let collapsibleFilters = () => {

    $('.filter-options-title').click(function () {

        let content = $(this).siblings('.filter-options-content');
        let btnExpand = $(this).find('.filter-expand');


        if (content.css('display') === 'none') {
            content.css('display', 'flex');
            content.css('flex-direction', 'column');
            content.css('align-items', 'center')
            btnExpand.text('-');
        } else {
            content.css('display', 'none');
            btnExpand.text('+');
        }
    });
}
collapsibleFilters();

let filterModal = document.getElementById('filter-modal');

let sidebar = document.querySelector('.sidebar');

let contentContainer = document.querySelector('.content-container');

let btn = document.querySelector(".btn-filters");

let btnProceed = document.querySelector('.btn.primary');

let span = document.querySelector('.modal-close');

let footer = document.querySelector('.rnd-footer');

filterModal.append(sidebar);

btn.onclick = function () {
    console.log("clicked");
    filterModal.style.display = "block";
    sidebar.style.display = "block";

    sidebar.style.position = "fixed";
    sidebar.style.backgroundColor = "#c0c0c0";
    sidebar.style.zIndex = 1;
    sidebar.style.width = "100%";
    sidebar.style.height = "100%";
    sidebar.style.filter = "drop-shadow(5px 5px 5px rgba(0,0,0,0.3)";
    sidebar.style.boxShadow = "3px 2px 2px 0 rgb(0 0 0 / 15%)";
    sidebar.style.backgroundColor = "white";
    sidebar.style.bottom = 0;

    span.style.color = "#aaaaaa";
    span.style.position = "absolute !important";
    span.style.display = "block";
    span.style.fontSize = "30px";
    span.zIndex = 3;
}


if (window.matchMedia('screen and (max-width: 768px)').matches) {
    btnProceed.onclick = function () {
        filterModal.style.display = "none";
    }
}


span.onclick = function () {
    filterModal.style.display = "none";
}

window.onclick = function (evt) {
    if (evt.target === sidebar) {
        sidebar.style.display = "none";
    }
}

