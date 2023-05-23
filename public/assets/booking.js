
const pickUpMonth = document.getElementById('car_booking_pickUpDate_month');
const pickUpYear = document.getElementById('car_booking_pickUpDate_year');
const pickUpDay = document.getElementById('car_booking_pickUpDate_day');

const getDateChange = () => {
    const pickUpDate = new Date(`${pickUpMonth.value} ${pickUpDay.value}, ${pickUpYear.value}`);

    const bookingDuration = '{{ bookingDuration }}';

    const returnDate = new Date(pickUpDate);
    returnDate.setMonth(returnDate.getMonth() + bookingDuration);

    const year = returnDate.getFullYear();

    // add leading zeros if necessary
    const month = String(returnDate.getMonth() + 1).padStart(2, '0');
    const day = String(returnDate.getDate()).padStart(2, '0');

    const returnDateFormatted = `${year}-${month}-${day}`;

    const returnDateContainer = document.querySelector('.car_booking_returnDate').textContent = returnDateFormatted;
}

pickUpDay.addEventListener('change', getDateChange);
pickUpMonth.addEventListener('change', getDateChange);
pickUpYear.addEventListener('change', getDateChange);

const getCurrentYear = () => {
    return new Date().getFullYear();
};

const getCurrentMonth = () => {
    return new Date().getMonth() + 1;
};

const setDefaultOptionSelect = (selectElement, defaultValue) => {
    selectElement.value = defaultValue;
};

const disableOptionValuesExceptCurrentYear = (selectElement, currentYear) => {

    const optionValues = selectElement.options;

    for (let i = 0; i < optionValues.length; i++) {
        const option = optionValues[i];

        if (option.value !== currentYear) {
            option.style.display = "none";
        }
    }
};

const disableOptionsBeforeCurrentMonth = (selectElement, currentMonth) => {
    const optionValues = selectElement.options;

    for (let i = 0; i < optionValues.length; i++) {
        const option = optionValues[i];
        const monthValue = parseInt(option.value);

        if (monthValue < currentMonth) {
            option.style.display = "none";
        }
    }
};

const selectYear = document.querySelector('select[name="car_booking[pickUpDate][year]"]');
const selectMonth = document.querySelector('select[name="car_booking[pickUpDate][month]"]');

const currentYear = String(getCurrentYear());
const currentMonth = String(getCurrentMonth());

setDefaultOptionSelect(selectYear, currentYear);
disableOptionValuesExceptCurrentYear(selectYear, currentYear);
disableOptionsBeforeCurrentMonth(selectMonth, currentMonth);
