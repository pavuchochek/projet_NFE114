export function getCookie(name) {
    const value = `; ${document.cookie}`;
    console.log(`${name}=${value}`);
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
    return null;
}
export function convertDecimalHoursToHumanReadable(decimalHours) {
    const hours = Math.floor(decimalHours);
    const minutes = Math.round((decimalHours - hours) * 60);
    var result = `${hours}h ${minutes}m`;
    if (hours === 0) {
        result = `${minutes}m`;
    }else if (minutes === 0) {
        result = `${hours}h`;
    }
    return result;
}