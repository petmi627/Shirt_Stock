/**
 * This function will set a cookie param to get another language
 * @param language
 */

function changeLanguage(language) {
    console.log("Set language to " + language);
    document.cookie = "language=" + language;

    location.reload();
}